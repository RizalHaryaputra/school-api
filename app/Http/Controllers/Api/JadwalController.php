<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Http\Requests\Jadwal\JadwalStoreRequest;
use App\Http\Requests\Jadwal\JadwalUpdateRequest;
use App\Http\Resources\JadwalCollection;
use App\Http\Resources\JadwalResource;

class JadwalController extends Controller
{
    public function index()
    {
        // cari berdasarkan nama guru, nama mapel, atau nama kelas
        $query = Jadwal::with(['guru', 'mapel', 'kelas']);
        if (request()->has('search') && request()->search != '') {
            $search = request()->search;
            $query->whereHas('guru', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('mapel', function ($q) use ($search) {
                $q->where('nama_mapel', 'like', "%{$search}%");
            })->orWhereHas('kelas', function ($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%");
            });
        }

        $jadwal = $query->paginate(10);
        $jadwal->appends(['search' => request()->search]);
        
        return new JadwalCollection($jadwal);
    }

    public function store(JadwalStoreRequest $request)
    {
        $jadwal = Jadwal::create($request->validated());
        
        return (new JadwalResource($jadwal->load(['guru', 'mapel', 'kelas'])))
                ->response()
                ->setStatusCode(201);
    }

    public function show(Jadwal $jadwal)
    {
        return new JadwalResource($jadwal->load(['guru', 'mapel', 'kelas']));
    }

    public function update(JadwalUpdateRequest $request, Jadwal $jadwal)
    {
        $jadwal->update($request->validated());
        
        return (new JadwalResource($jadwal->load(['guru', 'mapel', 'kelas'])))->additional([
            'meta' => [
                'message' => 'Jadwal berhasil diperbarui!',
                'status'  => 'success'
            ]
        ])->response()->setStatusCode(200);
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return response()->json(['message' => 'Jadwal berhasil dihapus'], 200);
    }
}