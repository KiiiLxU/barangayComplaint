<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'sender_id',
        'message',
        'message_type',
        'is_read',
    ];

    // A message belongs to a complaint
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // A message belongs to a sender (user)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
