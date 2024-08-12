<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {

    // jika param edit ada maka updet, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $kode_transaksi = $_POST['kode_transaksi'];
    $id_anggota        = $_POST['id_anggota'];
    $id_user        = $_POST['id_user'];
    $tgl_pinjam     = $_POST['tgl_pinjam'];
    $tgl_kembali     = $_POST['tgl_kembali'];

    $id_kategori = $_POST['id_kategori'];
    $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi, id_anggota, id_user, tgl_pinjam, tgl_kembali, status) 
    VALUES ('$kode_transaksi','$id_anggota','$id_user','$tgl_pinjam','$tgl_kembali','1')");
    if ($insert) {
        $id_peminjam = mysqli_insert_id($koneksi);
        foreach ($id_kategori as $key => $value) {
            $id_kategori = $_POST['id_kategori'][$key];
            $id_buku = $_POST['id_buku'][$key];
            $insert = mysqli_query($koneksi, "INSERT INTO detail_peminjaman (id_peminjaman,id_buku, id_kategori) 
    VALUES ('$id_peminjam','$id_kategori','$id_buku')");
            header("location:?pg=peminjaman&tambah=berhasil");
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("location:?pg=user&hapus=berhasil");
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");
// KODE TRANSAKSI
$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans   = mysqli_fetch_assoc($queryKodeTrans);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryBuku  = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");


?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Transaksi Peminjaman</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="">Kode Transaksi</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="kode_transaksi" value="<?php echo ($kode_transaksi ?? '') ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="">Nama Anggota</label>
                            </div>
                            <div class="col-sm-3">
                                <select name="id_anggota" id="" class="form-control">
                                    <option value="">Pilih Anggota</option>
                                    <?php while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                        <option value="<?php echo $rowAnggota['id'] ?>"><?php echo $rowAnggota['nama_lengkap'] ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="">Tanggal Pinjam</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_pinjam" value="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="">Tanggal Kembali</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_kembali" value="">
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-2">
                                <label for="">Petugas</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="" value="<?php echo ($_SESSION['NAMA_LENGKAP'] ?? '') ?>" readonly>
                                <input type="hidden" name="id_user" value="<?php echo ($_SESSION['ID_USER'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Get Data Kategori Buku dan Buku -->
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="">Kategori Buku</label>
                            </div>
                            <div class="col-sm-3">
                                <select name="id_kategori" id="id_kategori" class="form-control id_kategori">
                                    <option value="">Pilih Kategori</option>
                                    <?php while ($rowKategori = mysqli_fetch_assoc($queryKategori)) : ?>
                                        <option value="<?php echo $rowKategori['id'] ?>"><?php echo $rowKategori['nama_kategori'] ?></option>
                                    <?php endwhile ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="">Nama Buku</label>
                            </div>
                            <div class="col-sm-3">
                                <select name="id_anggota" id="id_buku" class="form-control">
                                    <option value="">Pilih Buku</option>

                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="tahun_terbit">
                        <div class="mt-5 mb-5">
                            <div align="right" class="mb-3">
                                <button type="button" id="tambah-row" class="btn btn-primary tambah-row">
                                    Tambah
                                </button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori Buku</th>
                                        <th>Judul Buku</th>
                                        <th>Tahun Terbit</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr> -->

                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>