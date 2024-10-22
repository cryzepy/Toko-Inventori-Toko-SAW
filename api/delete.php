<?php 
// Mengimpor model database, yang berisi class Database untuk berinteraksi dengan database
include_once 'model/db.php';

// Mengizinkan akses dari semua domain (origin) ke server.
// Hal ini diperlukan untuk menghindari masalah CORS (Cross-Origin Resource Sharing) saat aplikasi frontend dan backend berada di domain yang berbeda.
header("Access-Control-Allow-Origin: *");

// Mengizinkan tipe header tertentu untuk dikirim dalam permintaan, seperti Content-Type dan Authorization.
// Berguna untuk memungkinkan pengiriman header tambahan dari aplikasi frontend ke server backend.
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Custom-Header");

// Mengecek apakah metode HTTP yang digunakan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil ID produk yang akan dihapus dari input POST
    // Jika ID tidak disediakan, maka gunakan false sebagai default value
    $id = $_POST['id'] ?? false;

    // Jika ID tidak ada (false), kirimkan pesan gagal dan hentikan proses
    if(!$id) {
        echo json_encode(["status" => "gagal menghapus data", "message" => "id tidak valid"]);
        return; // Menghentikan eksekusi lebih lanjut jika ID tidak valid
    }

    // Membuat objek baru dari kelas Database
    $database = new Database();
    // Memanggil metode getConnection untuk mendapatkan koneksi ke database
    $db = $database->getConnection();
    
    // Memanggil metode deleteProduct untuk menghapus produk berdasarkan ID
    $products = $database->deleteProduct($id);

    // Mengecek apakah penghapusan produk berhasil
    if($products){
        // Jika berhasil, kirim respon JSON dengan status sukses
        echo json_encode(["status" => "sukses menghapus data"]);
    }else{
        // Jika gagal, kirim respon JSON dengan status gagal
        echo json_encode(["status" => "gagal menghapus data"]);
    }
}

?>
