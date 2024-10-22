<?php 
// Mengimpor model database yang berisi class Database untuk mengelola interaksi dengan database
include_once 'model/db.php';

// Mengizinkan akses dari semua domain (origin) ke server.
// Ini bertujuan untuk menghindari masalah CORS (Cross-Origin Resource Sharing) saat frontend dan backend berada di domain yang berbeda.
header("Access-Control-Allow-Origin: *");

// Mengizinkan tipe header tertentu seperti Content-Type, Authorization, dan X-Custom-Header dikirim dalam permintaan.
// Berguna ketika client (frontend) mengirimkan permintaan dengan header tambahan atau khusus.
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Custom-Header");

// Mengecek apakah metode HTTP yang digunakan adalah GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Membuat objek baru dari kelas Database
    $database = new Database();
    // Memanggil metode getConnection untuk menghubungkan ke database
    $db = $database->getConnection();
    
    // Memanggil metode readProducts dari class Database untuk membaca semua produk dari database
    $products = $database->readProducts();
    
    // Mengirimkan respons JSON yang berisi status sukses dan data produk yang telah dibaca dari database
    echo json_encode(["status" => "sukses", "data" => $products]);
    
}

?>
