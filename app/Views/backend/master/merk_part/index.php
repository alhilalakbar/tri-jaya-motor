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
                    <th style="width:10px">#</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php $no = 1; ?>

                <?php foreach ($data as $d): ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>
                        <span class="badge text-bg-secondary">
                            <?= $d['kode_merek_part']; ?>
                        </span>
                    </td>

                    <td>
                        <?= $d['nama_merek_part']; ?>
                    </td>

                    <td>

                        <button type="button" class="btn btn-warning btn-sm"
                            onclick='editData(<?= json_encode($d); ?>)'>

                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <a href="<?= base_url('backend/master/merk_part/delete/' . $d['id_merek_part']); ?>"
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

                    <h5 class="modal-title" id="modalTitle">

                        Form Data
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <?= $this->include('backend/master/merk_part/form'); ?>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Tutup
                    </button>

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

document.addEventListener('DOMContentLoaded', function() {

    modalElement =
        document.getElementById('modalMaster');

    form =
        document.getElementById('formMaster');



    if (!modalElement) {

        console.error(
            'Modal #modalMaster tidak ditemukan!'
        );

        return;
    }

    if (!form) {

        console.error(
            'Form #formMaster tidak ditemukan!'
        );

        return;
    }



    if (typeof bootstrap === 'undefined') {

        console.error(
            'Bootstrap JS belum dimuat! ' +
            'Pastikan bootstrap.bundle.min.js ada.'
        );

        return;
    }



    modal =
        new bootstrap.Modal(modalElement);

    console.log(
        'Modal berhasil diinisialisasi'
    );

});



function tambahData() {

    if (!modal || !form) {

        alert(
            'Sistem belum siap. ' +
            'Silakan refresh halaman.'
        );

        return;
    }

    form.reset();

    if (
        document.getElementById(
            'id_merek_part'
        )
    ) {

        document.getElementById(
            'id_merek_part'
        ).value = '';
    }

    document.getElementById(
        'modalTitle'
    ).innerText = 'Tambah Data';

    form.action =
        '<?= base_url('backend/master/merk_part/save'); ?>';

    modal.show();
}


function editData(data) {

    if (!modal || !form) {

        alert(
            'Sistem belum siap. ' +
            'Silakan refresh halaman.'
        );

        return;
    }

    console.log(data);

    // Title
    document.getElementById(
        'modalTitle'
    ).innerText = 'Edit Data';

    // Action
    form.action =
        '<?= base_url('backend/master/merk_part/update'); ?>/' +
        data.id_merek_part;

    // =========================
    // SET VALUE
    // =========================

    // ID
    if (
        document.getElementById(
            'id_merek_part'
        )
    ) {

        document.getElementById(
                'id_merek_part'
            ).value =
            data.id_merek_part ?? '';
    }

    // Kode
    if (
        document.getElementById(
            'kode_merek_part'
        )
    ) {

        document.getElementById(
                'kode_merek_part'
            ).value =
            data.kode_merek_part ?? '';
    }

    // Nama
    if (
        document.getElementById(
            'nama_merek_part'
        )
    ) {

        document.getElementById(
                'nama_merek_part'
            ).value =
            data.nama_merek_part ?? '';
    }

    // Show modal
    modal.show();
}

// =========================
// CLEANUP BACKDROP
// =========================

modalElement?.addEventListener(
    'hidden.bs.modal',
    function() {

        document.body.classList.remove(
            'modal-open'
        );

        document
            .querySelectorAll(
                '.modal-backdrop'
            )
            .forEach(el => el.remove());
    }
);
</script>

<?= $this->endSection(); ?>