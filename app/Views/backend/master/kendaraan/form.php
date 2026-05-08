<div class="mb-3">
    <label class="form-label">Pemilik (Pelanggan) <span class="text-danger">*</span></label>
    <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
        <option value="">-- Pilih Pelanggan --</option>
        <?php foreach ($pelanggan as $p) : ?>
            <option value="<?= $p['id_pelanggan']; ?>"><?= esc($p['nama_pelanggan']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Tipe Motor <span class="text-danger">*</span></label>
    <select name="id_tipe_motor" id="id_tipe_motor" class="form-select" required>
        <option value="">-- Pilih Tipe --</option>
        <?php foreach ($tipe as $t) : ?>
            <option value="<?= $t['id_tipe_motor']; ?>"><?= esc($t['nama_tipe']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Nomor Plat <span class="text-danger">*</span></label>
    <input type="text" name="nomor_plat" id="nomor_plat" class="form-control" placeholder="B 1234 ABC" required>
</div>