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

    <title>Buat Produk . POSW</title>
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
        <li><a href="" class="navbar__link--active">Produk</a></li>
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

<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Buat Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="" class="btn btn--gray-outline">Batal</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="row">
    <div class="col-md-8">
        <div class="main__box">
            <?= form_open(); ?>
                <select class="form-select mb-3" name="kategori_produk">
                    <option>Kategori produk...</option>
                    <option value="">Minyak Goreng</option>
                    <option value="">Mie</option>
                    <option value="">Makanan Ringan</option>
                </select>
                <input class="form-input mb-3" type="text" placeholder="Nama produk..." name="nama_produk">
                <div class="mb-3">
                    <div class="form-file">
                        <input type="file" name="foto_produk" id="foto_produk" accept="image/jpeg">
                        <label for="foto_produk">Pilih file...</label>
                    </div>
                    <small class="form-message form-message--info">Ukuran file maksimal 1 MB dan format file harus .jpg!</small>
                </div>
                <select class="form-select mb-3" name="status_produk">
                    <option value="ada">Ada</option>
                    <option value="tidak_ada">Tidak ada</option>
                </select>

                <div class="input-group">
                    <input class="form-input" type="text" placeholder="Besaran..." name="besaran">
                    <input class="form-input" type="text" placeholder="Harga..." name="harga">
                    <a class="btn btn--gray-outline" id="add-form-input-besaran-harga" href="">Tambah</a>
                </div>
            </form>
        </div><!-- main__box -->
    </div>
    </div>
</div>
</main>

<footer class="footer">
<div class="container-xl">
    <p class="mb-0">Copyright &copy; <a href="">Reza Sariful Fikri</a> 2020</p>
</div>
</footer>

<script src="<?= base_url('dist/js/posw.js'); ?>"></script>
<script>
// get file name and replace text in label with it
const form_file = document.querySelector('div.form-file input[type="file"]');
form_file.addEventListener('change', (e) => {
    e.target.nextElementSibling.innerText = e.target.files[0].name;
});

// add form input besaran and harga
const form = document.querySelector('form');
form.addEventListener('click', (e) => {
    if(e.target.getAttribute('id') === 'add-form-input-besaran-harga'){
        add_form_input_besaran_harga(e);
    }
});

// remove form input besaran and harga
form.addEventListener('click', (e) => {
    if(e.target.getAttribute('id') === 'remove-form-input-besaran-harga') {
        e.preventDefault();

        e.target.parentElement.remove();
    }
});
</script>
</body>
</html>
