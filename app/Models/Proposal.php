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
        'car_id'
    ];

    public function car()
    {
        // one car to many proposal
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
    public function services()
    {
        // one proposal include many services
        return $this->hasMany(Service::class, 'proposal_id', 'id');
    }
}
