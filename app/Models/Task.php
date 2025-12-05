<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'status',
        'priority',
        'category',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relasi ke User (Asprak)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope untuk filter berdasarkan priority
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    /**
     * Check if task is overdue
     */
    public function isOverdue()
    {
        return $this->deadline < now() && $this->status !== 'completed';
    }

    /**
     * Get badge color based on priority
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'red',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray',
        };
    }

    /**
     * Get badge color based on status
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'gray',
            'in_progress' => 'blue',
            'completed' => 'green',
            default => 'gray',
        };
    }
}
