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
        return $this->hasMany(Profile::class);
    }

}


