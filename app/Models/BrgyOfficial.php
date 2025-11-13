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
    ];

    // An official can be assigned to many complaints
    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'assigned_official_id');
    }
}
