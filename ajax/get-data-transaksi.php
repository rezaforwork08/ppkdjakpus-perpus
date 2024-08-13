<?php

include '../config/koneksi.php';

if (isset($_GET['kode_transaksi'])) {
    $id = $_GET['kode_transaksi'];
    $queryTrans = mysqli_query($koneksi, "SELECT IF(status  = 1, 'Sedang di pinjam','Sudah dikembalikan') as status_baru, DATE_FORMAT(tgl_pinjam, '%D/%M/%Y') as format_pinjam,  peminjaman.*  FROM peminjaman LEFT JOIN anggota  ON anggota.id = peminjaman.id_anggota
     WHERE peminjaman.id = '$id'");
    $rowPeminjam = mysqli_fetch_assoc($queryTrans);
    $tgl_pinjam = $rowPeminjam['format_pinjam'];

    $respon = json_encode(['data' => $rowPeminjam, 'tgl_pinjam' => $tgl_pinjam]);
    echo $respon;
}
