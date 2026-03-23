<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHeadAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = $request->user('admin');

        if (! $admin || ! $admin->isHeadAdmin()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Only the head admin can access admin management.');
        }

        return $next($request);
    }
}
