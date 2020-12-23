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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
                        </a>
                        </div>
                    </div><!-- input-group -->
                </li>
                <li><a href="" class="btn" title="Lihat keranjang belanja">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                </a></li>
            </ul>
        </div><!-- product__filter -->

        <h5 class="mb-2">Produk Terlaris</h5>
        <div class="product__populer">

            <div class="product__item">
                <div class="product__image">
                    <img src="<?= base_url('dist/images/apple [noupload].jpg'); ?>" alt="Apple">
                    <a class="btn btn--close d-none" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
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
                    <img src="<?= base_url('dist/images/lensa [noupload].jpg'); ?>" alt="Lensa">
                    <a class="btn btn--close d-none" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
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
                    <a class="btn btn--close d-none" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>
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
                <a class="btn btn--blue-outline btn--disabled" href="">Lihat Lebih Banyak
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
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

    <aside class="cart">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Keranjang Belanja</h5>
            <a class="btn btn--close" href="#" title="Tutup Keranjang Belanja">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
            </a>
        </div>
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

        <input class="form-input mb-3" type="text" placeholder="Uang Pembeli...">
        <input class="form-input mb-4" type="text" placeholder="Kembalian..." disabled="">

        <a class="btn btn--gray-outline me-2" href="">Batal</a>
        <a class="btn btn--blue mb-3" href="#">Selesai</a>
    </aside>
</main>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
</body>
</html>
