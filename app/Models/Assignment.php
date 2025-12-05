<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'judul',
        'deskripsi',
        'tipe',
        'praktikum',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSED = 'closed';

    const TIPE_LPJ = 'LPJ';
    const TIPE_RAB = 'RAB';
    const TIPE_LAPORAN = 'Laporan';
    const TIPE_PROPOSAL = 'Proposal';
    const TIPE_LAINNYA = 'Lainnya';

    /**
     * Relasi ke User (Laboran yang membuat assignment)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke Submissions
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Scope: filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: filter by praktikum
     */
    public function scopeByPraktikum($query, $praktikum)
    {
        return $query->where('praktikum', $praktikum);
    }

    /**
     * Scope: filter by tipe
     */
    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    /**
     * Accessor: status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_CLOSED => 'Ditutup',
            default => 'Unknown',
        };
    }

    /**
     * Accessor: status color for badge
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            self::STATUS_CLOSED => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Accessor: check if deadline passed
     */
    public function getIsExpiredAttribute()
    {
        return $this->deadline < now();
    }

    /**
     * Accessor: check if can submit (active and not expired)
     */
    public function getCanSubmitAttribute()
    {
        return $this->status === self::STATUS_ACTIVE && !$this->is_expired;
    }

    /**
     * Accessor: count submissions by status
     */
    public function getPendingCountAttribute()
    {
        return $this->submissions()->where('status', Submission::STATUS_PENDING)->count();
    }

    public function getApprovedCountAttribute()
    {
        return $this->submissions()->where('status', Submission::STATUS_APPROVED)->count();
    }

    public function getRejectedCountAttribute()
    {
        return $this->submissions()->where('status', Submission::STATUS_REJECTED)->count();
    }

    public function getTotalSubmissionsAttribute()
    {
        return $this->submissions()->count();
    }
}
