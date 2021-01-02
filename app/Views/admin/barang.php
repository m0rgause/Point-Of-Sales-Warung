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

    <title>Barang . POSW</title>
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
        <li><a href="" class="navbar__link--active">Barang</a></li>
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

<header class="header header--barang">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Barang</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <div class="input-group me-0 me-sm-2 mb-3 mb-sm-0">
           <input class="form-input" type="text" placeholder="Nama Barang...">
           <div class="input-group__append">
           <a class="btn btn--blue" href="">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
           </a>
           </div>
       </div><!-- input-group -->
       <a href="" class="btn btn--blue">Buat Barang</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="main__box">

    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-fill">
                <a href="#" class="btn btn--red-outline" title="Hapus barang"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg></a>
            </div>
            <div>
                <span id="page_position" class="me-2 text-muted">1 -</span><span id="page_total" class="me-3 text-muted">5 Hal</span>
                <a id="prev" class="btn btn--light" href=""><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg></a>
                <a href="" class="btn btn--light" id="next"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
</svg></a>
            </div>
        </div><!-- d-flex -->
        <table class="table min-width-711">
            <thead>
                <tr>
                    <th class="text-center" colspan="2">Aksi</th>
                    <th>Nama Barang</th>
                    <th>Harga / Besaran</th>
                    <th>Status</th>
                    <th>Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10"><div class="form-check"><input type="checkbox" id="checkbox" class="form-check-input"></div></td>
                    <td width="10"><a href="" title="Ubah Barang"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/></svg></a></td>

                    <td>Mie Goreng</td>
                    <td>Rp 3.000 / 1 Bungkus</td>
                    <td><span class="text-green">Ada</span></td>
                    <td>2 Jam yang lalu</td>
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
</body>
</html>

