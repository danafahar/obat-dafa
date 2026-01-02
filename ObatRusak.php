<?php
// Hapus pemanggilan session_start() dari model.
// Jika perlu, cek session di front controller (public/index.php) saja.
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

class ObatRusak
{
    private $conn;
    private $table = "tbl_obat_rusak";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll()
    {
        $query = "
            SELECT r.*, o.merek_obat, u.username
            FROM tbl_obat_rusak r
            JOIN tbl_obat o ON r.id_obat = o.id_obat
            JOIN tbl_login u ON r.id_user = u.id
            ORDER BY r.tanggal_rusak DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create obat rusak
     * $data may contain keys: id_obat or obat_id, jumlah_rusak, alasan_rusak, tanggal_rusak, keterangan
     * $userId optional; if null will try to read from session (fallback)
     */
    public function create($data, $userId = null)
    {
        // Normalisasi nama field
        $id_obat = $data['id_obat'] ?? $data['obat_id'] ?? null;
        $jumlah = isset($data['jumlah_rusak']) ? (int)$data['jumlah_rusak'] : null;
        $alasan = $data['alasan_rusak'] ?? '';
        $tanggal = $data['tanggal_rusak'] ?? date('Y-m-d');
        $keterangan = $data['keterangan'] ?? '';

        // Ambil user id jika belum diberikan
        if ($userId === null) {
            if (session_status() === PHP_SESSION_NONE) {
                // Jangan mulai session jika Anda menginginkan session di front controller;
                // ini fallback aman bila controller lupa mengoper userId.
                @session_start();
            }
            $userId = $_SESSION['user']['id'] ?? null;
        }

        // Validasi minimal
        if (empty($id_obat)) {
            throw new InvalidArgumentException('Field id_obat (atau obat_id) diperlukan.');
        }
        if ($jumlah === null || $jumlah <= 0) {
            throw new InvalidArgumentException('Field jumlah_rusak harus lebih besar dari 0.');
        }
        if (empty($userId)) {
            throw new InvalidArgumentException('User tidak terautentikasi (id user diperlukan).');
        }

        $query = "INSERT INTO tbl_obat_rusak 
            (id_obat, jumlah_rusak, alasan_rusak, tanggal_rusak, keterangan, id_user)
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $id_obat,
            $jumlah,
            $alasan,
            $tanggal,
            $keterangan,
            $userId
        ]);

        // Kurangi stok hanya jika insert sukses
        $this->kurangiStok($id_obat, $jumlah);
    }

    private function kurangiStok($id_obat, $jumlah)
    {
        $query = "UPDATE tbl_stok_obat 
                  SET jumlah_stok = jumlah_stok - ?
                  WHERE id_obat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$jumlah, $id_obat]);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_obat_rusak WHERE id_rusak = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $query = "UPDATE tbl_obat_rusak SET 
            id_obat = ?, jumlah_rusak = ?, alasan_rusak = ?, 
            tanggal_rusak = ?, keterangan = ?
            WHERE id_rusak = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $data['id_obat'],
            $data['jumlah_rusak'],
            $data['alasan_rusak'],
            $data['tanggal_rusak'],
            $data['keterangan'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tbl_obat_rusak WHERE id_rusak = ?");
        $stmt->execute([$id]);
    }
}
