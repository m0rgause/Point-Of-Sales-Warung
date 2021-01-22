<?= $this->extend('admin_layout'); ?>

<?= $this->section('main'); ?>
<header class="header header--product">
<div class="container-xl d-flex flex-column flex-sm-row justify-content-between flex-wrap">
    <h4 class="mb-4 mb-sm-0 me-2 flex-fill">Produk</h4>
    <div class="d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-start flex-fill">
        <div class="input-group me-0 me-sm-2 mb-3 mb-sm-0">
           <input class="form-input" type="text" placeholder="Nama Produk...">
           <div class="input-group__append">
           <a class="btn btn--blue" href="" id="search-product">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/></svg>
           </a>
           </div>
       </div><!-- input-group -->
       <a href="/admin/buat_produk" class="btn btn--blue">Buat Produk</a>
    </div><!-- d-flex -->
</div><!-- container-xl -->
</header>

<main class="main">
<div class="container-xl">
    <div class="main__box">

    <div class="position-relative">
    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-fill">
                <a href="#" class="btn btn--red-outline" title="Hapus produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg></a>
            </div>
            <div>
                <span id="page_position" data-page-position="1" class="me-2 text-muted">
                1 -</span><span id="page_total" class="me-3 text-muted" data-page-total="<?= $page_total; ?>"><?= $page_total; ?> Hal</span>

                <a id="prev" class="btn btn--light btn--disabled me-1" href=""><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg></a>
            <?php
                // if page total = 1
                if($page_total == 1) :
            ?>
                <a href="" class="btn btn--light btn--disabled" id="next">
            <?php else : ?>
                <a href="" class="btn btn--light" id="next">
            <?php endif; ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
</svg>
                </a>
            </div>
        </div><!-- d-flex -->
        <table class="table table--manual-striped min-width-711" data-csrf-name="<?= csrf_token(); ?>" data-csrf-value="<?= csrf_hash(); ?>">
            <thead>
                <tr>
                    <th class="text-center" colspan="3">Aksi</th>
                    <th>Nama Produk</th>
                    <th width="100">Status</th>
                    <th width="230">Waktu Buat</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $date_time = new \App\Libraries\DateTime();

                // if exists product
                if(count($products_db) > 0) :
                $i = 1;
                foreach($products_db as $p) :

                // if $i is prime number
                if(($i%2) !== 0) :
            ?>
                <tr class="table__row-odd">
            <?php else : ?>
                <tr>
            <?php endif; ?>
                    <td width="10">
                        <div class="form-check">
                            <input type="checkbox" id="checkbox" class="form-check-input" value="<?= $p['produk_id']; ?>">
                        </div>
                    </td>
                    <td width="10"><a href="" title="Ubah Produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/></svg></a></td>
                    <td width="10"><a href="#" id="show-product-detail" data-product-id="<?= $p['produk_id']; ?>" title="Lihat detail produk"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>

                    <td><?= $p['nama_produk']; ?></td>
                    <?php if($p['status_produk'] === 'ada') : ?>
                    <td><span class="text-green">Ada</span></td>
                    <?php else : ?>
                    <td><span class="text-red">Tidak Ada</span></td>
                    <?php endif; ?>
                    <td><?= $date_time->convertTimstampToIndonesianDateTime($p['waktu_buat']); ?></td>
                </tr>
            <?php $i++; endforeach; else : ?>
                <tr colspan="4" class="table__row-odd">
                    <td>Produk tidak ada</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div><!-- table-reponsive -->

    <div class="loading-bg position-absolute top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center d-none">
        <div class="loading">
            <div></div>
        </div>
    </div>
    </div><!-- position-relative -->
    </div><!-- main__box -->
</div>
</main>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
// show hide transaction detail
const table = document.querySelector('table.table');
table.querySelector('tbody').addEventListener('click', e => {
    let target = e.target;
    if(target.getAttribute('id') !== 'show-product-detail') target = target.parentElement;
    if(target.getAttribute('id') !== 'show-product-detail') target = target.parentElement;
    if(target.getAttribute('id') === 'show-product-detail') {
        e.preventDefault();

        // if next element sibling exists and next element sibling is tr.table__row-details
        const table_row_details = target.parentElement.parentElement.nextElementSibling;
        if(table_row_details !== null && table_row_details.classList.contains('table__row-details')) {
            table_row_details.classList.toggle('table__row-details--show');

        // if next element sibling not exits or next element sibling is not tr.table__row-details
        } else if(table_row_details === null || !table_row_details.classList.contains('table__row-details')) {
            const product_id = target.dataset.productId;
            const csrf_name = table.dataset.csrfName;
            const csrf_value = table.dataset.csrfValue;

            // loading
            table.parentElement.nextElementSibling.classList.remove('d-none');
            // disabled button search
            document.querySelector('a#search-product').classList.add('btn--disabled');

            fetch('/admin/show_produk_detail', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `${csrf_name}=${csrf_value}&product_id=${product_id}`
            })
            .finally(() => {
                // loading
                table.parentElement.nextElementSibling.classList.add('d-none');
                // enabled button search
                document.querySelector('a#search-product').classList.remove('btn--disabled');
            })
            .then(response => {
                return response.json();
            })
            .then(json => {
                // set new csrf hash to table tag
                if(json.csrf_value !== undefined) {
                    table.dataset.csrfValue = json.csrf_value;
                }

                // if product price exists
                if(json.product_price.length > 0) {
                    let li = '';
                    json.product_price.forEach(val => {
                        li += `<li><span class="table__title">Harga Produk</span>
                            <span class="table__information">Besaran :</span><span class="table__data">${val.besaran_produk}</span>
                            <span class="table__information">Harga :</span><span class="table__data">Rp ${val.harga_produk}</span></li>`;
                    });
                    const tr = document.createElement('tr');
                    tr.classList.add('table__row-details');
                    tr.classList.add('table__row-details--show');
                    tr.innerHTML = `<td colspan="4"><ul>${li}</ul></td>
                        <td colspan="2"><img src="<?= base_url().'/dist/images/product_photo/'; ?>${json.product_photo}"></td>`;
                    target.parentElement.parentElement.after(tr);
                }
            })
            .catch(error => {
                console.error(error);
            });
        }
    }
});

