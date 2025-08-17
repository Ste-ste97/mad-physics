<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UploadPoint extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_active' => 'boolean',
        'start_at'  => 'datetime',
        'end_at'    => 'datetime',
    ];

    public function uploads(): HasMany
    {
        return $this->hasMany(StudentUpload::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeWithinWindow($q)
    {
        $now = now();

        return $q
            ->where(fn ($qq) => $qq->whereNull('start_at')->orWhere('start_at', '<=', $now))
            ->where(fn ($qq) => $qq->whereNull('end_at')->orWhere('end_at', '>=', $now));
    }
}
