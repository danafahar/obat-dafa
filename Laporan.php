<?php
// File: models/Laporan.php (REVISI AKHIR SESUAI DB)

// Asumsi: Class Laporan mewarisi method query() dari class Database
// require_once __DIR__ . '/Database.php'; // Pastikan path ini benar di index.php

class Laporan extends Database {
    
    /**
     * Mengambil semua data laporan obat (Masuk, Rusak, dan Stok) dengan opsi filter tanggal.
     */
    public function getObatData($start_date = null, $end_date = null) {
        
        $filter_obat_masuk = "";
        $filter_obat_rusak = "";
        $params = [];
        $display_range = "Semua Data";

        // --- 1. Logika Filter Tanggal dan Parameter ---
        if ($start_date && $end_date) {
            $current_start = $start_date;
            
            // Tambahkan waktu 23:59:59 ke tanggal akhir untuk mencakup seluruh hari
            $end_date_time = $end_date . ' 23:59:59'; 

            $filter_obat_masuk = " WHERE o.tanggal_masuk BETWEEN :start_date AND :end_date_time ";
            $filter_obat_rusak = " WHERE r.tanggal_rusak BETWEEN :start_date AND :end_date_time ";
            
            $params = [':start_date' => $current_start, ':end_date_time' => $end_date_time];
            
            $display_range = "Periode: " . date('d M Y', strtotime($start_date)) . " s/d " . date('d M Y', strtotime($end_date));
        }

        // --- QUERY 1: RIWAYAT OBAT MASUK (DITAMBAH STOK SAAT INI) ---
        $sql_masuk = "SELECT 
                    o.merek_obat, 
                    o.kode_obat,
                    o.jenis_obat,
                    o.tanggal_masuk,
                    o.exp,
                    tso.jumlah_stok  /* MENGAMBIL STOK SAAT INI */
                FROM 
                    tbl_obat o
                LEFT JOIN 
                    tbl_stok_obat tso ON o.id_obat = tso.id_obat /* JOIN DENGAN TABEL STOK */
                " . $filter_obat_masuk . "
                ORDER BY 
                    o.tanggal_masuk DESC";
        $obat_masuk = $this->query($sql_masuk, $params);
        
        // --- QUERY 2: RIWAYAT OBAT RUSAK ---
        $sql_rusak = "SELECT 
                    r.tanggal_rusak, 
                    r.jumlah_rusak, 
                    r.alasan_rusak, 
                    r.keterangan,
                    o.merek_obat, 
                    l.nama_lengkap AS user_pelapor
                FROM 
                    tbl_obat_rusak r
                JOIN 
                    tbl_obat o ON r.id_obat = o.id_obat
                JOIN 
                    tbl_login l ON r.id_user = l.id
                " . $filter_obat_rusak . "
                ORDER BY 
                    r.tanggal_rusak DESC";
        $obat_rusak = $this->query($sql_rusak, $params);
        
        // --- QUERY 3: DATA STOK OBAT SAAT INI (Snapshot Terpisah) ---
        $sql_stok = "SELECT
                        tso.jumlah_stok,
                        o.kode_obat,
                        o.merek_obat,
                        o.jenis_obat
                    FROM
                        tbl_stok_obat tso
                    JOIN
                        tbl_obat o ON tso.id_obat = o.id_obat
                    WHERE 
                        tso.jumlah_stok > 0
                    ORDER BY 
                        o.merek_obat ASC";
        $obat_stok = $this->query($sql_stok); // Tidak ada filter tanggal
        
        // Data tanggal untuk View
        $report_dates = [
            'current_start' => $start_date, 
            'current_end' => $end_date,
            'display_range' => $display_range,
            'start' => $start_date, 
            'end' => $end_date,
        ];

        // PASTIKAN KEY 'obat_stok' DIKEMBALIKAN
        return [
            'obat_masuk' => $obat_masuk,
            'obat_rusak' => $obat_rusak,
            'obat_stok' => $obat_stok, /* <<< Wajib ada di sini */
            'report_dates' => $report_dates
        ];
    }
}
?>