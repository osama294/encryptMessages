<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['recipient_id', 'encrypted_message', 'expires_at', 'recipient_identifier','secret_code'];


    protected $casts = [
        'read' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
