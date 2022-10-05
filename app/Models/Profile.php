<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
	protected $fillable = [
        'img',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'state',
        'zipcode',
        'available',
    ];

    public function friends()
    {
    return $this->belongsToMany(Profile::class, 'friend_profiles', 'profile_id', 'friend_id')->withTimeStamps();
    }

}


