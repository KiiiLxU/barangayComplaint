<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'details',
        'sitio',
        'respondent',
        'photo',
        'status',
        'assigned_admin_id',
        'status_updated_at',
        'purok',
        'street',
        'assigned_official_id',
    ];

    protected $casts = [
        'status_updated_at' => 'datetime',
    ];

    // A complaint belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A complaint can be assigned to an admin
    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }

    // A complaint can be assigned to a barangay official
    public function assignedOfficial()
    {
        return $this->belongsTo(BrgyOfficial::class, 'assigned_official_id');
    }

    // A complaint can have many messages
    public function messages()
    {
        return $this->hasMany(ComplaintMessage::class);
    }
}
