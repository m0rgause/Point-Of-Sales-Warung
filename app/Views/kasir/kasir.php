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

<nav class="navbar container-xxl d-flex justify-content-between">
    <ul class="navbar__left">
        <li><a href=""><img src="<?= base_url('/dist/images/posw.svg'); ?>" alt="posw logo" width="100"></a></li>
    </ul>

    <ul class="navbar__right">
        <li class="dropdown"><a href="" class="dropdown-toggle" target=".dropdown-menu">Reza Sariful Fikri</a>
            <ul class="dropdown-menu dropdown-menu--end d-none">
                <li><a href="" class="text-hover-red">Sign Out</a></li>
            </ul>
        </li>
    </ul>
</nav>

<header class="header">
<div class="container-xl d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="mb-3 mb-sm-0">Transaksi</h4>
    <ul class="d-flex align-items-center d-sm-block">
        <li class="flex-fill me-2 me-sm-1">
            <div class="input-group">
                <input class="form-input" type="text" placeholder="Nama Barang...">
                <div class="input-group__append">
                <a class="btn btn--gray" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
                </a>
                </div>
            </div><!-- input-group -->
        </li>
        <li><a href="" class="btn btn--gray" title="Lihat keranjang belanja" id="show-cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
        </a></li>
    </ul>
</div><!-- container-xl -->
</header>

<main class="container-xl">
    <div class="product">
        <h5 class="mb-2">Produk Terlaris</h5>
        <div class="product__populer">

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/apple [noupload].jpg'); ?>" alt="Apple">
                </div>
                <div class="product__info">
                    <p class="product__name">iPhone 12 Pro</p>
                    <p class="product__category">Handphone</p>
                    <p class="product__sales">Terjual 11</p>

                    <div class="product__price">
                        <h5>Rp 50.000</h5><span>/</span>
                        <select name="besaran">
                            <option value="">1 Buah</option>
                        </select>
                    </div>
                </div>
                <div class="product__action">
                    <input type="number" class="form-input" placeholder="Jumlah...">
                    <a class="btn" href="" title="Tambah ke keranjang belanja">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/lensa2 [noupload].jpg'); ?>" alt="Lensa">
                </div>
                <div class="product__info">
                    <p class="product__name">Lensa Fix 50mm Canon</p>
                    <p class="product__category">Lensa</p>
                    <p class="product__sales">Terjual 100</p>

                    <div class="product__price">
                        <h5>Rp 50.000</h5><span>/</span>
                        <select name="besaran">
                            <option value="">1 Buah</option>
                        </select>
                    </div>
                </div>
                <div class="product__action">
                    <input type="number" class="form-input" placeholder="Jumlah...">
                    <a class="btn" href="" title="Tambah ke keranjang belanja">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

        </div><!-- product__populer -->

        <h5 class="mb-2 mt-5">Produk Lainnya</h5>
        <div class="product__more mb-5">

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/handphone [noupload].jpg'); ?>" alt="Samsung">
                </div>
                <div class="product__info">
                    <p class="product__name">Galaxy S20 FE</p>
                    <p class="product__category">Handphone</p>
                    <p class="product__sales">Terjual 5</p>

                    <div class="product__price">
                        <h5>Rp 3.249.000</h5><span>/</span>
                        <select name="besaran">
                            <option value="">1 Buah</option>
                        </select>
                    </div>
                </div>
                <div class="product__action">
                    <input type="number" class="form-input" placeholder="Jumlah...">
                    <a class="btn" href="" title="Tambah ke keranjang belanja">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

        </div><!-- product__more -->

        <div class="d-flex justify-content-center">
            <div class="position-relative">
                <a class="btn btn--blue-outline btn--disabled" id="show_more_product" href="">Lihat Lebih Banyak
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg>
                </a>

                <div class="loading-bg rounded position-absolute top-0 bottom-0 end-0 start-0 d-flex justify-content-center align-items-center">
                    <div class="loading">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- product -->

    <aside class="cart">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Keranjang Belanja</h5>
            <a class="btn btn--close" href="#" title="Tutup Keranjang Belanja">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
            </a>
        </div>

        <div class="position-relative">
        <div class="table-responsive mb-3">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Aksi</th>
                        <th>Barang</th>
                        <th>Harga / Besaran</th>
                        <th width="10">Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="10"><a href="#" title="Hapus barang" class="text-hover-red">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                        </a></td>
                        <td width="10"><a href="#" title="Tambah jumlah barang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                        </a></td>
                        <td width="10"><a href="#" title="Kurang jumlah barang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
                        </a></td>

                        <td>Mie Goreng</td>
                        <td>Rp 3.000 / 1 Buah</td>
                        <td>3</td>
                        <td>Rp 9.000</td>
                    </tr>

                    <tr>
                        <td width="10"><a href="#" title="Hapus barang" class="text-hover-red">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                        </a></td>
                        <td width="10"><a href="#" title="Tambah jumlah barang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                        </a></td>
                        <td width="10"><a href="#" title="Kurang jumlah barang">
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

<!-- <a class="btn btn\-\-blue" href="" id="show-modal">Show Modal</a> -->

<div class="modal">
    <div class="modal__content">
        <a class="btn btn--close" href=""><svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
        <div class="modal__icon mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" fill="currentColor" viewBox="0 0 16 16"><path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z"/></svg>
        </div>
        <div class="modal__body mb-5">
            <h4 class="mb-2">Konfirmasi Hapus Mie Goreng</h4>
            <p>Yakin mau menghapus Mie Goreng dari keranjang belanja?</p>
        </div>
        <a class="btn btn--red-outline" href="">Ya, Hapus</a>
    </div>
</div>

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
cart.querySelector('a.btn--close').addEventListener('click', (e) => {
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

document.querySelector('a#show-modal').addEventListener('click', show_modal);
modal_content.querySelector('a.btn--close').addEventListener('click', hide_modal);

</script>
</body>
</html>
