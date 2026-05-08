<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Daftar Pemasok</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">
            <i class="bi bi-plus-lg"></i> Tambah Pemasok
        </button>
    </div>
    <div class="card-body">
        <table id="tableMaster" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Kode</th>
                    <th>Nama Pemasok</th>
                    <th>Nomor HP</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge text-bg-secondary"><?= $d['kode_pemasok']; ?></span></td>
                    <td><?= $d['nama_pemasok']; ?></td>
                    <td><?= $d['nomor_hp_pemasok']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editData(<?= htmlspecialchars(json_encode($d)); ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <a href="<?= base_url('backend/master/pemasok/delete/' . $d['id_pemasok']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
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
                <div class="modal-header"><h5 class="modal-title" id="modalTitle">Form Data Pemasok</h5></div>
                <div class="modal-body">
                    <?= $this->include('backend/master/pemasok/form'); ?>
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
        document.getElementById('modalTitle').innerText = 'Tambah Pemasok';
        form.action = '<?= base_url('backend/master/pemasok/save'); ?>';
        form.reset();
        modal.show();
    }

    function editData(data) {
        if (!form || !modal) return;
        document.getElementById('modalTitle').innerText = 'Edit Pemasok';
        form.action = '<?= base_url('backend/master/pemasok/update'); ?>/' + data.id_pemasok;
        
        if(document.getElementById('nama_pemasok')) document.getElementById('nama_pemasok').value = data.nama_pemasok;
        if(document.getElementById('nomor_hp_pemasok')) document.getElementById('nomor_hp_pemasok').value = data.nomor_hp_pemasok;
        if(document.getElementById('alamat_pemasok')) document.getElementById('alamat_pemasok').value = data.alamat_pemasok;
        
        modal.show();
    }
</script>
<?= $this->endSection(); ?>