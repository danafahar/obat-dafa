<?php
// File: config/Database.php (REVISI FINAL)
class Database
{
    // Sesuaikan detail koneksi Anda di sini
    private $host = "localhost:3306";
    private $db_name = "db_apotek";
    private $username = "root";
    private $password = ""; 
    public $conn;

    /**
     * Constructor: Otomatis membuat koneksi saat objek Database dibuat
     */
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }
    
    public function getConnection()
    {
        $this->conn = null;
        try {
            // Logika untuk menangani host:port jika ada
            $parts = explode(':', $this->host);
            $host_only = $parts[0];
            $port = (count($parts) > 1) ? ';port=' . $parts[1] : '';

            $this->conn = new PDO(
                "mysql:host=" . $host_only . $port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Penting: Mengatur hasil fetch menjadi array asosiatif
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
        } catch (PDOException $exception) {
            die("Koneksi gagal: " . $exception->getMessage());
        }
        return $this->conn;
    }
    
    /**
     * Method 'query' KRUSIAL untuk menjalankan SELECT, INSERT, UPDATE, DELETE
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            // Jika query adalah SELECT, kembalikan semua hasilnya
            if (stripos(trim($sql), 'SELECT') === 0) {
                return $stmt->fetchAll();
            }
            // Untuk INSERT, UPDATE, DELETE
            return $stmt;
        } catch (PDOException $e) {
            die("SQL Error: " . $e->getMessage() . " in query: " . $sql);
        }
    }
}
?>