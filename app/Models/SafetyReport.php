<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SafetyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_code',
        'reporter_id',
        'reported_user_id',
        'booking_id',
        'category',
        'title',
        'description',
        'evidence_photo',
        'severity',
        'status',
        'admin_notes',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Pelapor keamanan (Renter atau Owner).
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Pihak terlapor (Penyewa bermasalah atau Owner terlapor).
     */
    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    /**
     * Booking / Transaksi yang disengketakan.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Thread pesan / percakapan aduan penipuan antara korban & admin pusat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(SafetyReportMessage::class, 'safety_report_id')->oldest();
    }

    /**
     * Label kategori laporan keamanan.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'damage_dispute' => 'Sengketa Kerusakan Unit',
            'loss_theft' => 'Indikasi Kehilangan / Penggelapan',
            'fraud_payment' => 'Penipuan / Pembayaran Ilegal',
            'identity_breach' => 'Pemalsuan Identitas / KTP',
            'item_mismatch' => 'Unit Tidak Sesuai Deskripsi',
            'harassment' => 'Pelanggaran Perilaku / Ancaman',
            default => 'Laporan Keamanan Lainnya',
        };
    }

    /**
     * Badge status penanganan.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending' => ['class' => 'badge-warning', 'label' => 'Perlu Investigasi', 'icon' => 'fas fa-exclamation-circle'],
            'investigating' => ['class' => 'badge-info', 'label' => 'Sedang Ditinjau', 'icon' => 'fas fa-search'],
            'resolved' => ['class' => 'badge-success', 'label' => 'Tuntas / Aman', 'icon' => 'fas fa-check-circle'],
            'action_taken' => ['class' => 'badge-danger', 'label' => 'Sanksi Diberikan (Suspend)', 'icon' => 'fas fa-user-slash'],
            default => ['class' => 'badge-secondary', 'label' => 'Menunggu', 'icon' => 'fas fa-clock'],
        };
    }

    /**
     * Badge tingkat keparahan.
     */
    public function getSeverityBadgeAttribute(): array
    {
        return match ($this->severity) {
            'critical' => ['class' => 'badge-danger', 'label' => 'Kritis / Mendesak'],
            'high' => ['class' => 'badge-danger', 'label' => 'Tinggi'],
            'medium' => ['class' => 'badge-warning text-dark', 'label' => 'Sedang'],
            'low' => ['class' => 'badge-secondary', 'label' => 'Rendah'],
            default => ['class' => 'badge-light border', 'label' => 'Normal'],
        };
    }
}
