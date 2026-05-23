<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
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
                <th>Nama Jasa</th>
                <th>Biaya Standar</th>
                <th style="width: 120px" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
foreach ($data as $d): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><span class="badge text-bg-secondary"><?= $d['kode_jasa']; ?></span></td>
                <td><?= $d['nama_jasa']; ?></td>
                <td>Rp <?= number_format($d['biaya_standar'], 0, ',', '.'); ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-warning btn-sm"
                            onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                            <i class="bi bi-pencil-square text-white"></i>
                        </button>

                        <a href="<?= base_url('master/jasa-servis/delete/' . $d['id_jasa']); ?>"
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
                    <?= $this->include('backend/master/jasa_servis/form'); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let modal;
let form;

// Menunggu seluruh elemen HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('modalMaster');
    form = document.getElementById('formMaster');

    // Pastikan library Bootstrap sudah tersedia
    if (typeof bootstrap !== 'undefined' && modalElement) {
        modal = new bootstrap.Modal(modalElement);
    } else {
        console.error("Error: Bootstrap JS atau elemen modalMaster tidak ditemukan!");
    }
});

function tambahData() {
    if (!form || !modal) {
        console.error("Sistem belum siap.");
        return;
    }

    document.getElementById('modalTitle').innerText = 'Tambah Data Jasa';
    form.action = '<?= site_url('master/jasa-servis/save'); ?>';
    form.reset();
    modal.show();
}

function editData(data) {
    if (!form || !modal) return;

    document.getElementById('modalTitle').innerText = 'Edit Data Jasa';
    form.action = '<?= site_url('master/jasa-servis/update'); ?>/' + data.id_jasa;

    // Mengisi nilai input di dalam modal
    if (document.getElementById('nama_jasa')) {
        document.getElementById('nama_jasa').value = data.nama_jasa;
    }

    if (document.getElementById('biaya_standar')) {
        document.getElementById('biaya_standar').value = data.biaya_standar;
    }

    modal.show();
}
</script>
<?= $this->endSection(); ?>