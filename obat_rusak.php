<h2>Data Obat Rusak</h2>
<a href="index.php?action=create_rusak">+ Tambah</a>

<table border="1" width="100%">
<tr>
    <th>No</th>
    <th>Obat</th>
    <th>Jumlah</th>
    <th>Alasan</th>
    <th>Tanggal</th>
    <th>Petugas</th>
    <th>Aksi</th>
</tr>

<?php $no=1; foreach($obatRusak as $r): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $r['merek_obat'] ?></td>
    <td><?= $r['jumlah_rusak'] ?></td>
    <td><?= $r['alasan_rusak'] ?></td>
    <td><?= $r['tanggal_rusak'] ?></td>
    <td><?= $r['username'] ?></td>
    <td>
        <a href="index.php?action=edit_rusak&id=<?= $r['id_rusak'] ?>">Edit</a>
        <a href="index.php?action=delete_rusak&id=<?= $r['id_rusak'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
