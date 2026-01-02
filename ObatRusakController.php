<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ObatRusak.php';
require_once __DIR__ . '/../models/Obat.php';

class ObatRusakController
{
    private $conn;
    private $model;
    private $obatModel;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();

        $this->model = new ObatRusak($this->conn);
        $this->obatModel = new Obat($this->conn);
    }

    public function index()
    {
        $obatRusak = $this->model->readAll();
        $view = __DIR__ . '/../views/obat_rusak/read_data.php';
        if (is_file($view)) {
            include $view;
        } else {
            http_response_code(500);
            echo "View tidak ditemukan: " . htmlspecialchars($view);
            exit;
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // debug sementara — hapus setelah selesai
            // var_dump($_POST); exit;

            $payload = [
                'id_obat'      => $_POST['obat_id'] ?? $_POST['id_obat'] ?? null,
                'jumlah_rusak' => isset($_POST['jumlah_rusak']) ? (int)$_POST['jumlah_rusak'] : null,
                'alasan_rusak' => $_POST['alasan_rusak'] ?? '',
                'tanggal_rusak'=> $_POST['tanggal_rusak'] ?? date('Y-m-d'),
                'keterangan'   => $_POST['keterangan'] ?? ($_POST['alasan_rusak'] ?? '')
            ];

            $userId = $_SESSION['user']['id'] ?? null;

            try {
                $payload = [
                    'id_obat'       => $_POST['obat_id'] ?? null,
                    'jumlah_rusak'  => (int)($_POST['jumlah_rusak'] ?? 0),
                    'alasan_rusak'  => $_POST['alasan_rusak'] ?? '',
                    'tanggal_rusak' => $_POST['tanggal_rusak'] ?? date('Y-m-d'),
                    'keterangan'    => $_POST['keterangan'] ?? ''
                ];
                $this->model->create($payload, $userId);
                header('Location: index.php?action=obat_rusak');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
                $dataObat = $this->obatModel->readAll();
                $view = __DIR__ . '/../views/obat_rusak/create_obatrusak.php';
                if (is_file($view)) {
                    include $view;
                } else {
                    http_response_code(500);
                    echo "View tidak ditemukan: " . htmlspecialchars($view);
                }
                return;
            }
        } else {
            $dataObat = $this->obatModel->readAll();
            $view = __DIR__ . '/../views/obat_rusak/create_obatrusak.php';
            if (is_file($view)) {
                include $view;
            } else {
                http_response_code(500);
                echo "View tidak ditemukan: " . htmlspecialchars($view);
                exit;
            }
        }
    }

    public function edit($id)
    {
        $rusak = $this->model->find($id);
        $dataObat = $this->obatModel->readAll();
        $view = __DIR__ . '/../views/obat_rusak/update.php';
        if (is_file($view)) {
            include $view;
        } else {
            http_response_code(500);
            echo "View tidak ditemukan: " . htmlspecialchars($view);
            exit;
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payload = [
                'id_obat'       => $_POST['obat_id'] ?? $_POST['id_obat'] ?? null,
                'jumlah_rusak'  => isset($_POST['jumlah_rusak']) ? (int)$_POST['jumlah_rusak'] : null,
                'alasan_rusak'  => $_POST['alasan_rusak'] ?? '',
                'tanggal_rusak' => $_POST['tanggal_rusak'] ?? date('Y-m-d'),
                'keterangan'    => $_POST['keterangan'] ?? ''
            ];

            try {
                $this->model->update($id, $payload);
                header('Location: index.php?action=obat_rusak');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
                $rusak = $this->model->find($id);
                $dataObat = $this->obatModel->readAll();
                $view = __DIR__ . '/../views/obat_rusak/update.php';
                if (is_file($view)) {
                    include $view;
                } else {
                    http_response_code(500);
                    echo "View tidak ditemukan: " . htmlspecialchars($view);
                }
                return;
            }
        } else {
            header('Location: index.php?action=obat_rusak');
            exit;
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: index.php?action=obat_rusak');
        exit;
    }
}
