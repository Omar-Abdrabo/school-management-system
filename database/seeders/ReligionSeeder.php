<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('religions')->delete();
        $religions = [
            [
                'en' => 'Muslim',
                'ar' => 'مسلم'
            ],
            [
                'en' => 'Christian',
                'ar' => 'مسيحي'
            ],
            [
                'en' => 'Other',
                'ar' => 'غيرذلك'
            ],
        ];
        foreach ($religions as $religion) {
            \App\Models\Religion::create(['name' => $religion]);
        }
    }
}
