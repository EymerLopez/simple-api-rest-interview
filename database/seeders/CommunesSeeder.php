<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;

class CommunesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $core = [
            [
                'id_reg' => 1,
                'code' => 1,
                'description' => 'Comuna A',
                'status' => 'A',
            ],
            [
                'id_reg' => 1,
                'code' => 2,
                'description' => 'Comuna B',
                'status' => 'A',
            ],
            [
                'id_reg' => 2,
                'code' => 3,
                'description' => 'Comuna C',
                'status' => 'I',
            ],
            [
                'id_reg' => 2,
                'code' => 4,
                'description' => 'Comuna D',
                'status' => 'A',
            ],
            [
                'id_reg' => 3,
                'code' => 5,
                'description' => 'Comuna E',
                'status' => 'I',
            ],
            [
                'id_reg' => 3,
                'code' => 6,
                'description' => 'Comuna F',
                'status' => 'A',
            ],
        ];

        foreach ($core as $index => $item) {
            Commune::firstOrCreate(['code' => $item['code']], $item);
        }
    }
}
