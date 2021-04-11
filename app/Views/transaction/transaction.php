<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--transaction">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Transaksi</h4>

    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <div class="input-group me-0 me-sm-2 mb-3 mb-sm-0">
           <input type="text" id="transaction-date-range" name="transaction_date_range" placeholder="Pilih Rentang Waktu...">
           <a class="btn btn--blue" href="#" id="search-product">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
           </a>
       </div><!-- input-group -->

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
                <a href="#" class="btn btn--red-outline" title="Hapus transaksi"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg></a>
            </div>
            <div>
                <span class="text-muted me-1" id="result-status">1 - 2 dari 2 Total transaksi</span>
            </div>
        </div><!-- d-flex -->
        <table class="table table--manual-striped min-width-711">
            <thead>
                <tr>
                    <th class="text-center" colspan="2">Aksi</th>
                    <th>Total Produk</th>
                    <th>Total Bayaran</th>
                    <th>Kasir</th>
                    <th>Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table__row-odd">
                    <td width="10"><div class="form-check"><input type="checkbox" id="checkbox" class="form-check-input"></div></td>
                    <td width="10"><a href="" id="show-transaction-detail" data-transaksi-id="1a23" title="Lihat detail transaksi"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>
                    <td>5</td>
                    <td>Rp 22000</td>
                    <td>Dian</td>
                    <td>2 Jam yang lalu</td>
                </tr>
                <tr>
                    <td width="10"><div class="form-check"><input type="checkbox" id="checkbox" class="form-check-input"></div></td>
                    <td width="10"><a href="" id="show-transaction-detail" data-transaksi-id="1a23" title="Lihat detail transaksi"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>
                    <td>3</td>
                    <td>Rp 9000</td>
                    <td>Adelina</td>
                    <td>1 Menit yang lalu</td>
                </tr>
            </tbody>
        </table>
    </div><!-- table-reponsive -->
    </div><!-- main__box -->
</div>
</main>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="<?= base_url('/dist/css/flatpickr.min.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url('dist/js/transaction.posw.min.js'); ?>"></script>
<?= $this->endSection(); ?>
