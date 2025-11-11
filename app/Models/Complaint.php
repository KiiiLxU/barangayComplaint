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
        'photo',
        'status',
        'assigned_admin_id',
        'status_updated_at',
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
}
