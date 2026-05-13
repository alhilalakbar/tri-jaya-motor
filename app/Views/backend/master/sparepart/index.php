<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Daftar Suku Cadang (Sparepart)</h5>
        <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">
            <i class="bi bi-plus-lg"></i> Tambah Sparepart
        </button>
    </div>
    <div class="card-body">
        <table id="tableMaster" class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Kode</th>
                    <th>Nama Part</th>
                    <th>Kategori / Merek</th>
                    <th class="text-center">Stok</th>
                    <th>Harga Jual</th>
                    <th style="width: 100px text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($sparepart as $s): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><span class="badge text-bg-secondary"><?= $s['kode_part']; ?></span></td>
                        <td>
                            <?= $s['nama_part']; ?><br>
                            <small class="text-muted">Kualitas: <?= $s['kualitas_part']; ?></small>
                        </td>
                        <td><?= $s['nama_kategori']; ?> <br> <small><?= $s['nama_merek_part']; ?></small></td>
                        <td class="text-center">
                            <?php
                            $statusClass = ($s['stok_saat_ini'] <= $s['stok_minimum']) ? 'bg-danger' : 'bg-success';
                            ?>
                            <span class="badge <?= $statusClass; ?>">
                                <?= $s['stok_saat_ini']; ?>
                            </span>
                            <div style="font-size: 0.7rem;" class="text-muted mt-1">Min: <?= $s['stok_minimum']; ?></div>
                        </td>
                        <td>Rp <?= number_format($s['harga_jual'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm"
                                onclick="editData(<?= htmlspecialchars(json_encode($s)); ?>)">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <a href="<?= base_url('backend/master/sparepart/delete/' . $s['id_part']); ?>"
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
    <div class="modal-dialog modal-lg">
        <form action="" method="post" id="formMaster">
            <?= csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Sparepart</h5>
                </div>
                <div class="modal-body">
                    <?= $this->include('backend/master/sparepart/form'); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let modalElement; let modal; let form;
    document.addEventListener('DOMContentLoaded', function () {
        modalElement = document.getElementById('modalMaster');
        form = document.getElementById('formMaster');
        if (typeof bootstrap !== 'undefined') modal = new bootstrap.Modal(modalElement);
    });

    function tambahData() {
        if (!form || !modal) return;
        document.getElementById('modalTitle').innerText = 'Tambah Sparepart';
        form.action = '<?= base_url('backend/master/sparepart/save'); ?>';
        form.reset();

        if (document.getElementById('stok_saat_ini')) {
            document.getElementById('stok_saat_ini').value = 0;
            document.getElementById('stok_saat_ini').readOnly = true;
        }

        modal.show();
    }

    function editData(data) {
        if (!form || !modal) return;
        document.getElementById('modalTitle').innerText = 'Edit Sparepart';
        form.action = '<?= base_url('backend/master/sparepart/update'); ?>/' + data.id_part;

        document.getElementById('nama_part').value = data.nama_part;
        document.getElementById('id_kategori').value = data.id_kategori;
        document.getElementById('id_merek_part').value = data.id_merek_part;
        document.getElementById('kualitas_part').value = data.kualitas_part;
        document.getElementById('harga_jual').value = data.harga_jual;
        document.getElementById('stok_minimum').value = data.stok_minimum;

        // Stok saat ini tidak boleh diubah di sini (harus via Pembelian/Transaksi)
        if (document.getElementById('stok_saat_ini')) {
            document.getElementById('stok_saat_ini').value = data.stok_saat_ini;
            document.getElementById('stok_saat_ini').readOnly = true;
            document.getElementById('stok_saat_ini').classList.add('bg-light');
        }

        modal.show();
    }
</script>
<?= $this->endSection(); ?>