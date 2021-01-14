<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header">
<div class="container-xl d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Pengguna</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <a href="/admin/buat_pengguna" class="btn btn--blue">Buat Pengguna</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="main__box">

    <div class="table__reponsive">
         <table class="table table--auto-striped min-width-711">
            <thead>
                <tr>
                    <th class="text-center" colspan="2">Aksi</th>
                    <th>Nama Lengkap</th>
                    <th>Tingkat</th>
                    <th width="300">Sign In Terakhir</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $date_time = new \App\Libraries\DateTime();
                foreach($users_db as $u) :
            ?>
                <tr>
                    <?php if($u['pengguna_id'] !== $_SESSION['posw_user_id']): ?>
                    <td width="10"><a href="" data-user-id="<?= $u['pengguna_id']; ?>" title="Hapus pengguna" class="text-hover-red" id="remove-user">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                    </a></td>
                    <td width="10">
                    <?php else: ?>
                    <td width="10" colspan="2" class="text-center">
                    <?php endif; ?>
                        <a href="/admin/perbaharui_pengguna/<?= $u['pengguna_id']; ?>" title="Perbaharui pengguna"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/></svg></a>
                    </td>

                    <td><?= $u['nama_lengkap']; ?></td>
                    <td><?= $u['tingkat']; ?></td>
                    <td><?= $date_time->convertTimstampToIndonesianDateTime($u['sign_in_terakhir']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div><!-- table_responsive -->

    </div><!-- main_box  -->
</div>
</main>
<?= $this->endSection(); ?>
