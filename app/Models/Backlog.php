<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Backlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'assign_to',
        'progress_notes',
        'progress_file',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Status constants
     */
    const STATUS_BELUM_DIKERJAKAN = 'belum_dikerjakan';
    const STATUS_ON_PROGRESS = 'on_progress';
    const STATUS_DONE = 'done';

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_BELUM_DIKERJAKAN => 'Belum Dikerjakan',
            self::STATUS_ON_PROGRESS => 'On Progress',
            self::STATUS_DONE => 'Done',
        ];
    }

    /**
     * Get the user that owns the backlog
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by assign_to
     */
    public function scopeByAssignTo($query, $assignTo)
    {
        return $query->where('assign_to', 'like', '%' . $assignTo . '%');
    }

    /**
     * Scope a query to get overdue backlogs
     */
    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
                     ->where('status', '!=', self::STATUS_DONE);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_BELUM_DIKERJAKAN => 'yellow',
            self::STATUS_ON_PROGRESS => 'blue',
            self::STATUS_DONE => 'green',
            default => 'gray',
        };
    }

    /**
     * Check if backlog is overdue
     */
    public function getIsOverdueAttribute()
    {
        return $this->deadline < now() && $this->status !== self::STATUS_DONE;
    }

    /**
     * Get progress file URL
     */
    public function getProgressFileUrlAttribute()
    {
        return $this->progress_file ? Storage::url($this->progress_file) : null;
    }

    /**
     * Delete progress file from storage
     */
    public function deleteProgressFile()
    {
        if ($this->progress_file && Storage::exists($this->progress_file)) {
            Storage::delete($this->progress_file);
        }
    }
}
