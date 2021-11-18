## Aplikasi Point Of Sale Berbasis Website
aplikasi ini dibuat menggunakan framework Laravel 8 dan Bootstrap 4. aplikasi ini berfungsi untuk memudahkan kegiatan transaksi dan pengelolaan data pada toko. terdapat 2 tipe akun, yakni admin dan kasir.

## fitur admin
- Mengelola data kategori
- Mengelola data produk
- Cetak barcode produk
- Mengelola data member
- Cetak kartu member 
- Mengelola data supplier 
- Mengelola data pembelian produk 
- Melakukan pembelian kepada supplier yang terdaftar, membatalkan pembelian, lihat detail pembelian 
- Mengelola data pengeluaran 
- Mengelola data penjualan
- Melakukan transaksi penjualan dan cetak nota
- Mengatur desain kartu member, logo, nama perusahaan, alamat perusahaan, nomor perusahaan, dan diskon member
- Cetak laporan penjualan, pembelian, dan pengeluaran
- Data penjualan dan pengeluaran dalam bentuk grafik

## fitur user
- Melakukan transaksi penjualan
- Melihat detail dan membatalkan penjualan

## cara instal 
- Clone repo ini 
<code>git clone https://github.com/yasminramadini/point-of-sale.git</code>
- Copy file .env.example dengan perintah berikut melalui terminal
<code>cp .env.example .env</code>

atau

<code>copy .env.example .env</code>
- ketik perintah <code>composer install</code>
- ketik perintah <code>php artisan key:generate</code>
- buka file .env, edit konfigurasi databasenya 
- lakukan migrasi database dan seeder <code>php artisan migrate --seed</code>
- jalankan server dengan php artisan serve
