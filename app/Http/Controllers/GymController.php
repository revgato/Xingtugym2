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
                $query->where('pool', 1);
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

    // fake rating
    public function rating(Request $request)
    {
        $image_urls = [
            'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAoGBxMUExYUFBQXFhYXGRoZGhkZGhkhFxkZGRkZGB8dGBkZISoiGSAoHyAYIzUjJysuMTExGCE2OzYwOiowMS4BCwsLDw4PHRERHTInIScyLi4wNTAwMDIwMDUzMDIyMDIyMjAyMDAwMDAyMDAwMDIwMDAwMDAwMDAwMDAwMDAwMP/AABEIALUBFwMBIgACEQEDEQH/xAAbAAABBQEBAAAAAAAAAAAAAAAFAAIDBAYBB//EAEcQAAIBAgQDBQQHAwoEBwAAAAECEQADBBIhMQUiQQYTUWFxMoGRoQcUI0JSscFi0fAWM0NygpKiwtLhJFNzshUXY5Oj4vH/xAAaAQACAwEBAAAAAAAAAAAAAAACAwABBAUG/8QAMhEAAgEDAwEHAwIGAwAAAAAAAQIAAxEhBBIxQRMyUWFxkaEFIoFCsRQjM1LB0RU04f/aAAwDAQACEQMRAD8A9mpUqVSSKlSpVJIqVKlUkipUqVSSKlSpVJIqVKlUkipUqVSSKlSpVJIqVKlUkipUqVSSKlXK4xqryREionuVx3qFrlVeMVI83TUVxz5VwtUbk0QMMpGM48BTCRSuOaga7TREstpKStKV6GqrXKb3tMCxRMtNFRPUBvVG9+iCmLLiPuRULeVIXx1rvepTACIhjectrrrSpXW0kVypmBNiGFdmqGc0s5rm7p1dkvZq5n8jVUXDThJqtxk2yyGpTUIRqeFPlV3MogSSlTQDXYqXMqdpVwUqm4yp2lNcpVN0kVKmF/SuG6PEfGqvLsZJmpZqhOIHiK4b4/gVe4y9pkveCl3oqHvvI07vPL8qrcZe2SF/KonvN0Fdzjwrpbwj41NxkAt0ldrz0w4h6skt4D40wgncCoGjAR4SNbhO9cdhUvdik1ifCpul3ErZh0rhPnVr6vTWsVNwhBxKjLVe5bPhVt0g1C90U1GMJgCJScVExq1eIqq8VpQ3mKotjIWao2JqbLO1SXFhY6mm7rROwmD2Q1wWx4mnu1Rl6YCZmKi87PhXKt4PDo4k5vdt8a7SzVANpoXSswvNQY8aUDxrLW/pAw8qrK6sdTJSANdZnXaht76U0VmU4ZzBIkMsEAkA7eVc8UX8Jo7dL2vN1kFdCisViPpJtKqu2HMNEcw6iR92oB9KuH6WLk6ddNR6fp0q+wfwl9slr3m+99Oz+debHtpirs3bToloksqtblggHj1O5mjXBe2FsWz9Zur3mYxlQgZSqkGB6mqai6i5kFVD1mv7zzrneedZsduMD/zZ/sn4Vz+XOEnQ3DG/IaXsaTtafiJpM5/EK776ytzt/hBsLpj9lf1aqzfSNY+7auHwk2xp/ePnU2mCa1MdZs8vn8zXDHiKxtv6RLEHNZuA7wCjCN95Fd/8xcNubV6PROm/3vSptk7en/dNgCviPhXRl8RWN/8AMHDiT3V3p1t9J/apH6RMN/yr3l/N6/49KlhC7an/AHTZSnl8qUp4/lWMT6Q8MQT3N+RsITX/ABaVFjPpHsBeS02bpnIA0/qzNXtlioh6zbFl/FSzr4mvMcf2xxZ2YWgdeS2dQSAOZwT1G3jVVu0OMK5zfvZT1ykDUx0XxqbV6sIwAkXAM9VN1fOl3w8/hXkNrj919frN8iQNGuDU/CqY45iC2UX8TOv9Jc6SerUS01bAYSmJXkGe1d+POuHFDxNeP4XtBjbZJW9eO0hyHHXpcJHjRFfpFxSrz2Efzgg7xqA0H5UZ07CAKydZ6acT51z615n5VjsB2rvEM1y1bYFZQJmUg/tli2npU2K7Uv8A0dpQIHtknmkTosaRPvqdiRDFRDNYcYP4FR3cZ4CaydntY4Qm5ZV2k/zbZVyx1Dzrv191DsR2txdx8lizaT2tXYsRkJUydANRpoaEqqi7cQlYHuibg4wfhmqeI4hZUwzqh6AuoPwJmvO+KPjrjZL2JQGfZFxUHwQCR5mqOG7MYh5Kd0wmJ7xYMgNpO+hFCK9Bc7h7yfzOiz0w4hXPKwPoQaTJXmF/snfUtypKrmIDqdJI08TIOlS9nMbiSuaziSon2Lilh7g4MD0itVOoj9wgzNUDjvCelKQNt6Zdeay1vi2OVpa5h3H4cjj4EGfjNXr/AB9inJbUP1zElPiIO8dKaLXim3WhdFt/eDH0iKlXFW19lP3/ABrKcQ7RX0VTltAktJhyIEHxEUGs9vbpOtq2V8swJHxMfOjKgi5MFarKbAZ9Jv7uP8qVYj+W0/0H/wAn/wBa5U2pC7etMxd4jdUmBKSQCBI1nTrvSs49Wk3HZQTEhJ13g6iDr0qTDYxhAiVaWJjfXST0Ik13F2EuplfQjUMOhG8gbgiazICovMoo3yZZuLcuIuYZUEQbgKvy6aJLE+ulcCKNFZztqx12j9as4jDXHZgqvK92WZiCArTsDqeny21odexiIvtEgnRmGp1bYAQBynz0pqPuzeONID7TLljE38vdpcQbBS4gx15tgdtxrJ2qHGYPEPlY3bZMahmj2dssDmJXynQ71DxFbgSQ+Q7yVB0jaMuh3o3wVGt8rMpJjNOYwxEryqmUSNZJG9QFWNmv7wXoEDB94LwnD7wHtWzEeywZhmk+yNuu/hUj8NCibrmZ0VdJj8U7Ud+vTtBlcwKgEZehDEjTzrPcRsOHjPlMmcxJMiZE9dj86BthyuYSULYacuIDsIPvqBxlHMpb+r+vz3q5hMICFVrhLNAnNl3UHQeJM9av4LB9ypAcm4QGfNIXuxPtBjynMAZX8NJquijjMh0yNkGAMPisw5bQ8BrJzTt8PKn4q5ctwGssvXY6yBqI6wRtUzpbRi4HWVPOcs6giDPx8akXGyzTpdQkByzg7mRly7b9aBlYG4GPWKFFSbGCm4vEswG06Ez7taPcIthQ93EKzWk3CwdjqTzgjp08a5YxVtiLAUHODlECGfmZmZm5vE669OtEfqbIrB1yhiuZcrmQSDMhC2p6RoI13q1zc7TGJSQHMuYi1glyZsLdTO2gknMACYAVzTcBxDD2nu27a3F1Tl7t2gFZGeVbLrm386qY7HKDbuOxfuyzKFt3AFaOuYCQFk9P3t/lAmdWR9XXnUg7iQF8Bp1MnWhZmHAmpRTXgQyvCXxA+zZVCtMMp151fcb+yPjVfG9zaR7LXEDKlsaMuptsSd9dTrHnQf8A8fa2Q1pp1zODBkwAQumnKPEEaVmeK2M7h0lrlyS4AICltRPSs6ozsLjjN5oq6iy/Zm/TwhrgBw9sQ+IBgqSVDt/NwYiBvA186r8GvIt1ma6q6AAtm0PMNQR50MweGvG6EuMq7RLQSD+GQcwB39CJpvH7eRkIIyHQKcxOm5JIyz5D4U9AVa1pkqV6rnIFpsMVfNlAz4iweYEEIrSADIIBM+OtVl4tYIg30gDX7BOaTJgkTv8ADpWR4RhUuuCwYKCAch36mc0kCAdvGiCcKQuq285bMSSfZy6iAN/DmJ6GntWcZitpORYfiaK1hrYud+HLsZIAFtLeuuuVfD31Ws9pna5lthQXOYDLI5FJ3nQQCelRXMe2HVgLactwOSSwkjqIEGTO5Hvpp4kys7LlPeWyJQEkHKDlGsRIHwrL2m/levj8zWHCqLHM0GA7XG4wtXrKiSpzJtAYEiDO486qYztLYVTblCUe5vMlu8PtGIA1PyrLricTdv2rl2HdBEgyxU67IOgkeOtEuI4ohrwCXQHPeGQwAkxABAKyfzrK2kpqMLnqASQI06wpm80+KxgtPkyW3ZgnMzKIVSwkTvp+VCeIY+2IXOkRYec4mUy6ARqYGs6fCsnxG7dxFwSWkZUnUge4fGr13h1ywQqXUuDKJXlmdjowBAmQNZ0quwp39bfi0Ea9+8Bge8O8NtBO5uMwZXuXiTIgBkZWk7EbnxqA3xZtgPyHIVDM6gFpOs5umgoDY48SO60VQCAsSASdd9ddeszTMRxEKrIWLAbKJyKW9ogTpOlPRPEH3/1ENrGLd2azDdoEaeS2wIact0EjMRBAkREQIjeiWExwvhioQgHlA5YbK41huYeyImJ1rzrA41lDlGyhxGh+6CDBnr101qZePXragK28iMqn3kxRNRV7nIPkZa61gbbb+s1fbE3FsEnJmLQElZy5V0gNOpDa1ksLfuFlDWragkAnPsCRr7XQa1YscfuMZuw0+zoM2YCIM6AR5VcsYi4GLZAc4ZeULoSRJZgIjQEdK0Uqm1AucfmCW3EtbmUXxFwMwFpCASAQ+4BgH2uo1pVdGHxBP89lXwCqT812pU7dCsfCEbeDZXV7pVbSg8kmWMabGNDr41A2JAJ7uQCQZJk6AbA6Dbp7zVLDY/6xdVFDtcckLIUDl1P3oAFT8atNhrz2LqtnSJy5SOZQwg5tdCKeLRGLy5gsaFdXLuhUyMsROXLJBBI08PhRjB8RbDhBhktNb5ZcWQ1zdi2uaZ1EDbU1neDYO5iXZLFt3ZVLEcg5QQCeZ/EiqOF4yEeFzowOUyFgGfvDN5GquohWJms4njxfUF7ly6WLSDI1CPlDKBAXUHQRoKH8KW87HWHbumiGk9yuwhTJKxA6/CqmG4kCwzRlLTBJjUZSukkJ16kajaAD2FZ0uXHsWrRa2QVDm53IGYDNbEx00ME6g9KtTYkxbLcAGC7VhkhczryIg5CvKM2kMZEyd/KquNsLnOd3ytdzESNARMrI8GI8K9F4X2ktB7YxGFyOzv3dzOhtzEwrOQSYIGgj4Ve4lxJ7l22tvAm9aYc5ZcpUz0c8hEdCaYK6A22/MS9Gpa+7HoZ5XiLeHtnka+8GUELEFWifOcm24LdYq4b+H70OpurJAHfKIRF+9IJkxHT08/VLnZtHFpu5RMr5mtkKZUqVKkgxOpIgxIFY/iHArN3E38PZUKxCyxAa2QzEEHNqvQAT0PQ0olKjXHTOQLQStSmADkHw5lG12dsPKnEJcJgoUvCGJmAyhZQ6iBDbx618T2UvhCbVlsjHUl82bUgb5So929aLAfRjaUQ91rZyqWKhQJLNoNTHsg1pcPicJhLAtNea4toEyZuOAJbUWxoOg08BQFwOLGPVN3eFh8zzGzhsbZdQLQBUZgoVZInJLFZMS2xOseVNspiJYtZc5shZjIcC0zGSGAMbgVu8b24wGWVS7zZeY2WUMFuAwDcgt1OnjXb/AGv4bcjvkuJIlX7p59oA5LtrmBnXod5oVbPdhGmLYPzMHeuqjkOGbvFLBFeSc4FrKYPLA6ETqNpFd4dbw1wraLXUdoXLIIZyYGU5CRrM+FekjB8OvWyilMzJALswuezAJLnMWHjM0/g/YfCWCHRSWywSWkTIJZZ9kk+H560w1E2kFcyLScMDuxPJ+OWUsObYJfKYfNaUhWIDCLjBQZ0GlDsPjwrw45dWIyieg0g+gr3DiXZW3dAm5cUjqO7InaYdTHuivP8AFdm8f3pRbTEZiFMJESQpYgQNKOitJ+oBHjF12dDgGx8MzB4jF8zOg5hnIYxyTpHuEa1Yx2OV3gIDbkEIQd8gJ2IJg5q3d/sXxFBIRH68rW50/rAa0/g/ZDG3RmK27K+Fy2mY/wBnITE+MU3ZSAvuFvWKFSoTbafaY3B4cWcmd1Fi5nYrBEHI0Tm1HNlEDwqjh8WABzMdNSAsDafvAjeJ869F7ScPx1grP/EIR7S2lADdBCHN7yBUnFuHWLeDF3EWbq3HIUKFQMSddj3mQbxmM+U0pqahRm4PgY8MGJ5BHiJ5tjyuZgCStt2A1Mb6bHm2qWxjUNvNcUXGVoygENlIUyFUiDJAmPdtWgPDrBBFosuggMTqJjNCkdJ1Gm0CSa5ieG92ea0+ZhIIWQeaSJEaak666bRFZ9yC7eHSGFY2PTykGG4ZbxFvvG7zD2y5XMyMf2RmAGZBqNYI8TRXGdjsQtvNYupdBEQCQGXfrKsZ8xQ/ht17zRbdURLmtttVi24cMG03IGv8AzYw/dr9lca2yoQxQwrlLdsg5TKnf2onXepQbthe1vKR2Ci8w+KwWIw5AZTaAeSH0LNp6lhAPWKht37pV0VAFfNmLlQWAJ9ksR4gj/8Aa2VvFXrq5MRfuFCFmAjH+ZW4coCGTJOw0HpVG12Qv3R3gVXBmPtrZXQkASreEUTadRkcyLUBwZmm4argrZVS5TNlYtKgSW1aBmgjx2210de7OqYhniRnU5c5JmMmXTWI99aK7wXF4cZmQFNSTahiumswJGnu86GYrKbZIIQEFVABDz67ZYBEeflrznp1kNgf8wxttcTK2bOW8UEgSdGIkEaaxpvVv6sRbW8SIY5Z69enXb51Zv8ACbdtbbB3zsM8aZYDMIPUkkHxp+O4Y6kWWZWa2YJ6Hfaa1AgqDA3KzWvK1hQuofm8TbJ8OgorgMfcZ0t96SS4TLlInOYUQykL1128apYWzs51h0BAH48xnTQAZfnXeEYxUv2nfRVuI23gQdonpQnaDmN+1ciWr/FrqKpNkEMNDmAmInRQCD1g+NKg983jqSo6zynUxsDqKVTH6TH7vKeqWuCvd4g5xb2VgL3mS9ctgrBWLeRhrG4PQ+dZftvwCyMZdFpmZOTKe8dyfs0nnJJbWevSOlaLtvjbd3FX07u8TktD+bJRh+KRtBgBvHTxrP8ADz3P2WbWC5uRAFtoaQCBJggeZptSvsN2XOLDgZ6zEtsrfxMEB0wTBymcPyEG5dUc2pJNplYiAdNtavYLA3kuq1lZY3OXVmRiDI9s8w2OvjVHi17uwiZbikKNJaY1+9pIiKsdlbj95dIFwZbFxlzE6EMh5ZMA6fKtmxSSwP8AuLVm2AEX8+kWJUG7dWAlwMM9tFbQsfudMvU66flq+GcB7lO9u3Vu2AAzhACwUNBCODEzuPUaVnu2dp7eITEWYGeDAJ0zKA4+R+NGOHcYt2sCq3g1t3a41sJLkKSGOYuRJlm0J8ulI7QWB95oKHPx6z0fs3xfh5QLhntr+yTD+Gufmb11rQA14B31i7dItW3uRE6BHyndgByaHpAJ6bUSxOBa0xFm9eAG2QXJ087Yy+6Z8qIUab5DW9Yjtqq4K39DPbaqrw+2LpvZftCuQtrqu8Hp0FeW4HjvErWi4jOB9y4JJ/8AcAY+5q33Y7tA2LtMXTJcQ5XgHKTvyzqPQ7UFTTtTG64I8oaV1dtpBB5sRO4/hVy+57wBAEWCrEiSXDDUDYZTMdaz176P8QulnErl1EXFLET1Db5vMzXoFcmkhyOJo2i1jPIeMfR9ikUF7tgorcpOfMS5GjBYVROsgdBNct/RhigAQ1s5tyQDlBG1vmEiNswPSt9juNBXcXJFpWtASjghw5ZiWIyshUKwYGAAZiinDsX3iZguVZIXUaqNJ5SQATMa7R6U81agF5nVaRYgATz1+yeKtqCHd3QqURxFmUIjNklun3SJ2OlVcdjMfbbvHS6hChfsGDJlBDmE0YMTp5DrXq+eoruVtCAfWliob5EcyqRaeY4P6Q8QqlS6XLhyqiuhVi5Ys3LozBUgSNNDJ0o1Z+klFP21lgpa5DWyHAVBK5iNAx1ETpp7jvFez2HvAhranyOxrE8R7CYdWzNZzqNtWIXXYoTC+6mAoeRBVCTYH3m7w3aWw9tbkuA6hgCjTDAETE9KZiu1OGQS1wj+y8+4RJ91ZjDXGCqF1VQAAI0AER5RWLxvEQtxzdbJl1Y3Aw67A51N30VY1paopMdUQqt5vuJfSZgrWgNxzpolsk6+IJEbHeKEY/6UgbRu2cM72w6q5cpEHNsAxzbelZTimJS8yutrcTzLCnSC3dsAS+wkDQRqdSRVvHMkWyQFMlUkhgDIOhOkg7efrRtSYZUTMtRSbE5hW72mw5xHejCXecyEBiIZszlSNNxpNOxnaWzfLqR3KoMqk65howUZZymJ1mKHHGWgORpYwDmtmQfXWdao38RJJmY01WfLqKS1N2wVmjegXBEspx3LdLZjckTCqYkgDMIE/OPOjGF4qwt3sykRZuuDBI2tKAQeum1ZTuVvOAqrJgElioGVY36bfurV4a4xW2hPeMiw1yIU68oE6tCwMx3imUwaZvaAqLVuJzh/FLtlluXgJQm5vBYshQZiNIjLEeFUeGcZKMhtM1q41494wy5e6cg8wYw2XU6iY2NFkwneXLNtgvc96ucH8JMGD0/jrVZsIne4e2FUZ2fNpqUUv4eQ3/OnLdheLqhaTbfGarC9pGt6Ym3ABA760s2ySivqpJZYDCTqPOreP4JhcUouFUeRpcRgJ96aN75rF38XmwHIAGa/dVQogCLdvxjoCZohiFP/AIletWX7mUd2NuJIRXMFDKmYXWJEb0ZUiJ3C/h+07xXsLdUf8OVueTmHA3gE8p19KCpwx884lTa1gsxEiP2Pab1A89aWFxvfWbty894926Albt0SGDE8ubIToI069ac/Bk7qzdtFrjXFckycxhyoIRiTp1A3ietBUp7hxGpUAPPxJcFwaxdtfV7OIi6IJDgwxEH7M+G+m+u1W+GdmsZh2NxGssxUoQZaQxH4gOsVm8Vge7uFWzZgA2/iubqNDRrEccvGx3IuXSoOjyq3IU7FwSSJ99VS0t7eXjBq6kL+fKEMb2YusqFyA6j2kCiDtAWSAInTUeEVyqqdu7wAVraHpPMTp4jMJPnPupUs6GxtGDWXEbe7Wvdvi7paVlFpwAG0Vs4YZlPXXT8NUS3O9tSTmIUkx7ElwJ6akbeFMe2LdsF7bIraqSQMynqFYgxtr51UtjOzlTIWNfgNPhHuo6+nY5DBiDf44nOpsSTuBAtb3ljE8Qa0DZzEoDoGAI9Vn2fDQ1Pw3iFssDcXqAfQnp5+s1FiAM2sAuNm6HXw2/3q1w/gN68Qtuw39efswB1zNoPj8aFNPVqDttw9D8x4q9kdgBmit2cPirps2bjFlBcZhysqkAlXHgTsQPfVbH2BhbwV0JtXQoQguZubFSFkAxBGg2MkaSf4Th1wlhmuOrXBmL3QBCodciuQCwnWT1J6aUHvY247PetNdKEABe4xGUBRBgqoLTv7QG9GwUN9vE1h32WfmUOO2LUAuR3ZB0L2yqhdWnK85huBBbTwmifDux+IdEKYvEryqQGuDlDAEToQ3oZoM1u7iMRlXLkJHeKzNnW0w0BzMQkndQAYAk16Yg7qLaqVRQAo8vXxq3BwBApuqglushwHZKwttVunMFAEKSBp+1vr5RR2w1q2oS2MqjQAbVRGK6Ug/WklSeYbVATeFTfpd/Q4X642JqbIJqiEGug/lUaOqgKoAA2AAAHoBVA4nzpjYiiFMxZqCEWv1G1+hzYmoziqIUoBriEjeFVMbLAFYkdDMEdQY8vI+lVXxVU8TxHIP4+VMWib4iX1SqMmSvhZkmUYmeUyNgNQf0NVsZg7dyBcNt/Nt/mNPjVZce7sQTlUbn9K6wSP1NMOlHWAn1cqMZHnA+J7C4eSbZdCREpdB08NzHWht36PkUfYko8+2xViRrI1Namzi7KAJGWOpEgnxJ3p9y9aI3Qj1Wq/hiDyYY+qoR3Qb8zDHsHeMq91WtnVgMucnfcN4/Ko/wCQ96YZhkHsZBziNBJkg6Vs2sYcmYX4iqHF+H2CpK2gWPURA9QPKaaNMWxcxX/JqvNMfgmZpOw92SWa6DtK24089CDRF+CxZ7su6mAM+zSOs1LwvBBObIACNZEe8e6iAxDKJDOI6Bm/Kdah0LH9Ui/XaSG3ZexmFxKHDlWcICjKwPMVYhsywoE9BJLVBhuPnNMZrhJKnKdGYFZJOsBSQFGlbXG8XFwQQrn9u2v5qA3zqgt3DsefDsn7Vpv8lyf+6hbTV1GLGPp6zTVTc3X1gR8Sfq1iyxGc4hiQCdZyqDBnfTStFhcQTxLFnSFs3T0nVUXffrXMPgLd1lNm6jMCCEuDJcMH7oblb3E1Dg8K9i9ibl6Va5ZdQGBEu1xG6DUEA69IpIYqQri3E1GirgtSN8GZ61fUYV7S53ZriPED2VWNII6/nVjj7kYbBqghu4JAM8uYgzPjrQgcOxCzyoviZJPuJJotxy5h7yWlYkG1bCe8eHltvVq172zj/Mp6ViL4zf4lnjPaW219wAl2yzKFOz6jKxDaEdN6ifidsEBEdhJjMVA5jm1IihAwmcSl7lH3QNvMtGWreAwgFksGJAViQV5tWBBO0Cgd2XuyLTDCxtG47jLIYW3ZBHWM8j1Mj5UqoXrVq42iuSNysxPgDSpW2q2bwftGIW7Q4xXcXM7XHW6A4IGRhucsjac2pkQBpVW1xphZdAtoXDcleQCFAM5TMROuXLG5mhoxCw/MZUArqIBGkZSNf96nw/E9IRVkxoFBPgR4ySRWVWdQAs0GmGOZ6h2bQZLV0FA5Uk5VXLJgHKRI3E6H4UZdnaCzs3xrPdnHNmxatP8AzgQEgbCdI8v9qKfXjP3ffr+taSbTZTUbQQJX7XXXXDwpAzOin2dVYwQc5AM+UmjOJ7L8NYy9gMx017yfm2lA+17OLFp1mEvIzhc5lZ8EYSPIhh5aTW1a1m3dviKlM3vMupGRaBsH2XwFsMtvDqucQ0MQCNRrznxNFbVlVUKC0KIAlzAHnJJppwg/Ex+H+ml9XHn8v0Ap35mSx6iAeJ425YxtsF3Ni8uVVIMJcBGsnWDI38TrRoXT4ih/aTggv2SFJFxee2czaONgYaYO2ketD+EcYa9bPM63EOV1ddM40I1Eb75SYmKHeFwYYoGp3TYwzevHnAMZQNfM+FMt3G7xxJyiIkzqdTvqOnxFUhcuS0i20wCOunQEERUpxlse2GSSDIYHUf1t/dRrUQxVTSVRkfvLbXjUL4qo+4ZwTbuI+8A8ra7aHTShWNuXEYhwUPmInTWDsdfCtNNVfgzlaqpVpcqYTuYwD31C+OoScWa4bh8a1iiBOW+sc8QoeIRvUF3iBJ0A8tNaoZq4WohSAiG1FQ4vLL4pjuaabs71BmrmamBAIoszcmSl6YwFNzVxjRWggTpQeAprW18BTSaaWq7QwDH5Y2JHvNc7xt5B9R+6KYfWuFqsCHmMv2FYyQVPlqPhvUd3AqRKGT5/xpU4aueY3q9sYHYQaVVigiQDrPrNXuH8WuIpt3AL1gfcualQTrkfdT4bjyrty2G1BCt18D6TVXYNIIOmh99KemrizCbKOodDdTaE+IcEt3LXf4cs9qdVJ+0tkdDH8etY+9wYIeRRBOrbtsd531o9wviVzD3O8tCQQBcQ+y6Tt5MNYPn4Udx/D7d6z9Zw092ScyEQyMNwV6Hy66EefH1Gnak25eJ6fSapNSmypzPNisANAC9M7RJB/CB49PlSt3dczjO5GVQM0LO5zdPWjuM4eJzr7YBA8NYnT3ChOKwp10bTQktA+C6fIVEcVBYjMqvQaibjiVMZgxCJ7bFQSLcggLpqNiJO+h0pVPhXZJCFVkySTJ9wrlAdPnkwBWk+F7JW97uIJERyoAYn8Tn9KK4BcPhzOHtS/wDzG1PxP+UCpLfBbC74kE/s23PzYCriLg7Ylmvt5gW1H+Ims2egtOmopg5N5Pw8sTnYyzfp+VEEUk70OXjeCEDLf/v2/wDTUlrjODYaPfX1CMPkwqBb8mN7VBxDHGkz4a4kEyp0AtmY8rvL8x5EGjHZ3iveYayxDlsuVoBPMvKZ7oMoOkxPWsotzD3BC37TeT5ln+9yn41zsZxVsLiFtxcOGxCqVCWUFu2xgZ2uWztMqSV2gzAksUWmWvZ+DN6cx17tz8P8zfpXTbfoqD1b9Av61aZvT5k1wMfP4AUW4zLtEgXDufab+4p/NiaA8c7PurnE4Yg3yIdXKhboAgSVQsCNOUEAxrWjI9PmTTL15V0ZgD4EgH3KNTVEboSnabieW8Y4/es30v2g4tXFCXFKFSWTMC4t3DKEEQJiQNehrrcTuOBefH2rSsJAW2FukRtmuyJHXKDrNa7jvZ23iT3qobd3QG7lUZlHRhcBO2xgEaelYt+H4rhr5wG7piRltlrgYlhzT3YVW10zBZ896i3XBhsQ+RzCHCuLa8n1rETHMwAUeam4U3/ZB6VqLPEzly30LW2AkMBKz4wT8R86xF25cvgvd4gtlD7SBBbuidcrM7ch22qLhWLw9py1pb95yCpcFihGm7XCFPuk0y18rA3C218j9psOOcH7pe+tEtZ0zAmWSeoP3l+YoULk0Z7O8eDKUu2yqtKw2oKkbE7dT+XhQ3jfCTh2zpLWWPKd+78nPQeBro6Wt+ipz0nn9foFB30uPKQF65nqJGrpat9pxtsdm8a7mqOaRapaTbHFq4XNcY0wtUlhY8mm03NXGapC2x9LNUTN503N51IW2TzXCaiDUmfSrvJtj4nTemm0RsSvqR+Rpqk66kAb+dSlAAYGoE69B5+O40HjVXh8SLM/Rh8F/dRzsHiCMQ9pjIvWyT4ZkOm2xg/KhVu6Ao3n03HT+NaLdhsJ3t+5eI+yRCik7Fj7Wux/2rLXdWok/j8idDSI61gLef4ModosMLV9lgAHmHlMg/MGszxbBKxzFQfJtp01+VantVdzXtAdNPjzRPXegXELQdChG4jqOlcQkBr+E9gFL0QD1Ey2IRZ/opHhpHzpUzHX7iHKtoZRAmCZgeVKtHapOZ2NQdPmGFOJux3VswdjBk7nTSI0+RqjbuGSzr3mnWcvUaAaafpV/C4tr+HfmuZrbqAxeM1szCFRAJHjpAPWaHYu42onpEbmP63TTQ1jY2muc+sgaiQD0zEj3yTBn5VatXuWQy+RKxPjAmD60IugDQHQxHjppRmyii0rHLMGCPaEk7g0m55gpnrK+JI1yqA3gvhPjoRWu4hgbV3C21cZu6zr7TLoFXLLLM7HodqyPf8AKWIYr4xAn00JrZ8MxBfN0GW0+8688/8AcK0UbNdTBfjcOkPdie1iOiYe5cQ3wOQJcVy9sARLvEuBuJJMT4xpLly8dlVB1LnMfcBAB95rzO7i7+IZ7a2mwzIpud4bA7tyhBgZgJO5B8qLdne2qo3cYk3HIIAvmyygbD7Y9NfvwBG/jTAbcwGUkXE2TIT7Vx3B6CFHvyxI9Zp9q0qjlVU91dzftCPLrSTyEeZozEgR4E9J8ztXcs+fptTRB8WPyobx7tHh8MB378x0W0gzXGPhlG3qdKEwwL8Sjj+yFiXbDn6tdcgs1tQysQZh0OkeSld6y3aW1iVuLZW7YFwlgIJYwPZzADkO7HMBHTNGs/GO0uMvqwQDDWmEBd7pH/qEeyPIQayHE+E3bKLccgsZNt7Z5TOpFy2w8CdVPxqgxXK8Rppk2Dc9BLmI4GQS2Mvm548xW2B5bfpWm4L22CkWwr3rWizkAUDbQsRnEeRrH8Cx2HcnvLI71YhmdmUkn7quxg07E8TvF2SxaYkGMxHKPft8a0AqVuf/AEzIwcNt5+AJ6Hc4PYvjvMJcFsndGk2yT0/FbP8AEUJx2Gu2D9tbKD8Y1tn+2ug98VmOENiEvC7cusziQADCCQRqBE/Ktfw7t2FuLZe4jMxgBZJn9qJA9DT11FSmM8ecytoaNcnac+UqK4I01HiNR8qTNR299QvNNy3kc/eSVPvKGPjUd7sura4fE+64Aw/v24+YNPTXI3OJjq/SKyQFPnTCw21ojf7MYtRoiXP+m4/z5aH3cJfX2sPeU/8ATcj4qCK0LWRuCJkOlqLypjXuRt/Hxppu6xt1qK60bqyn9pSPjIFRNiU/Eu3Uj9aYCJOxI5EsBzr+tNV6h+sIfvg+8U/NPsgn0BJ+QqFgJYpnoJNM6fxFRk/D0olhuAXmU3HK2RMDPOZteigT++k/Absqqwc0wz8qkiTvqdp6axWX+O0+7buF/eaBoa+3dtNpSw7AAgnRtJ21Bn4fvp9y+BObQ5YadJURt57fDwNG8N2Mb+nxCKOq2hmb+83+mrdnDcPwxlVFy4NmdszDrouw9wFDU1lNeMxlP6bVc5gHD4G44tm4rJZZ1tB4hueQOXcDTfTbTxrTX+KW8PlsWdEWFyQIbN1DaaTvA6QNxQfjXHDiRkQQ0gAmNQWWdAD6jXcfHP4/iOS6zO+dgk7febXU6DTyJrz2q1h3EDqQZ3aOlFJRuHlDq4Nrz95dcKGI0HViYjw2/jrVDidlFnIOUH8QJEiddB08vyqra4uHChPutIIO5Ea+s5jHgfKm28SCzKfCDpuBHX+NRUosXyTk9J0Fqi3lKz2gdxSpC8pJggxpp+6lTdrRwKkXlfs3hUFu/ZdkBchkDHkEKQIcKWZtSY2G+9U8dhjYdreZWiJZSYgidJEk69fChfDMVcwt9XIIKypDCTB/CG036+tGuK4XMpxCspW4Zyg8ywoIEa+kz01qj3c8zBe+RxAF5EQwROsyTtVnD39ZMt4DpHm36eVNxFkBTmbUT6T4SOtU0xLdIG2niB5UnbmLI2m8uXL4IProDt+fyrUdkMXKseq2nB8OUhwPgprGW7gXTqenQH+OtFOzXERbulejgrPTMZAnxBBI99HTfawMBSSbHg4mu4RjsU95RkVrL5hIbmQOhEMp3hvCqXaBcSCnc3BbVlIY/e9BHr5etC+B4jELiQRcEK6MUIgFQwkr4Hy86N9tMLehRZCyrspJIAAPXU+VblIZSTBdSjgDmLslxrEYMC39tiVMkplUJb1klbrNodzlOh8q2d7tZhRaW890gNMWysXZG4Nvp6nTUa615AeHXSwa7dJYEEZToCOo6D3AUc4V2ctX1cuzi7mU58xLGZ1M76g0IVug95Cyfq+JpsT2nxeJOXDr9VsndmE32H7I2X+NaHYTDW7F1yAWYmGdjLn3n9IqXhtq9aud3edHiMrCQ7A7ZgdAd9qbxJIuuY8PyFAV+255vNlKwb7eLXk2IOYeNR8fw2bD2fL/AEkVFh75kA+I/OiHFNcPb/rR/wB9GhujCSsP5yGeccU4XrI0g/Gm4TtFiLXJOZdgG3HoR/vWoxGFkGhlrhktzDSswZkOI56CvzBL4q/ekeyp3C7minAuCd2wc7jUeP8AtRnDYRVGgAqdfKaNmZ8sZdOglPuiTrcMb/lNSqTvMefUD1FVjdFdz+elAZol9ePXxoHJ9QD896sW+1OIG5X4H8wayV3jKhmEaAkeelWcJxFHmnFXVbzEr0Kj7bZ9JrE7YXAOZAfRo/MGnfy0P/K/xD/TWIv8WUNAGlF+A5SPrDiUUwBvLbbfH30FV3pJvY4ggaZnKAZmg/lw0wLJk7aj5QtS4jtdcAYFYJU7EGJ08AZ8qCcb4p3iKrbgkhgo5QN4jp5elA/rwt4a5dYsXuhu7IgcpeJjcEgEehNcttXU1CWXFzY+NpHp0lYBR+ZpLDYu9FzIcomAeh9N5qvjOOYjN3Y3B0AUTPkCJFBeB8SS2FaWU7EKAOnXpv671e/lHKlragEQBnzMSNQQTpqNNvClUVNE/dkeXSPp7befnJMSMQ8ls7QNSTI0jbWDv0qkXYamQD5RPpStcbKtLWVBP3lJB8jzE1bfjPerlzliJ5X5fmDDe/Wt616bdZZqFekscOeFbKxE5VJ25ZDN4QN99+umhx3arHBnIBOUaDQASYnQHTSjOVwHIKI7nQFXAtxIkSSCddJ0E1kuJ4dhcKmYZhl31XXXbxP50NSkN4bpM7uWHEu8AfrrCsp9RzCKvviG7wshEyZJ9nmEnU7ahT7jQfPkUW4MzJ84mPdRLD22yjLG2oO0RsCNjMH3Uyi20nF7zKbjAhLh+EsB81y5mzZoykhB1gtvMEHp76VC3xNqMt0aDoMpjw0Bnx1867UcVGN9xhLgWtIuN3ze1aBERA2nz3NEOyZS6j2HQZbYVlK6HO7hcxJkmB0nX4R2lWut3ovSYpwPxBdcvz8o2+QoZeSNZ3j9f3UqVZo8zrXNjA2G+vl1p9tJ6xGtKlVHiKMLG6zItyYfLMj4VqO0+Pb6qLx1Yi059XUT+ZrtKtun7p9IWp/RMBd4tcY6ELPgNfia2H0fYbIbvMSSLZk+rUqVXSN3i6uFxLvbViL1ogwYkHqCrGCKrYRmZWzMSQSZO5PnSpUGo701aI/ZLFoeyfMUax4nDj+v+rUqVXT7rekKt/UT1ga4tM7vzpUqzzYOY8LTgKVKoYYjSvWmXjAmlSoBCMEYnhwknNuZ28arW7eVtDuKVKujU7k4NDFb3j8Pgswkt1Ybec/rRfhFxrRgGQFJgjTXXbp018qVKud9S/6w/EtP6x9ZIZu2EYmCwymNumse+hHG3ItzO+UR0EBjp8vhSpVztOACfWaxzK+GXYeOX5kzSxd5reSDo5C+m2oPoYpUq3IileOsonMnZJ66bR8P1M10LDZZkFZ9+g/3pUqmpRcY6GXRNwZfwzSqjx2/Z9PLyNR9oMIqZuptoYJ6gZdCP1GtKlQ0e5aXU5gW7eMs/WPyANR4TBvfjNcgSTAXXXzmlSo6fJmdOTJMJgrdm4AVFyZ9rp6AUqVKrY5mhRif/9k=',
            'data:image/jpeg;base64,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',
            'https://hocboibonmua.vn/wp-content/uploads/2021/02/be-boi-hapulico-1.jpg',
            'https://hocboibonmua.vn/wp-content/uploads/2021/02/be-boi-hapulico-1.jpg',
            'https://hocboibonmua.vn/wp-content/uploads/2021/02/be-boi-hapulico-1.jpg',
            'https://hocboibonmua.vn/wp-content/uploads/2021/02/be-boi-hapulico-1.jpg',

            // Thêm các URL ảnh khác nếu cần
        ];

        $image_rating = collect($image_urls);
        $gym_ratings = Room::query()->paginate(3);
        return view('gym.rating',compact('image_rating','gym_ratings'));
    }

}
