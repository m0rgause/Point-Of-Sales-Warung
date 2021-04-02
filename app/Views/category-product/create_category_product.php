<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Buat Kategori Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/kategori_produk" class="btn btn--gray-outline">Batal</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="row">
    <div class="col-md-8">
        <div class="main__box">
            <?= form_open('/admin/simpan_kategori_produk_ke_db'); ?>
                <div class="mb-3">
                    <label class="form-label" for="category-product-name">Nama Kategori</label>
                    <input class="form-input" id="category-product-name" type="text" name="category_product_name" value="<?= old('category_product_name'); ?>">
                    <?= $_SESSION['form_errors']['category_product_name']??null; ?>
                </div>
               <button class="btn btn--blue" type="submit">Simpan</button>
            </form>
        </div><!-- main__box -->
    </div>
    </div>
</div>
</main>
<?= $this->endSection(); ?>
