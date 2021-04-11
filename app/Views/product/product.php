<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Produk</h4>

    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <div class="input-group me-0 me-sm-2 mb-3 mb-sm-0">
           <input class="form-input" type="text" name="product_name_search" placeholder="Nama Produk...">
           <a class="btn btn--blue" href="#" id="search-product">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
           </a>
       </div><!-- input-group -->

       <a href="/admin/buat_produk" class="btn btn--blue">Buat Produk</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main" data-base-url="<?= base_url(); ?>">
<div class="container-xl">
    <div class="main__box">

    <div class="position-relative">
    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-fill">
                <a href="#" id="remove-product" class="btn btn--red-outline" title="Hapus produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg></a>
            </div>
            <div>
            <?php
                $count_products_db = count($products_db);

                // if exists product
                if ($count_products_db > 0) :
            ?>
                <span class="text-muted me-1" id="result-status">1 - <?= $count_products_db;  ?> dari <?= $product_total; ?> Total produk</span>
            <?php else : ?>
                <span class="text-muted me-1" id="result-status">0 Total produk</span>
            <?php endif; ?>
            </div>
        </div><!-- d-flex -->
        <table class="table table--manual-striped min-width-711" data-csrf-name="<?= csrf_token(); ?>" data-csrf-value="<?= csrf_hash(); ?>">
            <thead>
                <tr>
                    <th class="text-center" colspan="3">Aksi</th>
                    <th>Nama Produk</th>
                    <th width="100">Kategori</th>
                    <th width="100">Status</th>
                    <th width="230">Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $indo_time = new \App\Libraries\IndoTime();

                // if exists product
                if ($count_products_db > 0) :
                $i = 1;
                foreach($products_db as $p) :

                // if $i is prime number
                if (($i%2) !== 0) :
            ?>
                <tr class="table__row-odd">
            <?php else : ?>
                <tr>
            <?php endif; ?>
                    <td width="10">
                        <div class="form-check">
                            <input type="checkbox" name="product_id" data-create-time="<?= $p['waktu_buat'] ?>"
                            class="form-check-input" value="<?= $p['produk_id']; ?>">
                        </div>
                    </td>
                    <td width="10"><a href="/admin/perbaharui_produk/<?= $p['produk_id']; ?>" title="Ubah Produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/></svg></a></td>
                    <td width="10"><a href="#" id="show-product-detail" data-product-id="<?= $p['produk_id']; ?>" title="Lihat detail produk"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>

                    <td><?= $p['nama_produk']; ?></td>
                    <td><?= $p['nama_kategori_produk']; ?></td>
                    <?php if ($p['status_produk'] === 'ada') : ?>
                    <td><span class="text-green">Ada</span></td>
                    <?php else : ?>
                    <td><span class="text-red">Tidak Ada</span></td>
                    <?php endif; ?>
                    <td><?= $indo_time->toIndoLocalizedString($p['waktu_buat']); ?></td>
                </tr>
            <?php $i++; endforeach; else : ?>
                <tr class="table__row-odd">
                    <td colspan="7">Produk tidak ada.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    <?php
        // if product show total = product limit
        if ($count_products_db === $product_limit) :
    ?>
        <span id="limit-message" class="text-muted d-block mt-3">Hanya <?= $product_limit; ?> Produk terbaru yang ditampilkan, Pakai fitur
        <i>Pencarian</i> untuk hasil lebih spesifik!</span>
    <?php endif; ?>
    </div><!-- table-reponsive -->

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
<script src="<?= base_url('dist/js/product.posw.min.js'); ?>"></script>
<?= $this->endSection(); ?>
