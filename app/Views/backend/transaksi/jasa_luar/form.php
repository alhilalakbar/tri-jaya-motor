<div class="mb-3">
    <label class="form-label">No. Transaksi Servis <span class="text-danger">*</span></label>
    <select name="id_transaksi" id="id_transaksi" class="form-select" required>
        <option value="">-- Pilih Transaksi --</option>
        <?php foreach ($transaksi as $t) : ?>
            <option value="<?= $t['id_transaksi']; ?>"><?= $t['kode_transaksi']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" class="form-control" rows="2" placeholder="Contoh: Bubut kruk as atau Press segitiga" required></textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Biaya Modal (Vendor)</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="biaya_modal_vendor" id="biaya_modal_vendor" class="form-control" value="0">
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Tagihan ke Pelanggan</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="tagihan_ke_pelanggan" id="tagihan_ke_pelanggan" class="form-control" value="0">
        </div>
    </div>
</div>