<script>
const main = document.querySelector('main.main');
const btn_show_cart = document.querySelector('a#show-cart');
const btn_search_product = document.querySelector('a#search-product');
const btn_cancel_transaction = document.querySelector('a#cancel-transaction');
const btn_finish_transaction = document.querySelector('a#finish-transaction');
const cart_table = document.querySelector('aside.cart table.table');

// show transaction detail in cart
function show_transaction_detail(
    cart_table,
    csrf_name,
    csrf_value,
    btn_show_cart,
    main
) {
    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');
    // disabled button show cart
    btn_show_cart.classList.add('btn--disabled');

    fetch('/kasir/tampil_transaksi_detail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        document.querySelector('div#cart-loading').classList.add('d-none');
        // enabled button show cart
        btn_show_cart.classList.remove('btn--disabled');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if exists transaction detail
        if (json.transaction_detail.length > 0) {
            let tr = '';
            let total_payment = 0;
            let total_qty = 0;

            json.transaction_detail.forEach (td => {
                const payment = parseInt(td.harga_produk) * parseInt(td.jumlah_produk);
                tr += `<tr data-product-id="${td.produk_id}" data-transaction-detail-id="${td.transaksi_detail_id}">
                    <td width="10"><a href="#" title="Hapus produk" id="remove-product"  class="text-hover-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Tambah jumlah produk" id="add-product-qty">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Kurangi jumlah produk" id="reduce-product-qty">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
                    </a></td>

                    <td>${td.nama_produk}</td>
                    <td id="price" data-price="${td.harga_produk}">
                        ${number_formatter_to_currency(parseInt(td.harga_produk))} / ${td.besaran_produk}
                    </td>
                    <td id="qty" data-qty="${td.jumlah_produk}">${td.jumlah_produk}</td>
                    <td id="payment" data-payment="${payment}">${number_formatter_to_currency(payment)}</td>
                </tr>`;

                total_payment += payment;
                total_qty += parseInt(td.jumlah_produk);
            });

            // inner html transaction detail to cart table tbody
            cart_table.querySelector('tbody').innerHTML = tr;

            // inner text total payment and total qty in cart table
            cart_table.querySelector('td#total-qty').innerText = total_qty;
            cart_table.querySelector('td#total-payment').innerText = number_formatter_to_currency(total_payment);
            cart_table.querySelector('td#total-qty').dataset.totalQty = total_qty;
            cart_table.querySelector('td#total-payment').dataset.totalPayment = total_payment;

            // add attribute aria label = transaction
            cart_table.setAttribute('aria-label', 'transaction');
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// show cart
const cart = document.querySelector('aside.cart');
btn_show_cart.addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.add('cart--animate-show');
    setTimeout(() => {
        cart.classList.remove('cart--animate-show');
        cart.classList.add('cart--show');

        // if window less than 991.98px add overflow hidden to body tag
        if(window.screen.width <= 991.98) {
            document.querySelector('body').classList.add('overflow-hidden');
        }
    }, 500);

    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;

    // if not exists attribute aria-label
    if (cart_table.getAttribute('aria-label') === null) {
        // get and show transaction detail in cart
        show_transaction_detail(
            cart_table,
            csrf_name,
            csrf_value,
            e.target,
            main
        );
    }
});

// hide cart
const btn_close_cart = cart.querySelector('a#btn-close');
btn_close_cart.addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.replace('cart--show', 'cart--animate-hide');
    setTimeout(() => {
        cart.classList.remove('cart--animate-hide');
    }, 450);

    // remove class overflow hidden in tag body
    document.querySelector('body').classList.remove('overflow-hidden');
});

// change product price info
function change_product_price_info(e)
{
    const product_price = e.target.selectedOptions[0].dataset.productPrice;
    e.target.previousElementSibling.previousElementSibling.innerText = number_formatter_to_currency(parseInt(product_price));
}

