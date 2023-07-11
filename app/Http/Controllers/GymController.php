<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GymController extends Controller
{
    public function myGym()
    {
        //find gym by user_id
        $gym = Room::where('owner_id', Auth::user()->id)->first();
        //redirect to create gym if not found
        if (!$gym) {
            return redirect()->route('gym.create');
        } else {
            return redirect()->route('gym.edit');
        }
    }

    public function index()
    {
        // Lấy danh sách phòng gym phân trang
        $gymRooms = Room::orderByDesc('rating')->paginate(10);

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
        return view('gym.index', compact('gymRooms'));
    }

    public function create()
    {
        return view('gym.create');
    }

    public function store(Request $request)
    {
        //if gym already exist
        $gym = Room::where('owner_id', Auth::user()->id)->first();
        if ($gym) {
            return redirect()->route('gym.edit');
        }
        $gym = [
            'owner_id' => Auth::user()->id,
            'name' => $request->nameGym,
            'phone' => $request->phone,
            'email' => $request->email,
            'nameOwner' => $request->nameOwner,
            'address' => $request->address,
            'price' => $request->price,
        ];
        foreach ($request->services as $service) {
            $gym[$service] = 1;
        }
        Room::create($gym);
        User::where('id', Auth::user()->id)->update(['phone' => $request->phone]);

        $gym = Room::where('owner_id', Auth::user()->id)->first();
        //file upload
        $fileImages = $request->file('file');
        if ($fileImages) {
            foreach ($fileImages as $file) {
                $fileName = $file->getClientOriginalName();
                $fileName = '/images/roomImages/' . uniqid('gymImage') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/roomImages'), $fileName);
                DB::table('roomimages')->insert([
                    'room_id' => $gym->id,
                    'image_url' => $fileName,
                ]);
            }
        }
        return redirect()->route('my-gym');
    }

    public function edit()
    {
        $gym = Room::where('owner_id', Auth::user()->id)->first();
        $images = $gym->roomImages()->get();
        return view('gym.edit', compact('gym', 'images'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        //file upload

        $gym = Room::where('owner_id', Auth::user()->id)->first();
        $fileImages = $request->file('file');
        if ($fileImages) {
            foreach ($fileImages as $file) {
                $fileName = $file->getClientOriginalName();
                $fileName = '/images/roomImages/' . uniqid('gymImage') . '.' . $file->getClientOriginalExtension();
                //if exist file name skip
                if (DB::table('roomimages')->where('image_url', $fileName)->first()) {
                    continue;
                }
                $file->move(public_path('images/roomImages'), $fileName);
                DB::table('roomimages')->insert([
                    'room_id' => $gym->id,
                    'image_url' => $fileName,
                ]);
            }
        }
        $gym->name = $request->nameGym;
        $gym->address = $request->address;
        $gym->price = $request->price;
        foreach ($request->services as $service) {
            $gym[$service] = 1;
        }
        $gym->save();
        User::where('id', Auth::user()->id)->update(['phone' => $request->phone]);
        return redirect()->route('my-gym');
    }

//    public function search(Request $request)
//    {
//        dd($request->all());
//    }

    public function show($id)
    {
        $gym = Room::findOrfail($id);
        $poolAverageRating = 0;

        if ($gym->pool == 1) {
            $ratings = $gym->poolRatings;
            $totalRating = 0;
            if (isset($ratings)) {
                $numRatings = count($ratings);

                foreach ($ratings as $rating) {
                    $totalRating += $rating->rating;
                }

                $poolAverageRating = $numRatings > 0 ? round($totalRating / $numRatings, 1) : 0;
            }
        }

        $owner = $gym->owner;
        $gym_imgs = $gym->roomImages()->get()->take(3);
//        dd($gym_imgs);
        return view('gym.show', compact('gym', 'gym_imgs', 'poolAverageRating', 'owner'));
    }

    public function search(Request $request)
    {
        $name = $request->input('inputName') ? $request->input('inputName') : null;
        $address = $request->input('inputAddress') ? $request->input('inputAddress') : null;
        $price = $request->input('inputPrice') ? $request->input('inputPrice') : null;
        $service = $request->input('inputService') ? $request->input('inputService') : null;
//
//        var_dump('name: ' . $name);
//        var_dump('address: ' . $address);
//        var_dump('price: ' . $price);
//        var_dump('service: ' . $service);


        $query = Room::query()->orderBy('rating', 'desc');

        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        if ($address) {
            $query->where('address', 'LIKE', '%' . $address . '%');
        }

        if ($price) {
            if ($price == 1) {
                $query->where('price', '>=', 100000)->where('price', '<', 300000);
            } else {
                if ($price == 2) {
                    $query->where('price', '>=', 300000)->where('price', '<', 500000);
                } else {
                    if ($price == 3) {
                        $query->where('price', '>=', 500000);
                    }
                }
            }
        }

        if ($service) {
            if ($service == 1) {
                $query->where('pool', 1)->orderBy();
            } else {
                if ($service == 2) {
                    $query->where('sauna', 1);
                } else {
                    if ($service == 3) {
                        $query->where('packing', 1);
                    }
                }
            }
        }
        $gymRooms = $query->paginate(10);
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
        return view('gym.index', compact('gymRooms'));
    }

    public function ownerShow()
    {
        $id = Auth::user()->id;

        $gym = Room::findOrfail($id);

        $poolAverageRating = 0;

        if ($gym->pool == 1) {
            $ratings = $gym->poolRatings;
            $totalRating = 0;
            if (isset($ratings)) {
                $numRatings = count($ratings);

                foreach ($ratings as $rating) {
                    $totalRating += $rating->rating;
                }

                $poolAverageRating = $numRatings > 0 ? round($totalRating / $numRatings, 1) : 0;
            }
        }

        $owner = $gym->owner;

        $gym_imgs = $gym->roomImages()->get()->take(3);

        return view('gym.owner.show', compact('gym', 'gym_imgs', 'poolAverageRating', 'owner'));
    }

}
