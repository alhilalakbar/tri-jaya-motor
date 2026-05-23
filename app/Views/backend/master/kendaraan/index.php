<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title m-0">Daftar Data</h5>

        <div class="flex-grow-1 d-flex justify-content-center">
            <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </button>
        </div>

        <div>
            <?= $this->include('backend/layout/search') ?>
        </div>
    </div>
    <div class="card-body">
        <table id="tableMaster" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nomor Plat</th>
                    <th>Pemilik</th>
                    <th>Tipe Motor</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($kendaraan as $d): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge text-bg-dark"><?= $d['nomor_plat']; ?></span></td>
                    <td><?= $d['nama_pelanggan']; ?></td>
                    <td><?= $d['nama_tipe']; ?></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-warning btn-sm"
                                onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                                <i class="bi bi-pencil-square text-white"></i>
                            </button>

                            <a href="<?= base_url('master/kendaraan/delete/' . $d['id_kendaraan']); ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
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
                    <h5 class="modal-title" id="modalTitle">Form Kendaraan</h5>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/master/kendaraan/form'); ?>
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
    document.getElementById('modalTitle').innerText = 'Tambah Kendaraan';
    form.action = '<?= base_url('master/kendaraan/save'); ?>';
    form.reset();
    modal.show();
}

function editData(data) {
    if (!form || !modal) return;
    document.getElementById('modalTitle').innerText = 'Edit Kendaraan';
    form.action = '<?= base_url('master/kendaraan/update'); ?>/' + data.id_kendaraan;

    document.getElementById('id_pelanggan').value = data.id_pelanggan;
    document.getElementById('id_tipe_motor').value = data.id_tipe_motor;
    document.getElementById('nomor_plat').value = data.nomor_plat;

    modal.show();
}
</script>
<?= $this->endSection(); ?>