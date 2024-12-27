<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grades')->delete();
        $grades = [
            ['en'=> 'Primary Stage', 'ar'=> 'المرحلة الابتدائية'],
            ['en'=> 'Midlle Stage', 'ar'=> 'المرحلة الاعدادية'],
            ['en'=> 'High Stage', 'ar'=> 'المرحلة الثانوية'],

        ];
        foreach ($grades as $ge) {
            Grade::create(['name' => $ge]);
        }
    }
}
