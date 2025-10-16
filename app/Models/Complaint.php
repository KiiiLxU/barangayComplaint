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
    ];

    // A complaint belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
