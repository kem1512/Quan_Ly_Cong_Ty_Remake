<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\equiment;



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
            'personnel_code' => 'NS0001',
            'level' => 2,
            'img_url' => 'marie.jpg',
        ]);

        $position = [
            ['id' => 1, 'position' => 'Tổng Giám Đốc'],
            ['id' => 2, 'position' => 'Giám Đốc'],
            ['id' => 3, 'position' => 'Phó Giám Đốc'],
            ['id' => 4, 'position' => 'Trưởng Phòng'],
            ['id' => 5, 'position' => 'Phó Phòng'],
            ['id' => 6, 'position' => 'Quản Lý Cấp Cao'],
            ['id' => 7, 'position' => 'Quản Lý'],
            ['id' => 8, 'position' => 'Trưởng Nhóm'],
            ['id' => 9, 'position' => 'Chuyên Viên'],
            ['id' => 10, 'position' => 'Nhân Viên'],
            ['id' => 11, 'position' => 'Thử Việc'],
            ['id' => 12, 'position' => 'Học Việc'],
            ['id' => 13, 'position' => 'Thực Tập'],
        ];

        DB::table('positions')->insert($position);
        $nominees = [
            [
                'id' => 1,
                'position_id' => '1',
                'nominees' => 'Tổng Giám Đốc Công Ty TNHH ABC'
            ],
            ['id' => 2, 'position_id' => '1', 'nominees' => 'Tổng Giám Đốc Công Ty Cổ Phần XYZ'],
            ['id' => 3, 'position_id' => '2', 'nominees' => 'Giám Đốc Kỹ Thuật'],
            ['id' => 4, 'position_id' => '2', 'nominees' => 'Giám Đốc Maketing'],
            ['id' => 5, 'position_id' => '2', 'nominees' => 'Giám Đốc Pháp Chế'],
            ['id' => 6, 'position_id' => '2', 'nominees' => 'Giám Đốc Nhân Sự'],
            ['id' => 7, 'position_id' => '2', 'nominees' => 'Giám đốc Tài Chính'],
            ['id' => 8, 'position_id' => '2', 'nominees' => 'Giám đốc Vận Hành'],
            ['id' => 9, 'position_id' => '3', 'nominees' => 'Phó Giám Đốc Kỹ Thuật'],
            ['id' => 10, 'position_id' => '3', 'nominees' => 'Phó Giám Đốc Maketing'],
            ['id' => 11, 'position_id' => '3', 'nominees' => 'Phó Giám Đốc Pháp Chế'],
            ['id' => 12, 'position_id' => '3', 'nominees' => 'Phó Giám Đốc Nhân Sự'],
            ['id' => 13, 'position_id' => '3', 'nominees' => 'Phó Giám đốc Tài Chính'],
            ['id' => 14, 'position_id' => '3', 'nominees' => 'Phó Giám đốc Vận Hành'],
            ['id' => 15, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Kỹ Thuật'],
            ['id' => 16, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Maketing'],
            ['id' => 17, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Pháp Chế'],
            ['id' => 18, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Nhân Sự'],
            ['id' => 19, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Tài Chính'],
            ['id' => 20, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Vận Hành'],
            ['id' => 21, 'position_id' => '4', 'nominees' => 'Trưởng Phòng Kinh Doanh'],
            ['id' => 22, 'position_id' => '5', 'nominees' => 'Phó Phòng Kỹ Thuật'],
            ['id' => 23, 'position_id' => '5', 'nominees' => 'Phó Phòng Maketing'],
            ['id' => 24, 'position_id' => '5', 'nominees' => 'Phó Phòng Pháp Chế'],
            ['id' => 25, 'position_id' => '5', 'nominees' => 'Phó Phòng Nhân Sự'],
            ['id' => 26, 'position_id' => '5', 'nominees' => 'Phó Phòng Tài Chính'],
            ['id' => 27, 'position_id' => '5', 'nominees' => 'Phó Phòng Vận Hành'],
            ['id' => 28, 'position_id' => '5', 'nominees' => 'Phó Phòng Kinh Doanh'],
            ['id' => 29, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Kỹ Thuật'],
            ['id' => 30, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Maketing'],
            ['id' => 31, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Pháp Chế'],
            ['id' => 32, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Nhân Sự'],
            ['id' => 33, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Tài Chính'],
            ['id' => 34, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Vận Hành'],
            ['id' => 35, 'position_id' => '6', 'nominees' => 'Quản Lý Cấp Cao Kinh Doanh'],
            ['id' => 36, 'position_id' => '7', 'nominees' => 'Quản Lý A'],
            ['id' => 37, 'position_id' => '7', 'nominees' => 'Quản Lý B'],
            ['id' => 38, 'position_id' => '7', 'nominees' => 'Quản Lý C'],
            ['id' => 39, 'position_id' => '7', 'nominees' => 'Quản Lý D'],
            ['id' => 40, 'position_id' => '7', 'nominees' => 'Quản Lý E'],
            ['id' => 41, 'position_id' => '7', 'nominees' => 'Quản Lý F'],
            ['id' => 42, 'position_id' => '7', 'nominees' => 'Quản Lý G'],
            ['id' => 43, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm A'],
            ['id' => 44, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm B'],
            ['id' => 45, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm C'],
            ['id' => 46, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm D'],
            ['id' => 47, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm E'],
            ['id' => 48, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm F'],
            ['id' => 49, 'position_id' => '8', 'nominees' => 'Trưởng Nhóm G'],
            ['id' => 50, 'position_id' => '9', 'nominees' => 'Chuyên Viên A'],
            ['id' => 51, 'position_id' => '9', 'nominees' => 'Chuyên Viên B'],
            ['id' => 52, 'position_id' => '9', 'nominees' => 'Chuyên Viên C'],
            ['id' => 53, 'position_id' => '9', 'nominees' => 'Chuyên Viên D'],
            ['id' => 54, 'position_id' => '9', 'nominees' => 'Chuyên Viên E'],
            ['id' => 55, 'position_id' => '9', 'nominees' => 'Chuyên Viên F'],
            ['id' => 56, 'position_id' => '9', 'nominees' => 'Chuyên Viên G'],
            ['id' => 57, 'position_id' => '10', 'nominees' => 'Nhân Viên A'],
            ['id' => 58, 'position_id' => '10', 'nominees' => 'Nhân Viên B'],
            ['id' => 59, 'position_id' => '10', 'nominees' => 'Nhân Viên C'],
            ['id' => 60, 'position_id' => '10', 'nominees' => 'Nhân Viên D'],
            ['id' => 61, 'position_id' => '10', 'nominees' => 'Nhân Viên E'],
            ['id' => 62, 'position_id' => '10', 'nominees' => 'Nhân Viên F'],
            ['id' => 63, 'position_id' => '10', 'nominees' => 'Nhân Viên G'],
            ['id' => 64, 'position_id' => '11', 'nominees' => 'Thử Việc A'],
            ['id' => 65, 'position_id' => '11', 'nominees' => 'Thử Việc B'],
            ['id' => 66, 'position_id' => '11', 'nominees' => 'Thử Việc C'],
            ['id' => 67, 'position_id' => '11', 'nominees' => 'Thử Việc D'],
            ['id' => 68, 'position_id' => '11', 'nominees' => 'Thử Việc E'],
            ['id' => 69, 'position_id' => '11', 'nominees' => 'Thử Việc F'],
            ['id' => 70, 'position_id' => '11', 'nominees' => 'Thử Việc G'],
            ['id' => 71, 'position_id' => '12', 'nominees' => 'Học Việc A'],
            ['id' => 72, 'position_id' => '12', 'nominees' => 'Học Việc B'],
            ['id' => 73, 'position_id' => '12', 'nominees' => 'Học Việc C'],
            ['id' => 74, 'position_id' => '12', 'nominees' => 'Học Việc D'],
            ['id' => 75, 'position_id' => '12', 'nominees' => 'Học Việc E'],
            ['id' => 76, 'position_id' => '12', 'nominees' => 'Học Việc F'],
            ['id' => 77, 'position_id' => '12', 'nominees' => 'Học Việc G'],
            ['id' => 78, 'position_id' => '13', 'nominees' => 'Thực Tập A'],
            ['id' => 79, 'position_id' => '13', 'nominees' => 'Thực Tập B'],
            ['id' => 80, 'position_id' => '13', 'nominees' => 'Thực Tập C'],
            ['id' => 81, 'position_id' => '13', 'nominees' => 'Thực Tập D'],
            ['id' => 82, 'position_id' => '13', 'nominees' => 'Thực Tập E'],
            ['id' => 83, 'position_id' => '13', 'nominees' => 'Thực Tập F'],
            ['id' => 84, 'position_id' => '13', 'nominees' => 'Thực Tập G'],
        ];

        DB::table('nominees')->insert($nominees);
        $data = [
            ['id' => 1, "code" => 'SNC1', 'name' => 'Sconnect'],
            ['id' => 2, "code" => 'SNC2', 'name' => 'Phòng Công Nghệ'],
            ['id' => 8, "code" => 'SNC3', 'name' => 'Nhóm Phát Triển Phần Mềm'],
            ['id' => 9, "code" => 'SNC4', 'name' => 'Nhóm Quản Trị Hệ Thống'],
            ['id' => 3, "code" => 'SNC5', 'name' => 'Phòng Hành Chính Nhân Sự'],
            ['id' => 10, "code" => 'SNC6', 'name' => 'Phòng Hành Chính Nhân Sự Con'],
            ['id' => 4, "code" => 'SNC7', 'name' => 'Phòng Pháp Chế'],
            ['id' => 11, "code" => 'SNC8', 'name' => 'Phòng Pháp Chế 1'],
            ['id' => 12, "code" => 'SNC9', 'name' => 'Phòng Pháp Chế 2'],
            ['id' => 13, "code" => 'SNC10', 'name' => 'Phòng Pháp Chế 3'],
            ['id' => 14, "code" => 'SNC11', 'name' => 'Phòng Pháp Chế 4'],
            ['id' => 5, "code" => 'SNC12', 'name' => 'Ban Giám Đốc'],
            ['id' => 6, "code" => 'SNC13', 'name' => 'Ban Dự Án'],
            ['id' => 7, "code" => 'SNC14', 'name' => 'Ban Tài Chính']
        ];
        DB::table('departments')->insert($data);

        $equipmenttypes = [
            ['id' => 1, 'name' => 'Màn hình', 'status' => true],
            ['id' => 2, 'name' => 'Case', 'status' => true],
            ['id' => 3, 'name' => 'Bàn phím không dây', 'status' => true],
            ['id' => 4, 'name' => 'Bàn phím có dây', 'status' => true],
            ['id' => 5, 'name' => 'Chuột không dây', 'status' => true],
            ['id' => 6, 'name' => 'Chuột có dây', 'status' => true],
            ['id' => 7, 'name' => 'Laptop', 'status' => true],
            ['id' => 8, 'name' => 'Model mạng', 'status' => true],
            ['id' => 9, 'name' => 'Tai nghe', 'status' => true],
        ];
        DB::table('equipment_types')->insert($equipmenttypes);

        $suppliers = [
            ['id' => 1, 'name' => 'Gaming Gear', 'status' => true],
            ['id' => 2, 'name' => 'MSI', 'status' => true],
            ['id' => 3, 'name' => 'Acer', 'status' => true],
            ['id' => 4, 'name' => 'Hp', 'status' => true],
            ['id' => 5, 'name' => 'Logitech', 'status' => true],
            ['id' => 6, 'name' => 'Viettel', 'status' => true],
            ['id' => 7, 'name' => 'Vinaphone', 'status' => true],
            ['id' => 8, 'name' => 'FPT', 'status' => true],
        ];
        DB::table('suppliers')->insert($suppliers);

        $equipments = [
            ['id' => 1, 'name' => 'Gaming Gear', 'image' => '1.jpg', 'specifications' => 'Ngon - bổ - rẻ', 'status' => 'active', 'price' => 10000000, 'out_of_date' => '2023/2/25', 'warranty_date' => '2023/2/25', 'equipment_type_id' => 1, 'supplier_id' => 1],
            ['id' => 2, 'name' => 'Gaming Gear 1', 'image' => '1.jpg', 'specifications' => 'Ngon - bổ - rẻ', 'status' => 'active', 'price' => 10000000, 'out_of_date' => '2023/2/25', 'warranty_date' => '2023/2/25', 'equipment_type_id' => 2, 'supplier_id' => 2],
            ['id' => 3, 'name' => 'Gaming Gear 2', 'image' => '1.jpg', 'specifications' => 'Ngon - bổ - rẻ', 'status' => 'active', 'price' => 10000000, 'out_of_date' => '2023/2/25', 'warranty_date' => '2023/2/25', 'equipment_type_id' => 3, 'supplier_id' => 3],
            ['id' => 4, 'name' => 'Gaming Gear 3', 'image' => '1.jpg', 'specifications' => 'Ngon - bổ - rẻ', 'status' => 'active', 'price' => 10000000, 'out_of_date' => '2023/2/25', 'warranty_date' => '2023/2/25', 'equipment_type_id' => 4, 'supplier_id' => 4],
            ['id' => 5, 'name' => 'Gaming Gear 4', 'image' => '1.jpg', 'specifications' => 'Ngon - bổ - rẻ', 'status' => 'active', 'price' => 10000000, 'out_of_date' => '2023/2/25', 'warranty_date' => '2023/2/25', 'equipment_type_id' => 5, 'supplier_id' => 4],
        ];
        DB::table('equipments')->insert($equipments);

        $storehouses = [
            ['id' => 1, 'name' => 'Kho 1', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 2, 'name' => 'Kho 2', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 3, 'name' => 'Kho 3', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 4, 'name' => 'Kho 4', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 5, 'name' => 'Kho 5', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 6, 'name' => 'Kho 6', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 7, 'name' => 'Kho 7', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 8, 'name' => 'Kho 8', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
            ['id' => 9, 'name' => 'Kho 9', 'image' => 'Ảnh.jpg', 'address' => 'Địa chỉ 1', 'status' => true],
        ];
        DB::table('storehouses')->insert($storehouses);


        // $use_details = [
        //     ['id' => 1, 'user_id' => 1, 'equipment_id' => 1, 2],
        //     ['id' => 2, 'user_id' => 2, 'equipment_id' => 2, 2],
        // ];
        // DB::table('use_details')->insert($use_details);
    }
}