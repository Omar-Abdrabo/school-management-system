<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->delete();
        $classrooms = [
            ['en' => 'First Class', 'ar' => 'الصف الاول'],
            ['en' => 'Second Class', 'ar' => ' الصف الثاني'],
            ['en' => 'Third  Class', 'ar' => ' الصف الثالث'],

        ];
        $grades = Grade::all();
        foreach ($grades as $grade) {
            foreach ($classrooms as $classroom) {
                Classroom::create([
                    'name_class' => $classroom,
                    'grade_id' => $grade->id
                ]);
            }
        }
    }
}
