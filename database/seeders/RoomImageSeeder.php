<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $room_images = [
            [
                'room_id' => 1,
                'image_url' => '/img/images-1686043264347-8b7f9ee2-e8e6-43c6-baec-ec42ff40ed52-ZAD_Case-studies_California_1362x628.jpg',
                'created_at' => '2023-06-06 09:21:04',
                'updated_at' => '2023-06-06 09:21:04',
            ],
            [
                'room_id' => 1,
                'image_url' => '/img/images-1686043264355-e30db190-3991-4f1f-aade-42e5f1f7af34-gia-tap-california-thumb.jpg',
                'created_at' => '2023-06-06 09:21:04',
                'updated_at' => '2023-06-06 09:21:04',
            ],
            [
                'room_id' => 1,
                'image_url' => '/img/images-1686043264365-effafffd-0bf8-44e5-811a-dbe9367d5a7e-phongtapcaliforniafitnessyoga17-1633450816_750x0.jpg',
                'created_at' => '2023-06-06 09:21:04',
                'updated_at' => '2023-06-06 09:21:04',
            ],
            [
                'room_id' => 2,
                'image_url' => '/img/images-1686043643361-8d3b960d-cf4e-43f7-830b-8084e32933a2-gym-o-ha-noi-1.jpg',
                'created_at' => '2023-06-06 09:27:23',
                'updated_at' => '2023-06-06 09:27:23',
            ],
            [
                'room_id' => 2,
                'image_url' => '/img/images-1686043643366-0971081f-e8de-4aa0-9890-58c2585cdae5-nshape fitness.jpg',
                'created_at' => '2023-06-06 09:27:23',
                'updated_at' => '2023-06-06 09:27:23',
            ],
            [
                'room_id' => 2,
                'image_url' => '/img/images-1686043643368-35c7c871-27c1-4ef9-a050-338c7e8a8357-tng-nshape-fitness-692143.jpg',
                'created_at' => '2023-06-06 09:27:23',
                'updated_at' => '2023-06-06 09:27:23',
            ],
            [
                'room_id' => 3,
                'image_url' => '/img/images-1686043823765-f20ab647-3ae2-4a05-abd7-c85812f853fb-img-7875_orig.jpg',
                'created_at' => '2023-06-06 09:30:23',
                'updated_at' => '2023-06-06 09:30:23',
            ],
            [
                'room_id' => 3,
                'image_url' => '/img/images-1686043823769-02aef519-87bf-4997-b8c7-1ef542171d67-top-30-phong-gym-xin-nhat-quanh-ha-noi-4.jpg',
                'created_at' => '2023-06-06 09:30:23',
                'updated_at' => '2023-06-06 09:30:23',
            ],
            [
                'room_id' => 3,
                'image_url' => '/img/images-1686043823771-9623fb54-84b7-408f-96d7-0fa8919d81b7-348s.jpg',
                'created_at' => '2023-06-06 09:30:23',
                'updated_at' => '2023-06-06 09:30:23',
            ],
            [
                'room_id' => 4,
                'image_url' => '/img/images-1686044034782-d5073b69-9d44-4e58-8a4a-85b356c74686-2017-08-23.jpg',
                'created_at' => '2023-06-06 09:33:54',
                'updated_at' => '2023-06-06 09:33:54',
            ],
            [
                'room_id' => 4,
                'image_url' => '/img/images-1686044034784-ac639bd0-3aff-41aa-9b2d-7a17d6bfe2a9-20170823_165410.jpg',
                'created_at' => '2023-06-06 09:33:54',
                'updated_at' => '2023-06-06 09:33:54',
            ],
            [
                'room_id' => 5,
                'image_url' => '/img/images-1686044291251-6b2f0e17-2738-4aca-967f-da542f7d05f3-imager_3361.jpg',
                'created_at' => '2023-06-06 09:38:11',
                'updated_at' => '2023-06-06 09:38:11',
            ],
            [
                'room_id' => 5,
                'image_url' => '/img/images-1686044291256-ca4294e3-711c-4a57-a23b-961c852290dc-1582061648_am-thanh-phong-tap-the-duc.jpg',
                'created_at' => '2023-06-06 09:38:11',
                'updated_at' => '2023-06-06 09:38:11',
            ],
            [
                'room_id' => 5,
                'image_url' => '/img/images-1686044291258-3a318090-7d2f-42ff-b949-0e20493902d9-anh5.jpg',
                'created_at' => '2023-06-06 09:38:11',
                'updated_at' => '2023-06-06 09:38:11',
            ],
            [
                'room_id' => 6,
                'image_url' => '/img/images-1686044424267-24ff6baa-afc6-469e-adef-7ec452f07605-Thiet-ke-chua-co-ten-7.png',
                'created_at' => '2023-06-06 09:40:24',
                'updated_at' => '2023-06-06 09:40:24',
            ],
            [
                'room_id' => 6,
                'image_url' => '/img/images-1686044424287-51b64059-9f9a-41b2-b4cb-f924f623bcea-fw_website_club_images_surrey-12.jpg',
                'created_at' => '2023-06-06 09:40:24',
                'updated_at' => '2023-06-06 09:40:24',
            ],
            [
                'room_id' => 6,
                'image_url' => '/img/images-1686044424291-d95b47d3-9daf-4f54-80c6-08dc1f65af9d-fw_website_club_images_kingsway-04.jpg',
                'created_at' => '2023-06-06 09:40:24',
                'updated_at' => '2023-06-06 09:40:24',
            ],
            [
                'room_id' => 7,
                'image_url' => '/img/images-1686044602429-59029bdc-21e2-454f-9fb7-ff32be04abef-studio_profile_FCBC5572038165.jpeg',
                'created_at' => '2023-06-06 09:43:22',
                'updated_at' => '2023-06-06 09:43:22',
            ],
            [
                'room_id' => 7,
                'image_url' => '/img/images-1686044602430-74951ffa-bf32-47cc-a334-7c2a222fe1fc-xfitness-batikent3.jpg',
                'created_at' => '2023-06-06 09:43:22',
                'updated_at' => '2023-06-06 09:43:22',
            ],
            [
                'room_id' => 7,
                'image_url' => '/img/images-1686044602430-b14a1540-175b-4808-9e17-e2e222401bd6-171504-the-tap-1-thang-xfitness-body-15.jpg',
                'created_at' => '2023-06-06 09:43:22',
                'updated_at' => '2023-06-06 09:43:22',
            ],
            [
                'room_id' => 8,
                'image_url' => '/img/images-1686044739828-2b8b37f5-6786-4748-84c1-767dd8a9afee-nhung-tieu-chi-danh-gia-phong-tap-gym-tot-tai-ha-noi.jpg',
                'created_at' => '2023-06-06 09:45:39',
                'updated_at' => '2023-06-06 09:45:39',
            ],
            [
                'room_id' => 8,
                'image_url' => '/img/images-1686044739829-551ce5b3-a076-4ffe-83e8-348f0dfb7f6a-Md-fitness-le-van-thiem.jpg',
                'created_at' => '2023-06-06 09:45:39',
                'updated_at' => '2023-06-06 09:45:39',
            ],
            [
                'room_id' => 8,
                'image_url' => '/img/images-1686044739834-eed8c0b1-d4c2-4c29-a12e-9009f2c94d8f-img-mi2-8258579153746671800.jpg',
                'created_at' => '2023-06-06 09:45:39',
                'updated_at' => '2023-06-06 09:45:39',
            ]
        ];

        DB::table('roomimages')->insert($room_images);
    }
}
