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

<nav class="header container-xxl d-flex justify-content-between sticky-top">
    <ul class="header__left">
        <li><a href=""><img src="<?= base_url('/dist/images/posw.svg'); ?>" alt="posw logo" width="100"></a></li>
    </ul>

    <ul class="header__right">
        <li class="dropdown"><a href="" class="dropdown-toggle" target=".dropdown-menu">Reza Sariful Fikri</a>
            <ul class="dropdown-menu dropdown-menu--end d-none">
                <li><a href="" class="text-hover-red">Sign Out</a></li>
            </ul>
        </li>
    </ul>
</nav>

<main class="container-xl">
    <div class="product">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h4 class="mb-3 mb-sm-0">Transaksi</h4>
            <ul class="product__filter d-flex align-items-center d-sm-block">
                <li class="flex-fill">
                    <div class="input-group">
                        <input class="form-input" type="text" placeholder="Nama Barang...">
                        <div class="input-group__append">
                        <a class="btn" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
                        </a>
                        </div>
                    </div><!-- input-group -->
                </li>
                <li><a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a></li>
            </ul>
        </div><!-- product__filter -->

        <h5>Produk Terlaris</h5>
        <div class="product__populer">

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/apple [noupload].jpg'); ?>" alt="Apple">
                </div>
                <h6>Samsung J Prime Mini</h6>
                <p>Handphone</p>

                <div class="product__price">
                    <select name="besaran">
                        <option value="">1 Buah</option>
                    </select>
                    <p>Rp 3.000</p>
                </div>
                <p class="product__sales">11 Terjual</p>

                <div class="product__action">
                    <input type="number" class="form-input">
                    <a class="btn" href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

        </div><!-- product__populer -->
    </div>

    <aside class="cart d-none">
        <h5>Keranjang Belanja</h5>
    </aside>
</main>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
</body>
</html>
