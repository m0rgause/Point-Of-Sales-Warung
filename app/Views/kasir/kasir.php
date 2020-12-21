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

<nav class="header container-xxl d-flex justify-content-between">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
                        </a>
                        </div>
                    </div><!-- input-group -->
                </li>
                <li><a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a></li>
            </ul>
        </div><!-- product__filter -->

        <h5 class="mb-2">Produk Terlaris</h5>
        <div class="product__populer">

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/apple [noupload].jpg'); ?>" alt="Apple">
                    <a class="btn btn--close d-none" href=""><svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
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
                    <a class="btn" href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/lensa [noupload].jpg'); ?>" alt="Lensa">
                    <a class="btn btn--close d-none" href=""><svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
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
                    <a class="btn" href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

        </div><!-- product__populer -->

        <h5 class="mb-2 mt-5">Produk Lainnya</h5>
        <div class="product__more mb-5">

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/handphone [noupload].jpg'); ?>" alt="Samsung">
                    <a class="btn btn--close d-none" href=""><svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
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
                    <a class="btn" href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div><!-- product__item -->

        </div><!-- product__more -->

        <div class="d-flex justify-content-center">
            <div class="position-relative">
                <a class="btn btn--blue-outline btn--disabled" href="">Lihat Lebih Banyak
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg>
                </a>

                <div class="btn-loading d-flex justify-content-center align-items-center">
                    <div class="loading">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- product -->

    <aside class="cart d-none">
        <h5>Keranjang Belanja</h5>
    </aside>
</main>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
</body>
</html>
