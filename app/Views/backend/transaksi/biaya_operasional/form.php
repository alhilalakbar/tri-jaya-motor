<div class="mb-3">

    <label class="form-label">
        Kategori Biaya
        <span class="text-danger">*</span>
    </label>

    <select name="id_kategori_biaya" id="id_kategori_biaya" class="form-select" required>

        <option value="">
            -- Pilih Kategori --
        </option>

        <?php foreach ($kategori as $k): ?>

            <option value="<?= $k['id_kategori_biaya']; ?>">

                <?= $k['nama_kategori']; ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>

<div class="mb-3">

    <label class="form-label">
        Nominal Biaya
        <span class="text-danger">*</span>
    </label>

    <div class="input-group">

        <span class="input-group-text">
            Rp
        </span>

        <input type="number" name="nominal" id="nominal" class="form-control" min="0" required>

    </div>

</div>

<div class="mb-3">

    <label class="form-label">
        Keterangan
    </label>

    <textarea name="keterangan" id="keterangan" rows="2" class="form-control"
        placeholder="Contoh: Pembelian oli, listrik bengkel, air galon"></textarea>

</div>