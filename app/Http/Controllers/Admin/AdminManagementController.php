<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminManagementController extends Controller
{
    public function index(Request $request): View
    {
        $adminFilter = $request->integer('admin_id');
        $actionFilter = trim((string) $request->query('action', ''));

        $admins = Admin::query()
            ->withCount('activities')
            ->with('latestActivity')
            ->orderByDesc('is_head_admin')
            ->orderBy('FirstName')
            ->get();

        $activities = AdminActivity::query()
            ->with(['admin', 'targetAdmin'])
            ->when($adminFilter > 0, fn ($query) => $query->where('admin_id', $adminFilter))
            ->when($actionFilter !== '', fn ($query) => $query->where('action', $actionFilter))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $availableActions = AdminActivity::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.management', [
            'admins' => $admins,
            'activities' => $activities,
            'availableActions' => $availableActions,
            'adminFilter' => $adminFilter,
            'actionFilter' => $actionFilter,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'FirstName' => ['required', 'string', 'max:255'],
            'LastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'admin_username' => ['required', 'string', 'max:255', 'unique:admins,admin_username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'email' => $data['email'],
            'admin_username' => $data['admin_username'],
            'admin_password' => Hash::make($data['password']),
            'email_verified_at' => now(),
            'is_head_admin' => false,
        ]);

        AdminActivity::record(
            'admin.created',
            'Created a new admin account.',
            $admin,
            [
                'email' => $admin->email,
                'username' => $admin->admin_username,
            ],
            $admin,
        );

        return redirect()
            ->route('admin.management.index')
            ->with('success', 'Admin account created successfully.');
    }
}
