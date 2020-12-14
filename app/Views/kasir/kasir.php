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

<div class="header">
    <div class="mb-3 d-flex justify-content-between">
        <img src="<?= base_url('/dist/images/posw.svg'); ?>" width="100" alt="Posw logo">
        <a href=""><span>Reza Sariful Fikri</span></a>
    </div>
    <div class="sticky-top d-flex justify-content-between">
        <h4>Transaksi</h4>
        <div class="d-flex align-items-center">
            <span class="header__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="%23333" class="bi bi-cart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
            </span>

            <div class="input-group">
                <input type="text" name="nama-barang" class="form-input">
                <div class="input-group__append">
                    <a class="btn btn--blue" href="">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="%23333" class="bi bi-search" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
                    </a>
                </div>
            </div><!-- input-group -->
        </div><!-- d-flex -->
    </div><!-- sticky d-flex jutify-content-between -->
</div>

<main class="container-fluid">
    <div class="product">
        <p></p>
    </div>

    <aside class="cart d-none">
        <h5>Keranjang Belanja</h5>
    </aside>
</main>

</body
</html>
