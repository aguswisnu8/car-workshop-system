<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'status',
        'description',
        'proposal_id',
        'mechanic_id',
    ];

    public function proposal()
    {
        // one proposal to many services
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
    }
    public function user()
    {
        // one user (mechanic) to many services
        return $this->belongsTo(User::class, 'mechanic_id', 'id');
    }
}
