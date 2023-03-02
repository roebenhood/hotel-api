<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rooms extends Model
{
    use HasFactory;

    protected $table = 'Rooms';

    protected $fillable = [
        'roomName',
        'roomDescription',
        'roomCapacity',
        'roomPrice',
        'createdOn',
        'updatedOn'
    ];

    public $timestamps = false;
}
