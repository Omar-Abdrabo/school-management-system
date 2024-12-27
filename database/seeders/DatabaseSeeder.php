<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BloodTypeSeeder::class,
            NationalitySeeder::class,
            ReligionSeeder::class,
            GenderSeeder::class,
            SpecializationSeeder::class,
            UserSeeder::class,
            GradeSeeder::class,
            ClassroomSeeder::class,
            SectionSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
