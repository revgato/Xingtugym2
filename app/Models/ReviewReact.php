<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReact extends Model
{
    use HasFactory;

    protected $table = 'reviewreacts';

    protected $fillable = [
        'id','user_id','review_id','react','created_at','updated_at'
    ];

    protected $visible = [
        'id','user_id','review_id','react','created_at','updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }
}
