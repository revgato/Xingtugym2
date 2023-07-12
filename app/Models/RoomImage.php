<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;
    protected $table = 'roomimages';
    protected $fillable = [
        'id',
        'room_id',
        'image',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
