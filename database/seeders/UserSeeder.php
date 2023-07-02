<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
   $users = [
      [
        'name' => 'Lee Bao Anh',
        'address' => '22 Tran Quang Dieu , Dong Da , Ha Noi',
        'phone' => '0963559370',
        'username' => 'anh.lb194470@gmail.com',
        'password' => Hash::make('123456'),
        'avatar' => 'https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png',
        'role' => 'user'
      ],
      [
        'name' => 'Lee Bao Anh',
        'address' => '22 Tran Quang Dieu , Dong Da , Ha Noi',
        'phone' => '0963559371',
        'username' => 'dxdass3105@gmail.com',
        'password' => Hash::make('123456'),
        'avatar' => 'https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png',
        'role' => 'admin'
      ],
      [
        'name' => 'Lee Bao Anh',
        'address' => '22 Tran Quang Dieu , Dong Da , Ha Noi',
        'phone' => '0963559372',
        'username' => 'anh.lb194470@sis.hust.edu.vn',
        'password' => Hash::make('123456'),
        'avatar' => 'https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png',
        'role' => 'user'
      ],
      [
        'name' => 'Do Minh Quan',
        'address' => '22 Tran Quang Dieu , Dong Da , Ha Noi',
        'phone' => '0963559373',
        'username' => 'anhlbaws3105@gmail.com',
        'password' => Hash::make('123456'),
        'avatar' => 'https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png',
        'role' => 'gym-owner'
      ],
      [
        'name' => 'Lee Bao Anh',
        'address' => '22 Tran Quang Dieu , Dong Da , Ha Noi',
        'phone' => '0963559377',
        'username' => 'anhlbio@gmail.com',
        'password' => Hash::make('123456'),
        'avatar' => 'https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png',
        'role' => 'gym-owner'
      ]
    ];

    DB::table('users')->insert($users);
  }
}