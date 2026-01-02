<?php
require_once '../config/database.php';

class PesananController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function buatPesanan($id_user, $id_obat, $jumlah) {
        // Simpan ke tabel pesanan
        $sql = "INSERT INTO pesanan (id_user, id_obat, jumlah, status, tanggal_pesan) 
                VALUES (?, ?, ?, 'pending', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user, $id_obat, $jumlah]);

        // Update stok obat
        $sql2 = "UPDATE obat SET jumlah_stok = jumlah_stok - ? WHERE id_obat = ?";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->execute([$jumlah, $id_obat]);
    }
}
