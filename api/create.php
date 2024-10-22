<?php 
// Mengimpor model database (file "db.php" yang mengandung kelas Database)
include_once 'model/db.php';

// Mengizinkan akses dari semua domain (origin) ke server.
// Hal ini diperlukan untuk menghindari masalah CORS ketika aplikasi frontend dan backend berjalan di domain yang berbeda.
header("Access-Control-Allow-Origin: *");

// Mengizinkan tipe header tertentu untuk dikirim dalam permintaan.
// Berguna untuk mengizinkan tipe header tertentu seperti "Content-Type", "Authorization", dan "X-Custom-Header".
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Custom-Header");

// Mengecek apakah metode HTTP yang digunakan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil data dari permintaan POST, jika tidak ada maka gunakan nilai default
    // Menggunakan tanda null coalescing operator (??) untuk menghindari undefined index error
    $name = $_POST['name'] ?? ''; // Jika $_POST['name'] tidak ada, gunakan string kosong sebagai default
    $category = $_POST['category'] ?? ''; // Sama seperti di atas, default nilai kategori adalah string kosong
    $stock = $_POST['stock'] ?? false; // Jika stok tidak ada, gunakan false sebagai default
    $price = $_POST['price'] ?? false; // Jika harga tidak ada, gunakan false sebagai default
    $description = $_POST['description'] ?? ''; // Default deskripsi adalah string kosong

    // Inisialisasi array untuk menyimpan pesan error jika ada kesalahan validasi
    $errors = [];

    // Validasi: Memeriksa apakah nama produk tidak kosong
    if (empty($name)) {
        $errors[] = "Nama produk tidak boleh kosong."; // Menambahkan pesan error ke array
    }

    // Validasi: Memeriksa apakah stok adalah angka dan lebih besar dari atau sama dengan 0
    if (!is_numeric($stock) || $stock < 0) {
        $errors[] = "Stok harus berupa angka yang lebih besar atau sama dengan 0.";
    }

    // Validasi: Memeriksa apakah harga adalah angka dan lebih besar dari atau sama dengan 0
    if (!is_numeric($price) || $price < 0) {
        $errors[] = "Harga harus berupa angka yang lebih besar atau sama dengan 0.";
    }

    // Jika tidak ada kesalahan validasi
    if(empty($errors)) {
        // Membuat objek baru dari kelas Database
        $database = new Database();
        // Memanggil metode getConnection untuk mendapatkan koneksi ke database
        $db = $database->getConnection();

        // Memanggil metode createProduct untuk menambahkan produk baru ke database
        // Data yang dikirimkan telah diproses dan di-trim untuk menghapus spasi yang tidak perlu
        $products = $database->createProduct(trim($name), trim($category), $stock, $price, trim($description));
    
        // Mengecek apakah penambahan produk berhasil
        if($products){
            // Jika berhasil, kirim respon JSON dengan status sukses
            echo json_encode(["status" => "sukses menambah data"]);
        }else{
            // Jika gagal, kirim respon JSON dengan status gagal
            echo json_encode(["status" => "gagal menambah data"]);
        }
    }else{
        // Jika ada kesalahan validasi, kirim respon JSON dengan status gagal dan pesan error pertama
        echo json_encode(["status" => "gagal menambahkan data", "message" => $errors[0]]);
    }

}

?>
