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
    <?= $this->renderSection('style'); ?>

    <title><?= $title; ?></title>
</head>
<body>

<nav class="navbar">
<div class="container-xxl d-flex justify-content-between align-items-center">
    <ul class="navbar__left">
        <li><a href=""><img src="<?= base_url('/dist/images/posw.svg'); ?>" alt="posw logo" width="80"></a></li>
    </ul>

    <a class="btn btn--toggler" href="">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg>
    </a>

    <ul class="navbar__right navbar__right--collapse">
        <li><a href="/admin" class="<?= active_menu($page, 'navbar__link--active', ['home']); ?>">Home</a></li>
        <li><a href="/admin/kategori_produk" class="<?= active_menu(
            $page,
            'navbar__link--active',
            ['kategori_produk', 'buat_kategori_produk', 'perbaharui_kategori_produk']
        ); ?>">Kategori Produk</a></li>
        <li><a href="/admin/produk" class="<?= active_menu(
            $page,
            'navbar__link--active',
            ['produk', 'buat_produk', 'perbaharui_produk']
        ); ?>">Produk</a></li>
        <li><a href="/admin/transaksi" class="<?= active_menu($page, 'navbar__link--active', ['transaksi']); ?>">Transaksi</a></li>
        <li><a href="/admin/pengguna" class="<?= active_menu(
            $page,
            'navbar__link--active',
            ['pengguna', 'buat_pengguna', 'perbaharui_pengguna']
        ); ?>">Pengguna</a></li>

        <li class="dropdown"><a href="" class="dropdown-toggle" target=".dropdown-menu"><?= $_SESSION['posw_user_full_name']  ?></a>
            <ul class="dropdown-menu dropdown-menu--end d-none">
                <li><a href="/admin/perbaharui_pengguna/<?= $_SESSION['posw_user_id']; ?>">Pengaturan</a></li>
                <li>
                    <hr>
                </li>
                <li><a href="/sign_out" class="text-hover-red">Sign Out</a></li>
            </ul>
        </li>
    </ul>
</div>
</nav>

<?= $this->renderSection('main');  ?>

<footer class="footer">
<div class="container-xl">
    <ul>
        <li>&copy; 2021 <a href="https://rezafikkri.github.io/" target="_blank" rel="noreferrer noopener">Reza Sariful Fikri</a>
    </li>
        <li>
            <a href="https://github.com/rezafikkri/Point-Of-Sales-Warung/wiki" target="_blank" rel="noreferrer noopener">Bantuan</a>
        </li>
    </ul>
</div>
</footer>

<script src="<?= base_url('dist/js/posw.min.js'); ?>"></script>
<?= $this->renderSection('script'); ?>

</body>
</html>
