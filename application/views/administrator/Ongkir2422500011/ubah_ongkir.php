<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Ongkir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator/ongkir') ?>">Ongkir</a></li>
                        <li class="breadcrumb-item active">Ubah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Ubah Ongkir</h5>

                            <?php if (validation_errors()) : ?>
                                <div class="alert alert-danger"><?= validation_errors() ?></div>
                            <?php endif ?>

                            <form method="post">
                                <div class="mb-3">
                                    <label for="nama_ekspedisi" class="form-label">Nama Ekspedisi</label>
                                    <input type="text" class="form-control" name="nama_ekspedisi" id="nama_ekspedisi" 
                                           value="<?= set_value('nama_ekspedisi', $ongkir['nama_ekspedisi011']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                                    <input type="text" class="form-control" name="jenis_layanan" id="jenis_layanan" 
                                           value="<?= set_value('jenis_layanan', $ongkir['jenis_layanan011']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="tarif_per_kg" class="form-label">Tarif Per Kg</label>
                                    <input type="number" class="form-control" name="tarif_per_kg" id="tarif_per_kg" 
                                           value="<?= set_value('tarif_per_kg', $ongkir['tarif_per_kg011']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif" <?= set_value('status', $ongkir['status011']) == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?= set_value('status', $ongkir['status011']) == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="<?= base_url('administrator/ongkir') ?>" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>