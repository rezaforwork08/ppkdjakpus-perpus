<?php

include '../config/koneksi.php';

if (isset($_GET['kode_transaksi'])) {
    $dataDetailPinjam = [];

    $id = $_GET['kode_transaksi'];
    $queryTrans = mysqli_query($koneksi, "SELECT IF(status  = 1, 'Sedang di pinjam','Sudah dikembalikan') as status_baru, DATE_FORMAT(tgl_pinjam, '%D/%M/%Y') as format_pinjam,  peminjaman.*, anggota.nama_lengkap  FROM peminjaman
     LEFT JOIN anggota  ON anggota.id = peminjaman.id_anggota
     WHERE peminjaman.id = '$id'");
    $rowPeminjam = mysqli_fetch_assoc($queryTrans);
    $tgl_pinjam = $rowPeminjam['format_pinjam'];

    $queryDetailPinjam = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman
     LEFT JOIN kategori ON kategori.id = detail_peminjaman.id_kategori
     LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku WHERE id_peminjaman = '$id'");
    while ($rowDetailPinjam = mysqli_fetch_assoc($queryDetailPinjam)) {
        $dataDetailPinjam[] = $rowDetailPinjam;
    }
    // print_r($dataDetailPinjam);
    // die;

    $respon = json_encode([
        'data' => $rowPeminjam,
        'detail_pinjam' => $dataDetailPinjam,
        'success'       => true,
        'status'    => 200,
    ]);
    echo $respon;
}
