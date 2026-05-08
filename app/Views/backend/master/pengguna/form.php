<div class="mb-3">
    <label class="form-label">Nama Pengguna <span class="text-danger">*</span></label>
    <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Kata Sandi</label>
    <input type="password" name="kata_sandi" id="kata_sandi" class="form-control">
    <small class="text-muted" id="passHelp">Kosongkan jika tidak ingin mengubah kata sandi saat edit.</small>
</div>
<div class="mb-3">
    <label class="form-label">Peran (Role)</label>
    <select name="peran" id="peran" class="form-select">
        <option value="Admin">Admin</option>
        <option value="Pemilik">Pemilik</option>
        <option value="Mekanik">Mekanik</option>
    </select>
</div>