<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Lấy top 5 phòng gym
        $topGym = Room::orderBy('rating', 'desc')->where('active',1)->take(5)->get();

        // Thêm RoomImage cho topGym
        foreach ($topGym as $gym) {
            $roomImages = $gym->roomImages()->get();
            if ($roomImages->isNotEmpty()) {
                $gym->roomImages = $roomImages;
                $gym->firstImage = $roomImages->first()->image_url;
            } else {
                $gym->roomImages = null;
                $gym->firstImage = null;
            }
        }

        // Lấy danh sách phòng gym phân trang
        $gymRooms = Room::orderByDesc('rating')->where('active',1)->paginate(10);

        // Thêm RoomImage cho gymRooms
        foreach ($gymRooms as $gym) {
            $roomImages = $gym->roomImages()->get();
            if ($roomImages->isNotEmpty()) {
                $gym->roomImages = $roomImages;
                $gym->firstImage = $roomImages->first()->image_url;
            } else {
                $gym->roomImages = null;
                $gym->firstImage = null;
            }
        }

        return view('home.index', compact('topGym', 'gymRooms'));
    }
}
