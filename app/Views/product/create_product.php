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
                    <label class="form-label" for="category-product">Kategori Produk</label>
                    <select class="form-select" name="category_product" id="category-product">
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
                    <label class="form-label" for="product-photo">Foto Produk</label>
                    <div class="form-file">
                        <input type="file" name="product_photo" id="product-photo" accept="image/jpeg">
                        <label for="product-photo">Pilih file...</label>
                    </div>
                    <?= $_SESSION['form_errors']['product_photo']??'<small class="form-message form-message--info">
                    Ukuran file maksimal 1 MB dan ekstensi file harus .jpg atau .jpeg!</small>'; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-status">Status Produk</label>
                    <select class="form-select" name="product_status" id="product-status">
                    <?php
                        $array_product_status = ['ada'=>'Ada','tidak_ada'=>'Tidak Ada'];
                        foreach($array_product_status as $key=>$value) :
                    ?>
                    <option value="<?= $key; ?>" <?= $key===old('product_status')?'selected':''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <?= $_SESSION['form_errors']['product_status']??null; ?>
                </div>
                <div id="magnitude-price">
                    <label class="form-label">Harga Produk</label>
                <?php
                    $count_product_magnitude_old = count(old('product_magnitudes', []));

                    // if not exists product magnitude old
                    if ($count_product_magnitude_old <= 0) $count_product_magnitude_old = 1;
                    for($i = 0; $i < $count_product_magnitude_old; $i++) :

                    // if not first looping
                    if ($i != 0) :
               ?>
                    <div class="mt-3">
                <?php else : ?>
                    <div>
                <?php endif; ?>
                        <div class="input-group">
                            <input class="form-input" type="text" placeholder="Besaran..."
                            name="product_magnitudes[]" value="<?= old('product_magnitudes')[$i]??null; ?>">
                            <input class="form-input" type="number" placeholder="Harga..."
                            name="product_prices[]" value="<?= old('product_prices')[$i]??null; ?>">
                    <?php
                        // if not first looping
                        if ($i != 0) :
                    ?>
                           <a class="btn btn--gray-outline" id="remove-form-input-magnitude-price" href="">Hapus</a>
                    <?php endif; ?>
                        </div>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_magnitudes'][$i]??null; ?></small>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_prices'][$i]??null; ?></small>
                    </div>

                <?php endfor; ?>
                </div><!-- magnitude-price -->
                <small class="form-message form-message--info
                mb-3">Pelajari lebih lanjut <a href="https://github.com/rezafikkri/Point-Of-Sales-Warung/wiki/Produk#harga-produk"
                target="_blank" rel="noreferrer noopener">Harga Produk</a>!</small>

                <a class="btn btn--gray-outline me-2" id="add-form-input-magnitude-price" href="">
                Tambah Form Harga Produk</a><button class="btn btn--blue" type="submit">Simpan</button>
            </form>
        </div><!-- main__box -->
    </div>
    </div>
</div>
</main>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('dist/js/create_product.posw.min.js'); ?>"></script>
<?= $this->endSection(); ?>
