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
                    <th>Kode</th>
                    <th>Nama</th>
                    <!-- Tambah kolom Biaya jika ini Jasa Servis -->
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data as $d): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge text-bg-secondary"><?= $d['kode_merek_motor']; ?></span></td>
                    <td><?= $d['nama_merek_motor']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="<?= base_url('master/merek_motor/delete/' . $d['id_merek_motor']); ?>"
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

<!-- Modal Pop-up -->
<div class="modal fade" id="modalMaster" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" id="formMaster">
            <?= csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Data</h5>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/master/merek_motor/form'); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// 1. Deklarasikan variabel secara global agar bisa diakses oleh fungsi lain
let modalElement;
let modal;
let form;

document.addEventListener('DOMContentLoaded', function() {
    // 2. Inisialisasi nilai variabel di dalam listener ini
    modalElement = document.getElementById('modalMaster');
    form = document.getElementById('formMaster');

    if (typeof bootstrap !== 'undefined' && modalElement) {
        modal = new bootstrap.Modal(modalElement);
    } else {
        console.error("Bootstrap atau elemen modal tidak ditemukan!");
    }
});

function tambahData() {
    if (!form || !modal) return;
    document.getElementById('modalTitle').innerText = 'Tambah Data';
    form.action = '<?= base_url('master/merek_motor/save'); ?>';
    form.reset();
    modal.show();
}

function editData(data) {
    if (!form || !modal) return;

    document.getElementById('modalTitle').innerText = 'Edit Data';
    form.action = '<?= base_url('master/merek_motor/update'); ?>/' + data.id_merek_motor;

    if (document.getElementById('nama_merek_motor')) {
        document.getElementById('nama_merek_motor').value = data.nama_merek_motor;
    }

    if (data.biaya_standar && document.getElementById('biaya_standar')) {
        document.getElementById('biaya_standar').value = data.biaya_standar;
    }

    modal.show();
}
</script>
<?= $this->endSection(); ?>