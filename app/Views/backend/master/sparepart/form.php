<div class="mb-3">
    <label class="form-label">Nama Sparepart <span class="text-danger">*</span></label>
    <input type="text" name="nama_part" id="nama_part" class="form-control" required>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-select">
            <?php foreach ($kategori as $k) : ?>
                <option value="<?= $k['id_kategori']; ?>"><?= esc($k['nama_kategori']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Merek</label>
        <select name="id_merek_part" id="id_merek_part" class="form-select">
            <?php foreach ($merek as $m) : ?>
                <option value="<?= $m['id_merek_part']; ?>"><?= esc($m['nama_merek']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Kualitas</label>
    <select name="kualitas_part" id="kualitas_part" class="form-select">
        <option value="Original">Original</option>
        <option value="OEM">OEM</option>
        <option value="KW">KW</option>
    </select>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Harga Jual</label>
        <input type="number" name="harga_jual" id="harga_jual" class="form-control" value="0">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Stok Minimum</label>
        <input type="number" name="stok_minimum" id="stok_minimum" class="form-control" value="5">
    </div>
</div>