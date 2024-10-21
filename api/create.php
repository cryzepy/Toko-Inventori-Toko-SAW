<?php 
// mengimpor model database
include_once 'model/db.php';

// Mengizinkan akses dari semua domain (origin) ke server.
header("Access-Control-Allow-Origin: *");
// Mengizinkan tipe header tertentu untuk dikirim dalam permintaan.
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Custom-Header");

// menangani method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $stock = $_POST['stock'] ?? false;
    $price = $_POST['price'] ?? false;
    $description = $_POST['description'] ?? '';


    $errors = [];

    if (empty($name)) {
        $errors[] = "Nama produk tidak boleh kosong.";
    }
    if (!is_numeric($stock) || $stock < 0) {
        $errors[] = "Stok harus berupa angka yang lebih besar atau sama dengan 0.";
    }
    if (!is_numeric($price) || $price < 0) {
        $errors[] = "Harga harus berupa angka yang lebih besar atau sama dengan 0.";
    }



    if(empty($errors)) {
        $database = new Database();
        $db = $database->getConnection();
        $products = $database->createProduct(trim($name), trim($category), $stock, $price, trim($description));
    
        if($products){
            echo json_encode(["status" => "sukses menambah data"]);
        }else{
            echo json_encode(["status" => "gagal menambah data"]);
        }
    }else{
        echo json_encode(["status" => "gagal menambahkan data", "message" => $errors[0]]);
    }

}


?>