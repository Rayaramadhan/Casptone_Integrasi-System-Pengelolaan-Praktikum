<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'asprak_id',
        'file_path',
        'catatan',
        'status',
        'feedback',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Boot method untuk auto-delete file
     */
    protected static function booted()
    {
        static::deleting(function ($submission) {
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
        });
    }

    /**
     * Relasi ke Assignment
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Relasi ke User (Asprak yang submit)
     */
    public function asprak()
    {
        return $this->belongsTo(User::class, 'asprak_id');
    }

    /**
     * Relasi ke User (Laboran yang review)
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope: filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: filter by assignment
     */
    public function scopeByAssignment($query, $assignmentId)
    {
        return $query->where('assignment_id', $assignmentId);
    }

    /**
     * Scope: filter by asprak
     */
    public function scopeByAsprak($query, $asprakId)
    {
        return $query->where('asprak_id', $asprakId);
    }

    /**
     * Accessor: status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Review',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Accessor: status color for badge
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_APPROVED => 'bg-green-100 text-green-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Accessor: file URL
     */
    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}
