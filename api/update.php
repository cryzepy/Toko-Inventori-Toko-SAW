<?php 
// mengimpor model database
include_once 'model/db.php';

// Mengizinkan akses dari semua domain (origin) ke server.
header("Access-Control-Allow-Origin: *");
// Mengizinkan tipe header tertentu untuk dikirim dalam permintaan.
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Custom-Header");

// menangani method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? false;
    $name = $_POST['name'] ?? false;
    $category = $_POST['category'] ?? false;
    $stock = $_POST['stock'] ?? false;
    $price = $_POST['price'] ?? false;
    $description = $_POST['description'] ?? false;


    if($id == false || $name == false || $category == false || $stock == false || $price == false || $description == false) {
        echo json_encode(["status" => "gagal mengupdate data cuy"]);
        return;
    }

    $database = new Database();
    $db = $database->getConnection();
    $products = $database->updateProduct($id ,$name, $category, $stock, $price, $description);

    if($products){
        echo json_encode(["status" => "sukses mengupdate data"]);
    }else{
        echo json_encode(["status" => "gagal mengupdate data"]);
    }

}


?>