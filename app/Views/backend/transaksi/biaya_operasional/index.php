<?= $this->extend('backend/layout/admin_layout'); ?>

<?= $this->section('content'); ?>

<div class="card card-primary card-outline">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="card-title m-0">
            Data Biaya Operasional
        </h5>

        <button type="button" class="btn btn-primary btn-sm" onclick="tambahData()">

            <i class="bi bi-plus-lg"></i>

            Tambah Data

        </button>

    </div>

    <div class="card-body">

        <table id="tableMaster" class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th style="width: 10px">#</th>

                    <th>Kategori Biaya</th>

                    <th>Tanggal & Jam</th>

                    <th>Nominal</th>

                    <th>Keterangan</th>

                    <th>Diinput Oleh</th>

                    <th style="width: 100px">Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php $no = 1; ?>

                <?php foreach ($data as $d): ?>

                    <tr>

                        <td>

                            <?= $no++; ?>

                        </td>

                        <td>

                            <span class="badge text-bg-info">

                                <?= esc($d['nama_kategori']); ?>

                            </span>

                        </td>

                        <td>

                            <div class="fw-semibold">

                                <?= date(
                                    'd-m-Y',
                                    strtotime($d['tanggal_biaya'])
                                ); ?>

                            </div>

                            <small class="text-muted">

                                <?= date(
                                    'H:i:s',
                                    strtotime($d['tanggal_biaya'])
                                ); ?>

                            </small>

                        </td>

                        <td>

                            Rp <?= number_format(
                                $d['nominal'],
                                0,
                                ',',
                                '.'
                            ); ?>

                        </td>

                        <td>

                            <?= esc($d['keterangan']); ?>

                        </td>

                        <td>

                            <span class="badge text-bg-secondary">

                                <?= esc($d['nama_pengguna'] ?? '-'); ?>

                            </span>

                        </td>

                        <td>

                            <button class="btn btn-warning btn-sm" onclick='editData(<?= json_encode($d); ?>)'>

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <a href="<?= base_url('backend/transaksi/biaya_operasional/delete/' . $d['id_biaya_operasional']); ?>"
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

                    <h5 class="modal-title" id="modalTitle">

                        Form Biaya Operasional

                    </h5>

                </div>

                <div class="modal-body">

                    <?= $this->include('backend/transaksi/biaya_operasional/form'); ?>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">

                        Simpan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

    let modalElement;
    let modal;
    let form;

    document.addEventListener('DOMContentLoaded', function () {

        modalElement =
            document.getElementById('modalMaster');

        form =
            document.getElementById('formMaster');

        if (typeof bootstrap !== 'undefined') {

            modal = new bootstrap.Modal(modalElement);

        }

    });

    function tambahData() {

        if (!form || !modal) return;

        document.getElementById('modalTitle').innerText =
            'Tambah Biaya Operasional';

        form.action =
            '<?= base_url('backend/transaksi/biaya_operasional/save'); ?>';

        form.reset();

        modal.show();

    }

    function editData(data) {

        if (!form || !modal) return;

        document.getElementById('modalTitle').innerText =
            'Edit Biaya Operasional';

        form.action =
            '<?= base_url('backend/transaksi/biaya_operasional/update'); ?>/' +
            data.id_biaya_operasional;

        if (document.getElementById('id_kategori_biaya')) {

            document.getElementById('id_kategori_biaya').value =
                data.id_kategori_biaya;

        }

        if (document.getElementById('nominal')) {

            document.getElementById('nominal').value =
                data.nominal;

        }

        if (document.getElementById('keterangan')) {

            document.getElementById('keterangan').value =
                data.keterangan;

        }

        modal.show();

    }

</script>

<?= $this->endSection(); ?>