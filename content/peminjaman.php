<?php
$queryPinjam = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, 
user.nama_lengkap, peminjaman.* FROM peminjaman 
LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota
LEFT JOIN user ON user.id = peminjaman.id_user
 ORDER BY id DESC");

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Transaksi Peminjaman</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-peminjaman" class="btn btn-primary">Tambah</a>
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
                                <th>Kode Transaksi</th>
                                <th>Anggota</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $no = 1;
                            while ($row = mysqli_fetch_assoc($queryPinjam)) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row['kode_transaksi'] ?></td>
                                    <td><?php echo $row['nama_anggota'] ?></td>
                                    <td><?php echo $row['tgl_pinjam'] ?></td>
                                    <td><?php echo $row['tgl_kembali'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td><?php echo $row['nama_lengkap'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-peminjaman&detail=<?php echo $row['id'] ?>" class="btn btn-sm btn-success">Detail</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')" href="?pg=tambah-user&delete=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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