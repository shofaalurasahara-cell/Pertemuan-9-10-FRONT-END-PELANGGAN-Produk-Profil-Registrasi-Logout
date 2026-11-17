<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-box mr-2 text-primary"></i> Produk
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator/produk') ?>">Produk</a></li>
                        <li class="breadcrumb-item active">Ubah Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title font-weight-bold" style="font-size: 1.5rem;">
                                <i class="fas fa-edit mr-2 text-primary"></i> Ubah Produk
                            </h3>
                            <div class="clearfix"></div><br>

                            <!-- Form Utama Update Produk -->
                            <form id="formUtama" action="<?= base_url('administrator/produk/ubah/' . $produk['id_produk']) ?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="<?= set_value('nama_produk', $produk['nama']) ?>">
                                    <small class="text-danger"><em><?= form_error('nama_produk') ?></em></small>
                                </div>

                                <div class="mb-3">
                                    <label for="kategori_produk" class="form-label">Kategori Produk</label>
                                    <select name="kategori_produk" id="kategori_produk" class="form-control">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($list_kategori as $kategori) : ?>
                                            <option value="<?= $kategori['id_kategori'] ?>" <?= set_value('kategori_produk', $produk['id_kategori']) == $kategori['id_kategori'] ? 'selected' : '' ?>>
                                                <?= $kategori['nama'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                    <small class="text-danger"><em><?= form_error('kategori_produk') ?></em></small>
                                </div>

                                <div class="mb-3">
                                    <label for="harga_produk" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_produk" id="harga_produk" class="form-control" value="<?= set_value('harga_produk', $produk['harga']) ?>">
                                    </div>
                                    <small class="text-danger"><em><?= form_error('harga_produk') ?></em></small>
                                </div>

                                <div class="mb-3">
                                    <label for="stok_produk" class="form-label">Stok Produk</label>
                                    <input type="number" class="form-control" name="stok_produk" id="stok_produk" value="<?= set_value('stok_produk', $produk['stok']) ?>">
                                    <small class="text-danger"><em><?= form_error('stok_produk') ?></em></small>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi_produk" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi_produk" form="formUtama" id="deskripsi_produk" cols="30" rows="5" class="form-control"><?= set_value('deskripsi_produk', $produk['deskripsi']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar_produk" class="form-label">Tambah Gambar Baru (Opsional)</label>
                                    <input class="form-control" type="file" id="gambar_produk" name="gambar_produk[]" multiple>
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB.</small>
                                </div>

                                <button type="submit" form="formUtama" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="<?= base_url('administrator/produk') ?>" class="btn btn-danger">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </form>

                            <hr class="my-4">
                            <h5 class="font-weight-bold">Daftar Gambar Produk</h5>
                            
                            <?php if (isset($list_gambar) && !empty($list_gambar)) : ?>
                                <div class="row mb-3">
                                    <?php foreach ($list_gambar as $gambar) : ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <div class="card h-100">
                                                <img src="<?= base_url('uploads/produk/' . $gambar['nama_gambar']) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                <div class="card-body p-2">
                                                    <div class="row g-2">
                                                        <!-- Kolom Ubah/Ganti Gambar -->
                                                        <div class="col-6">
                                                            <form action="<?= base_url('administrator/produk/ubah_gambar/' . $gambar['id_gambar']) ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="produk_id" value="<?= $produk['id_produk'] ?>">
                                                                <input type="file" name="gambar_baru" id="ganti_gambar_<?= $gambar['id_gambar'] ?>" style="display: none;" accept="image/*" required onchange="this.form.submit()">
                                                                <label for="ganti_gambar_<?= $gambar['id_gambar'] ?>" class="btn btn-warning text-white btn-sm w-100" style="cursor: pointer;">
                                                                    <i class="fas fa-sync-alt"></i> Ganti
                                                                </label>
                                                            </form>
                                                        </div>
                                                        <!-- Kolom Hapus Gambar -->
                                                        <div class="col-6">
                                                            <a href="<?= base_url('administrator/produk/hapus_gambar/' . $gambar['id_gambar']) ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php else : ?>
                                <p class="text-muted">Belum ada gambar untuk produk ini.</p>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>