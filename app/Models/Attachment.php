<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'filename',
        'mime_type',
        'drive_file_id',
        'drive_file_link',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
