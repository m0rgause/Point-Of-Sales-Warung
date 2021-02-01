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
        <li class="dropdown"><a href="#" class="dropdown-toggle" target=".dropdown-menu">Reza Sariful Fikri</a>
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
           <input class="form-input" type="text" placeholder="Nama Produk...">
           <a class="btn btn--blue" href="">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
           </a>
       </div><!-- input-group -->
       <a href="" class="btn btn--blue" title="Lihat keranjang belanja" id="show-cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
        </a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <h5 class="mb-2">Produk Terlaris</h5>
    <div class="product mb-5">
    <?php
        $fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

        // if exists bestseller products
        if (count($bestseller_products) > 0) :
        foreach ($bestseller_products as $bp) :
    ?>
        <div class="product__item">
            <div class="product__image">
                <img src="<?= base_url('dist/images/product_photo/'.$bp['product_photo']); ?>" alt="<?= $bp['product_name']; ?>">
            </div>
            <div class="product__info">
                <p class="product__name"><?= $bp['product_name']; ?></p>
                <p class="product__category"><?= $bp['category_name']; ?></p>
                <p class="product__sales">Terjual <?= $bp['number_product']; ?></p>

                <div class="product__price">
                    <h5><?= $fmt->formatCurrency($bp['product_price'][0]['product_price'], 'IDR'); ?></h5><span>/</span>
                    <select name="besaran">
                    <?php foreach($bp['product_price'] as $pp) : ?>
                        <option data-product-price="<?= $fmt->formatCurrency($pp['product_price'], 'IDR'); ?>" value="<?= $pp['product_price_id']; ?>">
                        <?= $pp['product_magnitude']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="product__action">
                <input type="number" class="form-input" placeholder="Jumlah..." min="1">
                <a class="btn" href="" title="Tambah ke keranjang belanja">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a>
            </div>
        </div><!-- product__item -->
    <?php endforeach; else : ?>
        <p>Produk Terlaris Tidak Ada</p>
    <?php endif; ?>
    </div><!-- product -->

    <h5 class="mb-2">Produk Lainnya</h5>
    <div class="product mb-5">
    <?php
        // if exists other products
        if (count($other_products) > 0) :
        foreach ($other_products as $op) :
    ?>
        <div class="product__item">
            <div class="product__image">
            <img src="<?= base_url('dist/images/product_photo/'.$op['product_photo']); ?>" alt="<?= $op['product_name']?>">
            </div>
            <div class="product__info">
                <p class="product__name"><?= $op['product_name']; ?></p>
                <p class="product__category"><?= $op['category_name']; ?></p>
                <p class="product__sales">Terjual <?= $op['number_product']??0; ?></p>

                <div class="product__price">
                    <h5><?= $fmt->formatCurrency($op['product_price'][0]['product_price'], 'IDR'); ?></h5><span>/</span>
                    <select name="besaran">
                    <?php foreach($op['product_price'] as $pp) : ?>
                        <option data-product-price="<?= $fmt->formatCurrency($pp['product_price'], 'IDR'); ?>" value="<?= $pp['product_price_id']; ?>">
                        <?= $pp['product_magnitude']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="product__action">
                <input type="number" class="form-input" placeholder="Jumlah..." min="1">
                <a class="btn" href="" title="Tambah ke keranjang belanja">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a>
            </div>
        </div><!-- product__item -->
    <?php endforeach; else : ?>
        <p>Produk Tidak Ada</p>
    <?php endif; ?>
    </div><!-- product -->

    <div class="d-flex justify-content-center">
        <div class="position-relative">
            <a class="btn btn--blue-outline" id="show_more_product" href="">Lihat Lebih Banyak
                <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg>
            </a>

            <div class="loading-bg rounded position-absolute top-0 bottom-0 end-0 start-0 d-flex justify-content-center align-items-center d-none">
                <div class="loading">
                    <div></div>
                </div>
            </div>
        </div>
    </div>

</div><!-- container-xl -->

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
                <tr>
                    <td width="10"><a href="#" title="Hapus produk" class="text-hover-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Tambah jumlah produk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Kurang jumlah produk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
                    </a></td>

                    <td>Mie Goreng</td>
                    <td>Rp 3.000 / 1 Buah</td>
                    <td>3</td>
                    <td>Rp 9.000</td>
                </tr>

                <tr>
                    <td width="10"><a href="#" title="Hapus produk" class="text-hover-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Tambah jumlah produk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Kurang jumlah produk">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
                    </a></td>

                    <td>Minyak Sanco</td>
                    <td>Rp 3.000 / 1 Kg</td>
                    <td>3</td>
                    <td>Rp 9.000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Total Semua</th>
                    <td>6</td>
                    <td>Rp 18.000</td>
                </tr>
            </tfoot>
        </table>
    </div><!-- table-responsive -->

    <div class="mb-3">
        <select name="history_transaction" class="form-select">
            <option selected>Riwayat transaksi</option>
            <option value="08:00:00_25-12-2020_4000">08:00 - 25 Des 2020 - Rp 4.000</option>
        </select>
        <small class="form-message form-message--info">Pilih riwayat transaksi jika ingin melakukan Rollback transaksi!</small>
    </div>
    <input class="form-input mb-3" type="number" placeholder="Uang Pembeli..." name="uang_pembeli">
    <input class="form-input mb-4" type="text" placeholder="Kembalian..." disabled="" name="kembalian">

    <a class="btn btn--gray-outline me-2" href="">Batal</a>
    <a class="btn btn--blue mb-3" href="#">Selesai</a>

    <div class="loading-bg position-absolute top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center d-none">
        <div class="loading">
            <div></div>
        </div>
    </div>
    </div><!-- position-relative -->
</aside>
</main>

<footer class="footer">
<div class="container-xl">
    <p class="mb-0">Copyright &copy; <a href="https://rezafikkri.github.io/" target="_blank" rel="noreferrer noopener">Reza Sariful Fikri</a> 2020</p>
</div>
</footer>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
<script>
// show cart
const cart = document.querySelector('aside.cart');
document.querySelector('a#show-cart').addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.add('cart--animate-show');
    setTimeout(() => {
        cart.classList.remove('cart--animate-show');
        cart.classList.add('cart--show');

        // if window less than 991.98px add overflow hidden to body tag
        if(window.screen.width <= 991.98) {
            document.querySelector('body').classList.add('overflow-hidden');
        }
    }, 501);
});

// hide cart
cart.querySelector('a#btn-close').addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.replace('cart--show', 'cart--animate-hide');
    setTimeout(() => {
        cart.classList.remove('cart--animate-hide');
    }, 501);

    // remove class overflow hidden in tag body
    document.querySelector('body').classList.remove('overflow-hidden');

});

// show hide modal
const modal = document.querySelector('.modal');
const modal_content = modal.querySelector('.modal__content');

document.querySelector('a#show-modal').addEventListener('click', (e) => {
    e.preventDefault();
    show_modal(modal, modal_content);
});
modal_content.querySelector('a#btn-close').addEventListener('click', (e) => {
    e.preventDefault();
    hide_modal(modal, modal_content);
});

</script>
</body>
</html>
