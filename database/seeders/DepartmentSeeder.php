<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['kode' => 'FIN', 'nama' => 'Keuangan', 'deskripsi' => 'Departemen Keuangan dan Akuntansi'],
            ['kode' => 'HRD', 'nama' => 'Sumber Daya Manusia', 'deskripsi' => 'Departemen Personalia dan SDM'],
            ['kode' => 'IT', 'nama' => 'Teknologi Informasi', 'deskripsi' => 'Departemen IT dan Sistem Informasi'],
            ['kode' => 'OPS', 'nama' => 'Operasional', 'deskripsi' => 'Departemen Operasional dan Logistik'],
            ['kode' => 'MKT', 'nama' => 'Marketing', 'deskripsi' => 'Departemen Pemasaran dan Penjualan'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
