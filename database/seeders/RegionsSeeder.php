<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionsSeeder extends Seeder
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
                'code' => 1,
                'description' => 'Región A',
                'status' => 'A',
            ],
            [
                'code' => 2,
                'description' => 'Región B',
                'status' => 'A',
            ],
            [
                'code' => 3,
                'description' => 'Región C',
                'status' => 'I',
            ],
        ];

        foreach ($core as $index => $item) {
            Region::firstOrCreate(['code' => $item['code']], $item);
        }
    }
}
