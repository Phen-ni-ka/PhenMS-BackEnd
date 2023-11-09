<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check = DB::table('majors')->first();
        if ($check) {
            return;
        }
        $filePath = "database\seeders\data_majors.csv";

        $handle = fopen($filePath, "r");
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== false) {
            Major::create(
                [
                    "name" => $data[0],
                    "major_code" => $data[1]
                ]
            );
        }

        fclose($handle);
    }
}
