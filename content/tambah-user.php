<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}
if (isset($_POST['simpan'])) {
    // jika param edit ada maka updet, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $nama_lengkap = $_POST['nama_lengkap'];
    $email        = $_POST['email'];
    $password     = sha1($_POST['password']);
    $id_level     = $_POST['id_level'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, email, password, id_level) VALUES ('$nama_lengkap','$email','$password','$id_level')");
        header("location:?pg=user&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET 
        nama_lengkap='$nama_lengkap',
        email = '$email',
        id_level = '$id_level',
        password = '$password'
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
                <div class="card-header">Data User</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Level</label>
                            <select name="id_level" id="" class="form-control">
                                <option value="">Pilih Level</option>
                                <?php while ($rowLevel = mysqli_fetch_assoc($level)) : ?>
                                    <option <?php echo isset($rowEdit['id_level']) ? ($rowEdit['id_level'] == $rowLevel['id']) ? 'selected' : '' : '' ?> value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['nama_level'] ?></option>
                                <?php endwhile ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input value="<?php echo ($rowEdit['nama_lengkap'] ?? '') ?>" type="text" class="form-control" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input value="<?php echo ($rowEdit['email'] ?? '') ?>" type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password</label>
                            <input value="" type="password" class="form-control" name="password">
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