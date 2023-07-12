<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;

    protected $table = 'reviewimages';

    protected $fillable = [
        'id','review_id','image_url','created_at','updated_at'
    ];

    protected $visible = [
        'id','review_id','image_url','react','created_at','updated_at'
    ];
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }
}
