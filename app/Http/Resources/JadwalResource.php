<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'hari'          => $this->hari,
            'jam_mulai'     => $this->jam_mulai,  
            'jam_selesai'   => $this->jam_selesai,
            'guru'          => $this->guru->nama ?? null,
            'mapel'         => $this->mapel->nama_mapel ?? null,
            'kelas'         => $this->kelas->nama_kelas ?? null,
            'guru_id'       => $this->guru_id,
            'mapel_id'      => $this->mapel_id,
            'kelas_id'      => $this->kelas_id,

            '_links'        => [
                [
                    'rel'    => 'self',
                    'method' => 'GET',
                    'href'   => route('jadwal.show', ['jadwal' => $this->id])
                ],
                [
                    'rel'    => 'update',
                    'method' => 'PUT',
                    'href'   => route('jadwal.update', ['jadwal' => $this->id])
                ],
                [
                    'rel'    => 'delete',
                    'method' => 'DELETE',
                    'href'   => route('jadwal.destroy', ['jadwal' => $this->id])
                ],
            ]
        ];
    }
}
