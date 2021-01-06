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

<nav class="navbar">
<div class="container-xxl d-flex justify-content-between align-items-center">
    <ul class="navbar__left">
        <li><a href=""><img src="<?= base_url('/dist/images/posw.svg'); ?>" alt="posw logo" width="100"></a></li>
    </ul>

    <a class="btn btn--toggler" href="">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg>
    </a>

    <ul class="navbar__right navbar__right--collapse">
        <li><a href="">Kategori Produk</a></li>
        <li><a href="">Produk</a></li>
        <li><a href="" class="navbar__link--active">Transaksi</a></li>
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

<header class="header header--transaction">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Produk</h4>
    <div class="d-flex justify-content-end align-items-start flex-fill">
        <select class="form-select me-2" name="bulan">
            <option>Januari 2021</option>
            <option>Desember 2020</option>
            <option>November 2020</option>
        </select>
        <a href="" class="btn btn--blue" title="Ekspor ke excel"><svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path d="M6 12v-2h3v2H6z"/><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3V9z"/></svg></a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="main__box">

    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-fill">
                <a href="#" class="btn btn--red-outline" title="Hapus produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg></a>
            </div>
            <div>
                <span id="page_position" class="me-2 text-muted">1 -</span><span id="page_total" class="me-3 text-muted">5 Hal</span>
                <a id="prev" class="btn btn--light me-1" href=""><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg></a>
                <a href="" class="btn btn--light" id="next"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
</svg></a>
            </div>
        </div><!-- d-flex -->
        <table class="table table--manual-striped min-width-711">
            <thead>
                <tr>
                    <th class="text-center" colspan="2">Aksi</th>
                    <th>Total Produk</th>
                    <th>Total Bayaran</th>
                    <th>Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table__row-odd">
                    <td width="10"><div class="form-check"><input type="checkbox" id="checkbox" class="form-check-input"></div></td>
                    <td width="10"><a href="" id="show-transaction-detail" data-transaksi-id="1a23" title="Lihat detail transaksi"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>
                    <td>5</td>
                    <td>Rp 22000</td>
                    <td>2 Jam yang lalu</td>
                </tr>
                <tr>
                    <td width="10"><div class="form-check"><input type="checkbox" id="checkbox" class="form-check-input"></div></td>
                    <td width="10"><a href="" id="show-transaction-detail" data-transaksi-id="1a23" title="Lihat detail transaksi"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>
                    <td>3</td>
                    <td>Rp 9000</td>
                    <td>1 Menit yang lalu</td>
                </tr>
            </tbody>
        </table>
    </div><!-- table-reponsive -->
    </div><!-- main__box -->
</div>
</main>

<footer class="footer">
<div class="container-xl">
    <p class="mb-0">Copyright &copy; <a href="">Reza Sariful Fikri</a> 2020</p>
</div>
</footer>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
<script>
// show hide transaction detail
const tbody = document.querySelector('table.table tbody');
tbody.addEventListener('click', (e) => {
    let target = e.target;
    if(target.getAttribute('id') !== 'show-transaction-detail') target = target.parentElement;
    if(target.getAttribute('id') !== 'show-transaction-detail') target = target.parentElement;
    if(target.getAttribute('id') === 'show-transaction-detail') {
        e.preventDefault();

        // if next element sibling exists and next element sibling is tr.table__row-details
        const table_row_details = target.parentElement.parentElement.nextElementSibling;
        if(table_row_details !== null && table_row_details.classList.contains('table__row-details')) {
            table_row_details.classList.toggle('table__row-details--show');

        // if next element sibling not exits or next element sibling is not tr.table__row-details
        } else if(table_row_details === null || !table_row_details.classList.contains('table__row-details')) {
            const tr = document.createElement('tr');
            tr.classList.add('table__row-details');
            tr.classList.add('table__row-details--show');
            tr.setAttribute('id',`transaksi_id_${target.dataset.transaksiId}`);
            tr.innerHTML = `<td colspan="5"><ul>
                <li><span class="table__title">Mie Duo</span>
                <span class="table__information">Harga :</span><span class="table__data">Rp 3500 / 1 Bungkus</span>
                <span class="table__information">Jumlah :</span><span class="table__data">2</span>
                <span class="table__information">Bayaran :</span><span class="table__data">Rp 7000</span></li>

                <li><span class="table__title">Telur</span>
                <span class="table__information">Harga :</span><span class="table__data">Rp 2000 / 1 Buah</span>
                <span class="table__information">Jumlah :</span><span class="table__data">1</span>
                <span class="table__information">Bayaran :</span><span class="table__data">Rp 2000</span></li>
            </ul></td>`;
           target.parentElement.parentElement.after(tr);
        }
    }
});
</script>
</body>
</html>

