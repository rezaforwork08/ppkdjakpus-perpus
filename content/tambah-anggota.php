<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {
    // jika param edit ada maka updet, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $nisn           = $_POST['nisn'];
    $nama_lengkap   = $_POST['nama_lengkap'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $alamat         = $_POST['alamat'];
    $no_telp        = $_POST['no_telp'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO anggota (nama_lengkap, nisn, jenis_kelamin, alamat, no_telp) VALUES ('$nama_lengkap','$nisn','$jenis_kelamin','$alamat','$no_telp')");
        header("location:?pg=anggota&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE anggota SET 
        nama_lengkap='$nama_lengkap',
        nisn = '$email',
        alamat = '$alamat',
        no_telp = '$no_telp',
        jenis_kelamin = '$jenis_kelamin'
        WHERE id = '$id'
        ");
        header("location:?pg=user&ubah=berhasil");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("location:?pg=user&hapus=berhasil");
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");


?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Tambah Anggota</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Nisn</label>
                            <input value="<?php echo ($rowEdit['nisn'] ?? '') ?>" type="text" class="form-control" name="nisn">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input value="<?php echo ($rowEdit['nama_lengkap'] ?? '') ?>" type="text" class="form-control" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">No Telp</label>
                            <input value="" type="number" class="form-control" name="no_telp" value="<?php echo ($rowEdit['no_telp'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id=""><?php echo ($rowEdit['alamat'] ?? '') ?></textarea>
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