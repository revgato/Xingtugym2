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
            return redirect()->route('gym.owner.show');
        }
    }

    public function index()
    {
        // Lấy danh sách phòng gym phân trang với active = 1
        $gymRooms = Room::where('active', 1)->orderByDesc('rating')->paginate(10);

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
            return redirect()->route('gym.owner.show');
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
        if ($request->has('services'))
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
                $fileName = '/images/roomImages/' . uniqid('gym') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/images/roomImages'), $fileName);
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
            // Get path and delete all file images from roomimages table with room_id
            $roomImages = DB::table('roomimages')->where('room_id', $gym->id);
            foreach ($roomImages->get() as $roomImage) {
                $path = public_path() . $roomImage->image_url;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $roomImages->delete();

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
        $gym->nameOwner = $request->name;
        $gym->email = $request->email;
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
        return view('gym.show', compact('gym', 'gym_imgs', 'poolAverageRating', 'owner'));
    }

    public function search(Request $request)
    {
        $name = $request->input('inputName') ? $request->input('inputName') : null;
        $address = $request->input('inputAddress') ? $request->input('inputAddress') : null;
        $price = $request->input('inputPrice') ? $request->input('inputPrice') : null;
        $service = $request->input('inputService') ? $request->input('inputService') : null;

        $query = Room::query()->orderBy('rating', 'desc')->where('active', 1);

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
                $query->where('pool', 1)->orderBy('pool_rating', 'desc');
            } else {
                if ($service == 2) {
                    $query->where('sauna', 1);
                } else {
                    if ($service == 3) {
                        $query->where('parking', 1);
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
        $user = Auth::user();
        $gym = $user->room->first();
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

    public function destroy()
    {
        $gym = Room::where('owner_id', Auth::user()->id)->first();
        $gym->delete();
        return redirect()->route('my-gym');
    }
    public function updateStatus()
    {
        $gym = Room::where('owner_id', Auth::user()->id)->first();
        $gym->active = $gym->active == 1 ? 0 : 1;
        $gym->save();
        return redirect()->route('my-gym');
    }
}
