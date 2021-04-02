<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('/dist/css/bootstrap-reboot.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/dist/css/bootstrap-grid.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/dist/css/bootstrap-utilities.min.css'); ?>">

    <!-- POSW CSS -->
    <link rel="stylesheet" href="<?= base_url('/dist/css/posw.min.css'); ?>">

    <title>Transaksi . POSW</title>
</head>
<body>

<nav class="navbar container-xxl d-flex justify-content-between align-items-center">
    <ul class="navbar__left">
        <li><a href=""><img src="<?= base_url('/dist/images/posw.svg'); ?>" alt="posw logo" width="80"></a></li>
    </ul>

    <ul class="navbar__right">
        <li class="dropdown"><a href="#" class="dropdown-toggle" target=".dropdown-menu"><?= $_SESSION['posw_user_full_name']; ?></a>
            <ul class="dropdown-menu dropdown-menu--end d-none">
                <li><a href="/sign_out" class="text-hover-red">Sign Out</a></li>
            </ul>
        </li>
    </ul>
</nav>

<header class="header header--cashier">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Transaksi</h4>
    <div class="d-flex flex-fill justify-content-end">
       <div class="input-group me-2">
           <input class="form-input" type="text" name="product_name_search" placeholder="Nama Produk..." autocomplete="false">
           <a class="btn btn--blue" href="#" id="search-product">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
           </a>
       </div><!-- input-group -->
       <a href="#" class="btn btn--blue" title="Lihat keranjang belanja" id="show-cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
        </a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main" data-csrf-name="<?= csrf_token(); ?>" data-csrf-value="<?= csrf_hash(); ?>" data-base-url="<?= base_url(); ?>">
<div class="container-xl">
    <?php
        // if exists product
        if (count($bestseller_products) > 0 || count($products_db) > 0) :
    ?>
        <span class="text-muted me-1 d-block mb-3" id="result-status">
        1 - <?= count($bestseller_products)+count($products_db); ?> dari <?= $product_total; ?> Total produk</span>
    <?php else : ?>
        <span class="text-muted me-1 d-block mb-3" id="result-status">0 Total produk</span>
    <?php endif; ?>

    <h5 class="mb-2 main__title">Produk Terlaris</h5>
    <div class="product mb-5">
    <?php
        // if exists bestseller products
        if (count($bestseller_products) > 0) :
        foreach ($bestseller_products as $bp) :

        $product_sale = $bp['product_sale']??0;
    ?>
        <div class="product__item" data-product-id="<?= $bp['product_id']; ?>">
            <div class="product__image">
                <img src="<?= base_url('dist/images/product_photo/'.$bp['product_photo']); ?>" alt="<?= $bp['product_name']; ?>">
            </div>
            <div class="product__info">
                <p class="product__name"><?= $bp['product_name']; ?></p>
                <p class="product__category"><?= $bp['category_name']; ?></p>
                <p class="product__sale" data-product-sale="<?= $product_sale; ?>">Terjual <?= $product_sale; ?></p>

                <div class="product__price">
                    <h5><?= $bp['product_price'][0]['product_price_formatted']; ?></h5><span>/</span>
                    <select name="magnitude">
                    <?php foreach($bp['product_price'] as $pp) : ?>
                        <option data-product-price="<?= $pp['product_price']; ?>" value="<?= $pp['product_price_id']; ?>">
                        <?= $pp['product_magnitude']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="product__action">
                <input type="number" class="form-input" name="product_qty" placeholder="Jumlah..." min="1">
                <a class="btn" href="#" id="buy-rollback" title="Tambah ke keranjang belanja">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a>
            </div>
        </div><!-- product__item -->
    <?php endforeach; else : ?>
        <p>Produk Terlaris Tidak Ada</p>
    <?php endif; ?>
    </div><!-- product -->

    <h5 class="mb-2 main__title">Produk Lainnya</h5>
    <div class="product">
    <?php
        // if exists other products
        if (count($products_db) > 0) :
        foreach ($products_db as $op) :

        $product_sale = $op['product_sale']??0;
    ?>
        <div class="product__item" data-product-id="<?= $op['product_id']; ?>">
            <div class="product__image">
            <img src="<?= base_url('dist/images/product_photo/'.$op['product_photo']); ?>" alt="<?= $op['product_name']?>">
            </div>
            <div class="product__info">
                <p class="product__name"><?= $op['product_name']; ?></p>
                <p class="product__category"><?= $op['category_name']; ?></p>
                <p class="product__sale" data-product-sale="<?= $product_sale; ?>">Terjual <?= $product_sale; ?></p>

                <div class="product__price">
                    <h5><?= $op['product_price'][0]['product_price_formatted']; ?></h5><span>/</span>
                    <select name="magnitude">
                    <?php foreach($op['product_price'] as $pp) : ?>
                        <option data-product-price="<?= $pp['product_price']; ?>" value="<?= $pp['product_price_id']; ?>">
                        <?= $pp['product_magnitude']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="product__action">
                <input type="number" class="form-input" name="product_qty" placeholder="Jumlah..." min="1">
                <a class="btn" href="#" id="buy-rollback" title="Tambah ke keranjang belanja">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a>
            </div>
        </div><!-- product__item -->
    <?php endforeach; else : ?>
        <p>Produk Tidak Ada</p>
    <?php endif; ?>
    </div><!-- product -->

    <?php
        // if product show total = product limit
        if (count($bestseller_products)+count($products_db) === $bestseller_product_limit+$product_limit) :
    ?>
        <span id="limit-message" class="text-muted d-block mb-5">
        Hanya <?= $bestseller_product_limit+$product_limit; ?> Produk yang ditampilkan, Pakai fitur
        <i>Pencarian</i> untuk hasil lebih spesifik!</span>
    <?php endif; ?>
