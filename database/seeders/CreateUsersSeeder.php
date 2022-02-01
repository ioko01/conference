<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                "prefix" => "นาย",
                "fullname" => "ธนพงษ์ สุนทราวิรัตน์",
                "sex" => "male",
                "phone" => "0997711531",
                "institution" => "มหาวิทยาลัยราชภัฏเลย",
                "address" => "อาคาร 20 ชั้น 4 234 ถนน เลย-เชียงคาน ตำบลเมือง อำเภอเมืองเลย เลย 42000",
                "position_id" => "1",
                "person_attend" => "attend",
                "email" => "monday-december.1997@hotmail.com",
                "is_admin" => "2",
                "password" => bcrypt("1234")
            ],
            [
                "prefix" => "Mr.",
                "fullname" => "Thanapong Soontarawirat",
                "sex" => "male",
                "phone" => "0997711531",
                "institution" => "มหาวิทยาลัยราชภัฏเลย",
                "address" => "อาคาร 20 ชั้น 4 234 ถนน เลย-เชียงคาน ตำบลเมือง อำเภอเมืองเลย เลย 42000",
                "position_id" => "1",
                "person_attend" => "attend",
                "email" => "ioko.peezaza@gmail.com",
                "is_admin" => "0",
                "password" => bcrypt("1234")
            ]
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}