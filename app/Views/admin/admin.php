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

    <title>Admin . POSW</title>
</head>
<body>

<nav class="navbar">
<div class="container-xxl d-flex justify-content-between align-items-center">
    <ul class="navbar__left">
        <li><a href=""><img src="<?= base_url('/dist/images/posw.svg'); ?>" alt="posw logo" width="100"></a></li>
    </ul>

    <a class="btn btn--toggler" href="">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg>
    </a>

    <ul class="navbar__right navbar__right--collapse">
        <li><a href="">Kategori Barang</a></li>
        <li><a href="">Barang</a></li>
        <li><a href="">Transaksi</a></li>
        <li><a href="">Pengguna</a></li>

        <li class="dropdown"><a href="" class="dropdown-toggle" target=".dropdown-menu">Reza Sariful Fikri</a>
            <ul class="dropdown-menu dropdown-menu--end d-none">
                <li><a href="">Pengaturan</a></li>
                <li>
                    <hr>
                </li>
                <li><a href="" class="text-hover-red">Sign Out</a></li>
            </ul>
        </li>
    </ul>
</div>
</nav>

<header class="header">
<div class="container-xl d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="mb-0">Dashboard</h4>
</div><!-- container-xl -->
</header>


<div class="container-xl">
<main class="main">
    <div class="info-box">

        <div class="info-box__item info-box__item--green">
            <div class="info-box__data">
                <p class="mb-2">Total Transaksi</p>
                <h3 class="mb-0">120K</h3>
            </div>
            <div class="info-box__icon">
               <svg xmlns="http://www.w3.org/2000/svg" width="60" fill="currentColor" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z"/></svg>
            </div>
        </div><!-- infor-box__item -->

        <div class="info-box__item info-box__item--orange">
            <div class="info-box__data">
                <p class="mb-2">Total User</p>
                <h3 class="mb-0">12</h3>
            </div>
            <div class="info-box__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" fill="currentColor" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
            </div>
        </div><!-- infor-box__item -->

        <div class="info-box__item info-box__item--blue">
            <div class="info-box__data">
                <p class="mb-2">Total Barang</p>
                <h3 class="mb-0">400</h3>
            </div>
            <div class="info-box__icon">
               <svg xmlns="http://www.w3.org/2000/svg" width="55" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/></svg>
            </div>
        </div><!-- infor-box__item -->

    </div><!-- info-box -->
</main>
</div><!-- container -->

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
</body>
</html>

