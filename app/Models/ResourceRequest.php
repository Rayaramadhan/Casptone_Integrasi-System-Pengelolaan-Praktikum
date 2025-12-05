<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ResourceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'laboratorium',
        'nama_praktikum',
        'title',
        'description',
        'resource_type',
        'quantity',
        'needed_date',
        'needed_time',
        'duration',
        'status',
        'feedback',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'needed_date' => 'date',
        'needed_time' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relations
     */
    
    // Requester (Asprak)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Reviewer (Laboran)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scopes
     */
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByResourceType($query, $type)
    {
        return $query->where('resource_type', $type);
    }

    public function scopeByLaboratorium($query, $lab)
    {
        return $query->where('laboratorium', $lab);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('needed_date', '>=', now())
                     ->orderBy('needed_date', 'asc');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                     ->where('needed_date', '<', now());
    }

    /**
     * Helper Methods
     */
    
    public function isOverdue()
    {
        return $this->status === 'pending' && $this->needed_date < now();
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Accessor Attributes
     */
    
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown',
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-700',
            'medium' => 'bg-yellow-100 text-yellow-700',
            'low' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getLaboratoriumPraktikumsAttribute()
    {
        return self::getPraktikumsForLab($this->laboratorium);
    }

    /**
     * Get available praktikums for a laboratorium
     */
    public static function getPraktikumsForLab($lab)
    {
        $praktikums = [
            'EISD' => [
                'Algoritma Pemrograman',
                'Pengembangan Aplikasi Website',
                'Analisis dan Perancangan Sistem Informasi',
                'Pemrograman Berorientasi Objek'
            ],
            'ERP' => [
                'Sistem Enterprise',
                'Manajemen Rantai Pasok',
                'Sistem Akuntansi & Manajemen Keuangan',
                'Manajemen Sumber Daya Manusia'
            ],
            'EDM' => [
                'Sistem Basis Data',
                'Data Mining',
                'Data Warehouse & Business Intelligence'
            ],
            'EIM' => [
                'Sistem Operasi',
                'Jaringan Komputer',
                'Keamanan Sistem Informasi'
            ],
            'SAG' => [
                'Pengantar Sistem Informasi',
                'Pemodelan Proses Bisnis',
                'Arsitektur Enterprise'
            ]
        ];

        return $praktikums[$lab] ?? [];
    }

    /**
     * Get all laboratoriums
     */
    public static function getLaboratoriums()
    {
        return ['EISD', 'ERP', 'EDM', 'EIM', 'SAG'];
    }

    public function getResourceTypeLabelAttribute()
    {
        return match($this->resource_type) {
            'room' => 'Ruangan',
            'tool_account' => 'Akun Tools',
            'hardware' => 'Perangkat Keras',
            'software' => 'Software/License',
            'other' => 'Lainnya',
            default => 'Unknown',
        };
    }

    public function getResourceTypeIconAttribute()
    {
        return match($this->resource_type) {
            'room' => '🏢',
            'tool_account' => '🔑',
            'hardware' => '💻',
            'software' => '💿',
            'other' => '📦',
            default => '📋',
        };
    }

    public function getFormattedNeededDateAttribute()
    {
        return $this->needed_date->format('d M Y');
    }

    public function getFormattedNeededTimeAttribute()
    {
        return $this->needed_time ? $this->needed_time->format('H:i') : '-';
    }

    public function getDurationTextAttribute()
    {
        if (!$this->duration) {
            return '-';
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} jam {$minutes} menit";
        } elseif ($hours > 0) {
            return "{$hours} jam";
        } else {
            return "{$minutes} menit";
        }
    }
}
