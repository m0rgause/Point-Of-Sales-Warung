<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header">
<div class="container-xl d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Kategori Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/buat_kategori_produk" class="btn btn--blue">Buat Kategori Produk</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="main__box">

    <div class="position-relative">
    <div class="table-responsive">
        <table class="table table--auto-striped min-width-711" data-csrf-name="<?= csrf_token(); ?>" data-csrf-value="<?= csrf_hash(); ?>">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Aksi</th>
                    <th>Nama Kategori Produk</th>
                    <th width="300">Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $indo_time = new \App\Libraries\IndoTime();

                // if exists category products
                if (count($category_products_db) > 0) :
                foreach($category_products_db as $c) :
            ?>
                <tr>
                    <td width="10"><a href="#" data-category-product-id="<?= $c['kategori_produk_id']; ?>" title="Hapus kategori produk" class="text-hover-red" id="remove-category-product"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg></a></td>
                    <td width="10"><a href="/admin/perbaharui_kategori_produk/<?= $c['kategori_produk_id']; ?>" title="Perbaharui kategori produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/></svg></a></td>

                    <td><?= $c['nama_kategori_produk']; ?></td>
                    <td><?= $indo_time->toIndoLocalizedString($c['waktu_buat']); ?></td>
                </tr>
            <?php endforeach; else : ?>
                <tr>
                    <td colspan="4">Kategori produk tidak ada</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div><!-- table-responsive -->

    <div class="loading-bg position-absolute top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center d-none">
        <div class="loading">
            <div></div>
        </div>
    </div>
    </div><!-- position-relative -->

    </div><!-- main__box -->
</div>
</main>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('dist/js/category_product.posw.min.js'); ?>"></script>
<?= $this->endSection(); ?>
