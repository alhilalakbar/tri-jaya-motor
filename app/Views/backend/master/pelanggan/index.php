<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Daftar Pelanggan</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">
            <i class="bi bi-plus-lg"></i> Tambah Pelanggan
        </button>
    </div>
    <div class="card-body">
        <table id="tableMaster" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Kode</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor HP</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge text-bg-secondary"><?= $d['kode_pelanggan']; ?></span></td>
                    <td><?= $d['nama_pelanggan']; ?></td>
                    <td><?= $d['nomor_hp']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="<?= base_url('backend/master/pelanggan/delete/' . $d['id_pelanggan']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
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
                <div class="modal-header"><h5 class="modal-title" id="modalTitle">Form Data Pelanggan</h5></div>
                <div class="modal-body">
                    <?= $this->include('backend/master/pelanggan/form'); ?>
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
        }
    });

    function tambahData() {
        if (!form || !modal) return;
        document.getElementById('modalTitle').innerText = 'Tambah Pelanggan';
        form.action = '<?= base_url('backend/master/pelanggan/save'); ?>';
        form.reset();
        modal.show();
    }

    function editData(data) {
        if (!form || !modal) return;
        document.getElementById('modalTitle').innerText = 'Edit Pelanggan';
        form.action = '<?= base_url('backend/master/pelanggan/update'); ?>/' + data.id_pelanggan;
        
        if(document.getElementById('nama_pelanggan')) document.getElementById('nama_pelanggan').value = data.nama_pelanggan;
        if(document.getElementById('nomor_hp')) document.getElementById('nomor_hp').value = data.nomor_hp;
        
        modal.show();
    }
</script>
<?= $this->endSection(); ?>