function pagination(command, page_position_el, page_total_el, next, prev)
{
    let page;
    if(command === 'next') {
        page = parseInt(page_position_el.dataset.pagePosition)+1;
    } else {
        page = parseInt(page_position_el.dataset.pagePosition)-1;
    }
    const csrf_name = table.dataset.csrfName;
    const csrf_value = table.dataset.csrfValue;
    let data = `${csrf_name}=${csrf_value}&page=${page}`;

    // if attribute rel="search" and attribute keyword exists in table tag
    if(table.getAttribute('rel') === 'search' && table.getAttribute('keyword') !== null) {
        data += `&keyword=${table.getAttribute('keyword')}`;
    }

    // loading
    table.parentElement.nextElementSibling.classList.remove('d-none');
    // disabled button search
    document.querySelector('a#search-product').classList.add('btn--disabled');

    fetch('/admin/show_paginasi_produk', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: data
    })
    .finally(() => {
        // loading
        table.parentElement.nextElementSibling.classList.add('d-none');
        // enabled button search
        document.querySelector('a#search-product').classList.remove('btn--disabled');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if(json.csrf_value !== undefined) {
            table.dataset.csrfValue = json.csrf_value;
        }

        // if product exists
        if(json.products_db.length !== 0) {
            let tr = '';
            let i = 1;
            json.products_db.forEach(p => {
                if(i%2 !== 0) {
                    tr += '<tr class="table__row-odd">';
                } else {
                    tr += '<tr>';
                }
                tr += `<td width="10">
                        <div class="form-check">
                            <input type="checkbox" id="checkbox" class="form-check-input" value="${p.produk_id}">
                        </div>
                    </td>
                    <td width="10"><a href="" title="Ubah Produk"><svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/></svg></a></td>
                    <td width="10"><a href="#" id="show-product-detail" data-product-id="${p.produk_id}" title="Lihat detail produk"><svg xmlns="http://www.w3.org/2000/svg" width="21" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></a></td>

                     <td>${p.nama_produk}</td>`;
                if(p.status_produk === 'ada') {
                     tr += `<td><span class="text-green">Ada</span></td>`;
                } else {
                     tr += `<td><span class="text-red">Tidak Ada</span></td>`;
                }
                tr += `<td>${p.waktu_buat}</td></tr>`;

                // increment i
                i++;
            });

            table.querySelector('tbody').innerHTML = tr;

            // change page total and page position
            page_total_el.innerText = `${json.page_total} Hal`;
            page_total_el.dataset.pageTotal = json.page_total;
            page_position_el.innerText = `${page} -`;
            page_position_el.dataset.pagePosition = page;

            // if command = next and page >= page_total
            if(command === 'next' && page >= json.page_total) {
                next.classList.add('btn--disabled');
            }
            // if command = next and if btn prev disabled
            if(command === 'next' && prev.classList.contains('btn--disabled')) {
                prev.classList.remove('btn--disabled');
            }

            // if command = prev and page <= 1
            if(command === 'prev' && page <= 1) {
                prev.classList.add('btn--disabled');
            }
            // if command = prev and if btn next disabled
            if(command === 'prev' && next.classList.contains('btn--disabled')) {
                next.classList.remove('btn--disabled');
            }
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// pagination
const next = document.querySelector('a#next');
const prev = document.querySelector('a#prev');
const page_position_el = document.querySelector('span#page_position');
const page_total_el = document.querySelector('span#page_total');
next.addEventListener('click', e => {
    e.preventDefault();

    pagination('next', page_position_el, page_total_el, next, prev);
});

prev.addEventListener('click', e => {
    e.preventDefault();

    pagination('prev', page_position_el, page_total_el, next, prev);
});
</script>
<?= $this->endSection(); ?>
