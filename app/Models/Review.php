<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'id', 'user_id', 'room_id', 'review', 'rating', 'image', 'like', 'dislike', 'created_at', 'updated_at'
    ];

    protected $visible = [
        'id', 'user_id', 'room_id', 'review', 'rating', 'image', 'like', 'dislike', 'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function reviewReacts()
    {
        return $this->hasMany(ReviewReact::class, 'review_id', 'id');
    }
    public function reviewImages()
    {
        return $this->hasMany(ReviewImage::class, 'review_id', 'id');
    }
}
