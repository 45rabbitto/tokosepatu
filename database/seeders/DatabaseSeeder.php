<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create UMKM Owner Users
        $owner1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'umkm_owner',
        ]);

        $owner2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'umkm_owner',
        ]);

        // Create Categories
        $categories = [
            ['nama' => 'Sneakers', 'deskripsi' => 'Sepatu casual sporty untuk aktivitas sehari-hari'],
            ['nama' => 'Formal', 'deskripsi' => 'Sepatu untuk acara formal dan kantor'],
            ['nama' => 'Olahraga', 'deskripsi' => 'Sepatu khusus untuk kegiatan olahraga'],
            ['nama' => 'Sandal', 'deskripsi' => 'Sandal nyaman untuk berbagai kesempatan'],
            ['nama' => 'Boots', 'deskripsi' => 'Sepatu boots untuk berbagai gaya'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create UMKMs
        $umkm1 = Umkm::create([
            'user_id' => $owner1->id,
            'nama' => 'Sepatu Jaya Abadi',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            'kontak' => '081234567890',
            'deskripsi' => 'Toko sepatu berkualitas dengan harga terjangkau. Menyediakan berbagai jenis sepatu untuk semua kalangan.',
        ]);

        $umkm2 = Umkm::create([
            'user_id' => $owner2->id,
            'nama' => 'Footwear Indonesia',
            'alamat' => 'Jl. Sudirman No. 456, Bandung',
            'kontak' => '082345678901',
            'deskripsi' => 'Spesialis sepatu handmade dengan kualitas premium. Produk lokal dengan standar internasional.',
        ]);

        // Create Products for UMKM 1
        $products1 = [
            [
                'nama' => 'Sneakers Urban Classic',
                'deskripsi' => 'Sneakers nyaman untuk aktivitas sehari-hari dengan desain modern',
                'harga' => 350000,
                'stok' => 25,
                'ukuran' => '38, 39, 40, 41, 42, 43',
                'warna' => 'Hitam, Putih, Abu-abu',
            ],
            [
                'nama' => 'Sepatu Formal Eksekutif',
                'deskripsi' => 'Sepatu kulit asli untuk acara formal dan profesional',
                'harga' => 550000,
                'stok' => 15,
                'ukuran' => '39, 40, 41, 42, 43',
                'warna' => 'Hitam, Coklat',
            ],
            [
                'nama' => 'Running Shoes Pro',
                'deskripsi' => 'Sepatu lari ringan dengan teknologi cushioning terbaik',
                'harga' => 450000,
                'stok' => 30,
                'ukuran' => '38, 39, 40, 41, 42, 43, 44',
                'warna' => 'Biru, Merah, Hijau',
            ],
        ];

        foreach ($products1 as $productData) {
            $product = Product::create(array_merge($productData, ['umkm_id' => $umkm1->id]));
            // Attach random categories
            $product->categories()->attach(
                Category::inRandomOrder()->take(rand(1, 2))->pluck('id')
            );
        }

        // Create Products for UMKM 2
        $products2 = [
            [
                'nama' => 'Handmade Leather Oxford',
                'deskripsi' => 'Sepatu oxford handmade dari kulit sapi pilihan',
                'harga' => 750000,
                'stok' => 10,
                'ukuran' => '40, 41, 42, 43',
                'warna' => 'Coklat Tua, Hitam',
            ],
            [
                'nama' => 'Boots Vintage Style',
                'deskripsi' => 'Boots dengan gaya vintage yang timeless',
                'harga' => 650000,
                'stok' => 12,
                'ukuran' => '39, 40, 41, 42, 43',
                'warna' => 'Coklat, Hitam',
            ],
            [
                'nama' => 'Sandal Kulit Premium',
                'deskripsi' => 'Sandal kulit tahan lama dengan kenyamanan maksimal',
                'harga' => 280000,
                'stok' => 40,
                'ukuran' => '38, 39, 40, 41, 42, 43, 44',
                'warna' => 'Coklat, Tan, Hitam',
            ],
        ];

        foreach ($products2 as $productData) {
            $product = Product::create(array_merge($productData, ['umkm_id' => $umkm2->id]));
            // Attach random categories
            $product->categories()->attach(
                Category::inRandomOrder()->take(rand(1, 2))->pluck('id')
            );
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('UMKM Owner 1: budi@example.com / password');
        $this->command->info('UMKM Owner 2: siti@example.com / password');
    }
}
