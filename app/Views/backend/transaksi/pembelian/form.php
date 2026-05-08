<div class="row mb-4">
    <div class="col-md-9">
        <label class="form-label">Toko / Pemasok <span class="text-danger">*</span></label>
        <select name="header[id_pemasok]" class="form-select" required>
            <option value="">-- Pilih Toko/Supplier --</option>
            <?php foreach ($pemasok as $ps): ?>
                <option value="<?= $ps['id_pemasok']; ?>"><?= esc($ps['nama_pemasok']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Tanggal Beli</label>
        <input type="date" name="header[tanggal_pembelian]" class="form-control" value="<?= date('Y-m-d'); ?>" required>
    </div>
</div>

<hr>

<h6><i class="bi bi-cart-plus text-primary"></i> Daftar Barang yang Dibeli</h6>
<table class="table table-sm table-bordered" id="tableItem">
    <thead class="table-light">
        <tr>
            <th>Pilih Sparepart</th>
            <th style="width: 100px">Jumlah</th>
            <th style="width: 200px">Harga Beli Satuan (Rp)</th>
            <th style="width: 50px"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <select name="items[0][id_part]" class="form-select form-select-sm" required>
                    <option value="">-- Pilih Suku Cadang --</option>
                    <?php foreach ($part_list as $p): ?>
                        <option value="<?= $p['id_part']; ?>"><?= esc($p['nama_part']); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input type="number" name="items[0][jumlah]" class="form-control form-control-sm" value="1" min="1"
                    required></td>
            <td><input type="number" name="items[0][harga_beli]" class="form-control form-control-sm" value="0" min="0"
                    required></td>
            <td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm disabled"><i
                        class="bi bi-trash"></i></button></td>
        </tr>
    </tbody>
</table>
<button type="button" class="btn btn-outline-primary btn-sm" onclick="addRow('tableItem')"><i class="bi bi-plus-lg"></i>
    Tambah Baris Barang</button>