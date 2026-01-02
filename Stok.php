<?php
class Obat
{
    private $conn;
    private $table = 'tbl_obat';
    private $table = 'tbl_stok_obat';


    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ambil semua data obat + stok
    public function readWithStok()
    {
        $query = "SELECT o.*, s.jumlah 
                  FROM {$this->table} o 
                  LEFT JOIN tbl_stok_obat s ON o.id_obat = s.id_obat
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil semua data obat (tanpa stok)
    public function readAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah data obat (dan stok awal)
    public function create($data)
    {
        try {
            $this->conn->beginTransaction();

            $query = "INSERT INTO {$this->table} (kode_obat, merek_obat, jenis_obat, tanggal_masuk, exp, created_at) 
                      VALUES (:kode_obat, :merek_obat, :jenis_obat, :tanggal_masuk, :exp, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kode_obat', $data['kode_obat']);
            $stmt->bindParam(':merek_obat', $data['merek_obat']);
            $stmt->bindParam(':jenis_obat', $data['jenis_obat']);
            $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
            $stmt->bindParam(':exp', $data['exp']);
            $stmt->execute();

            $id_obat = $this->conn->lastInsertId();
            $this->updateStok($id_obat, $data['jumlah'] ?? 0);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Create Error: " . $e->getMessage());
            return false;
        }
    }

    // Cari data berdasarkan ID
    public function find($id)
    {
        $query = "SELECT o.*, s.jumlah 
                  FROM {$this->table} o
                  LEFT JOIN tbl_stok_obat s ON o.id_obat = s.id_obat
                  WHERE o.id_obat = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update data obat dan stok
    public function update($id, $data)
    {
        try {
            $this->conn->beginTransaction();

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
            $stmt->execute();

            $this->updateStok($id, $data['jumlah'] ?? 0);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    // Hapus data obat dan stoknya
    public function delete($id)
    {
        try {
            $this->conn->beginTransaction();

            $queryStok = "DELETE FROM tbl_stok_obat WHERE id_obat = :id";
            $stmtStok = $this->conn->prepare($queryStok);
            $stmtStok->bindParam(':id', $id);
            $stmtStok->execute();

            $query = "DELETE FROM {$this->table} WHERE id_obat = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Delete Error: " . $e->getMessage());
            return false;
        }
    }

    // Tambah/update stok obat
    public function updateStok($id_obat, $jumlah)
    {
        $query = "SELECT * FROM tbl_stok_obat WHERE id_obat = :id_obat";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_obat', $id_obat);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = "UPDATE tbl_stok_obat SET jumlah = :jumlah, updated_at = NOW() WHERE id_obat = :id_obat";
        } else {
            $query = "INSERT INTO tbl_stok_obat (id_obat, jumlah, updated_at) VALUES (:id_obat, :jumlah, NOW())";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_obat', $id_obat);
        $stmt->bindParam(':jumlah', $jumlah);
        return $stmt->execute();
    }
}
