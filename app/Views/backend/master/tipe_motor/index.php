<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Daftar Tipe Motor</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">
            <i class="bi bi-plus-lg"></i> Tambah Tipe
        </button>
    </div>
    <div class="card-body">
        <table id="tableMaster" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Kode</th>
                    <th>Merek</th>
                    <th>Nama Tipe</th>
                    <th>Jenis</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($tipe as $t) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge text-bg-secondary"><?= $t['kode_tipe_motor']; ?></span></td>
                    <td><?= $t['nama_merek_motor']; ?></td>
                    <td><?= $t['nama_tipe']; ?></td>
                    <td><?= $t['jenis_kendaraan']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editData(<?= htmlspecialchars(json_encode($t)); ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="<?= base_url('backend/master/tipe_motor/delete/' . $t['id_tipe_motor']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
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
                <div class="modal-header"><h5 class="modal-title" id="modalTitle">Form Tipe Motor</h5></div>
                <div class="modal-body">
                    <?= $this->include('backend/master/tipe_motor/form'); ?>
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
        document.getElementById('modalTitle').innerText = 'Tambah Tipe Motor';
        form.action = '<?= base_url('backend/master/tipe_motor/save'); ?>';
        form.reset();
        modal.show();
    }

    function editData(data) {
        if (!form || !modal) return;
        document.getElementById('modalTitle').innerText = 'Edit Tipe Motor';
        form.action = '<?= base_url('backend/master/tipe_motor/update'); ?>/' + data.id_tipe_motor;
        
        if(document.getElementById('id_merek_motor')) document.getElementById('id_merek_motor').value = data.id_merek_motor;
        if(document.getElementById('nama_tipe')) document.getElementById('nama_tipe').value = data.nama_tipe;
        if(document.getElementById('jenis_kendaraan')) document.getElementById('jenis_kendaraan').value = data.jenis_kendaraan;
        
        modal.show();
    }
</script>
<?= $this->endSection(); ?>