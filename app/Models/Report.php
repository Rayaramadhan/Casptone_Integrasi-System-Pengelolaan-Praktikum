<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'original_filename',
        'status',
        'deadline',
        'revision_notes',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'deadline' => 'date',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user (asprak) who submitted the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user (laboran) who reviewed the report.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope to get pending reports.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get approved reports.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get reports needing revision.
     */
    public function scopeRevisionRequested($query)
    {
        return $query->where('status', 'revision_requested');
    }

    /**
     * Scope to get overdue reports.
     */
    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
                     ->where('status', '!=', 'approved');
    }

    /**
     * Check if the report is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->deadline->isPast() && $this->status !== 'approved';
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): array
    {
        return match($this->status) {
            'approved' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => '✅'],
            'revision_requested' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => '🔄'],
            default => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => '⏳']
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'approved' => 'Disetujui',
            'revision_requested' => 'Perlu Revisi',
            default => 'Menunggu Review'
        };
    }

    /**
     * Get file size in human readable format.
     */
    public function getFileSizeAttribute(): string
    {
        $path = storage_path('app/' . $this->file_path);
        if (!file_exists($path)) {
            return 'N/A';
        }
        
        $bytes = filesize($path);
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension.
     */
    public function getFileExtensionAttribute(): string
    {
        return pathinfo($this->original_filename, PATHINFO_EXTENSION);
    }
}
