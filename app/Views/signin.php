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
<body>

<main class="container-fluid d-flex justify-content-center height-100vh align-items-center">
    <div class="signin">
        <div class="signin__head text-center">
            <img src="<?= base_url('/dist/images/posw.svg'); ?>" width="100" class="mb-4">
            <h5 class="mb-4">Sign in ke POSW</h5>
        </div>
        <div class="signin__body">
            <?= form_open(); ?>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" class="form-input">
                    <small class="form-message form-message--danger">Please enter your password!</small>
                </div>
                
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-input">
                </div>

                <button type="submit" class="btn btn--blue">Sign In</button>
            </form>
        </div>
    </div>
</main>

</body>
</html>






