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

    if(!$id) {
        echo json_encode(["status" => "gagal menghapus data", "message" => "id tidak valid"]);
        return;
    }

    $database = new Database();
    $db = $database->getConnection();
    $products = $database->deleteProduct($id);

    if($products){
        echo json_encode(["status" => "sukses menghapus data"]);
    }else{
        echo json_encode(["status" => "gagal menghapus data"]);
    }
}


?>