</div><!-- container-xl -->

<div class="loading-bg position-absolute top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center d-none" id="transaction-loading">
    <div class="loading position-fixed top-50">
        <div></div>
    </div>
</div>

<aside class="cart">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Keranjang Belanja</h5>
        <a class="btn btn--light" href="#" title="Tutup Keranjang Belanja" id="btn-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
        </a>
    </div>

    <div class="position-relative">
    <div class="table-responsive mb-3">
        <table class="table table--auto-striped">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">Aksi</th>
                    <th>Produk</th>
                    <th>Harga / Besaran</th>
                    <th width="10">Jumlah</th>
                    <th>Bayaran</th>
                </tr>
            </thead>
            <tbody>
                <tr id="empty-shopping-cart"><td colspan="7"></td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Total Semua</th>
                    <td id="total-qty" data-total-qty="0">0</td>
                    <td id="total-payment" data-total-payment="0">Rp 0</td>
                </tr>
            </tfoot>
        </table>
    </div><!-- table-responsive -->

    <div class="mb-3" id="customer-money">
        <input class="form-input" type="number" placeholder="Uang Pembeli..." name="customer_money">
    </div>
    <input class="form-input mb-3" type="text" placeholder="Kembalian..." disabled="" name="change_money">

    <a id="rollback-transaction" class="btn btn--gray-outline d-block" href="#">Rollback Transaksi</a>
    <small class="text-muted d-block mt-2 mb-4">
        Pelajari lebih lanjut <a href="https://github.com/rezafikkri/Point-Of-Sales-Warung/wiki/Rollback-Transaksi" target="_blank" rel="noreferrer noopener">
        Rollback Transaksi</a>!
    </small>

    <a class="btn btn--gray-outline me-2" id="cancel-transaction" href="">
    Batal</a><a class="btn btn--blue mb-3" id="finish-transaction" href="#">Selesai</a>

    <div class="loading-bg position-absolute top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center d-none" id="cart-loading">
        <div class="loading">
            <div></div>
        </div>
    </div>
    </div><!-- position-relative -->
</aside>
</main>

<div class="modal modal--blue">
    <div class="modal__content">
        <a class="btn btn--light" id="btn-close" href=""><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
        <div class="modal__icon mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" fill="currentColor" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.93 4.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
        </div>
        <div class="modal__body">
            <h4 class="mb-2">Rollback Transaksi</h4>
            <p class="mb-4">Pilih riwayat transaksi jika ingin melakukan Rollback Transaksi lalu klik Oke!
            </p>
            <select name="transactions_three_days_ago" class="form-select mb-4"></select>
            <div class="position-relative d-inline-block">
                <a class="btn btn--blue-outline" href="#" id="show-transaction-detail">Oke</a>

                <div class="loading-bg rounded position-absolute top-0 bottom-0 end-0 start-0 d-flex justify-content-center align-items-center d-none">
                    <div class="loading loading--blue">
                        <div></div>
                    </div>
                </div>
            </div><!-- position-relative -->
        </div><!-- modal__body -->
    </div>
</div><!-- modal -->

<footer class="footer">
<div class="container-xl">
    <ul>
        <li>&copy; 2021 <a href="https://rezafikkri.github.io/" target="_blank" rel="noreferrer noopener">Reza Sariful Fikri</a>
    </li>
        <li>
            <a href="https://github.com/rezafikkri/Point-Of-Sales-Warung/wiki" target="_blank" rel="noreferrer noopener">Bantuan</a>
        </li>
    </ul>
</div>
</footer>

<script src="<?= base_url('dist/js/posw.min.js'); ?>"></script>
<script src="<?= base_url('dist/js/cashier.posw.min.js'); ?>"></script>
</body>
</html>
