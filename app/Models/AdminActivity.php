<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class AdminActivity extends Model
{
    protected $fillable = [
        'admin_id',
        'target_admin_id',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function targetAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'target_admin_id', 'admin_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function record(
        string $action,
        string $description,
        mixed $subject = null,
        array $metadata = [],
        ?Admin $targetAdmin = null,
        ?Admin $admin = null,
    ): void {
        $admin = $admin ?? Auth::guard('admin')->user();

        if (! $admin instanceof Admin) {
            return;
        }

        static::create([
            'admin_id' => $admin->getKey(),
            'target_admin_id' => $targetAdmin?->getKey(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => method_exists($subject, 'getKey') ? $subject->getKey() : null,
            'metadata' => $metadata ?: null,
        ]);
    }
}
