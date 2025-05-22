<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'thread_id',
        'from_email',
        'to_emails',
        'cc_emails',
        'bcc_emails',
        'subject',
        'body_text',
        'body_html',
        'headers',
        'received_at',
    ];

    protected $casts = [
        'to_emails' => 'array',
        'cc_emails' => 'array',
        'bcc_emails' => 'array',
        'headers' => 'array',
        'received_at' => 'datetime',
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
