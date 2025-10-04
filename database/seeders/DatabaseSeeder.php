<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // === Create Admin User ===
        User::updateOrCreate(
            ['email' => 'admin@isp.com'], // cek berdasarkan email
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // === Create Teknisi Users ===
        User::updateOrCreate(
            ['email' => 'teknisi1@isp.com'],
            [
                'name' => 'Teknisi 1',
                'password' => Hash::make('teknisi123'),
                'role' => 'teknisi',
            ]
        );

        User::updateOrCreate(
            ['email' => 'teknisi2@isp.com'],
            [
                'name' => 'Teknisi 2',
                'password' => Hash::make('teknisi123'),
                'role' => 'teknisi',
            ]
        );

        // === Create Sample Materials ===
        $materials = [
            [
                'kode_material' => 'CAB001',
                'nama_material' => 'Kabel Fiber Optic 50m',
                'deskripsi' => 'Kabel fiber optic single mode untuk instalasi outdoor',
                'satuan' => 'roll',
                'stok' => 25,
                'minimum_stok' => 5,
                'harga' => 750000,
                'lokasi_penyimpanan' => 'Gudang A - Rak 1',
            ],
            [
                'kode_material' => 'CON001',
                'nama_material' => 'Connector SC/UPC',
                'deskripsi' => 'Connector fiber optic SC/UPC untuk terminasi kabel',
                'satuan' => 'pcs',
                'stok' => 100,
                'minimum_stok' => 20,
                'harga' => 15000,
                'lokasi_penyimpanan' => 'Gudang A - Rak 2',
            ],
            [
                'kode_material' => 'SPL001',
                'nama_material' => 'Splitter 1:8 PLC',
                'deskripsi' => 'Splitter fiber optic 1:8 dengan teknologi PLC',
                'satuan' => 'unit',
                'stok' => 15,
                'minimum_stok' => 3,
                'harga' => 125000,
                'lokasi_penyimpanan' => 'Gudang B - Rak 1',
            ],
            [
                'kode_material' => 'ONT001',
                'nama_material' => 'ONT CDATA HG704',
                'deskripsi' => 'Optical Network Terminal untuk pelanggan FTTH',
                'satuan' => 'unit',
                'stok' => 50,
                'minimum_stok' => 10,
                'harga' => 350000,
                'lokasi_penyimpanan' => 'Gudang B - Rak 3',
            ],
            [
                'kode_material' => 'ONT002', // ganti dari ONT001 biar tidak bentrok
                'nama_material' => 'ONT CDATA HG712',
                'deskripsi' => 'Optical Network Terminal untuk pelanggan FTTH',
                'satuan' => 'unit',
                'stok' => 50,
                'minimum_stok' => 10,
                'harga' => 350000,
                'lokasi_penyimpanan' => 'Gudang B - Rak 3',
            ],
            [
                'kode_material' => 'CBL002',
                'nama_material' => 'Kabel UTP Cat6 305m',
                'deskripsi' => 'Kabel UTP Category 6 untuk instalasi LAN',
                'satuan' => 'box',
                'stok' => 8,
                'minimum_stok' => 2,
                'harga' => 1250000,
                'lokasi_penyimpanan' => 'Gudang A - Rak 3',
            ],
            [
                'kode_material' => 'SWT001',
                'nama_material' => 'Switch 24 Port Gigabit',
                'deskripsi' => 'Switch managed 24 port gigabit ethernet',
                'satuan' => 'unit',
                'stok' => 5,
                'minimum_stok' => 1,
                'harga' => 1500000,
                'lokasi_penyimpanan' => 'Gudang C - Rak 1',
            ],
            [
                'kode_material' => 'RTR089',
                'nama_material' => 'Router Dlink-dir612m',
                'deskripsi' => 'Router standar ISP',
                'satuan' => 'unit',
                'stok' => 10,
                'minimum_stok' => 1,
                'harga' => 2300000,
                'lokasi_penyimpanan' => 'Gudang C - Rak 1',
            ],
            [
                'kode_material' => 'RTR088',
                'nama_material' => 'ROUTER TOTOLINK AC Gigabit',
                'deskripsi' => 'Router Totolink gigabit dual-band',
                'satuan' => 'unit',
                'stok' => 3,
                'minimum_stok' => 1,
                'harga' => 2500000,
                'lokasi_penyimpanan' => 'Gudang C - Rak 1',
            ],
        ];

        foreach ($materials as $material) {
            Material::updateOrCreate(
                ['kode_material' => $material['kode_material']], // cek berdasarkan kode_material
                $material
            );
        }
    }
}