// search product
btn_search_product.addEventListener('click', e => {
    e.preventDefault();

    const container = main.querySelector('div.container-xl');
    const keyword = document.querySelector('input[name="product_name_search"]').value;
    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;

    // if empty keyword
    if (keyword.trim() === '') {
        return false;
    }

    // loading
    container.innerHTML = `<div class="d-flex justify-content-center align-items-center mt-4"><div class="loading"><div></div></div></div>`;
    // disabled button search
    btn_search_product.classList.add('btn--disabled');

    fetch('/kasir/cari_produk', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `keyword=${keyword}&${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // enabled button search
        btn_search_product.classList.remove('btn--disabled');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if product exists
        if (json.products_db.length > 0) {
            let product = `<span class="text-muted me-1 d-block mb-3" id="result-status">
                    1 - ${json.products_db.length} dari ${json.product_search_total} Total produk hasil pencarian</span>`;

            product += '<h5 class="mb-2 main__title">Produk</h5><div class="product mb-4">';

            json.products_db.forEach (p => {
                const product_sales = p.product_sales!==null?p.product_sales:0;

                product += `<div class="product__item" data-product-id="${p.product_id}">
                    <div class="product__image">
                        <img src="<?= base_url('dist/images/product_photo'); ?>/${p.product_photo}" alt="${p.product_name}">
                    </div>
                    <div class="product__info">
                        <p class="product__name">${p.product_name}</p>
                        <p class="product__category">${p.category_name}</p>
                        <p class="product__sales" data-product-sales="${product_sales}">Terjual ${product_sales}</p>

                        <div class="product__price">
                            <h5>${p.product_price[0].product_price}</h5><span>/</span>
                            <select name="magnitude" onchange="change_product_price_info(event)">`;

                            p.product_price.forEach (pp => {
                                product += `<option data-product-price="${pp.product_price}" value="${pp.product_price_id}">
                                        ${pp.product_magnitude}</option>`;
                            });

                product += `</select>
                        </div>
                    </div>
                    <div class="product__action">
                        <input type="number" class="form-input" name="product_qty" placeholder="Jumlah..." min="1">
                        <a class="btn" href="#" id="buy-rollback" title="Tambah ke keranjang belanja">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                        </a>
                    </div>
                </div><!-- product__item -->`;
            });

            product += '</div><!-- product -->';

            // inner html product to container
            container.innerHTML = product;
        }
        // if product not exists
        else {
            let product = `<span class="text-muted me-1 d-block mb-3" id="result-status">0 Total produk hasil pencarian</span>
                <h5 class="mb-2 main__title">Produk</h5><div class="product mb-4">
                <p>Produk tidak ada</p>`;
            container.innerHTML = product
        }

        const limit_message = document.querySelector('span#limit-message');
        // add limit message if product search total = product limit && limit message not exists
        if (json.products_db.length === json.product_limit && limit_message === null) {
            const span = document.createElement('span');
            span.classList.add('text-muted');
            span.classList.add('d-block');
            span.classList.add('mb-5');
            span.setAttribute('id', 'limit-message');
            span.innerHTML = `Hanya ${json.product_limit} Produk terbaru yang ditampilkan, Pakai fitur <i>Pencarian</i> untuk hasil lebih spesifik!`;
            document.querySelector('div.product').after(span);
        }
        // else if product search total != product limit and limit message exists
        else if (json.products_db.length !== json.product_limit && limit_message !== null) {
            limit_message.remove();
        }
    })
    .catch(error => {
        console.error(error);
    });
});

// buy product
function buy_product_transaction(
    target,
    cart_table,
    product_price_id,
    product_qty,
    csrf_name,
    csrf_value,
    btn_search_product,
    btn_cancel_transaction,
    btn_finish_transaction,
    main
) {
    // loading
    document.querySelector('div#transaction-loading').classList.remove('d-none');
    // disabled button search, cancel and finish transaction
    btn_search_product.classList.add('btn--disabled');
    btn_cancel_transaction.classList.add('btn--disabled');
    btn_finish_transaction.classList.add('btn--disabled');

    fetch('/kasir/beli_produk_transaksi', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_price_id=${product_price_id}&product_qty=${product_qty}&${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        document.querySelector('div#transaction-loading').classList.add('d-none');
        // enabled button search, cancel and finish transaction
        btn_search_product.classList.remove('btn--disabled');
        btn_cancel_transaction.classList.remove('btn--disabled');
        btn_finish_transaction.classList.remove('btn--disabled');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if buy product success
        if (json.success === true) {
            // reset form number of product
            target.previousElementSibling.value = '';

            // update product sales
            const product_sales_el = target.parentElement.previousElementSibling.querySelector('p.product__sales');
            const new_product_sales = parseInt(product_qty) + parseInt(product_sales_el.dataset.productSales);
            product_sales_el.innerText = `Terjual ${new_product_sales}`;
            product_sales_el.dataset.productSales = new_product_sales;

            // if attribute aria label = transaction in cart table
            if (cart_table.getAttribute('aria-label') === 'transaction') {
                const product_id = target.parentElement.parentElement.dataset.productId;
                const product_info_el = target.parentElement.previousElementSibling;
                const product_name = product_info_el.querySelector('p.product__name').textContent;
                const product_price = product_info_el.querySelector('select[name="magnitude"]').selectedOptions[0].dataset.productPrice;
                const product_magnitude = product_info_el.querySelector('select[name="magnitude"]').selectedOptions[0].text;
                const payment = parseInt(product_price) * parseInt(product_qty);

                const tr = document.createElement('tr');
                tr.setAttribute('data-product-id', product_id);
                tr.setAttribute('data-transaction-detail-id', json.transaction_detail_id);

                tr.innerHTML = `<td width="10"><a href="#" title="Hapus produk" id="remove-product"  class="text-hover-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M2.037 3.225l1.684 10.104A2 2 0 0 0 5.694 15h4.612a2 2 0 0 0 1.973-1.671l1.684-10.104C13.627 4.224 11.085 5 8 5c-3.086 0-5.627-.776-5.963-1.775z"/><path fill-rule="evenodd" d="M12.9 3c-.18-.14-.497-.307-.974-.466C10.967 2.214 9.58 2 8 2s-2.968.215-3.926.534c-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466zM8 5c3.314 0 6-.895 6-2s-2.686-2-6-2-6 .895-6 2 2.686 2 6 2z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Tambah jumlah produk" id="add-product-qty">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 11.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                    </a></td>
                    <td width="10"><a href="#" title="Kurangi jumlah produk" id="reduce-product-qty">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
                    </a></td>

                    <td>${product_name}</td>
                    <td id="price" data-price="${product_price}">
                        ${number_formatter_to_currency(parseInt(product_price))} / ${product_magnitude}
                    </td>
                    <td id="qty" data-qty="${product_qty}">${product_qty}</td>
                    <td id="payment" data-payment="${payment}">${number_formatter_to_currency(payment)}</td>`;

                // if not exists product in cart table
                if (cart_table.querySelector('tr#empty-shopping-cart') !== null) {
                    cart_table.querySelector('tr#empty-shopping-cart').remove();
                }

                // append tr to cart table
                cart_table.querySelector('tbody').append(tr);

                const total_payment_old = cart_table.querySelector('td#total-payment').dataset.totalPayment;
                const total_qty_old = cart_table.querySelector('td#total-qty').dataset.totalQty;
                const total_payment_new = parseInt(payment) + parseInt(total_payment_old);
                const total_qty_new = parseInt(product_qty) + parseInt(total_qty_old);

                // inner text total payment and total qty in cart table
                cart_table.querySelector('td#total-qty').innerText = total_qty_new;
                cart_table.querySelector('td#total-qty').dataset.totalQty = total_qty_new;
                cart_table.querySelector('td#total-payment').innerText = number_formatter_to_currency(total_payment_new);
                cart_table.querySelector('td#total-payment').dataset.totalPayment = total_payment_new;

                // if customer money has inputed
                let customer_money = document.querySelector('input[name="customer_money"]').value;
                if (customer_money.value !== '') {
                    customer_money = parseInt(customer_money);
                    const total_payment = parseInt(document.querySelector('aside.cart td#total-payment').dataset.totalPayment);

                    if (customer_money >= total_payment) {
                        document.querySelector('input[name="change_money"]').value = number_formatter_to_currency(customer_money - total_payment);
                    } else {
                        document.querySelector('input[name="change_money"]').value = '';
                    }
                }
            }
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// buy product and rollback transaksi
main.querySelector('div.container-xl').addEventListener('click', e => {
    let target = e.target;

    if (target.getAttribute('id') !== 'buy-rollback') target = target.parentElement;
    if (target.getAttribute('id') !== 'buy-rollback') target = target.parentElement;

    if (target.getAttribute('id') === 'buy-rollback') {
        e.preventDefault();

        const product_price_id = target.parentElement.previousElementSibling.querySelector('select[name="magnitude"]').value;
        const product_qty = target.previousElementSibling.value;
        const csrf_name = main.dataset.csrfName;
        const csrf_value = main.dataset.csrfValue;

        // if empty product qty
        if (product_qty.trim() === '') {
            return false;
        }

        // if attribute aria-label = rollback-transaksi and transaksi-id exists in tag table
        if (cart_table.getAttribute('aria-label') === 'rollback-transaksi' && cart_table.getAttribute('transaksi-id' !== null)) {
            // rollback transaction
        } else {
            // buy product transaction
            buy_product_transaction(
                target,
                cart_table,
                product_price_id,
                product_qty,
                csrf_name,
                csrf_value,
                btn_search_product,
                btn_cancel_transaction,
                btn_finish_transaction,
                main
            );
        }
    }
});

// update product quantity
function update_product_qty(
    target,
    cart_table,
    product_qty_new,
    total_qty_new,
    payment_new,
    total_payment_new,
    product_sales_new,
    transaction_detail_id,
    csrf_name,
    csrf_value,
    main
) {
    if (product_qty_new <= 0) {
        return false;
    }

    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/ubah_jumlah_produk', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_qty_new=${product_qty_new}&transaction_detail_id=${transaction_detail_id}&${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        document.querySelector('div#cart-loading').classList.add('d-none');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if update product qty success
        if (json.success === true) {
            // update product qty, total qty, payment, total payment in cart table
            const target_tr = target.parentElement.parentElement;
            target_tr.querySelector('td#qty').innerText = product_qty_new;
            target_tr.querySelector('td#qty').dataset.qty = product_qty_new;
            target_tr.querySelector('td#payment').innerText = number_formatter_to_currency(payment_new);
            target_tr.querySelector('td#payment').dataset.payment = payment_new;
            cart_table.querySelector('td#total-qty').innerText = total_qty_new;
            cart_table.querySelector('td#total-qty').dataset.totalQty = total_qty_new;
            cart_table.querySelector('td#total-payment').innerText = number_formatter_to_currency(total_payment_new);
            cart_table.querySelector('td#total-payment').dataset.totalPayment = total_payment_new;

            // update product sale in product item
            const product_sales_el = document.querySelector(`div.product__item[data-product-id="${target_tr.dataset.productId}"] p.product__sales`);
            product_sales_el.innerText = `Terjual ${product_sales_new}`;
            product_sales_el.dataset.productSales = product_sales_new;

            // if customer money has inputed
            let customer_money = document.querySelector('input[name="customer_money"]').value;
            if (customer_money.value !== '') {
                customer_money = parseInt(customer_money);
                const total_payment = parseInt(document.querySelector('aside.cart td#total-payment').dataset.totalPayment);

                if (customer_money >= total_payment) {
                    document.querySelector('input[name="change_money"]').value = number_formatter_to_currency(customer_money - total_payment);
                } else {
                    document.querySelector('input[name="change_money"]').value = '';
                }
            }
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// remove product from shopping cart
function remove_product_from_shopping_cart(
    target,
    cart_table,
    total_qty_new,
    total_payment_new,
    product_sales_new,
    transaction_detail_id,
    csrf_name,
    csrf_value,
    main
) {
    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/hapus_produk_dari_keranjang_belanja', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `transaction_detail_id=${transaction_detail_id}&${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        document.querySelector('div#cart-loading').classList.add('d-none');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if remove product success
        if (json.success === true) {
            // update total qty, total payment in cart table
            const target_tr = target.parentElement.parentElement;
            cart_table.querySelector('td#total-qty').innerText = total_qty_new;
            cart_table.querySelector('td#total-qty').dataset.totalQty = total_qty_new;
            cart_table.querySelector('td#total-payment').innerText = number_formatter_to_currency(total_payment_new);
            cart_table.querySelector('td#total-payment').dataset.totalPayment = total_payment_new;

            // update product sale in product item
            const product_sales_el = document.querySelector(`div.product__item[data-product-id="${target_tr.dataset.productId}"] p.product__sales`);
            product_sales_el.innerText = `Terjual ${product_sales_new}`;
            product_sales_el.dataset.productSales = product_sales_new;

            // remove product in table cart
            target_tr.remove();

            // if customer money has inputed
            let customer_money = document.querySelector('input[name="customer_money"]').value;
            if (customer_money.value !== '') {
                customer_money = parseInt(customer_money);
                const total_payment = parseInt(document.querySelector('aside.cart td#total-payment').dataset.totalPayment);

                if (customer_money >= total_payment) {
                    document.querySelector('input[name="change_money"]').value = number_formatter_to_currency(customer_money - total_payment);
                } else {
                    document.querySelector('input[name="change_money"]').value = '';
                }
            }

            // if not exists product in cart table
            if (cart_table.querySelector('tbody tr') === null) {
                cart_table.querySelector('tbody').innerHTML = '<tr id="empty-shopping-cart"><td colspan="7"></td></tr>';
            }
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// add and reduce product qty and remove product from cart
document.querySelector('aside.cart table.table tbody').addEventListener('click', e => {
    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;

    // find true target add, because may be variabel e containing not element a, but element path or svg
    let target_add = e.target;
    if (target_add.getAttribute('id') !== 'add-product-qty') target_add = target_add.parentElement;
    if (target_add.getAttribute('id') !== 'add-product-qty') target_add = target_add.parentElement;

    // find true target reduce, because may be variabel e containing not element a, but element path or svg
    let target_reduce = e.target;
    if (target_reduce.getAttribute('id') !== 'reduce-product-qty') target_reduce = target_reduce.parentElement;
    if (target_reduce.getAttribute('id') !== 'reduce-product-qty') target_reduce = target_reduce.parentElement;

    // find true target remove, because may be variabel e containing not element a, but element path or svg
    let target_remove = e.target;
    if (target_remove.getAttribute('id') !== 'remove-product') target_remove = target_remove.parentElement;
    if (target_remove.getAttribute('id') !== 'remove-product') target_remove = target_remove.parentElement;


    // if user click link for add product qty
    if (target_add.getAttribute('id') === 'add-product-qty') {
        e.preventDefault();

        // get transaction detail id
        const transaction_detail_id = target_add.parentElement.parentElement.dataset.transactionDetailId;

        // generate product qty new, total qty new, payment new and total payment new
        const product_price = parseInt(target_add.parentElement.parentElement.querySelector('td#price').dataset.price);
        const total_payment_old = parseInt(cart_table.querySelector('td#total-payment').dataset.totalPayment);

        const product_qty_new = parseInt(target_add.parentElement.parentElement.querySelector('td#qty').dataset.qty)+1;
        const total_qty_new = parseInt(cart_table.querySelector('td#total-qty').dataset.totalQty)+1;
        const payment_new = product_qty_new * product_price;
        const total_payment_new = total_payment_old + product_price;

        // generate product sales new
        const product_id = target_add.parentElement.parentElement.dataset.productId;
        const product_sales_el = document.querySelector(`div.product__item[data-product-id="${product_id}"] p.product__sales`);
        const product_sales_new = parseInt(product_sales_el.dataset.productSales) + 1;

        update_product_qty(
            target_add,
            cart_table,
            product_qty_new,
            total_qty_new,
            payment_new,
            total_payment_new,
            product_sales_new,
            transaction_detail_id,
            csrf_name,
            csrf_value,
            main
        );
    }

    // if user click link for reduce product qty
    else if (target_reduce.getAttribute('id') === 'reduce-product-qty') {
        e.preventDefault();

        // get transaction detail id
        const transaction_detail_id = target_reduce.parentElement.parentElement.dataset.transactionDetailId;

        // generate product qty new, total qty new, payment new and total payment new
        const product_price = parseInt(target_reduce.parentElement.parentElement.querySelector('td#price').dataset.price);
        const total_payment_old = parseInt(cart_table.querySelector('td#total-payment').dataset.totalPayment);

        const product_qty_new = parseInt(target_reduce.parentElement.parentElement.querySelector('td#qty').dataset.qty)-1;
        const total_qty_new = parseInt(cart_table.querySelector('td#total-qty').dataset.totalQty)-1;
        const payment_new = product_qty_new * product_price;
        const total_payment_new = total_payment_old - product_price;

        // generate product sales new
        const product_id = target_reduce.parentElement.parentElement.dataset.productId;
        const product_sales_el = document.querySelector(`div.product__item[data-product-id="${product_id}"] p.product__sales`);
        const product_sales_new = parseInt(product_sales_el.dataset.productSales) - 1;

        update_product_qty(
            target_reduce,
            cart_table,
            product_qty_new,
            total_qty_new,
            payment_new,
            total_payment_new,
            product_sales_new,
            transaction_detail_id,
            csrf_name,
            csrf_value,
            main
        );
    }

    // if user click link for remove product from cart
    else if (target_remove.getAttribute('id') === 'remove-product') {
        e.preventDefault();

        // get transaction detail id
        const transaction_detail_id = target_remove.parentElement.parentElement.dataset.transactionDetailId;

        // generate product qty new, total qty new, payment new and total payment new
        const payment = parseInt(target_remove.parentElement.parentElement.querySelector('td#payment').dataset.payment);
        const total_payment_old = parseInt(cart_table.querySelector('td#total-payment').dataset.totalPayment);
        const product_qty = parseInt(target_remove.parentElement.parentElement.querySelector('td#qty').dataset.qty);

        const total_qty_new = parseInt(cart_table.querySelector('td#total-qty').dataset.totalQty) - product_qty;
        const total_payment_new = total_payment_old - payment;

        // generate product sales new
        const product_id = target_remove.parentElement.parentElement.dataset.productId;
        const product_sales_el = document.querySelector(`div.product__item[data-product-id="${product_id}"] p.product__sales`);
        const product_sales_new = parseInt(product_sales_el.dataset.productSales) - product_qty;

        remove_product_from_shopping_cart(
            target_remove,
            cart_table,
            total_qty_new,
            total_payment_new,
            product_sales_new,
            transaction_detail_id,
            csrf_name,
            csrf_value,
            main
        );
    }
});

// calculate change money
let calculate = true;
document.querySelector('aside.cart input[name="customer_money"]').addEventListener('input', (e) => {
    if (calculate === true) {
        // set calculate = false
        calculate = false;

        // calculate change money after 500ms
        setTimeout(() => {
            const customer_money = parseInt(e.target.value);
            const total_payment = parseInt(document.querySelector('aside.cart td#total-payment').dataset.totalPayment);

            if (customer_money >= total_payment) {
                document.querySelector('input[name="change_money"]').value = number_formatter_to_currency(customer_money - total_payment);
            } else {
                document.querySelector('input[name="change_money"]').value = '';
            }

            calculate = true;
        }, 300);
    }
});

function reset_shopping_cart(cart_table)
{
    // empty cart
    cart_table.querySelector('tbody').innerHTML = '<tr id="empty-shopping-cart"><td colspan="7"></td></tr>';
    cart_table.querySelector('td#total-qty').innerText = 0;
    cart_table.querySelector('td#total-qty').dataset.totalQty = 0;
    cart_table.querySelector('td#total-payment').innerText = 'Rp 0';
    cart_table.querySelector('td#total-payment').dataset.totalPayment = 0;
    document.querySelector('input[name="customer_money"]').value = '';
    document.querySelector('input[name="change_money"]').value = '';

    // remove attribute aria-label in cart table
    cart_table.removeAttribute('aria-label');

    // all form message
    const all_form_message = document.querySelectorAll('aside.cart small.form-message');
    if (all_form_message.length > 0) {
        all_form_message.forEach(el => el.remove());
    }
}

function finish_transaction(csrf_name, csrf_value, cart_table, main, btn_close_cart, customer_money)
{
    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/transaksi_selesai', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `customer_money=${customer_money}&${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        document.querySelector('div#cart-loading').classList.add('d-none');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if success
        if (json.success === true) {
            // close cart
            btn_close_cart.click();
            // reset shopping cart
            reset_shopping_cart(cart_table);
        }
        // if false and form message exists
        if (json.success === false && json.form_errors !== undefined) {
            // if exists form message
            const form_message_customer_money = document.querySelector('aside.cart div#customer-money small.form-message');
            if (form_message_customer_money !== null) {
                form_message_customer_money.innerText = json.form_errors.customer_money;

            } else {
                const small_node = document.createElement('small');
                small_node.classList.add('form-message');
                small_node.classList.add('form-message--danger');
                small_node.innerText = json.form_errors.customer_money;

                // add form message to after customer money input
                document.querySelector('aside.cart div#customer-money').append(small_node);
            }
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// finish transaction
btn_finish_transaction.addEventListener('click', e => {
    e.preventDefault();

    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;
    const customer_money = document.querySelector('input[name="customer_money"]').value;

    // if exists attribute aria-label = rollback-transaction and transaction-id in cart table
    if (cart_table.getAttribute('aria-label') === 'rollback-transaction' && cart_table.getAttribute('transaction-id') !== null) {

    }

    // else if exists attribute aria-label = transaction
    else if (cart_table.getAttribute('aria-label') === 'transaction') {
        finish_transaction(csrf_name, csrf_value, cart_table, main, btn_close_cart, customer_money);
    }
});

function cancel_transaction(csrf_name, csrf_value, cart_table, main)
{
    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/transaksi_batal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        document.querySelector('div#cart-loading').classList.add('d-none');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if success
        if (json.success === true) {
            // update product sales in product items
            const products_in_shopping_cart = cart_table.querySelectorAll('tbody tr[data-product-id]');
            products_in_shopping_cart.forEach (el => {
                const product_sales_el = document.querySelector(`div.product__item[data-product-id="${el.dataset.productId}"] p.product__sales`);
                // product sales new = product sales old - product qty
                const product_sales_new = parseInt(product_sales_el.dataset.productSales) - parseInt(el.querySelector('td#qty').dataset.qty);
                product_sales_el.dataset.productSales = product_sales_new;
                product_sales_el.innerText = `Terjual ${product_sales_new}`;
            });

            // reset shopping cart
            reset_shopping_cart(cart_table);
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// cancel transaction
btn_cancel_transaction.addEventListener('click', e => {
    e.preventDefault();

    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;

    // if exists attribute aria-label = rollback-transaction and transaction-id in cart table
    if (cart_table.getAttribute('aria-label') === 'rollback-transaction' && cart_table.getAttribute('transaction-id') !== null) {

    }

    // else if exists attribute aria-label = transaction
    else if (cart_table.getAttribute('aria-label') === 'transaction') {
        cancel_transaction(csrf_name, csrf_value, cart_table, main);
    }
});
</script>
