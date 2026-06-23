<?= $this->extend('backend/layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Transaksi Servis (<?= esc($header['kode_transaksi']) ?>)</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="box" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('transaksi/servis/update') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id_transaksi" value="<?= $header['id_transaksi'] ?>">

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Data Utama</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kendaraan / Plat Nomor</label>
                                <select name="header[id_kendaraan]" class="form-control" required>
                                    <option value="">-- Pilih Kendaraan --</option>
                                    <?php foreach ($kendaraan as $k): ?>
                                    <option value="<?= $k['id_kendaraan'] ?>"
                                        <?= $k['id_kendaraan'] == $header['id_kendaraan'] ? 'selected' : '' ?>>
                                        <?= esc($k['nomor_plat']) ?> - <?= esc($k['nama_pelanggan']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mekanik</label>
                                <select name="header[id_mekanik]" class="form-control" required>
                                    <option value="">-- Pilih Mekanik --</option>
                                    <?php foreach ($mekanik as $m): ?>
                                    <option value="<?= $m['id_mekanik'] ?>"
                                        <?= $m['id_mekanik'] == $header['id_mekanik'] ? 'selected' : '' ?>>
                                        <?= esc($m['nama_mekanik']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Keluhan Awal</label>
                                <textarea name="header[keluhan_awal]" class="form-control"
                                    rows="2"><?= esc($header['keluhan_awal']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Hasil Pemeriksaan</label>
                                <textarea name="header[hasil_pemeriksaan]" class="form-control"
                                    rows="2"><?= esc($header['hasil_pemeriksaan']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Status Kerja</label>
                                <select name="header[status_pengerjaan]" class="form-control">
                                    <?php $status_kerja = ["Antre","Diproses","Menunggu Part","Selesai","Diambil","Dibatalkan"]; ?>
                                    <?php foreach ($status_kerja as $sk): ?>
                                    <option value="<?= $sk ?>"
                                        <?= $header['status_pengerjaan'] == $sk ? 'selected' : '' ?>><?= $sk ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status Transaksi (Kunci)</label>
                                <select name="header[status_transaksi]" class="form-control">
                                    <option value="Draft"
                                        <?= $header['status_transaksi'] == 'Draft' ? 'selected' : '' ?>>Draft (Bisa
                                        Edit)</option>
                                    <option value="Progress"
                                        <?= $header['status_transaksi'] == 'Progress' ? 'selected' : '' ?>>Progress
                                        (Bisa Edit)</option>
                                    <option value="Lunas"
                                        <?= $header['status_transaksi'] == 'Lunas' ? 'selected' : '' ?>>Lunas (Kunci
                                        Data)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-info card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Rincian Jasa Servis</h3>
                            <button type="button" class="btn btn-success btn-sm ml-auto" id="btn-tambah-jasa">
                                <i class="fas fa-plus"></i> Tambah Jasa
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped mb-0" id="tabel-jasa">
                                <thead>
                                    <tr>
                                        <th>Nama Jasa Servis</th>
                                        <th style="width: 25%">Biaya Jasa</th>
                                        <th style="width: 25%">Biaya Tambahan</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $idxJasa = 0; ?>
                                    <?php foreach ($jasa_lama as $jl): ?>
                                    <tr>
                                        <td>
                                            <select name="jasa[<?= $idxJasa ?>][id_jasa]" class="form-control" required>
                                                <option value="">-- Pilih Jasa --</option>
                                                <?php foreach ($jasa_list as $jl_master): ?>
                                                <option value="<?= $jl_master['id_jasa'] ?>"
                                                    <?= $jl_master['id_jasa'] == $jl['id_jasa'] ? 'selected' : '' ?>>
                                                    <?= esc($jl_master['nama_jasa']) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="jasa[<?= $idxJasa ?>][harga_saat_transaksi]"
                                                class="form-control" value="<?= (float)$jl['harga_saat_transaksi'] ?>"
                                                min="0" required>
                                        </td>
                                        <td>
                                            <input type="number" name="jasa[<?= $idxJasa ?>][biaya_tambahan]"
                                                class="form-control" value="<?= (float)$jl['biaya_tambahan'] ?>" min="0"
                                                required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus-baris"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php $idxJasa++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card card-warning card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Rincian Penggunaan Sparepart</h3>
                            <button type="button" class="btn btn-success btn-sm ml-auto" id="btn-tambah-part">
                                <i class="fas fa-plus"></i> Tambah Part
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped mb-0" id="tabel-part">
                                <thead>
                                    <tr>
                                        <th>Nama Sparepart</th>
                                        <th style="width: 20%">Harga Jual Satuan</th>
                                        <th style="width: 15%">Qty Pakai</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $idxPart = 0; ?>
                                    <?php foreach ($part_lama as $pl): ?>
                                    <tr>
                                        <td>
                                            <select name="part[<?= $idxPart ?>][id_part]" class="form-control" required>
                                                <option value="">-- Pilih Sparepart --</option>
                                                <?php foreach ($part_list as $pl_master): ?>
                                                <option value="<?= $pl_master['id_part'] ?>"
                                                    <?= $pl_master['id_part'] == $pl['id_part'] ? 'selected' : '' ?>>
                                                    <?= esc($pl_master['nama_part']) ?> (Stok:
                                                    <?= $pl_master['stok_saat_ini'] ?>)
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="part[<?= $idxPart ?>][harga_satuan_jual]"
                                                class="form-control" value="<?= (float)$pl['harga_satuan_jual'] ?>"
                                                min="0" required>
                                        </td>
                                        <td>
                                            <input type="number" name="part[<?= $idxPart ?>][jumlah_pakai]"
                                                class="form-control" value="<?= $pl['jumlah_pakai'] ?>" min="1"
                                                required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus-baris"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php $idxPart++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-right">
                            <a href="<?= base_url('transaksi/servis') ?>" class="btn btn-secondary mr-2">Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan
                                Perubahan</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let indexJasa = <?= $idxJasa ?>;
    let indexPart = <?= $idxPart ?>;

    document.getElementById('btn-tambah-jasa').addEventListener('click', function() {
        let tbody = document.querySelector('#tabel-jasa tbody');
        let html = `<tr>
            <td>
                <select name="jasa[${indexJasa}][id_jasa]" class="form-control" required>
                    <option value="">-- Pilih Jasa --</option>
                    <?php foreach ($jasa_list as $m_jasa): ?>
                        <option value="<?= $m_jasa['id_jasa'] ?>"><?= esc($m_jasa['nama_jasa']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="number" name="jasa[${indexJasa}][harga_saat_transaksi]" class="form-control" value="0" min="0" required></td>
            <td><input type="number" name="jasa[${indexJasa}][biaya_tambahan]" class="form-control" value="0" min="0" required></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-hapus-baris"><i class="fas fa-trash"></i></button></td>
        </tr>`;
        tbody.insertAdjacentHTML('beforeend', html);
        indexJasa++;
    });

    document.getElementById('btn-tambah-part').addEventListener('click', function() {
        let tbody = document.querySelector('#tabel-part tbody');
        let html = `<tr>
            <td>
                <select name="part[${indexPart}][id_part]" class="form-control" required>
                    <option value="">-- Pilih Sparepart --</option>
                    <?php foreach ($part_list as $m_part): ?>
                        <option value="<?= $m_part['id_part'] ?>"><?= esc($m_part['nama_part']) ?> (Stok: <?= $m_part['stok_saat_ini'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="number" name="part[${indexPart}][harga_satuan_jual]" class="form-control" value="0" min="0" required></td>
            <td><input type="number" name="part[${indexPart}][jumlah_pakai]" class="form-control" value="1" min="1" required></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-hapus-baris"><i class="fas fa-trash"></i></button></td>
        </tr>`;
        tbody.insertAdjacentHTML('beforeend', html);
        indexPart++;
    });

    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('btn-hapus-baris') || e.target.closest(
                '.btn-hapus-baris'))) {
            let row = e.target.closest('tr');
            row.remove();
        }
    });
});
</script>
<?= $this->endSection() ?>