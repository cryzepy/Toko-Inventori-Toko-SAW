<?php

// file ini menangani interaksi langsung dengan database, seperti Create, Read, Update, dan Delete (CRUD) data

class Database
{
    // konfigurasi database
    // Properti untuk menyimpan informasi koneksi database (host, nama database, username, password)
    private $host = "localhost"; // Host database, biasanya "localhost" untuk server lokal
    private $db_name = "sistem_aplikasi_web"; // Nama database yang digunakan
    private $username = "root"; // Username untuk akses ke database (umumnya "root" pada server lokal)
    private $password = ""; // Password untuk akses ke database (kosong pada setup default XAMPP atau LAMP)
    public $conn; // Properti untuk menyimpan koneksi database

    // Fungsi untuk menghubungkan ke database
    public function getConnection()
    {
        $this->conn = null; // Inisialisasi properti koneksi dengan nilai null

        try {
            // Mencoba untuk membuat koneksi ke database menggunakan PDO (PHP Data Objects)
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Mengatur mode error PDO agar menampilkan exception jika ada kesalahan
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Jika koneksi gagal, tampilkan pesan kesalahan
            echo "Koneksi gagal: " . $exception->getMessage();
        }

        return $this->conn; // Mengembalikan objek koneksi database
    }

    // CREATE: Menambahkan produk baru
    public function createProduct($name, $category, $stock, $price, $description)
    {
        // Query SQL untuk menambahkan produk baru ke tabel "products"
        $query = "INSERT INTO products (name, category, stock, price, description) 
                  VALUES (:name, :category, :stock, :price, :description)";
        // Mempersiapkan query dengan metode prepare untuk keamanan (menghindari SQL injection)
        $stmt = $this->conn->prepare($query);

        // Binding parameter (menghubungkan nilai dari parameter ke query SQL)
        $stmt->bindParam(':name', $name); // Menghubungkan nilai $name ke parameter :name
        $stmt->bindParam(':category', $category); // Menghubungkan nilai $category ke parameter :category
        $stmt->bindParam(':stock', $stock); // Menghubungkan nilai $stock ke parameter :stock
        $stmt->bindParam(':price', $price); // Menghubungkan nilai $price ke parameter :price
        $stmt->bindParam(':description', $description); // Menghubungkan nilai $description ke parameter :description

        // Menjalankan query dan memeriksa apakah eksekusi berhasil
        if ($stmt->execute()) {
            // Menghitung jumlah baris yang dipengaruhi oleh query (untuk mengetahui apakah ada data yang dimasukkan)
            $rowCount = $stmt->rowCount();

            // Cek apakah setidaknya satu baris data berhasil dimasukkan
            if ($rowCount > 0) {
                return true; // Jika ada baris yang dipengaruhi, kembalikan true
            } else {
                return false; // Jika tidak ada baris yang dipengaruhi, kembalikan false
            }
        }

        return false; // Jika eksekusi query gagal, kembalikan false
    }

    // READ: Melihat semua produk
    public function readProducts()
    {
        // Query SQL untuk mengambil semua produk dari tabel "products" diurutkan berdasarkan tanggal dibuat (created_at) dari yang terbaru
        $query = "SELECT * FROM products ORDER BY created_at DESC";
        // Mempersiapkan query
        $stmt = $this->conn->prepare($query);
        // Menjalankan query
        $stmt->execute();
        // Mengembalikan hasil query dalam bentuk array asosiatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE: Mengupdate produk berdasarkan ID
    public function updateProduct($id, $name, $category, $stock, $price, $description)
    {
        // Query SQL untuk mengupdate data produk berdasarkan ID
        $query = "UPDATE products 
                  SET name = :name, category = :category, stock = :stock, price = :price, description = :description
                  WHERE id = :id";
        // Mempersiapkan query untuk dieksekusi
        $stmt = $this->conn->prepare($query);

        // Binding parameter (menghubungkan nilai ke query)
        $stmt->bindParam(':id', $id); // Menghubungkan nilai $id ke parameter :id
        $stmt->bindParam(':name', $name); // Menghubungkan nilai $name ke parameter :name
        $stmt->bindParam(':category', $category); // Menghubungkan nilai $category ke parameter :category
        $stmt->bindParam(':stock', $stock); // Menghubungkan nilai $stock ke parameter :stock
        $stmt->bindParam(':price', $price); // Menghubungkan nilai $price ke parameter :price
        $stmt->bindParam(':description', $description); // Menghubungkan nilai $description ke parameter :description

        // Menjalankan query dan memeriksa apakah eksekusi berhasil
        if ($stmt->execute()) {
            // Menghitung jumlah baris yang dipengaruhi oleh query
            $rowCount = $stmt->rowCount();

            // Cek apakah ada baris yang diubah
            if ($rowCount > 0) {
                return true; // Jika ada baris yang dipengaruhi, kembalikan true
            } else {
                return false; // Jika tidak ada baris yang diubah, kembalikan false
            }
        }

        return false; // Jika eksekusi query gagal, kembalikan false
    }

    // DELETE: Menghapus produk berdasarkan ID
    public function deleteProduct($id)
    {
        // Query SQL untuk menghapus produk berdasarkan ID
        $query = "DELETE FROM products WHERE id = :id";
        // Mempersiapkan query untuk dieksekusi
        $stmt = $this->conn->prepare($query);
        // Binding parameter (menghubungkan nilai $id ke parameter :id)
        $stmt->bindParam(':id', $id);

        // Menjalankan query dan memeriksa apakah eksekusi berhasil
        if ($stmt->execute()) {
            // Menghitung jumlah baris yang dipengaruhi oleh query
            $rowCount = $stmt->rowCount();

            // Cek apakah ada baris yang dihapus
            if ($rowCount > 0) {
                return true; // Jika ada baris yang dipengaruhi, kembalikan true
            } else {
                return false; // Jika tidak ada baris yang dihapus, kembalikan false
            }
        }

        return false; // Jika eksekusi query gagal, kembalikan false
    }
}
