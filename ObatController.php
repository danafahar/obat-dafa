<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Obat.php';

class ObatController
{
    private $conn;
    private $model;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->model = new Obat($this->conn);
    }

    // === OBAT ===
    public function index()
    {
        $obat = $this->model->readAll();
        include __DIR__ . '/../views/obat/read_data.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header('Location: index.php?action=obat');
            exit;
        } else {
            include __DIR__ . '/../views/obat/create.php';
        }
    }

    public function edit($id)
    {
        $obat = $this->model->find($id);
        include __DIR__ . '/../views/obat/update.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header('Location: index.php?action=obat');
            exit;
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: index.php?action=obat');
        exit;
    }

    // === STOK OBAT ===
    public function stokObat()
    {
        $dataStok = $this->model->getStok();
        include __DIR__ . '/../views/obat/stok_obat.php';
    }

    public function createStok()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->model->createStok($_POST);
        header('Location: index.php?action=stok_obat');
        exit;
    } else {
        // Ambil semua obat agar bisa dipilih
        $dataObat = $this->model->readAll();
        include __DIR__ . '/../views/obat/create_stok.php';
    }
}
    public function deleteStok($id)
{
    require_once __DIR__. '/../models/Obat.php';
    $model = new Obat($this->conn);
    $model->deleteStok($id);
    header('Location: index.php?action=stok_obat');
    exit;
}
    // Tampilkan form edit stok
public function editStok($id)
{
    require_once __DIR__ . '/../models/Obat.php';
    $model = new Obat($this->conn);
    $stok = $model->findStok($id); // cari data stok berdasarkan id_stok
    $obatList = $model->readAll(); // untuk select obat jika perlu
    include __DIR__ . '/../views/obat/edit_stok.php'; // tampilan form edit
}

// Simpan hasil update stok
public function updateStok($id)
{
    require_once __DIR__ . '/../models/Obat.php';
    $model = new Obat($this->conn);

    $data = [
        'id_obat' => $_POST['id_obat'],
        'jumlah_stok' => $_POST['jumlah_stok'],
        'harga_beli' => $_POST['harga_beli'],
        'harga_jual' => $_POST['harga_jual']
    ];

    $model->updateStok($id, $data);
    header('Location: index.php?action=stok_obat');
    exit;
}

public function getDashboardStats()
{
    return [
        'total_obat' => $this->model->getTotalObat(),
        'total_stok' => $this->model->getTotalStok(),
    ];
}

public function getDataObatDenganHarga()
{
    require_once '../config/Database.php';
    $database = new Database();
    $conn = $database->getConnection();

    $query = "
        SELECT o.id_obat, o.kode_obat, o.merek_obat, o.jenis_obat, o.tanggal_masuk, o.exp, 
               s.jumlah_stok, s.harga_jual
        FROM tbl_obat o
        LEFT JOIN tbl_stok_obat s ON o.id_obat = s.id_obat
        ORDER BY o.created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getObatById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM obat WHERE id_obat = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}





}