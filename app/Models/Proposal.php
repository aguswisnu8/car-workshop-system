<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'repair_status',
        'car_in',
        'car_id',
        'user_id'
    ];

    public function car()
    {
        // one car has many proposal
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
    public function user()
    {
        // one user has many car
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function services()
    {
        // one proposal include many services
        return $this->hasMany(Service::class, 'proposal_id', 'id');
    }
}
