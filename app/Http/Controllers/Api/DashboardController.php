<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mengambil ringkasan data untuk halaman Dashboard
     */
    public function index(Request $request)
    {
        // 1. Statistik Utama (Kartu Metrik)
        $stats = [
            'total_siswa' => Siswa::count(),
            'total_guru'  => Guru::count(),
            'total_kelas' => Kelas::count(),
            'total_user'  => User::count(),
        ];

        // 2. Data Demografi (Untuk Grafik)
        $demografiSiswa = [
            'laki_laki' => Siswa::whereIn('gender', ['L', 'laki-laki'])->count(),
            'perempuan' => Siswa::whereIn('gender', ['P', 'perempuan'])->count(),
        ];

        // 3. Menarik Jadwal Hari Ini
        // Carbon akan mengambil nama hari ini dalam bahasa Indonesia (senin, selasa, dst)
        $hariIni = strtolower(Carbon::now()->locale('id')->translatedFormat('l'));

        $jadwalHariIni = Jadwal::with(['guru', 'kelas', 'mapel'])
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->take(5) // Ambil 5 jadwal terdekat agar dashboard tidak penuh
            ->get()
            ->map(function ($jadwal) {
                // Memetakan struktur agar frontend lebih mudah merender
                return [
                    'id'    => $jadwal->id,
                    'waktu' => substr($jadwal->jam_mulai, 0, 5) . ' - ' . substr($jadwal->jam_selesai, 0, 5),
                    'kelas' => $jadwal->kelas->nama_kelas ?? 'Tanpa Kelas',
                    'mapel' => $jadwal->mapel->nama_mapel ?? 'Tanpa Mapel',
                    'guru'  => $jadwal->guru->nama ?? 'Tanpa Guru',
                ];
            });

        // 4. Data Terbaru (5 Siswa Terakhir yang Didaftarkan)
        $siswaTerbaru = Siswa::with('kelas')
            ->latest() // Otomatis order by created_at DESC
            ->take(5)
            ->get()
            ->map(function ($siswa) {
                return [
                    'id'         => $siswa->id,
                    'nis'        => $siswa->nis,
                    'nama'       => $siswa->nama,
                    'kelas'      => $siswa->kelas->nama_kelas ?? '-',
                    'created_at' => $siswa->created_at->diffForHumans() // Contoh: "2 jam yang lalu"
                ];
            });

        // Kembalikan Response JSON yang terstruktur
        return response()->json([
            'meta' => [
                'status'  => 'success',
                'message' => 'Data dashboard berhasil dimuat.'
            ],
            'data' => [
                'hari_ini'        => ucfirst($hariIni),
                'stats'           => $stats,
                'demografi'       => $demografiSiswa,
                'jadwal_hari_ini' => $jadwalHariIni,
                'siswa_terbaru'   => $siswaTerbaru
            ]
        ], 200);
    }
}
