<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 1. href: Tautan permanen ke koleksi itu sendiri
            'href' => route('users.index'),

            // 2. items: Array dari anggota koleksi (akan otomatis di-format oleh UserResource)
            'items' => $this->collection,

            // 3. links: Tautan ke resource lain yang terkait
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.index')
                ]
            ],

            // 4. queries: Kontrol Hypermedia untuk mencari isi koleksi (Search Templates)
            'queries' => [
                [
                    'rel'    => 'search',
                    'href'   => route('users.index'),
                    'prompt' => 'Cari User berdasarkan Username atau Role',
                    'data'   => [
                        ['name' => 'username', 'value' => ''],
                        ['name' => 'type', 'value' => '']
                    ]
                ]
            ],

            // 5. template: Kontrol Hypermedia berupa template kosong untuk menambahkan item baru (Write Templates)
            'template' => [
                'data' => [
                    ['name' => 'username', 'value' => '', 'prompt' => 'Username (Wajib unik)'],
                    ['name' => 'password', 'value' => '', 'prompt' => 'Password (Minimal 8 karakter)'],
                    ['name' => 'type', 'value' => '', 'prompt' => 'Role (admin atau guru)']
                ]
            ]
        ];
    }
}
