<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_plate',
        'user_id'
    ];

    public function user(){
        // one user has many cars
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function proposals(){
        // one car has many proposals
        return $this->hasMany(Proposal::class, 'car_id', 'id');
    }


}
