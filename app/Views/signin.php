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

    <title>Sign in ke POSW</title>
</head>
<body class="p-0">

<main class="container-fluid d-flex justify-content-center height-100vh overflow-x-auto">
    <div class="signin">
        <div class="signin__head text-center">
            <img src="<?= base_url('/dist/images/posw.svg'); ?>" width="100" class="mb-4">
            <h5 class="mb-4">Sign in ke POSW</h5>
        </div>
        <div class="signin__body">
            <?= form_open('/sign_in'); ?>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group">
                        <input type="text" id="username" class="form-input" name="username" value="<?= old('username'); ?>">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg></span>
                    </div>
                    <?= $_SESSION['form_errors']['username']??null; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" class="form-input" name="password">
                        <a id="show-password" href=""><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg></a>
                    </div>
                    <?= $_SESSION['form_errors']['password']??null; ?>
                </div>

                <button type="submit" class="btn btn--blue">Sign In</button>
            </form>
        </div>
    </div>
</main>

<script>
// show password
document.querySelector('a#show-password').addEventListener('click', (e) => {
    e.preventDefault();

    let target = e.target;

    if(target.getAttribute('id') !== 'show-password') target = target.parentElement;
    if(target.getAttribute('id') !== 'show-password') target = target.parentElement;

    if(target.getAttribute('id') === 'show-password') {
        const input = target.previousElementSibling;
        if(input.getAttribute('type') === 'password') {
            input.setAttribute('type','text');
            target.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/></svg>`;
        } else {
            input.setAttribute('type','password');
            target.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg>`;
        }
    }
});
</script>
</body>
</html>
