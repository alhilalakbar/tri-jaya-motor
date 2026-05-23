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
                    <th>Kode Pengguna</th>
                    <th>Nama Pengguna</th>
                    <th>Peran (Role)</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data as $d): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><strong><?= $d['kode_pengguna']; ?></strong></td>
                    <td><?= $d['nama_pengguna']; ?></td>
                    <td><span class="badge text-bg-info"><?= $d['peran']; ?></span></td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="<?= base_url('master/pengguna/delete/' . $d['id_pengguna']); ?>"
                            class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
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
                    <h5 class="modal-title" id="modalTitle">Form Pengguna</h5>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/master/pengguna/form'); ?>
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
    document.getElementById('modalTitle').innerText = 'Tambah Pengguna';
    form.action = '<?= base_url('master/pengguna/save'); ?>';
    form.reset();
    modal.show();
}

function editData(data) {
    if (!form || !modal) return;
    document.getElementById('modalTitle').innerText = 'Edit Pengguna';
    form.action = '<?= base_url('master/pengguna/update'); ?>/' + data.id_pengguna;

    document.getElementById('nama_pengguna').value = data.nama_pengguna;
    document.getElementById('peran').value = data.peran;
    document.getElementById('kata_sandi').value = '';

    modal.show();
}
</script>
<?= $this->endSection(); ?>