<?php

namespace Database\Seeders;

use App\Models\MyParent;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $myParent = new MyParent();
        $myParent->email = 'parent@parent.com';
        $myParent->password = Hash::make('123456789');
        $myParent->father_name = ['en' => 'Hassan Mohamed', 'ar' => 'حسن محمد'];
        $myParent->father_national_id = '1234567810';
        $myParent->father_passport_id = '1234567810';
        $myParent->father_phone = '1234567810';
        $myParent->father_job = ['en' => 'programmer', 'ar' => 'مبرمج'];
        $myParent->nationality_father_id  = Nationality::all()->unique()->random()->id;
        $myParent->blood_type_father_id  = BloodType::all()->unique()->random()->id;
        $myParent->religion_father_id  = Religion::all()->unique()->random()->id;
        $myParent->father_address = 'القاهرة';

        $myParent->mother_name = ['Mai Sam' => 'SS', 'ar' => 'مى سام'];
        $myParent->mother_national_id = '1234567810';
        $myParent->mother_passport_id = '1234567810';
        $myParent->mother_phone = '1234567810';
        $myParent->mother_job = ['en' => 'Teacher', 'ar' => 'معلمة'];
        $myParent->nationality_mother_id  = Nationality::all()->unique()->random()->id;
        $myParent->blood_type_mother_id  = BloodType::all()->unique()->random()->id;
        $myParent->religion_mother_id  = Religion::all()->unique()->random()->id;
        $myParent->mother_address = 'القاهرة';
        $myParent->save();
    }
}
