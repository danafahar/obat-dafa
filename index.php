<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// =====================================================================
// REQUIRE SEMUA FILE
// =====================================================================
require_once '../config/Database.php';
require_once '../models/Laporan.php';
require_once '../vendor/autoload.php';

require_once '../controllers/UserController.php';
require_once '../controllers/ObatController.php';
require_once '../controllers/ObatRusakController.php';
require_once '../controllers/LaporanController.php';

$action = $_GET['action'] ?? 'login';
$id     = $_GET['id'] ?? null;

// =====================================================================
// CEK LOGIN KECUALI AKSI LOGIN / LOGOUT
// =====================================================================
if (!in_array($action, ['login', 'logout']) && !isset($_SESSION['user'])) {
    header('Location: index.php?action=login');
    exit;
}

// =====================================================================
// INISIALISASI CONTROLLER
// =====================================================================
$userController       = new UserController();
$obatController       = new ObatController();
$obatRusakController  = new ObatRusakController();
$laporanController    = new LaporanController();

// =====================================================================
// ROUTING UTAMA (HANYA ADA SATU SWITCH SAJA)
// =====================================================================
switch ($action) {

    // === USER ========================================================
    case 'akun':
        $userController->akun(); 
        break;

    case 'create_user':
        $userController->create(); 
        break;

    case 'edit_user':
        $userController->edit($id); 
        break;

    case 'update_user':
        $userController->update($id); 
        break;

    case 'delete_user':
        $userController->delete($id); 
        break;

    case 'login':
        $userController->login();
        break;

    case 'logout':
        $userController->logout();
        break;


    // === OBAT ========================================================
    case 'obat':
        $obatController->index();
        break;

    case 'create_obat':
        $obatController->create();
        break;

    case 'edit_obat':
        $obatController->edit($id);
        break;

    case 'update_obat':
        $obatController->update($id);
        break;

    case 'delete_obat':
        $obatController->delete($id);
        break;


    // === STOK OBAT ===================================================
    case 'stok_obat':
        $obatController->stokObat();
        break;

    case 'create_stok':
        $obatController->createStok();
        break;

    case 'delete_stok':
        $obatController->deleteStok($id);
        break;

    case 'edit_stok':
        $obatController->editStok($id);
        break;

    case 'update_stok':
        $obatController->updateStok($id);
        break;


    // === OBAT RUSAK ==================================================
    case 'obat_rusak':
        $obatRusakController->index();
        break;

    case 'create_rusak':
        $obatRusakController->create();
        break;

    case 'edit_rusak':
        $obatRusakController->edit($id);
        break;

    case 'update_rusak':
        $obatRusakController->update($id);
        break;

    case 'delete_rusak':
        $obatRusakController->delete($id);
        break;


    // === LAPORAN =====================================================
    case 'laporan':
        $laporanController->index();
        break;

    case 'cetak_laporan_pdf':
        $laporanController->cetakPdf();
        break;


    // === DASHBOARD ===================================================
    case 'dashboard_admin':
        include '../views/dashboard_admin.php';
        break;


    // === DEFAULT =====================================================
    default:
        $userController->login();
        break;
}
?>
