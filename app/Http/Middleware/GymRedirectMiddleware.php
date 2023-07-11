<?php

namespace App\Http\Middleware;

use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GymRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
//        dd(auth()->user());
        // Kiểm tra vai trò của người dùng sau khi đăng nhập
        if (auth()->user()->role == 'gym-owner') {
            // Kiểm tra tồn tại phòng gym
            if (Room::where('ownerid', auth()->user()->id)->exists()) {
                // Điều hướng đến trang chi tiết phòng gym
                return redirect('/gym/' . auth()->user()->gym->id);
            } else {
                // Điều hướng đến trang đăng ký phòng gym
                return redirect('/gym/register');
            }
        }
        return $next($request);
    }
}
