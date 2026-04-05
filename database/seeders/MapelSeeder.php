<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Mapel::create([
            'kode_mapel' => 'MAT',
            'nama_mapel' => 'Matematika'
        ]);

        \App\Models\Mapel::create([
            'kode_mapel' => 'IPA',
            'nama_mapel' => 'Ilmu Pengetahuan Alam'
        ]);

        \App\Models\Mapel::create([
            'kode_mapel' => 'IPS',
            'nama_mapel' => 'Ilmu Pengetahuan Sosial'
        ]);
    }
}
