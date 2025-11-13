<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrgyOfficial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo',
        'contact_no',
        'purok_assigned',
        'user_id',
    ];

    // An official can be assigned to many complaints
    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'assigned_official_id');
    }

    // An official belongs to a user (for kagawad accounts)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
