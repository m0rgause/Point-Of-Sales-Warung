<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Perbaharui Kategori Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/kategori_produk" class="btn btn--gray-outline">Kembali</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="row">
    <div class="col-md-8">
        <?= $_SESSION['form_success']['update_category_product']??null; ?>
        <div class="main__box">
            <?= form_open('/admin/perbaharui_kategori_produk_di_db'); ?>
                <input type="hidden" value="<?= $category_product_id; ?>" name="category_product_id">
                <div class="mb-3">
                    <label class="form-label" for="category_product_name">Nama Kategori Produk</label>
                    <input class="form-input" id="category_product_name" type="text"
                            name="category_product_name" value="<?= $category_product_db['nama_kategori_produk']??null; ?>">
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
