# School API

School API adalah RESTful Web API yang dibangun menggunakan **Laravel** untuk memanajemen sistem informasi sekolah tingkat lanjut. API ini tidak hanya menyediakan operasi CRUD dasar, tetapi juga mengadopsi standar arsitektur **Collection+JSON** dengan implementasi **Hypermedia Controls (HATEOAS)**.

Dengan pendekatan ini, API bersifat **self-descriptive** sehingga client seperti **React, Vue, atau Nuxt.js** dapat memahami struktur data dan alur interaksi langsung dari respons API.

---

# 🚀 Fitur Utama

### 🔐 Otentikasi Aman

Menggunakan **Laravel Sanctum** untuk sistem autentikasi berbasis token.

### 👥 Role Based Access Control (RBAC)

Mendukung otorisasi berbasis peran dengan middleware khusus:

* Admin
* Guru

### 📦 Standardisasi Respons API

Struktur respons API dipisahkan menjadi:

* **Resource** → representasi item tunggal
* **ResourceCollection** → representasi koleksi data

Pendekatan ini menjaga konsistensi dan menghindari kesenjangan semantik.

### 🔗 Hypermedia Controls (HATEOAS)

Setiap respons koleksi dilengkapi dengan lima slot makro:

* **href** → tautan permanen ke koleksi
* **items** → representasi detail setiap data
* **links** → navigasi paginasi
* **queries** → template pencarian data
* **template** → template untuk membuat data baru

### ⚡ Optimasi Relasi Database

Menggunakan **Eager Loading** untuk menghindari masalah **N+1 Query** pada relasi kompleks.

Contoh relasi:

* Jadwal → Guru
* Jadwal → Mata Pelajaran
* Jadwal → Kelas

---

# 📚 Modul API

Sistem menyediakan beberapa modul utama:

### 1. Users

Manajemen akun pengguna sistem.

Akses:

* Admin

### 2. Kelas

Manajemen data kelas sekolah.

### 3. Mata Pelajaran

Manajemen data mata pelajaran.

### 4. Guru

Manajemen profil guru.

Relasi:

* One-to-one dengan tabel **users**

### 5. Siswa

Manajemen data siswa.

Relasi:

* Belongs-to dengan **kelas**

### 6. Jadwal

Manajemen jadwal pelajaran.

Relasi:

* Guru
* Mata Pelajaran
* Kelas

---

# 🛠️ Prasyarat

Sebelum menjalankan proyek ini pastikan sistem sudah memiliki:

* PHP ^8.2
* Composer
* MySQL / MariaDB

---

# ⚙️ Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/RizalHaryaputra/school-api
cd school-api
```

### 2. Install Dependency

```bash
composer install
```

### 3. Copy File Environment

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_school
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate --seed
```

### 7. Jalankan Server Lokal

```bash
php artisan serve
```

Server akan berjalan di:

```
http://127.0.0.1:8000
```

---

# 📖 Contoh Respons API

Endpoint:

```
GET /api/kelas
```

Contoh respons:

```json
{
  "href": "http://127.0.0.1:8000/api/kelas",
  "items": [
    {
      "id": 1,
      "kode_kelas": "X-IPA-1",
      "nama_kelas": "Kelas X IPA 1",
      "_links": [
        {
          "rel": "self",
          "method": "GET",
          "href": "http://127.0.0.1:8000/api/kelas/1"
        },
        {
          "rel": "update",
          "method": "PUT",
          "href": "http://127.0.0.1:8000/api/kelas/1"
        },
        {
          "rel": "delete",
          "method": "DELETE",
          "href": "http://127.0.0.1:8000/api/kelas/1"
        }
      ]
    }
  ],
  "links": [
    {
      "rel": "self",
      "href": "http://127.0.0.1:8000/api/kelas"
    }
  ],
  "queries": [
    {
      "rel": "search",
      "href": "http://127.0.0.1:8000/api/kelas",
      "prompt": "Cari kelas berdasarkan kode atau nama",
      "data": [
        {
          "name": "kode_kelas",
          "value": ""
        },
        {
          "name": "nama_kelas",
          "value": ""
        }
      ]
    }
  ],
  "template": {
    "data": [
      {
        "name": "kode_kelas",
        "value": "",
        "prompt": "Kode kelas (contoh: X-IPA-1)"
      },
      {
        "name": "nama_kelas",
        "value": "",
        "prompt": "Nama kelas"
      }
    ]
  },
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "total": 1
  }
}
```

---

# 👨‍💻 Pengembang

**Rizal Haryaputra**

---

# 📄 Lisensi

Proyek ini dibuat untuk tujuan pembelajaran dan pengembangan sistem informasi sekolah.
