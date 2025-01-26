<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'date',
        'start_time',
        'end_time',
        'responsible_id',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function involved(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    public function getFormattedTimeAttribute(): string
    {
        if ($this->start_time && $this->end_time) {
            return '<i class="fa-regular fa-clock"></i> ' . $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
        } elseif ($this->start_time) {
            return '<i class="fa-regular fa-clock"></i> ' . $this->start_time->format('H:i');
        }
        return '<i class="fa-regular fa-clock"></i> '. $this->created_at->diffForHumans();
    }
}
