<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fullname' => 'admin',
            'email' => 'admin@argon.com',
            'password' => bcrypt('admin')
        ]);

        $data = [
            ['id' => 1, "code" => 'SNC1', 'name' => 'Sconnect', 'id_department_parent' => 1, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],

            ['id' => 2, "code" => 'SNC2', 'name' => 'Phòng Công Nghệ', 'id_department_parent' => 1, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 8, "code" => 'SNC3' ,'name' => 'Nhóm Phát Triển Phần Mềm', 'id_department_parent' => 2, "avatar" => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRqRyIiwYCq4s-fZi1zdmyfSuIPUvg9EyZ_Q&usqp=CAU', 'created_at' => Carbon::now()],
            ['id' => 9, "code" => 'SNC4', 'name' => 'Nhóm Quản Trị Hệ Thống', 'id_department_parent' => 2, 'avatar' => 'https://png.pngtree.com/png-vector/20190704/ourlarge/pngtree-boy-user-avatar-vector-icon-free-png-image_1538406.jpg', 'created_at' => Carbon::now()],

            ['id' => 3, "code" => 'SNC3', 'name' => 'Phòng Hành Chính Nhân Sự', 'id_department_parent' => 1, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 10, "code" => 'SNC4', 'name' => 'Phòng Hành Chính Nhân Sự Con', 'id_department_parent' => 3, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],

            ['id' => 4, "code" => 'SNC4', 'name' => 'Phòng Pháp Chế', 'id_department_parent' => 1, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 11, "code" => 'SNC4', 'name' => 'Phòng Pháp Chế 1', 'id_department_parent' => 4, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 12, "code" => 'SNC4', 'name' => 'Phòng Pháp Chế 2', 'id_department_parent' => 4, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 13, "code" => 'SNC4', 'name' => 'Phòng Pháp Chế 3', 'id_department_parent' => 4, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 14, "code" => 'SNC4', 'name' => 'Phòng Pháp Chế 4', 'id_department_parent' => 4, 'avatar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6w0iLn47qlyZKqAWdYuahcG16QzNFa0dt4YieTcNzyzvtVJ6NuVlzHGEa8Or1qa02cwY&usqp=CAU', 'created_at' => Carbon::now()],

            ['id' => 5, "code" => 'SNC5', 'name' => 'Ban Giám Đốc', 'id_department_parent' => 1, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 6, "code" => 'SNC6', 'name' => 'Ban Dự Án', 'id_department_parent' => 1, 'avatar' => 'https://vothisaucamau.edu.vn/wp-content/uploads/2022/12/1670579071_256_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg', 'created_at' => Carbon::now()],
            ['id' => 7, "code" => 'SNC7', 'name' => 'Ban Tài Chính', 'id_department_parent' => 1, 'avatar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRormNx-cWkV0Ggs-j5Jnk6g6x7JSyVqRh7uA&usqp=CAU', 'created_at' => Carbon::now()]
        ];

        DB::table('departments')->insert($data);
    }
}
