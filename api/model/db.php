<?php

// file ini menangani interaksi langsung dengan database, seperti Create, Read, Update, dan Delete (CRUD) data

class Database
{

    // konfigurasi database
    private $host = "localhost";
    private $db_name = "sistem_aplikasi_web";
    private $username = "root";
    private $password = "";
    public $conn;

    // Fungsi untuk menghubungkan ke database
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Koneksi gagal: " . $exception->getMessage();
        }

        return $this->conn;
    }

    // CREATE: Menambahkan produk baru
    public function createProduct($name, $category, $stock, $price, $description)
    {
        $query = "INSERT INTO products (name, category, stock, price, description) 
                  VALUES (:name, :category, :stock, :price, :description)";
        $stmt = $this->conn->prepare($query);

        // Binding parameter
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            // Check how many rows were affected
            $rowCount = $stmt->rowCount();

            // Optional: You can return the row count or check if at least one row was affected
            if ($rowCount > 0) {
                return true; // or return true;
            } else {
                return false; // No rows were updated
            }
        }

        return false;
    }

    // READ: Melihat semua produk
    public function readProducts()
    {
        $query = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE: Mengupdate produk berdasarkan ID
    public function updateProduct($id, $name, $category, $stock, $price, $description)
    {
        $query = "UPDATE products 
                  SET name = :name, category = :category, stock = :stock, price = :price, description = :description
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Binding parameter
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            // Check how many rows were affected
            $rowCount = $stmt->rowCount();

            // Optional: You can return the row count or check if at least one row was affected
            if ($rowCount > 0) {
                return true; // or return true;
            } else {
                return false; // No rows were updated
            }
        }

        return false;
    }

    // DELETE: Menghapus produk berdasarkan ID
    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Check how many rows were affected
            $rowCount = $stmt->rowCount();

            // Optional: You can return the row count or check if at least one row was affected
            if ($rowCount > 0) {
                return true; // or return true;
            } else {
                return false; // No rows were updated
            }
        }

        return false;
    }
}
