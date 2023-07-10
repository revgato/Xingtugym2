<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'id', 'name', 'address','phone','email','nameOwner', 'price', 'owner_id', 'numberOfUsers', 'rating', 'pool', 'parking', 'sauna', 'coach', 'active', 'is_admin_approved'
    ];

    protected $visible = [
        'id', 'name', 'address','phone','email','nameOwner', 'price', 'owner_id', 'numberOfUsers', 'rating', 'pool', 'parking', 'sauna', 'coach', 'active', 'is_admin_approved'
    ];

    // belongsTo
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
    public function roomImages()
    {
        return $this->hasMany(RoomImage::class, 'room_id', 'id');
    }

}
