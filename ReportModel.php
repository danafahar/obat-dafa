<?php
// Asumsikan koneksi database sudah tersedia di sini ($pdo atau $conn)

class ReportModel {
    
    // Fungsi ini mensimulasikan pengambilan data dari database
    // Di dunia nyata, ini akan menggunakan koneksi database ($pdo)
    public function getObatData($start_date = null, $end_date = null) {
        
        // --- LOGIKA DATABASE SEBENARNYA AKAN BERADA DI SINI ---
        
        // 1. QUERY UNTUK OBAT MASUK
        // Contoh Query: SELECT * FROM obat_masuk WHERE tanggal_masuk BETWEEN :start AND :end
        
        // Data Contoh (Ganti dengan hasil database Anda)
        $obat_masuk = [
            ['kode_obat' => 'OBT001', 'merek_obat' => 'Paracetamol', 'jenis_obat' => 'Tablet', 'tanggal_masuk' => '2025-12-01', 'exp' => '2026-12-01'],
            ['kode_obat' => 'OBT002', 'merek_obat' => 'Amoxicillin', 'jenis_obat' => 'Kapsul', 'tanggal_masuk' => '2025-11-20', 'exp' => '2026-05-15'],
        ];

        // 2. QUERY UNTUK OBAT RUSAK
        // Contoh Query: SELECT * FROM obat_rusak WHERE tanggal_rusak BETWEEN :start AND :end
        
        // Data Contoh (Ganti dengan hasil database Anda)
        $obat_rusak = [
            ['merek_obat' => 'Obat Batuk Syrup', 'jumlah_rusak' => 5, 'tanggal_rusak' => '2025-12-05', 'alasan_rusak' => 'Kemasan Pecah', 'keterangan' => 'Dikirim kembali ke distributor', 'user_pelapor' => 'Admin A'],
            ['merek_obat' => 'Vitamin C', 'jumlah_rusak' => 10, 'tanggal_rusak' => '2025-12-06', 'alasan_rusak' => 'Kedaluwarsa', 'keterangan' => 'Menunggu pemusnahan', 'user_pelapor' => 'Admin B'],
        ];
        
        // Mengembalikan data dalam bentuk array
        return [
            'obat_masuk' => $obat_masuk,
            'obat_rusak' => $obat_rusak,
            'report_dates' => ['start' => $start_date, 'end' => $end_date] // Info tambahan
        ];
    }
}