<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Identity\Models\User;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;

class RentalCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $toko = [
            [
                'nama_toko' => 'Rinjani Outdoor',
                'alamat' => 'Jl. Raya Sembalun No. 12, Pos Registrasi Sembalun (Meja 3)',
                'penanggung_jawab' => 'Hendra Gunawan',
                'telepon_toko' => '0812-3456-7890',
                'pos' => 'Sembalun',
            ],
            [
                'nama_toko' => 'Sembalun Gear',
                'alamat' => 'Jl. Wisata Sembalun No. 4, Sembalun Lawang',
                'penanggung_jawab' => 'Muhammad Fauzi',
                'telepon_toko' => '0819-7822-1090',
                'pos' => 'Sembalun',
            ],
            [
                'nama_toko' => 'Senaru Camp',
                'alamat' => 'Jl. Pariwisata Senaru No. 8, Bayan',
                'penanggung_jawab' => 'Lalu Saputra',
                'telepon_toko' => '0813-5566-7711',
                'pos' => 'Senaru',
            ],
            [
                'nama_toko' => 'Torean Basecamp',
                'alamat' => 'Dusun Torean, Kecamatan Bayan',
                'penanggung_jawab' => 'Rizky Maulana',
                'telepon_toko' => '0817-2211-3344',
                'pos' => 'Torean',
            ],
        ];

        $tokoModel = [];

        foreach ($toko as $index => $data) {
            $user = User::firstOrCreate(
                ['email' => 'toko'.($index + 1).'@rinjaniguide.id'],
                [
                    'nama' => $data['penanggung_jawab'],
                    'no_telepon' => $data['telepon_toko'],
                    'password' => Hash::make('password'),
                    'peran' => 'rental',
                ],
            );

            $tokoModel[$data['nama_toko']] = TokoRental::firstOrCreate(
                ['nama_toko' => $data['nama_toko']],
                [
                    'user_id' => $user->id,
                    'alamat' => $data['alamat'],
                    'penanggung_jawab' => $data['penanggung_jawab'],
                    'telepon_toko' => $data['telepon_toko'],
                    'status' => 'active',
                ],
            );
        }

        $tenda = [
            'https://images.unsplash.com/photo-1504280387966-2b87855d93af?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1629235882317-91247d0d085e?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?q=80&w=900&auto=format&fit=crop',
        ];

        $sleepingBag = [
            'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542314570-58e3918e44ba?q=80&w=900&auto=format&fit=crop',
        ];

        $matras = [
            'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1504280387966-2b87855d93af?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542314570-58e3918e44ba?q=80&w=900&auto=format&fit=crop',
        ];

        $alatMasak = [
            'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1504280387966-2b87855d93af?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=900&auto=format&fit=crop',
        ];

        $carrier = [
            'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542314570-58e3918e44ba?q=80&w=900&auto=format&fit=crop',
        ];

        $aksesoris = [
            'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1629235882317-91247d0d085e?q=80&w=900&auto=format&fit=crop',
        ];

        $katalog = [
            [
                'nama' => 'Tenda Dome 4P',
                'kategori' => 'Tenda',
                'pos' => 'Sembalun',
                'toko' => 'Rinjani Outdoor',
                'deskripsi' => 'Double layer waterproof 3000mm, alloy pole ringan.',
                'tarif' => 45000,
                'stok' => 12,
                'kapasitas' => '4 Orang',
                'berat' => '3.5 kg',
                'material' => 'Polyester 3000mm',
                'dimensi' => '210 x 210 x 130 cm',
                'rating' => 4.9,
                'ulasan' => 24,
                'galeri' => $tenda,
                'sorotan' => true,
                'gambar' => $tenda[0],
            ],
            [
                'nama' => 'Sleeping Bag',
                'kategori' => 'Sleeping Bag',
                'pos' => 'Sembalun',
                'toko' => 'Rinjani Outdoor',
                'deskripsi' => 'Comfort limit 5°C, bahan polar tebal & higienis dicuci.',
                'tarif' => 25000,
                'stok' => 30,
                'kapasitas' => '1 Orang',
                'berat' => '1.2 kg',
                'material' => 'Polar fleece',
                'dimensi' => '180 x 75 cm',
                'rating' => 4.8,
                'ulasan' => 18,
                'galeri' => $sleepingBag,
                'sorotan' => true,
                'gambar' => $sleepingBag[0],
            ],
            [
                'nama' => 'Matras Gulung',
                'kategori' => 'Matras',
                'pos' => 'Sembalun',
                'toko' => 'Sembalun Gear',
                'deskripsi' => 'Busa EVA tebal 10mm, isolasi tanah dingin maksimal.',
                'tarif' => 15000,
                'stok' => 25,
                'kapasitas' => '2 Orang',
                'berat' => '1.0 kg',
                'material' => 'Busa EVA',
                'dimensi' => '180 x 60 x 1 cm',
                'rating' => 4.7,
                'ulasan' => 12,
                'galeri' => $matras,
                'sorotan' => false,
                'gambar' => $matras[0],
            ],
            [
                'nama' => 'Alat Masak Portable',
                'kategori' => 'Alat Masak',
                'pos' => 'Sembalun',
                'toko' => 'Sembalun Gear',
                'deskripsi' => 'Nesting aluminium anodized 4-in-1 + kompor ultralight.',
                'tarif' => 30000,
                'stok' => 8,
                'kapasitas' => '2-4 Orang',
                'berat' => '1.4 kg',
                'material' => 'Aluminium anodized',
                'dimensi' => '18 x 18 x 12 cm',
                'rating' => 4.8,
                'ulasan' => 9,
                'galeri' => $alatMasak,
                'sorotan' => false,
                'gambar' => $alatMasak[0],
            ],
            [
                'nama' => 'Carrier 60L',
                'kategori' => 'Carrier',
                'pos' => 'Senaru',
                'toko' => 'Senaru Camp',
                'deskripsi' => 'Backsystem torso adjustable, include rain cover antibadai.',
                'tarif' => 50000,
                'stok' => 10,
                'kapasitas' => '60 Liter',
                'berat' => '1.8 kg',
                'material' => 'Nylon 420D',
                'dimensi' => '70 x 34 x 26 cm',
                'rating' => 4.9,
                'ulasan' => 31,
                'galeri' => $carrier,
                'sorotan' => true,
                'gambar' => $carrier[0],
            ],
            [
                'nama' => 'Headlamp LED',
                'kategori' => 'Aksesoris',
                'pos' => 'Senaru',
                'toko' => 'Senaru Camp',
                'deskripsi' => '350 Lumens, baterai tahan 12 jam, waterproof IPX4.',
                'tarif' => 20000,
                'stok' => 15,
                'kapasitas' => '1 Orang',
                'berat' => '0.2 kg',
                'material' => 'ABS + silikon',
                'dimensi' => '6 x 4 x 3 cm',
                'rating' => 4.6,
                'ulasan' => 14,
                'galeri' => $aksesoris,
                'sorotan' => false,
                'gambar' => $aksesoris[0],
            ],
            [
                'nama' => 'Tenda Dome 2P',
                'kategori' => 'Tenda',
                'pos' => 'Senaru',
                'toko' => 'Senaru Camp',
                'deskripsi' => 'Tenda ringan 2 orang, mudah dipasang sendiri dalam 5 menit.',
                'tarif' => 35000,
                'stok' => 9,
                'kapasitas' => '2 Orang',
                'berat' => '2.3 kg',
                'material' => 'Polyester 2500mm',
                'dimensi' => '200 x 150 x 110 cm',
                'rating' => 4.7,
                'ulasan' => 11,
                'galeri' => $tenda,
                'sorotan' => false,
                'gambar' => $tenda[1],
            ],
            [
                'nama' => 'Sleeping Bag Polar',
                'kategori' => 'Sleeping Bag',
                'pos' => 'Sembalun',
                'toko' => 'Sembalun Gear',
                'deskripsi' => 'Polar ekstra tebal untuk suhu puncak, tersedia sarung bantal.',
                'tarif' => 25000,
                'stok' => 14,
                'kapasitas' => '1 Orang',
                'berat' => '1.4 kg',
                'material' => 'Polar premium',
                'dimensi' => '190 x 80 cm',
                'rating' => 4.7,
                'ulasan' => 7,
                'galeri' => $sleepingBag,
                'sorotan' => false,
                'gambar' => $sleepingBag[1],
            ],
            [
                'nama' => 'Matras Ultralight Foil',
                'kategori' => 'Matras',
                'pos' => 'Sembalun',
                'toko' => 'Sembalun Gear',
                'deskripsi' => 'Matras foil aluminium super ringan, dilipat praktis.',
                'tarif' => 15000,
                'stok' => 20,
                'kapasitas' => '1 Orang',
                'berat' => '0.4 kg',
                'material' => 'Foil aluminium',
                'dimensi' => '180 x 50 x 0.8 cm',
                'rating' => 4.5,
                'ulasan' => 6,
                'galeri' => $matras,
                'sorotan' => false,
                'gambar' => $matras[1],
            ],
            [
                'nama' => 'Trekking Pole',
                'kategori' => 'Aksesoris',
                'pos' => 'Torean',
                'toko' => 'Torean Basecamp',
                'deskripsi' => 'Sepasang tongkat aluminium anti-shock, tinggi bisa diatur.',
                'tarif' => 10000,
                'stok' => 18,
                'kapasitas' => 'Dewasa',
                'berat' => '0.5 kg',
                'material' => 'Aluminium 7075',
                'dimensi' => '65 - 135 cm',
                'rating' => 4.6,
                'ulasan' => 8,
                'galeri' => $aksesoris,
                'sorotan' => false,
                'gambar' => $aksesoris[1],
            ],
            [
                'nama' => 'Sepatu Gunung',
                'kategori' => 'Aksesoris',
                'pos' => 'Torean',
                'toko' => 'Torean Basecamp',
                'deskripsi' => 'Sepatu hiking waterproof dengan grip tajam untuk medan terjal.',
                'tarif' => 40000,
                'stok' => 6,
                'kapasitas' => 'Size 39-45',
                'berat' => '1.1 kg',
                'material' => 'Leather + membrane',
                'dimensi' => 'Standar EU',
                'rating' => 4.8,
                'ulasan' => 5,
                'galeri' => $aksesoris,
                'sorotan' => false,
                'gambar' => $aksesoris[2],
            ],
            [
                'nama' => 'Jaket Gunung',
                'kategori' => 'Pakaian',
                'pos' => 'Torean',
                'toko' => 'Torean Basecamp',
                'deskripsi' => 'Jaket windproof berlapis fleece, nyaman untuk suhu puncak.',
                'tarif' => 30000,
                'stok' => 11,
                'kapasitas' => 'Size M-XXL',
                'berat' => '0.9 kg',
                'material' => 'Nylon + fleece',
                'dimensi' => 'Standar dewasa',
                'rating' => 4.7,
                'ulasan' => 10,
                'galeri' => $aksesoris,
                'sorotan' => false,
                'gambar' => $aksesoris[0],
            ],
        ];

        foreach ($katalog as $data) {
            Peralatan::updateOrCreate(
                ['nama' => $data['nama'], 'toko_rental_id' => $tokoModel[$data['toko']]->id],
                [
                    'kategori' => $data['kategori'],
                    'pos' => $data['pos'],
                    'deskripsi' => $data['deskripsi'],
                    'path_gambar' => $data['gambar'],
                    'tarif_harian' => $data['tarif'],
                    'jumlah_stok' => $data['stok'],
                    'kapasitas' => $data['kapasitas'],
                    'berat' => $data['berat'],
                    'material' => $data['material'],
                    'dimensi' => $data['dimensi'],
                    'rating' => $data['rating'],
                    'jumlah_ulasan' => $data['ulasan'],
                    'galeri' => $data['galeri'],
                    'sorotan' => $data['sorotan'],
                ],
            );
        }
    }
}
