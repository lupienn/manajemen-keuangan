# 💰 Sistem Manajemen Keuangan

Aplikasi web manajemen keuangan berbasis Laravel 12 yang dirancang untuk membantu pengelolaan transaksi, anggaran, dan pelaporan keuangan secara efisien.

---

## 📋 Tentang Proyek

Sistem Manajemen Keuangan ini dibangun sebagai aplikasi internal untuk mencatat dan memantau arus keuangan organisasi. Fitur utama meliputi:

- **Dashboard** — Ringkasan statistik keuangan secara real-time (pemasukan, pengeluaran, saldo).
- **Manajemen Transaksi** — Pencatatan transaksi pemasukan dan pengeluaran beserta kategori.
- **Manajemen Anggaran** — Penetapan dan pemantauan anggaran per kategori.
- **Laporan Keuangan** — Ekspor laporan keuangan ke format PDF.
- **Autentikasi** — Sistem login berbasis email & password menggunakan Laravel Breeze.

---

## 🛠️ Tech Stack

| Lapisan        | Teknologi                                      |
|----------------|------------------------------------------------|
| **Backend**    | PHP 8.2, Laravel 12                            |
| **Frontend**   | Blade, Tailwind CSS 3, Alpine.js 3, Flowbite   |
| **Build Tool** | Vite 7                                         |
| **Database**   | SQLite (default) / MySQL                       |
| **PDF Export** | barryvdh/laravel-dompdf                        |
| **Icons**      | Lucide Icons (Blade + JS)                      |
| **Testing**    | PHPUnit 11, Pest                               |

---

## 🗂️ Struktur Direktori

```
├── app/
│   ├── Http/Controllers/     # DashboardController, TransactionController, BudgetController, ReportController
│   ├── Models/               # User, Transaction, Budget, Category
│   ├── Observers/            # Model observers (audit log)
│   └── View/                 # View composers
├── database/
│   ├── migrations/           # Skema tabel (users, transactions, budgets, categories)
│   └── seeders/
├── resources/
│   ├── css/                  # app.css (Tailwind)
│   ├── js/                   # app.js (Alpine.js, Axios)
│   └── views/
│       ├── layouts/          # app.blade.php, sidebar.blade.php
│       ├── dashboard.blade.php
│       ├── transactions/     # index, create, edit
│       ├── budgets/          # index
│       └── reports/          # index (+ PDF export)
└── routes/
    ├── web.php               # Rute utama aplikasi
    └── auth.php              # Rute autentikasi (Breeze)
```

---

## ⚙️ Instalasi & Setup

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm

### 1. Klon Repositori

```bash
git clone <url-repositori>
cd manajemen-keuangan
```

### 2. Setup Awal (Sekali Jalan)

Perintah ini akan menginstal dependensi PHP & JS, membuat file `.env`, men-generate app key, menjalankan migrasi, dan mem-build aset frontend.

```bash
composer setup
```

### 3. Jalankan Server Pengembangan

```bash
composer run dev
```

Aplikasi akan tersedia di **http://127.0.0.1:8000**.

> Perintah ini menjalankan secara bersamaan: PHP server, queue worker, log watcher (Pail), dan Vite dev server (hot-reload).

---

## 🗄️ Skema Database

| Tabel          | Deskripsi                                              |
|----------------|--------------------------------------------------------|
| `users`        | Data pengguna sistem                                   |
| `categories`   | Kategori transaksi (mis. Operasional, Gaji, dll.)      |
| `transactions` | Catatan transaksi pemasukan & pengeluaran              |
| `budgets`      | Anggaran yang ditetapkan per kategori & periode        |

---

## 🔗 Rute Utama

| Method   | URI                    | Nama Route          | Keterangan                  |
|----------|------------------------|---------------------|-----------------------------|
| `GET`    | `/dashboard`           | `dashboard`         | Halaman utama / statistik   |
| `GET`    | `/transactions`        | `transactions.index`| Daftar transaksi            |
| `POST`   | `/transactions`        | `transactions.store`| Tambah transaksi            |
| `GET`    | `/transactions/create` | `transactions.create`| Form tambah transaksi      |
| `PUT`    | `/transactions/{id}`   | `transactions.update`| Edit transaksi             |
| `DELETE` | `/transactions/{id}`   | `transactions.destroy`| Hapus transaksi           |
| `GET`    | `/anggaran`            | `budgets.index`     | Daftar & kelola anggaran    |
| `GET`    | `/laporan`             | `reports.index`     | Halaman laporan keuangan    |
| `GET`    | `/laporan/pdf`         | `reports.pdf`       | Export laporan ke PDF       |
| `GET`    | `/profile`             | `profile.edit`      | Halaman profil pengguna     |

---

## 🧪 Menjalankan Tes

```bash
composer test
```

---

## 📦 Perintah Artisan Berguna

```bash
# Jalankan migrasi ulang dengan data seeder
php artisan migrate:fresh --seed

# Bersihkan cache konfigurasi & view
php artisan config:clear
php artisan view:clear

# Generate PDF (via route)
# Akses /laporan/pdf di browser setelah login
```

---


