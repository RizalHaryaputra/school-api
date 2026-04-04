<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kelas\KelasStoreRequest;
use App\Http\Requests\Kelas\KelasUpdateRequest;
use App\Http\Resources\KelasCollection;
use App\Http\Resources\KelasResource;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    // Tambahkan dependency injection Request $request
    public function index(Request $request)
    {
        $query = Kelas::query();

        // Logika Pencarian: Cek apakah ada parameter 'search' yang dikirim
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Mencari di kode_kelas ATAU nama_kelas
            $query->where('kode_kelas', 'like', "%{$search}%")
                ->orWhere('nama_kelas', 'like', "%{$search}%");
        }

        $kelas = $query->paginate(10);

        // Mempertahankan query pencarian pada link paginasi bawaan Laravel
        $kelas->appends(['search' => $request->search]);

        return new KelasCollection($kelas);
    }

    public function store(KelasStoreRequest $request)
    {
        $kelas = Kelas::create($request->validated());
        return (new KelasResource($kelas))->response()->setStatusCode(201);
    }

    public function show(Kelas $kela)
    {
        return new KelasResource($kela);
    }

    public function update(KelasUpdateRequest $request, Kelas $kela)
    {
        $kela->update($request->validated());
        return (new KelasResource($kela))->additional([
            'meta' => [
                'message' => 'Kelas berhasil diperbarui!',
                'status' => 'success'
            ]
        ])->response()->setStatusCode(200);
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return response()->json(['message' => 'Kelas berhasil dihapus'], 200);
    }
}
