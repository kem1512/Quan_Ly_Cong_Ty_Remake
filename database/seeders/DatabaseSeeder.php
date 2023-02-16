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
            'password' => bcrypt('admin'),
            'personnel_code' => 'NS1'
        ]);

        $data =[
            ['id' => 1, 'code' => 'SCN1', 'name' => 'Phòng Pháp Chế', 'created_at' => '2023-02-16 04:40:36', '_lft' => 2, '_rgt' => 11, 'parent_id' => 4],
            ['id' => 2, 'code' => 'SCN2', 'name' => 'Nhóm Phát Triển Phần Mềm', 'created_at' => '2023-02-16 04:40:36', '_lft' => 3, '_rgt' => 4, 'parent_id' => 1],
            ['id' => 3, 'code' => 'SCN3', 'name' => 'Nhóm Quản Trị Hệ Thống', 'created_at' => '2023-02-16 04:40:36', '_lft' => 5, '_rgt' => 6, 'parent_id' => 1],
            ['id' => 4, 'code' => 'SCN4', 'name' => 'Tổng Công Ty Sconnect', 'created_at' => '2023-02-16 04:40:36', '_lft' => 1, '_rgt' => 12, 'parent_id' => NULL],
            ['id' => 5, 'code' => 'SCN5', 'name' => 'Phòng Pháp Chế Con', 'created_at' => '2023-02-16 04:40:36', '_lft' => 7, '_rgt' => 8, 'parent_id' => 1],
            ['id' => 6, 'code' => 'SCN6', 'name' => 'Phòng Pháp Chế Con 2', 'created_at' => '2023-02-16 04:40:36', '_lft' => 9, '_rgt' => 10, 'parent_id' => 1],
        ];

        DB::table('departments')->insert($data);
    }
}
