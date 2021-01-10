<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header">
<div class="container-xl d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="mb-0">Aktivitas Harian</h4>
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
               <p class="me-2 mb-0 d-inline-block">Total Transaksi</p><p class="mb-0 d-inline-block" title="Transaksi terakhir">5 Jan 2021</p>
            </div>
            <div class="info-box__icon">
               <svg xmlns="http://www.w3.org/2000/svg" width="40" fill="currentColor" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z"/></svg>
            </div>
        </div><!-- infor-box__item -->

        <div class="info-box__item info-box__item--orange">
            <div class="info-box__data">
                <h4 class="mb-0 mb-2">12</h4>
                <p class="me-2 mb-0 d-inline-block">Total Pengguna</p><p class="mb-0 d-inline-block" title="Pengguna terakhir ditambahkan">3 Jan 2020</p>
            </div>
            <div class="info-box__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" fill="currentColor" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
            </div>
        </div><!-- infor-box__item -->

        <div class="info-box__item info-box__item--green">
            <div class="info-box__data">
                <h4 class="mb-2">400</h4>
                <p class="me-2 mb-0 d-inline-block">Total Produk</p><p class="mb-0 d-inline-block" title="Produk terakhir ditambahkan">1 Jan 2021</p>
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
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
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
<?= $this->endSection(); ?>
