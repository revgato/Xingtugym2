<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    //
    public function index(Room $gym)
    {
        //using relationship
        $reviews = $gym->reviews;
        foreach ($reviews as $review) {
            $review->like = $review->reviewReacts->where('react', 1)->count();
            $review->dislike = $review->reviewReacts->where('react', 0)->count();
            $review->userName = $review->user->name;
            $review->userAvatar = $review->user->avatar;
            $review->ImagesReview = $review->reviewImages;
            $review->liked = Auth::user() ? $review->reviewReacts->where('user_id', Auth::user()->id)->where('react', 1)->count() : 0;
            $review->dislikes = Auth::user() ? $review->reviewReacts->where('user_id', Auth::user()->id)->where('react', 0)->count() : 0;
        }
        $reviews = $reviews->sortByDesc('created_at');
        return view('gym.review', compact('gym', 'reviews'));
    }

    public function stored(Request $request, Room $gym)
    {
        Review::create([
            'user_id' => Auth::user()->id,
            'room_id' => $gym->id,
            'review' => $request->review,
            'rating' => $request->rating,
            'poolRating' => $request->poolRating,
            'like' => 0,
            'dislike' => 0,
        ]);
        return redirect()->route('gym.review', $gym->id);
    }

    public function updateLike(Request $request, Review $review)
    {
        $review->reviewReacts->where('user_id', Auth::user()->id)->where('react', 1)->count() == 0 ? $review->reviewReacts()->create([
            'user_id' => Auth::user()->id,
            'review_id' => $review->id,
            'react' => 1,
        ]) : $review->reviewReacts->where('user_id', Auth::user()->id)->where('react', 1)->first()->delete();
        return response()->json(['success' => 'success']);
    }
    public function updateDislike(Request $request, Review $review)
    {
        $review->reviewReacts->where('user_id', Auth::user()->id)->where('react', 0)->count() == 0 ? $review->reviewReacts()->create([
            'user_id' => Auth::user()->id,
            'review_id' => $review->id,
            'react' => 0,
        ]) : $review->reviewReacts->where('user_id', Auth::user()->id)->where('react', 0)->first()->delete();
        return response()->json(['success' => 'success']);
    }
}
