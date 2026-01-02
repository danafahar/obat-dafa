<?php
class Obat
{
    private $conn;
    private $table = 'tbl_obat';
    

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ambil semua data obat
    public function readAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah data obat
    public function create($data)
    {
        $query = "INSERT INTO {$this->table} (kode_obat, merek_obat, jenis_obat, tanggal_masuk, exp, created_at) 
                  VALUES (:kode_obat, :merek_obat, :jenis_obat, :tanggal_masuk, :exp, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kode_obat', $data['kode_obat']);
        $stmt->bindParam(':merek_obat', $data['merek_obat']);
        $stmt->bindParam(':jenis_obat', $data['jenis_obat']);
        $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
        $stmt->bindParam(':exp', $data['exp']);
        return $stmt->execute();
    }

    // Cari data obat berdasarkan ID
    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id_obat = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update data obat
    public function update($id, $data)
    {
        $query = "UPDATE {$this->table} 
                  SET kode_obat = :kode_obat, 
                      merek_obat = :merek_obat, 
                      jenis_obat = :jenis_obat, 
                      tanggal_masuk = :tanggal_masuk, 
                      exp = :exp 
                  WHERE id_obat = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kode_obat', $data['kode_obat']);
        $stmt->bindParam(':merek_obat', $data['merek_obat']);
        $stmt->bindParam(':jenis_obat', $data['jenis_obat']);
        $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
        $stmt->bindParam(':exp', $data['exp']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Hapus data obat
    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id_obat = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Ambil data stok obat dengan join ke tbl_obat
   public function getStok()
{
    $query = "SELECT s.*, o.kode_obat, o.merek_obat, o.jenis_obat
              FROM tbl_stok_obat s
              JOIN tbl_obat o ON s.id_obat = o.id_obat
              ORDER BY s.id_stok DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function stokObat()
{
    require_once __DIR__ . '/../models/Obat.php';
    $model = new Obat($this->conn);
    $dataStok = $model->getStok(); // memanggil data stok
    include __DIR__ . '/../views/obat/stok_obat.php';
}

    public function createStok($data)
{
    $query = "INSERT INTO tbl_stok_obat (id_obat, jumlah_stok, harga_beli, harga_jual)
              VALUES (:id_obat, :jumlah_stok, :harga_beli, :harga_jual)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_obat', $data['id_obat']);
    $stmt->bindParam(':jumlah_stok', $data['jumlah_stok']);
    $stmt->bindParam(':harga_beli', $data['harga_beli']);
    $stmt->bindParam(':harga_jual', $data['harga_jual']);
    return $stmt->execute();
}
    public function deleteStok($id)
{
    $query = "DELETE FROM tbl_stok_obat WHERE id_stok = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
    // Ambil satu data stok berdasarkan id_stok
public function findStok($id)
{
    $query = "
        SELECT stok.*, obat.kode_obat, obat.merek_obat 
        FROM tbl_stok_obat AS stok
        JOIN tbl_obat AS obat ON stok.id_obat = obat.id_obat
        WHERE stok.id_stok = :id
        LIMIT 1
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update data stok
public function updateStok($id, $data)
{
    $query = "
        UPDATE tbl_stok_obat 
        SET id_obat = :id_obat, 
            jumlah_stok = :jumlah_stok, 
            harga_beli = :harga_beli, 
            harga_jual = :harga_jual 
        WHERE id_stok = :id
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_obat', $data['id_obat']);
    $stmt->bindParam(':jumlah_stok', $data['jumlah_stok']);
    $stmt->bindParam(':harga_beli', $data['harga_beli']);
    $stmt->bindParam(':harga_jual', $data['harga_jual']);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
    public function getTotalObat()
{
    $stmt = $this->conn->query("SELECT COUNT(*) as total FROM tbl_obat");
    $result = $stmt->fetch();
    return $result['total'];
}

public function getTotalStok()
{
    $stmt = $this->conn->query("SELECT SUM(jumlah_stok) as total FROM tbl_stok_obat");
    $result = $stmt->fetch();
    return $result['total'] ?? 0;
}


}