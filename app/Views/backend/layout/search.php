<form action="" method="GET" class="m-0" id="formSearch">
    <div class="input-group input-group-sm" style="width: 200px;">
        <input type="text" name="keyword" class="form-control" 
               placeholder="Cari..." value="<?= esc($keyword ?? '') ?>" 
               onkeyup="if(event.keyCode == 13) this.form.submit();">
        <div class="input-group-append">
            <button type="submit" class="btn btn-default">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
</form>