<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JadwalCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'href' => route('jadwal.index'),

            'items' => $this->collection,

            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('jadwal.index')
                ]
            ],

            'queries' => [
                [
                    'rel'    => 'search',
                    'href'   => route('jadwal.index'),
                    'prompt' => 'Cari Jadwal berdasarkan Nama Guru, Nama Mapel, atau Nama Kelas',
                    'data'   => [
                        ['name' => 'mapel', 'value' => ''],
                        ['name' => 'guru', 'value' => ''],
                        ['name' => 'kelas', 'value' => '']
                    ]
                ]
            ],

            'template' => [
                'data' => [
                    ['name' => 'guru_id', 'value' => '', 'prompt' => 'ID Guru Pengampu (Wajib)'],
                    ['name' => 'mapel_id', 'value' => '', 'prompt' => 'ID Mata Pelajaran (Wajib)'],
                    ['name' => 'kelas_id', 'value' => '', 'prompt' => 'ID Kelas (Wajib)'],
                    ['name' => 'hari', 'value' => '', 'prompt' => 'Hari (senin, selasa, rabu, kamis, jumat, sabtu)'],
                    ['name' => 'jam_mulai', 'value' => '', 'prompt' => 'Jam Mulai (07:00)'],
                    ['name' => 'jam_selesai', 'value' => '', 'prompt' => 'Jam Selesai (08:00)'],
                ]
            ]
        ];
    }
}