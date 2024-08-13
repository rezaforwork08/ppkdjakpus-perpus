<?php

include '../config/koneksi.php';

if (isset($_GET['kode_transaksi']))
    $queryTrans = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id = '$id'");
