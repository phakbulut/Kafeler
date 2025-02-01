<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'user_id',
        'instagram',
        'facebook',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
