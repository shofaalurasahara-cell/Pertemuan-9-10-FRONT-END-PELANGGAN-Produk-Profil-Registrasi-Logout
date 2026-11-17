<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Starter Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ongkir</h5>
                            <p class="card-text">
                                <a href="<?= base_url('administrator/ongkir2422500011/tambah') ?>" class="btn btn-labeled btn-primary">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Tambah Ongkir
                                </a>
                                <div class="card-body">
                                    <?php if ($this->session->flashdata('message')) : ?>
                                        <?= $this->session->flashdata('message') ?>
                                    <?php endif ?>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                               <tr>
                                        <th>No</th>
                                        <th>Nama Ekspedisi</th>
                                        <th>Jenis Layanan</th>
                                        <th>Tarif Per Kg</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($list_ongkir as $ongkir) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $ongkir['nama_ekspedisi011'] ?></td>
                                            <td><?= $ongkir['jenis_layanan011'] ?></td>
                                            <td>Rp <?= number_format($ongkir['tarif_per_kg011'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php if ($ongkir['status011'] == 'Aktif') : ?>
                                                    <span class="badge bg-success"><?= $ongkir['status011'] ?></span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger"><?= $ongkir['status011'] ?></span>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('administrator/ongkir2422500011/ubah/'.$ongkir['id_ongkir011']) ?>" 
                                                   class="btn btn-warning btn-sm">Ubah</a>
                                                <a href="<?= base_url('administrator/ongkir2422500011/hapus/'.$ongkir['id_ongkir011']) ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                            </td>
                                        </tr>
                                            <?php $no++; endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->