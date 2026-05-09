<div class="mb-3">
    <label class="form-label">Mekanik <span class="text-danger">*</span></label>
    <select name="id_mekanik" id="id_mekanik" class="form-select" required>
        <option value="">-- Pilih Mekanik --</option>

        <?php foreach ($mekanik as $m): ?>
            <option value="<?= $m['id_mekanik']; ?>">
                <?= $m['nama_mekanik']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
    <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Nominal Gaji <span class="text-danger">*</span></label>

    <div class="input-group">
        <span class="input-group-text">Rp</span>

        <input type="number" name="nominal" id="nominal" class="form-control" min="0" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Keterangan</label>

    <textarea name="keterangan" id="keterangan" rows="2" class="form-control"
        placeholder="Contoh: Gaji harian mekanik"></textarea>
</div>