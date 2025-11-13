<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'action',
        'notes',
        'performed_by',
    ];

    // A log belongs to a complaint
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // A log is performed by a user
    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
