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
                <td><span class="badge text-bg-secondary"><?= $d['kode_kategori']; ?></span></td>
                <td><?= $d['nama_kategori']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <a href="<?= base_url('backend/master/kategori_part/delete/' . $d['id_kategori']); ?>"
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
                    <?= $this->include('backend/master/kategori_part/form'); ?>
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

    if (typeof bootstrap !== 'undefined') {
        modal = new bootstrap.Modal(modalElement);
    } else {
        console.error("Bootstrap belum dimuat");
    }
});

function tambahData() {

    if (!form || !modal) return;

    document.getElementById('modalTitle').innerText = 'Tambah Data';

    form.action = '<?= base_url('backend/master/kategori_part/save'); ?>';

    form.reset();

    modal.show();
}

function editData(data) {

    if (!form || !modal) return;

    document.getElementById('modalTitle').innerText = 'Edit Data';

    form.action = '<?= base_url('backend/master/kategori_part/update'); ?>/' + data.id_kategori;

    if (document.getElementById('nama_kategori')) {
        document.getElementById('nama_kategori').value = data.nama_kategori;
    }

    if (document.getElementById('biaya_standar') && data.biaya_standar) {
        document.getElementById('biaya_standar').value = data.biaya_standar;
    }

    modal.show();
}
</script>
<?= $this->endSection(); ?>