<div class="mb-3">
    <label class="form-label">Merek Motor <span class="text-danger">*</span></label>
    <select name="id_merek_motor" id="id_merek_motor" class="form-select" required>
        <option value="">-- Pilih Merek --</option>
        <?php foreach ($merk as $m) : ?>
            <option value="<?= $m['id_merek_motor']; ?>"><?= esc($m['nama_merek_motor']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Nama Tipe <span class="text-danger">*</span></label>
    <input type="text" name="nama_tipe" id="nama_tipe" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Jenis Kendaraan</label>
    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select">
        <option value="Matic">Matic</option>
        <option value="Bebek">Bebek</option>
        <option value="Sport">Sport</option>
        <option value="Lainnya">Lainnya</option>
    </select>
</div>