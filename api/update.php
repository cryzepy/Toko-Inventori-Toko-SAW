<?php 
// Mengimpor model database yang berisi class Database untuk mengelola interaksi dengan database
include_once 'model/db.php';

// Mengizinkan akses dari semua domain (origin) ke server.
// Ini bertujuan untuk menghindari masalah CORS (Cross-Origin Resource Sharing), terutama ketika frontend dan backend berada di domain yang berbeda.
header("Access-Control-Allow-Origin: *");

// Mengizinkan tipe header tertentu untuk dikirim dalam permintaan, seperti Content-Type, Authorization, dan X-Custom-Header.
// Berguna ketika permintaan dari client mengirim header tambahan atau khusus.
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Custom-Header");

// Memeriksa apakah metode HTTP yang digunakan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil data yang dikirim melalui POST dan memeriksa apakah setiap data tersedia, jika tidak tersedia, default ke nilai false
    $id = $_POST['id'] ?? false;
    $name = $_POST['name'] ?? false;
    $category = $_POST['category'] ?? false;
    $stock = $_POST['stock'] ?? false;
    $price = $_POST['price'] ?? false;
    $description = $_POST['description'] ?? false;

    // Memeriksa apakah ada data yang kosong, jika iya, mengembalikan pesan error dalam format JSON dan menghentikan eksekusi
    if($id == false || $name == false || $category == false || $stock == false || $price == false || $description == false) {
        echo json_encode(["status" => "gagal mengupdate data cuy"]);
        return; // Menghentikan eksekusi kode jika ada data yang tidak valid
    }

    // Membuat objek baru dari kelas Database
    $database = new Database();
    // Memanggil metode getConnection untuk menghubungkan ke database
    $db = $database->getConnection();
    
    // Memanggil metode updateProduct dari class Database untuk mengupdate produk di database berdasarkan ID
    $products = $database->updateProduct($id, $name, $category, $stock, $price, $description);

    // Jika produk berhasil di-update, kirim respons sukses dalam format JSON, jika gagal, kirim respons error dalam format JSON
    if($products){
        echo json_encode(["status" => "sukses mengupdate data"]);
    }else{
        echo json_encode(["status" => "gagal mengupdate data"]);
    }

}

?>
