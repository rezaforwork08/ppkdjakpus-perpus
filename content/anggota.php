<?php
$queryUser = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
// $rowUser = mysqli_fetch_assoc($queryUser);
// die;
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Data Anggota</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-anggota" class="btn btn-primary">Tambah</a>
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">
                            Data Berhasil ditambah
                        </div>
                    <?php endif ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-success">
                            Data Berhasil dihapus
                        </div>
                    <?php endif ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $no = 1;
                            while ($rowUser = mysqli_fetch_assoc($queryUser)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowUser['nisn'] ?></td>
                                    <td><?php echo $rowUser['nama_lengkap'] ?></td>
                                    <td><?php echo $rowUser['no_telp'] ?></td>
                                    <td><?php echo $rowUser['jenis_kelamin'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-anggota&edit=<?php echo $rowUser['id'] ?>" class="btn btn-sm btn-success">Edit</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')" href="?pg=tambah-anggota&delete=<?php echo $rowUser['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>