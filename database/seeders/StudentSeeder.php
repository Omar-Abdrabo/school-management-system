<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\BloodType;
use App\Models\Classroom;
use App\Models\MyParent;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = new Student();
        $students->name = ['ar' => 'احمد ابراهيم', 'en' => 'Ahmed Ibrahim'];
        $students->email = 'std@std.com';
        $students->password = Hash::make('123456789');
        $students->gender_id = 1;
        $students->nationality_id  = Nationality::all()->unique()->random()->id;
        $students->blood_type_id  =BloodType::all()->unique()->random()->id;
        $students->date_birth = date('1995-01-01');
        $students->grade_id = Grade::all()->unique()->random()->id;
        $students->classroom_id =Classroom::all()->unique()->random()->id;
        $students->section_id = Section::all()->unique()->random()->id;
        $students->parent_id = MyParent::all()->unique()->random()->id;
        $students->academic_year ='2024';
        $students->save();
    }
}
