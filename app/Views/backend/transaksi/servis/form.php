<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Kendaraan & Pemilik <span class="text-danger">*</span></label>
        <select name="header[id_kendaraan]" class="form-select select2" required>
            <option value="">-- Pilih Kendaraan --</option>
            <?php foreach ($kendaraan as $k): ?>
            <option value="<?= $k['id_kendaraan']; ?>"><?= esc($k['nomor_plat']); ?> - <?= esc($k['nama_pelanggan']); ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Mekanik <span class="text-danger">*</span></label>
        <select name="header[id_mekanik]" class="form-select" required>
            <option value="">-- Pilih Mekanik --</option>
            <?php foreach ($mekanik as $m): ?>
            <option value="<?= $m['id_mekanik']; ?>"><?= esc($m['nama_mekanik']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Tanggal Masuk</label>
        <input type="date" name="header[tanggal_masuk]" class="form-control" value="<?= date('Y-m-d'); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Keluhan Awal</label>
        <textarea name="header[keluhan_awal]" class="form-control" rows="2"
            placeholder="Masukkan keluhan pelanggan..."></textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Hasil Pemeriksaan</label>
        <textarea name="header[hasil_pemeriksaan]" class="form-control" rows="2"
            placeholder="Masukkan hasil pengecekan mekanik..."></textarea>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <label class="form-label">Status Pengerjaan</label>
        <select name="header[status_pengerjaan]" class="form-select">
            <option value="Antre">Antre</option>
            <option value="Diproses">Diproses</option>
            <option value="Menunggu Part">Menunggu Part</option>
            <option value="Selesai">Selesai</option>
            <option value="Diambil">Diambil</option>
            <option value="Dibatalkan">Dibatalkan</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Metode Pembayaran</label>
        <select name="header[metode_pembayaran]" class="form-select">
            <option value="Tunai">Tunai</option>
            <option value="QRIS">QRIS</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status Pembayaran</label>
        <select name="header[status_pembayaran]" class="form-select">
            <option value="Belum Lunas">Belum Lunas</option>
            <option value="Lunas">Lunas</option>
        </select>
    </div>
</div>

<hr>
<div class="mb-4">
    <h6><i class="bi bi-wrench-adjustable text-primary"></i> Detail Jasa Servis</h6>
    <table class="table table-sm table-bordered" id="tableJasa">
        <thead class="table-light">
            <tr>
                <th>Nama Jasa</th>
                <th style="width: 180px">Biaya Jasa (Rp)</th>
                <th style="width: 180px">Biaya Tambahan (Rp)</th>
                <th style="width: 50px"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="jasa[0][id_jasa]" class="form-select form-select-sm select-jasa" required>
                        <option value="">-- Pilih Jasa --</option>
                        <?php foreach ($jasa_list as $j): ?>
                        <option value="<?= $j['id_jasa']; ?>" data-price="<?= $j['biaya_standar']; ?>">
                            <?= esc($j['nama_jasa']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <td>
                    <input type="number" name="jasa[0][harga_saat_transaksi]"
                        class="form-control form-control-sm biaya-input" value="0" min="0">
                </td>

                <td>
                    <input type="number" name="jasa[0][biaya_tambahan]" class="form-control form-control-sm" value="0"
                        min="0">
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm disabled">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addRow('tableJasa')">
        <i class="bi bi-plus"></i> Tambah Jasa
    </button>
</div>

<div>
    <h6><i class="bi bi-box-seam text-success"></i> Penggantian Sparepart</h6>
    <table class="table table-sm table-bordered" id="tablePart">
        <thead class="table-light">
            <tr>
                <th>Nama Sparepart</th>
                <th style="width: 100px">Qty</th>
                <th style="width: 150px">Harga Satuan</th>
                <th style="width: 50px"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="part[0][id_part]" class="form-select form-select-sm select-part">
                        <option value="">-- Pilih Part (Opsional) --</option>
                        <?php foreach ($part_list as $p): ?>
                        <option value="<?= $p['id_part']; ?>" data-price="<?= $p['harga_jual']; ?>">
                            <?= esc($p['nama_part']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="part[0][jumlah_pakai]" class="form-control form-control-sm" value="1"
                        min="1"></td>
                <td><input type="number" name="part[0][harga_satuan_jual]"
                        class="form-control form-control-sm harga-input" value="0" min="0"></td>
                <td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm disabled"><i
                            class="bi bi-trash"></i></button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-outline-success btn-sm" onclick="addRow('tablePart')"><i
            class="bi bi-plus"></i> Tambah Part</button>
</div>