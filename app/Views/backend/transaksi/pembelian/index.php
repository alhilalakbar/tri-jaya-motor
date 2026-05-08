<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-dark card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Riwayat Pembelian Stok</h5>
        <button type="button" class="btn btn-dark btn-sm" onclick="tambahBeli()">
            <i class="bi bi-cart-plus"></i> Input Pembelian
        </button>
    </div>
    <div class="card-body">
        <table id="tableBeli" class="table table-bordered table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>No. Faktur</th>
                    <th>Tanggal</th>
                    <th>Pemasok</th>
                    <th>Total Belanja</th>
                    <th style="width: 80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d): ?>
                    <tr>
                        <td><span class="badge text-bg-dark"><?= $d['kode_pembelian']; ?></span></td>
                        <td><?= date('d/m/Y', strtotime($d['tanggal_pembelian'])); ?></td>
                        <td><?= esc($d['nama_pemasok']); ?></td>
                        <td>Rp <?= number_format($d['total_harga'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('transaksi/pembelian/detail/' . $d['id_pembelian']); ?>"
                                class="btn btn-outline-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalBeli" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('transaksi/pembelian/save'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="bi bi-cart-fill"></i> Tambah Stok Sparepart</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/transaksi/pembelian/form'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4">Simpan ke Stok</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let itemIdx = 1;

    function tambahBeli() {
        new bootstrap.Modal(document.getElementById('modalBeli')).show();
    }

    function addRow(tableId) {
        const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        const row = `<tr>
            <td><select name="items[${itemIdx}][id_part]" class="form-select form-select-sm" required>
                <option value="">-- Pilih Sparepart --</option>
                <?php foreach ($part_list as $p): ?><option value="<?= $p['id_part']; ?>"><?= esc($p['nama_part']); ?></option><?php endforeach; ?>
            </select></td>
            <td><input type="number" name="items[${itemIdx}][jumlah]" class="form-control form-control-sm" value="1"></td>
            <td><input type="number" name="items[${itemIdx}][harga_beli]" class="form-control form-control-sm" value="0"></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button></td>
        </tr>`;
        table.insertAdjacentHTML('beforeend', row);
        itemIdx++;
    }
</script>
<?= $this->endSection(); ?>