<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SafetyReportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'safety_report_id',
        'user_id',
        'message',
        'attachment',
        'is_admin',
    ];

    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
        ];
    }

    public function safetyReport(): BelongsTo
    {
        return $this->belongsTo(SafetyReport::class, 'safety_report_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
