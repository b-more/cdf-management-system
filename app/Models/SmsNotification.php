<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_id',
        'phone_number',
        'subject',
        'message',
        'message_type',
        'priority',
        'status',
        'schedule_send',
        'scheduled_at',
        'sent_at',
        'delivered_at',
        'failed_at',
        'delivery_report',
        'error_message',
        'sent_by_id',
        'retry_count',
    ];

    protected $casts = [
        'schedule_send' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'failed_at' => 'datetime',
        'retry_count' => 'integer',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by_id');
    }
}
