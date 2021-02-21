<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Perbaharui Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/produk" class="btn btn--gray-outline">Kembali</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="row">
    <div class="col-md-8">
        <?= $_SESSION['form_errors']['update_product']??null; ?>
        <?= $_SESSION['form_success']['update_product']??null; ?>
        <div class="main__box position-relative">
            <?= form_open_multipart('/admin/perbaharui_produk_di_db'); ?>
                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                <div class="mb-3">
                    <label class="form-label" for="category-product">Kategori Produk</label>
                    <select class="form-select" name="category_product" id="category-product">
                    <?php foreach($category_products_db as $cp) : ?>
                        <option value="<?= $cp['kategori_produk_id']; ?>"
                                <?= $cp['kategori_produk_id']===($product_db['kategori_produk_id']??null)?'selected':''; ?>>
                            <?= $cp['nama_kategori_produk']; ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                    <?= $_SESSION['form_errors']['category_product']??null; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-name">Nama Produk</label>
                    <input class="form-input" type="text" name="product_name" value="<?= $product_db['nama_produk']??null; ?>" id="product-name">
                    <?= $_SESSION['form_errors']['product_name']??null; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-photo">Foto Produk</label>
                    <input type="hidden" value="<?= $product_db['foto_produk']??null; ?>" name="old_product_photo">
                    <div class="form-file">
                        <input type="file" name="product_photo" id="product-photo" accept="image/jpeg">
                        <label for="product_photo">Pilih file...</label>
                    </div>
                    <?= $_SESSION['form_errors']['product_photo']??'<small class="form-message form-message--info">
                    Pilih file jika ingin perbaharui foto produk, ukuran file maksimal 1 MB dan ekstensi file harus .jpg atau .jpeg!</small>'; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-status">Status Produk</label>
                    <select class="form-select" name="product_status" id="product-status">
                    <?php
                        $array_product_status = ['ada'=>'Ada','tidak_ada'=>'Tidak Ada'];
                        foreach($array_product_status as $key=>$value) :
                    ?>
                    <option value="<?= $key; ?>" <?= $key===($product_db['status_produk']??null)?'selected':''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <?= $_SESSION['form_errors']['product_status']??null; ?>
                </div>
                <div id="magnitude-price">
                    <label class="form-label">Harga Produk</label>
                <?php
                    $count_product_price_db = count($product_prices_db);
                    $count_product_magnitude_old = count(old('product_magnitudes', []));

                    if ($count_product_price_db > 0) :
                    for ($i = 0; $i < $count_product_price_db; $i++) :
               ?>
                    <div class="mb-3">
                        <input type="hidden" name="product_price_ids[]" value="<?= $product_prices_db[$i]['harga_produk_id']; ?>">
                        <div class="input-group">
                            <input class="form-input" type="text" placeholder="Besaran..."
                            name="product_magnitudes[]" value="<?= $product_prices_db[$i]['besaran_produk']??null; ?>">
                            <input class="form-input" type="number" placeholder="Harga..."
                            name="product_prices[]" value="<?= $product_prices_db[$i]['harga_produk']??null; ?>">
                    <?php
                        // if not first looping
                        if ($i > 0) : ?>
                            <a class="btn btn--gray-outline" data-product-price-id="<?= $product_prices_db[$i]['harga_produk_id']; ?>"
                               id="remove-form-input-magnitude-price" href="">Hapus</a>
                    <?php endif; ?>
                        </div>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_magnitudes'][$i]??null; ?></small>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_prices'][$i]??null; ?></small>
                    </div><!-- mb-3 -->

                <?php
                    endfor;

                    // else if not exists product magnitude
                    elseif ($count_product_magnitude_old == 0) :
                ?>
                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-input" type="text" placeholder="Besaran..." name="product_magnitudes[]">
                            <input class="form-input" type="number" placeholder="Harga..." name="product_prices[]">
                        </div>
                    </div>
                <?php
                    endif;

                    // if product magnitude old > product price db
                    if ($count_product_magnitude_old > $count_product_price_db) :
                    for ($j = $i; $j < $count_product_magnitude_old; $j++) :
                ?>
                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-input" type="text" placeholder="Besaran..."
                            name="product_magnitudes[]" value="<?= old('product_magnitudes')[$j]??null; ?>"s>
                            <input class="form-input" type="number" placeholder="Harga..."
                            name="product_prices[]" value="<?= old('product_prices')[$j]??null; ?>">
                            <a class="btn btn--gray-outline" id="remove-form-input-magnitude-price" href="">Hapus</a>
                        </div>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_magnitudes'][$j]??null; ?></small>
                        <small class="form-message form-message--danger"><?= $_SESSION['form_errors']['product_prices'][$j]??null; ?></small>
                    </div><!-- mb-3 -->
                <?php endfor; endif; ?>
                </div><!-- magnitude-price -->
                <a class="btn btn--gray-outline me-2" id="add-form-input-magnitude-price" href="">
                Tambah Form Harga Produk</a><button class="btn btn--blue" type="submit">Simpan</button>
            </form>

            <div class="loading-bg position-absolute top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center d-none">
                <div class="loading">
                    <div></div>
                </div>
            </div>
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
const magnitude_price = document.querySelector('div#magnitude-price');
document.querySelector('a#add-form-input-magnitude-price').addEventListener('click', e => {
    e.preventDefault();
    add_form_input_magnitude_price(magnitude_price);
});

// remove product price
magnitude_price.addEventListener('click', e => {
    const target = e.target;
    if (target.getAttribute('id') === 'remove-form-input-magnitude-price') {
        e.preventDefault();

        // if product_price_id exists in btn
        if (target.dataset.productPriceId !== undefined) {
            // remove product price from db
            const csrf_name = "<?= csrf_token(); ?>";
            const csrf_input = document.querySelector(`input[name=${csrf_name}]`);
            const csrf_value = csrf_input.value;
            const product_price_id = target.dataset.productPriceId;

            // loading
            const loading = document.querySelector('div.loading-bg');
            loading.classList.remove('d-none');

            fetch('/admin/hapus_harga_produk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `${csrf_name}=${csrf_value}&product_price_id=${product_price_id}`
            })
            .finally(() => {
                // loading
                loading.classList.add('d-none');
            })
            .then(response => {
                return response.json();
            })
            .then(json => {
                // set new csrf hash to table tag
                if (json.csrf_value !== undefined) {
                    csrf_input.value = json.csrf_value;
                }

                // if fail remove product price
                if (json.success === false && json.error_message !== undefined) {
                    const alert = create_alert_node('alert--warning', `<strong>Peringatan</strong>, ${json.error_message}`);

                    // append alert to before div.main__box element
                    document.querySelector('main.main > div > div > div').insertBefore(alert, document.querySelector('div.main__box'));
                }

                // if success remove product price
                if (json.success === true) {
                    target.parentElement.parentElement.remove();
                }
            })
            .catch(error => {
                console.error(error);
            });

        } else {
            // remove form product price only
            target.parentElement.parentElement.remove();
        }
    }
});
</script>
<?= $this->endSection(); ?>
