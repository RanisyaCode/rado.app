<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'start_at',
        'due_at',
        'priority',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Helper: Cek apakah tugas sudah terlambat
    public function getIsOverdueAttribute(): bool
    {
        if (!$this->due_at || $this->status === 'Selesai') {
            return false;
        }
        return $this->due_at->isPast();
    }

    // Helper: Deskripsi keterlambatan
    public function getOverdueTextAttribute(): string
    {
        if (!$this->is_overdue || !$this->due_at) {
            return '';
        }
        $diffHours = (int) $this->due_at->diffInHours(now());
        if ($diffHours >= 24) {
            $days = (int) ($diffHours / 24);
            return "Terlambat {$days} hari";
        }
        if ($diffHours >= 1) {
            return "Terlambat {$diffHours} jam";
        }
        return "Tenggat baru saja lewat";
    }

    // Helper: Cek apakah tenggat hari ini
    public function getIsTodayAttribute(): bool
    {
        if (!$this->due_at) return false;
        return $this->due_at->isToday();
    }
}
