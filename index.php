<?php
session_start();
ob_start();
include 'config/koneksi.php';
include 'function/helper.php';

// echo "<h1>Selamat Datang " . (isset($_SESSION['NAMA_LENGKAP']) ? $_SESSION['NAMA_LENGKAP'] : '') . "</h1>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang, </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        nav.menu {
            background-color: white !important;
            box-shadow: 0 0 3px #000;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="menu navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Perpustakaan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=peminjaman">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=pengembalian">Pengembalian</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Master Data
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Buku</a></li>
                                <li><a class="dropdown-item" href="#">Kategori</a></li>
                                <li><a class="dropdown-item" href="#">Anggota</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Level</a></li>
                                <li><a class="dropdown-item" href="#">User</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="keluar.php" class="nav-link" aria-disabled="true">Keluar</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>



        <!-- content here -->
        <?php
        if (isset($_GET['pg'])) {
            if (file_exists('content/' . $_GET['pg'] . '.php')) {
                include 'content/' . $_GET['pg'] . '.php';
            } else {
                echo "not found";
            }
        } else {
            include 'content/home.php';
        }
        ?>
        <!-- end content -->
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.js"></script>

    <script>
        // let kategori = document.getElementById('id_kategori');
        // kategori.addEventListener('change', function() {
        //     let id = this.value;
        //     alert(id);
        // });

        $('#id_kategori').change(function() {
            let id = $(this).val(),
                option = "";
            $.ajax({
                url: "ajax/get-buku.php?id_kategori=" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    option += "<option value=''>Pilih Buku</option>"
                    $.each(data, function(key, value) {
                        let tahun_terbit = $('#tahun_terbit').val(value.tahun_terbit);
                        option += "<option value=" + value.id + ">" + value.judul + "</option>"
                        // console.log("valuenya : ", value.judul);
                    });
                    $('#id_buku').html(option);
                }
            })
        });

        $('#tambah-row').click(function() {
            if ($('#id_kategori').val() == "") {
                alert('Mohon pilih Kategori Buku terlebih dahulu');
                return false;
            }

            if ($('#id_buku').val() == "") {
                alert('Mohon pilih Buku terlebih dahulu');
                return false;
            }
            let nama_kategori = $('#id_kategori').find('option:selected').text(),
                nama_buku = $('#id_buku').find('option:selected').text(),
                tahun_terbit = $('#tahun_terbit').val(),
                id_kategori = $('#id_kategori').val(),
                id_buku = $('#id_buku').val();

            let tbody = $('tbody');
            let no = tbody.find('tr').length + 1;
            let table = "<tr>";
            table += "<td>" + no + "</td>";
            table += "<td>" + nama_kategori + " <input type='hidden' name='id_kategori[]' value='" + id_kategori + "'></td>";
            table += "<td>" + nama_buku + " <input type='hidden' name='id_buku[]' value='" + id_buku + "'></td>";
            table += "<td>" + tahun_terbit + "</td>";
            table += "<td><button type='button' id='remove'  class='remove btn btn-sm btn-success'>Delete</button></td>";
            table += "</tr>";
            tbody.append(table);

            $('.remove').click(function() {
                $(this).closest('tr').remove();
            });
        });

        $('#kode_peminjaman').change(function() {
            let id = $(this).val();
            $.ajax({
                url: "ajax/get-data-transaksi.php?kode_transaksi=" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#nama_anggota').val(data.data.nama_lengkap)
                    $('#tgl_pinjam').val(data.data.tgl_pinjam)
                    $('#tgl_kembali').val(data.data.tgl_kembali)

                    let tanggal_kembali = new moment(data.data.tgl_kembali);
                    let tanggal_pengembalian = new moment('2024-08-16');
                    let selisih = tanggal_pengembalian.diff(tanggal_kembali, 'days');
                    
                    if (selisih < 0) {
                        selisih = 0;
                    }
                    let denda = 1000000;
                    let totalDenda = selisih * denda;
                    $('.total-denda').html("<h5>Rp. " + totalDenda.toLocaleString('id-ID') + "</h5>");
                    $('#denda').val(totalDenda);
                    $('#terlambat').val(selisih)

                    let tbody = $('tbody'),
                        newRow = "";
                    let no = tbody.find('tr').length + 1;
                    $.each(data.detail_pinjam, function(index, val) {

                        // console.log("nilai sesudah di looping", val)
                        newRow += "<tr>";
                        newRow += "<td>" + no++ + "</td>"
                        newRow += "<td>" + val.nama_kategori + "</td>"
                        newRow += "<td>" + val.judul + "</td>"
                        newRow += "<td>" + val.tahun_terbit + "</td>"
                        newRow += "</tr>";
                    });
                    tbody.html(newRow);





                }
            })
        });

        // let tanggalSekarang = new Date();
        // let formatIndonesia = new Intl.DateTimeFormat('id-ID', {
        //     year: 'numeric',
        //     month: '2-digit',
        //     day: '2-digit'
        // }).format(tanggalSekarang);

        // let tgl_kembali = $('.tgl_kembali').val();
        // console.log("tanggal_kembali", tgl_kembali)

        // let tgl_pengembalian = $('#tgl_pengembalian').val();

        // let tanggal_kembali = new moment(tgl_kembali);
        // let tanggal_pengembalian = new moment('2024-08-16');

        // let selisih = tanggal_pengembalian.diff(tanggal_kembali, 'days');
        // console.log("selisih", selisih);
    </script>

</body>

</html>