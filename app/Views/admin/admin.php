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

<main class="main">
<div class="container-xl">
<div class="row">
    <div class="col-md-7 pe-md-1 mb-3 mb-md-0">
    <div class="chart">
        <div class="chart__header">
            <h5>Transaksi</h5>
            <p>Dalam 7 hari terakhir</p>
        </div>
        <div class="chart__body"></div>
    </div><!-- chart -->
    </div><!-- col-md-6 -->

    <div class="col-md-5">
    <div class="info-box mb-3">

        <div class="info-box__item info-box__item--blue">
            <div class="info-box__data">
                <h4 class="mb-2">120</h4>
               <p class="me-2 mb-0 d-inline-block">Total Transaksi</p><p class="mb-0 d-inline-block">Jan 2020</p>
            </div>
            <div class="info-box__icon">
               <svg xmlns="http://www.w3.org/2000/svg" width="40" fill="currentColor" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z"/></svg>
            </div>
        </div><!-- infor-box__item -->

        <div class="info-box__item info-box__item--orange">
            <div class="info-box__data">
                <h4 class="mb-0 mb-2">12</h4>
                <p class="me-2 mb-0 d-inline-block">Total Pengguna</p><p class="mb-0 d-inline-block">Jan 2020</p>
            </div>
            <div class="info-box__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" fill="currentColor" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
            </div>
        </div><!-- infor-box__item -->

        <div class="info-box__item info-box__item--green">
            <div class="info-box__data">
                <h4 class="mb-2">400</h4>
                <p class="me-2 mb-0 d-inline-block">Total Barang</p><p class="mb-0 d-inline-block">Jan 2020</p>
            </div>
            <div class="info-box__icon">
               <svg xmlns="http://www.w3.org/2000/svg" width="35" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/></svg>
            </div>
        </div><!-- infor-box__item -->

    </div><!-- info-box -->

    </div><!-- col-md-6 -->
</div><!-- row -->
</div><!-- container-xl -->
</main>

<footer class="footer">
<div class="container-xl">
    <p class="mb-0">Copyright &copy; <a href="">Reza Sariful Fikri</a> 2020</p>
</div>
</footer>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
<script src="<?= base_url('dist/plugins/apexcharts.min.js'); ?>"></script>
<script>
const options = {
    chart: {
        type: 'area',
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false }
    },
    colors: ['#7874f7'],
    series: [{
        name: 'Transaksi',
        data: [250, 123, 320, 210, 410, 350, 450]
    }],
    xaxis: {
        categories: ['22 Dec', '23 Dec', '24 Dec', '25 Dec', '26 Dec', '27 Dec', '1 Dec'],
        labels: {
            style: {
                colors: '#999999',
                fontFamily: 'roboto-regular'
            }
        },
        tooltip: {
            enabled: false
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: '#999999',
                fontFamily: 'roboto-regular'
            }
        }
    },
    dataLabels: {
        enabled: false,
   },
    grid: {
        borderColor: '#e8e8e8',
        strokeDashArray: 4
    }
};
const chart = new ApexCharts(document.querySelector('.chart .chart__body'), options);
chart.render();
</script>
</body>
</html>

