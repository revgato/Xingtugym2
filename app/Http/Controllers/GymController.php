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

    //    public function search() {
//        dd('search');
//        $name = $request->input('inputName');
//        $address = $request->input('inputAddress');
////        $price = $request->input('inputPrice');
////        $service = $request->input('inputService');
//
//        $query = Room::query();
//
////        if ($name) {
//////            var_dump($name);
////            $query->where('name', 'LIKE', '%' . $name . '%');
////        }
//
//        if ($address) {
//            $query->where('address', 'LIKE', '%' . $request->input('address') . '%');
//        }

//        if ($price) {
////            var_dump($price);
////            $query->where('price', $request->input('price'));
//        }
//
//        if ($service) {
////            var_dump($service);
////            $query->where('service', 'LIKE', '%' . $request->input('service') . '%');
//        }

//        $query = Room::query();
//        $gyms = $query->get();
//
//        return view('gym.index', compact('gyms'));
//    }

    public function search(Request $request)
    {
        dd($request->all());
    }

}
