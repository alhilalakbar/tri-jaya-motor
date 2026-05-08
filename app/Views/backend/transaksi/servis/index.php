<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Riwayat Servis Bengkel</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahServis()">
            <i class="bi bi-plus-lg"></i> Transaksi Baru
        </button>
    </div>
    <div class="card-body">
        <table id="tableHistory" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. Transaksi / Admin</th>
                    <th>Tanggal</th>
                    <th>Kendaraan & Keluhan</th>
                    <th>Status Pengerjaan</th>
                    <th>Pembayaran</th>
                    <th>Total Biaya</th>
                    <th style="width: 80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d): ?>
                    <tr>
                        <td>
                            <span class="fw-bold text-primary"><?= $d['kode_transaksi']; ?></span><br>
                            <small class="text-muted"><i class="bi bi-person"></i> Input:
                                <?= esc($d['nama_pengguna'] ?? ''); ?></small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($d['tanggal_masuk'])); ?></td>
                        <td>
                            <strong><?= esc($d['nomor_plat']); ?> (<?= esc($d['nama_pelanggan']); ?>)</strong><br>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;"
                                title="<?= esc($d['keluhan_awal']); ?>">
                                K: <?= esc($d['keluhan_awal'] ?: '-'); ?>
                            </small>
                        </td>
                        <td>
                            <?php
                            $statusColor = [
                                'Antre' => 'bg-secondary',
                                'Diproses' => 'bg-info',
                                'Menunggu Part' => 'bg-warning text-dark',
                                'Selesai' => 'bg-success',
                                'Diambil' => 'bg-primary',
                                'Dibatalkan' => 'bg-danger'
                            ];
                            ?>
                            <span class="badge <?= $statusColor[$d['status_pengerjaan']] ?? 'bg-secondary'; ?>">
                                <?= $d['status_pengerjaan'] ?: 'Antre'; ?>
                            </span><br>
                            <small class="text-muted">Mek: <?= esc($d['nama_mekanik'] ?? '-'); ?></small>
                        </td>
                        <td>
                            <span
                                class="badge <?= $d['status_pembayaran'] == 'Lunas' ? 'text-success border border-success' : 'text-danger border border-danger'; ?>">
                                <?= $d['status_pembayaran']; ?>
                            </span><br>
                            <small class="text-muted"><?= $d['metode_pembayaran']; ?></small>
                        </td>
                        <td class="fw-bold">Rp <?= number_format($d['total_biaya'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('backend/transaksi/servis/detail/' . $d['id_transaksi']); ?>"
                                    class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn btn-warning btn-sm"
                                    onclick="editStatus(<?= htmlspecialchars(json_encode($d)); ?>)"
                                    title="Update Status/Bayar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalServis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('backend/transaksi/servis/create'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-wrench-adjustable"></i> Input Transaksi Servis Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/transaksi/servis/form'); ?>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Transaksi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalEditStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('backend/transaksi/servis/update_status'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id_transaksi" id="edit_id_transaksi">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Update Status Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Pengerjaan</label>
                        <select name="status_pengerjaan" id="edit_status_pengerjaan" class="form-select">
                            <option value="Antre">Antre</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Menunggu Part">Menunggu Part</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Diambil">Diambil</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="edit_metode_pembayaran" class="form-select">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" id="edit_status_pembayaran" class="form-select">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let modalServis;
    let modalEditStatus;
    let jasaIdx = 1; 
    let partIdx = 1; 

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof bootstrap !== 'undefined') {
            modalServis = new bootstrap.Modal(document.getElementById('modalServis'));
            modalEditStatus = new bootstrap.Modal(document.getElementById('modalEditStatus'));
        }
    });

    function tambahServis() {
        modalServis.show();
    }

    function editStatus(data) {
        document.getElementById('edit_id_transaksi').value = data.id_transaksi;
        document.getElementById('edit_status_pengerjaan').value = data.status_pengerjaan;
        document.getElementById('edit_metode_pembayaran').value = data.metode_pembayaran;
        document.getElementById('edit_status_pembayaran').value = data.status_pembayaran;
        modalEditStatus.show();
    }

    // LOGIKA AUTOFILL (MENDETEKSI PERUBAHAN DROPDOWN)
    document.addEventListener('change', function (e) {
        // Jika yang berubah adalah dropdown Jasa
        if (e.target.classList.contains('select-jasa')) {
            const price = e.target.options[e.target.selectedIndex].dataset.price || 0;
            const row = e.target.closest('tr');
            row.querySelector('.biaya-input').value = price;
        }

        // Jika yang berubah adalah dropdown Sparepart
        if (e.target.classList.contains('select-part')) {
            const price = e.target.options[e.target.selectedIndex].dataset.price || 0;
            const row = e.target.closest('tr');
            row.querySelector('.harga-input').value = price;
        }
    });

    // FUNGSI TAMBAH BARIS
    function addRow(tableId) {
        const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        let row = '';

        if (tableId === 'tableJasa') {
            row = `<tr>
                <td><select name="jasa[${jasaIdx}][id_jasa]" class="form-select form-select-sm select-jasa" required>
                    <option value="">-- Pilih Jasa --</option>
                    <?php foreach ($jasa_list as $j): ?>
                        <option value="<?= $j['id_jasa']; ?>" data-price="<?= $j['biaya_standar']; ?>"><?= esc($j['nama_jasa']); ?></option>
                    <?php endforeach; ?>
                </select></td>
                <td><input type="number" name="jasa[${jasaIdx}][harga_saat_transaksi]" class="form-control form-control-sm biaya-input" value="0"></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button></td>
            </tr>`;
            jasaIdx++;
        } else {
            row = `<tr>
                <td><select name="part[${partIdx}][id_part]" class="form-select form-select-sm select-part">
                    <option value="">-- Pilih Part --</option>
                    <?php foreach ($part_list as $p): ?>
                        <option value="<?= $p['id_part']; ?>" data-price="<?= $p['harga_jual']; ?>"><?= esc($p['nama_part']); ?></option>
                    <?php endforeach; ?>
                </select></td>
                <td><input type="number" name="part[${partIdx}][jumlah_pakai]" class="form-control form-control-sm" value="1"></td>
                <td><input type="number" name="part[${partIdx}][harga_satuan_jual]" class="form-control form-control-sm harga-input" value="0"></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button></td>
            </tr>`;
            partIdx++;
        }
        table.insertAdjacentHTML('beforeend', row);
    }
</script>
<?= $this->endSection(); ?>