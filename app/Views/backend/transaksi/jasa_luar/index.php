<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Daftar Pekerjaan Jasa Luar (Vendor)</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">
            <i class="bi bi-plus-lg"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table id="tableMaster" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>No. Transaksi</th>
                    <th>Deskripsi Pekerjaan</th>
                    <th>Modal Vendor</th>
                    <th>Tagihan</th>
                    <th style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge text-bg-info"><?= $d['kode_transaksi']; ?></span></td>
                    <td><?= esc($d['deskripsi_pekerjaan']); ?></td>
                    <td>Rp <?= number_format($d['biaya_modal_vendor'], 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($d['tagihan_ke_pelanggan'], 0, ',', '.'); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="<?= base_url('transaksi/jasaluar/delete/' . $d['id_jasa_luar']); ?>"
                            class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalMaster" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" id="formMaster">
            <?= csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Jasa Luar</h5>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/transaksi/jasa_luar/form'); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let modalElement;
let modal;
let form;

document.addEventListener('DOMContentLoaded', function() {
    modalElement = document.getElementById('modalMaster');
    form = document.getElementById('formMaster');
    if (typeof bootstrap !== 'undefined') modal = new bootstrap.Modal(modalElement);
});

function tambahData() {
    if (!form || !modal) return;
    document.getElementById('modalTitle').innerText = 'Tambah Jasa Luar';
    form.action = '<?= base_url('backend/transaksi/jasa_luar/save'); ?>';
    form.reset();
    modal.show();
}

function editData(data) {
    if (!form || !modal) return;
    document.getElementById('modalTitle').innerText = 'Edit Jasa Luar';
    form.action = '<?= base_url('transaksi/jasaluar/update'); ?>/' + data.id_jasa_luar;

    // Isi form otomatis
    if (document.getElementById('id_transaksi')) document.getElementById('id_transaksi').value = data.id_transaksi;
    if (document.getElementById('deskripsi_pekerjaan')) document.getElementById('deskripsi_pekerjaan').value = data
        .deskripsi_pekerjaan;
    if (document.getElementById('biaya_modal_vendor')) document.getElementById('biaya_modal_vendor').value = data
        .biaya_modal_vendor;
    if (document.getElementById('tagihan_ke_pelanggan')) document.getElementById('tagihan_ke_pelanggan').value = data
        .tagihan_ke_pelanggan;

    modal.show();
}
</script>
<?= $this->endSection(); ?>