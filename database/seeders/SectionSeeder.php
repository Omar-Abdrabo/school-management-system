<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Classroom;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sections')->delete();
        $sections = [
            ['en' => 'A', 'ar' => 'أ'],
            ['en' => 'B', 'ar' => 'ب'],
            ['en' => 'C', 'ar' => 'ج'],
        ];
        $grades = Grade::all();
        $classrooms = Classroom::all();
        foreach ($grades as $grade) {
            foreach ($classrooms as $classroom) {
                foreach ($sections as $section) {
                    Section::create([
                        'section_name' => $section,
                        'grade_id' => $grade->id,
                        'classroom_id' => $classroom->id,
                        'status' => 1
                    ]);
                }
            }
        }
    }
}
