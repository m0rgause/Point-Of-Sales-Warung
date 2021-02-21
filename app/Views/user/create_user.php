<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Buat Pengguna</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/pengguna" class="btn btn--gray-outline">Batal</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="row">
    <div class="col-md-8">
        <div class="main__box">
            <?= form_open('/admin/simpan_pengguna_ke_db'); ?>
                <div class="mb-3">
                    <label class="form-label" for="full-name">Nama Lengkap</label>
                    <input class="form-input" id="full-name" type="text" name="full_name" value="<?= old('full_name'); ?>">
                    <?= $_SESSION['form_errors']['full_name']??null; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-input" type="text" id="username" name="username" value="<?= old('username'); ?>">
                    <?= $_SESSION['form_errors']['username']??null; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="level">Tingkat</label>
                    <select class="form-select" name="level" id="level">
                    <?php
                        $levels = ['kasir','admin'];
                        for($i = 0; $i < 2; $i++) :
                    ?>
                        <option value="<?= $levels[$i]; ?>" <?= $levels[$i]===old('level')?'selected':''; ?>><?= ucfirst($levels[$i]); ?></option>
                    <?php endfor; ?>
                    </select>
                    <?= $_SESSION['form_errors']['level']??null; ?>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                     <div class="input-group">
                        <input class="form-input" type="password" id="password" name="password">
                        <a class="btn btn--gray-outline" id="show-password" href=""><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg></a>
                        <a class="btn btn--gray-outline" id="generate-password" href="">Buat</a>
                    </div>
                    <?= $_SESSION['form_errors']['password']??null; ?>
                </div>
                <button class="btn btn--blue" type="submit">Simpan</button>
            </form>
        </div><!-- main__box -->
    </div>
    </div>
</div>
</main>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
// generate password
document.querySelector('a#generate-password').addEventListener('click', (e) => {
    e.preventDefault();

    const chart = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let password = '';

    for(i = 0; i < 8; i++) {
        password += chart[Math.floor(Math.random()*chart.length)];
    }

    document.querySelector('input[name="password"]').value = password;
});

// show password
document.querySelector('a#show-password').addEventListener('click', show_password);
</script>
<?= $this->endSection(); ?>
