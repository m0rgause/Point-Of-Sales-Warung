<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Buat Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/produk" class="btn btn--gray-outline">Batal</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="row">
    <div class="col-md-8">
        <?= $_SESSION['form_errors']['create_product']??null; ?>
        <div class="main__box">
            <?= form_open_multipart('/admin/simpan_produk_ke_db'); ?>
                <div class="mb-3">
                    <label class="form-label" for="category_product">Kategori Produk</label>
                    <select class="form-select" name="category_product" id="category_product">
                    <?php foreach($category_products_db as $cp) : ?>
                        <option value="<?= $cp['kategori_produk_id']; ?>" <?= $cp['kategori_produk_id']===old('category_product')?'selected':''; ?>>
                            <?= $cp['nama_kategori_produk']; ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                    <?= $_SESSION['form_errors']['category_product']??null; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product_name">Nama Produk</label>
                    <input class="form-input" type="text" name="product_name" value="<?= old('product_name'); ?>">
                    <?= $_SESSION['form_errors']['product_name']??null; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product_photo">Foto Produk</label>
                    <div class="form-file">
                        <input type="file" name="product_photo" id="product_photo" accept="image/jpeg">
                        <label for="product_photo">Pilih file...</label>
                    </div>
                    <?= $_SESSION['form_errors']['product_photo']??'<small class="form-message form-message--info">
                    Ukuran file maksimal 1 MB dan ekstensi file harus .jpg atau .jpeg!</small>'; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product_status">Status Produk</label>
                    <select class="form-select" name="product_status" id="product_status">
                    <?php
                        $array_product_status = ['ada'=>'Ada','tidak_ada'=>'Tidak Ada'];
                        foreach($array_product_status as $key=>$value) :
                    ?>
                    <option value="<?= $key; ?>" <?= $key===old('product_status')?'selected':''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <?= $_SESSION['form_errors']['product_status']??null; ?>
                </div>
                <div id="magnitude_price">
                    <label class="form-label">Harga Produk</label>
                <?php
                    $count_product_magnitude = count(old('product_magnitude', []));
                    if($count_product_magnitude > 0) :
                    for($i = 0; $i < $count_product_magnitude; $i++) :

               ?>
                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-input" type="text" placeholder="Besaran..."
                            name="product_magnitude[]" value="<?= old('product_magnitude')[$i]??null; ?>">
                            <input class="form-input" type="number" placeholder="Harga..."
                            name="product_price[]" value="<?= old('product_price')[$i]??null; ?>">
                    <?php
                        // if last looping
                        if($i === $count_product_magnitude-1) :
                    ?>
                            <a class="btn btn--gray-outline" id="add-form-input-magnitude-price" href="">Tambah</a>
                    <?php else: ?>
                            <a class="btn btn--gray-outline" id="remove-form-input-magnitude-price" href="">Hapus</a>
                    <?php endif; ?>
                        </div>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_magnitude'][$i]??null; ?></small>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_price'][$i]??null; ?></small>
                    </div><!-- mb-3 -->

                <?php endfor; else : ?>
                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-input" type="text" placeholder="Besaran..." name="product_magnitude[]">
                            <input class="form-input" type="number" placeholder="Harga..." name="product_price[]">
                            <a class="btn btn--gray-outline" id="add-form-input-magnitude-price" href="">Tambah</a>
                        </div>
                    </div>
                <?php endif; ?>
                </div><!-- magnitude-price -->
                <button class="btn btn--blue" type="submit">Simpan</button>
            </form>
        </div><!-- main__box -->
    </div>
    </div>
</div>
</main>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
// get file name and replace text in label with it
const form_file = document.querySelector('div.form-file input[type="file"]');
form_file.addEventListener('change', (e) => {
    e.target.nextElementSibling.innerText = e.target.files[0].name;
});

// add form input magnitude and price
const magnitude_price = document.querySelector('div#magnitude_price');
magnitude_price.addEventListener('click', (e) => {
    if(e.target.getAttribute('id') === 'add-form-input-magnitude-price'){
        e.preventDefault();
        add_form_input_magnitude_price(e.target, magnitude_price);
    }
});

// remove form input magnitude and price
magnitude_price.addEventListener('click', (e) => {
    if(e.target.getAttribute('id') === 'remove-form-input-magnitude-price') {
        e.preventDefault();

        e.target.parentElement.parentElement.remove();
    }
});
</script>
<?= $this->endSection(); ?>
