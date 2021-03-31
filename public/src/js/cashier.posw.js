import {create_alert_node, number_formatter_to_currency, show_modal, hide_modal} from './module.posw.js';

const main = document.querySelector('main.main');
const btn_show_cart = document.querySelector('a#show-cart');
const btn_search_product = document.querySelector('a#search-product');
const btn_cancel_transaction = document.querySelector('a#cancel-transaction');
const btn_finish_transaction = document.querySelector('a#finish-transaction');
const cart_table = document.querySelector('aside.cart table.table');

// update total qty and total payment in cart table
function update_total_qty_payment(cart_table, total_qty, total_payment)
{
    cart_table.querySelector('td#total-qty').innerText = total_qty;
    cart_table.querySelector('td#total-qty').dataset.totalQty = total_qty;
    cart_table.querySelector('td#total-payment').innerText = number_formatter_to_currency(total_payment);
    cart_table.querySelector('td#total-payment').dataset.totalPayment = total_payment;
}

// show transaction detail in cart table
function show_transaction_details(cart_table, transaction_details)
{
    let tr = '';
    let total_payment = 0;
    let total_qty = 0;
    transaction_details.forEach (td => {
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

    if (tr !== '') {
        // inner html transaction detail to cart table tbody
        cart_table.querySelector('tbody').innerHTML = tr;
    }

    // update total qty and total payment in cart table
    update_total_qty_payment(cart_table, total_qty, total_payment);
}

// get transaction detail
function get_transaction_details(
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
        if (json.transaction_details !== null) {
            // show transaction detail in cart table
            show_transaction_details(cart_table, json.transaction_details);

            // if type = rollback-transaction
            if (json.type === 'rollback-transaction') {
                // show customer money
                const customer_money = parseInt(json.customer_money);
                document.querySelector('input[name="customer_money"]').value = customer_money;

                // calculate change money
                const total_payment = parseInt(cart_table.querySelector('td#total-payment').dataset.totalPayment);
                calculate_change_money(customer_money, total_payment);

                // add attribute aria label = rollback-transaction
                cart_table.setAttribute('aria-label', 'rollback-transaction');

            } else {
                // add attribute aria label = transaction
                cart_table.setAttribute('aria-label', 'transaction');
            }
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
        get_transaction_details(
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
main.addEventListener('change', (e) => {
    // if changed is select magnitude in product item
    let target = e.target;
    if (target.getAttribute('name') === 'magnitude') {
        const product_price = target.selectedOptions[0].dataset.productPrice;
        target.previousElementSibling.previousElementSibling.innerText = number_formatter_to_currency(parseInt(product_price));
    }
});

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
    container.innerHTML = `<div id="search-loading" class="d-flex justify-content-center align-items-center mt-4">
    <div class="loading"><div></div></div>
</div>`;
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
        // loading
        container.querySelector('div#search-loading').remove();
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
            const base_url = main.dataset.baseUrl;
            let product = `<span class="text-muted me-1 d-block mb-3" id="result-status">
                    1 - ${json.products_db.length} dari ${json.product_search_total} Total produk hasil pencarian</span>`;

            product += '<h5 class="mb-2 main__title">Produk</h5><div class="product mb-4">';

            json.products_db.forEach (p => {
                const product_sale = p.product_sale!==null?p.product_sale:0;

                product += `<div class="product__item" data-product-id="${p.product_id}">
                    <div class="product__image">
                        <img src="${base_url}/dist/images/product_photo/${p.product_photo}" alt="${p.product_name}">
                    </div>
                    <div class="product__info">
                        <p class="product__name">${p.product_name}</p>
                        <p class="product__category">${p.category_name}</p>
                        <p class="product__sale" data-product-sale="${product_sale}">Terjual ${product_sale}</p>

                        <div class="product__price">
                            <h5>${p.product_price[0].product_price_formatted}</h5><span>/</span>
                            <select name="magnitude">`;

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
                <p>Produk tidak ada.</p>`;
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

// calculate change money
function calculate_change_money(customer_money, total_payment)
{
    const change_money_el = document.querySelector('input[name="change_money"]');
    // if customer money greater than total payment
    if (customer_money >= total_payment) {
        change_money_el.value = number_formatter_to_currency(customer_money - total_payment);
    }
    // else if input change money not empty
    else if (change_money_el.value !== '') {
        // reset input change money
        change_money_el.value = '';
    }
}

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

            calculate_change_money(customer_money, total_payment);

            calculate = true;
        }, 300);
    }
});

// add product to cart table in buy product
function add_product_to_cart_table(
    target,
    product_qty,
    json,
    cart_table,
    product_id,
    product_name,
    product_price,
    product_magnitude,
    payment
) {
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
}

// buy product in transaction
function buy_product(
    target,
    cart_table,
    product_qty,
    btn_search_product,
    btn_cancel_transaction,
    btn_finish_transaction,
    main,
    product_price_id,
    csrf_name,
    csrf_value
) {
    // loading
    document.querySelector('div#transaction-loading').classList.remove('d-none');
    // disabled button search, cancel and finish transaction
    btn_search_product.classList.add('btn--disabled');
    btn_cancel_transaction.classList.add('btn--disabled');
    btn_finish_transaction.classList.add('btn--disabled');

    fetch('/kasir/beli_produk', {
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

        // reset form number of product
        target.previousElementSibling.value = '';

        // if buy product success
        if (json.success === true) {
            // update product sale
            const product_sale_el = target.parentElement.previousElementSibling.querySelector('p.product__sale');
            const product_sale_new = parseInt(product_qty) + parseInt(product_sale_el.dataset.productSale);
            product_sale_el.innerText = `Terjual ${product_sale_new}`;
            product_sale_el.dataset.productSale = product_sale_new;

            // if attribute aria-label exists in cart table
            if (cart_table.getAttribute('aria-label') !== null) {
                const product_id = target.parentElement.parentElement.dataset.productId;
                const product_info_el = target.parentElement.previousElementSibling;
                const product_name = product_info_el.querySelector('p.product__name').textContent;
                const product_price = product_info_el.querySelector('select[name="magnitude"]').selectedOptions[0].dataset.productPrice;
                const product_magnitude = product_info_el.querySelector('select[name="magnitude"]').selectedOptions[0].text;
                const payment = parseInt(product_price) * parseInt(product_qty);

                // add product to cart table
                add_product_to_cart_table(
                    target,
                    product_qty,
                    json,
                    cart_table,
                    product_id,
                    product_name,
                    product_price,
                    product_magnitude,
                    payment
                );

                const total_payment_old = cart_table.querySelector('td#total-payment').dataset.totalPayment;
                const total_qty_old = cart_table.querySelector('td#total-qty').dataset.totalQty;
                const total_payment_new = payment + parseInt(total_payment_old);
                const total_qty_new = parseInt(product_qty) + parseInt(total_qty_old);

                // update total qty and total payment in cart table
                update_total_qty_payment(cart_table, total_qty_new, total_payment_new);

                // if customer money has inputed
                const customer_money = parseInt(document.querySelector('input[name="customer_money"]').value);
                calculate_change_money(customer_money, total_payment_new);
            }
        } else {
            const alert_node = create_alert_node(
                ['alert--warning', 'alert--fixed-rb'],
                `Beli produk gagal, muat ulang halaman lalu coba kembali!`
            );
            main.append(alert_node);
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// buy product transaction and rollback transaksi
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

        // buy product
        buy_product(
            target,
            cart_table,
            product_qty,
            btn_search_product,
            btn_cancel_transaction,
            btn_finish_transaction,
            main,
            product_price_id,
            csrf_name,
            csrf_value
        );
    }
});

// update qty and payment product in cart table
function update_qty_payment(target_tr, product_qty_new, payment_new)
{
    target_tr.querySelector('td#qty').innerText = product_qty_new;
    target_tr.querySelector('td#qty').dataset.qty = product_qty_new;
    target_tr.querySelector('td#payment').innerText = number_formatter_to_currency(payment_new);
    target_tr.querySelector('td#payment').dataset.payment = payment_new;
}

// update product quantity
function update_product_qty(
    target,
    cart_table,
    product_qty_new,
    total_qty_new,
    payment_new,
    total_payment_new,
    product_sale_el,
    product_sale_new,
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
            const target_tr = target.parentElement.parentElement;

            // update product qty and payment in cart table
            update_qty_payment(target_tr, product_qty_new, payment_new);
            // update total qty and total payment in cart table
            update_total_qty_payment(cart_table, total_qty_new, total_payment_new);

            // update product sale in product item
            const product_sale_el = document.querySelector(`div.product__item[data-product-id="${target_tr.dataset.productId}"] p.product__sale`);
            // if exists product item
            if (product_sale_el !== null) {
                product_sale_el.innerText = `Terjual ${product_sale_new}`;
                product_sale_el.dataset.productSale = product_sale_new;
            }

            // if customer money has inputed
            const customer_money = parseInt(document.querySelector('input[name="customer_money"]').value);
            calculate_change_money(customer_money, total_payment_new);
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
    product_sale_el,
    product_sale_new,
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
            const target_tr = target.parentElement.parentElement;

            // update total qty and total payment in cart table
            update_total_qty_payment(cart_table, total_qty_new, total_payment_new);

            // if exists product item, update product sale in product item
            if (product_sale_el !== null) {
                product_sale_el.innerText = `Terjual ${product_sale_new}`;
                product_sale_el.dataset.productSale = product_sale_new;
            }

            // remove product in cart table
            target_tr.remove();

            // if customer money has inputed
            const customer_money = parseInt(document.querySelector('input[name="customer_money"]').value);
            calculate_change_money(customer_money, total_payment_new);

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
        const product_sale_el = document.querySelector(`div.product__item[data-product-id="${product_id}"] p.product__sale`);
        let product_sale_new = 0;
        // if exists product item
        if (product_sale_el !== null) {
            product_sale_new = parseInt(product_sale_el.dataset.productSale) + 1;
        }

        update_product_qty(
            target_add,
            cart_table,
            product_qty_new,
            total_qty_new,
            payment_new,
            total_payment_new,
            product_sale_el,
            product_sale_new,
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
        const product_sale_el = document.querySelector(`div.product__item[data-product-id="${product_id}"] p.product__sale`);
        let product_sale_new = 0;
        // if exists product item
        if (product_sale_el !== null) {
            product_sale_new = parseInt(product_sale_el.dataset.productSale) - 1;
        }

        update_product_qty(
            target_reduce,
            cart_table,
            product_qty_new,
            total_qty_new,
            payment_new,
            total_payment_new,
            product_sale_el,
            product_sale_new,
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

        // generate total qty new and total payment new
        const payment = parseInt(target_remove.parentElement.parentElement.querySelector('td#payment').dataset.payment);
        const total_payment_old = parseInt(cart_table.querySelector('td#total-payment').dataset.totalPayment);
        const product_qty = parseInt(target_remove.parentElement.parentElement.querySelector('td#qty').dataset.qty);

        const total_qty_new = parseInt(cart_table.querySelector('td#total-qty').dataset.totalQty) - product_qty;
        const total_payment_new = total_payment_old - payment;

        // generate product sales new
        const product_id = target_remove.parentElement.parentElement.dataset.productId;
        const product_sale_el = document.querySelector(`div.product__item[data-product-id="${product_id}"] p.product__sale`);
        let product_sale_new = 0;
        // if exists product item
        if (product_sale_el !== null) {
            product_sale_new = parseInt(product_sale_el.dataset.productSale) - product_qty;
        }

        remove_product_from_shopping_cart(
            target_remove,
            cart_table,
            total_qty_new,
            total_payment_new,
            product_sale_el,
            product_sale_new,
            transaction_detail_id,
            csrf_name,
            csrf_value,
            main
        );
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

// show form message in cart
function show_form_error_message_customer_money(message)
{
    // if exists form message
    const form_message_customer_money = document.querySelector('aside.cart div#customer-money small.form-message');
    if (form_message_customer_money !== null) {
        form_message_customer_money.innerText = message;

    } else {
        const small_node = document.createElement('small');
        small_node.classList.add('form-message');
        small_node.classList.add(`form-message--danger`);
        small_node.innerText = message.customer_money;
        // add form message to after customer money input
        document.querySelector('aside.cart div#customer-money').append(small_node);
    }
}

function finish_rollback_transaction(csrf_name, csrf_value, cart_table, main, btn_close_cart, customer_money)
{
    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/rollback_transaksi_selesai', {
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
            show_form_error_message_customer_money(json.form_errors);
        }
    })
    .catch(error => {
        console.error(error);
    });
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
            show_form_error_message_customer_money(json.form_errors);
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

    // if exists attribute aria-label = transaction
    if (cart_table.getAttribute('aria-label') === 'transaction') {
        finish_transaction(csrf_name, csrf_value, cart_table, main, btn_close_cart, customer_money);
    }

    // else if exists attribute aria-label = rollback-transaction and transaction-id in cart table
    else if (cart_table.getAttribute('aria-label') === 'rollback-transaction') {
        finish_rollback_transaction(csrf_name, csrf_value, cart_table, main, btn_close_cart, customer_money);
    }
});

function generate_transaction_details_for_update_product_sale(transaction_details_backup, transaction_details_cart_table)
{
    let transaction_details = [];
    let i = 0;
    // get product id and product qty from transaction detail exists in cart table but not exists in backup
    for (const el of transaction_details_cart_table) {
        let exists = false;
        for (const tdb of transaction_details_backup) {
            // if exists in backup
            if (el.dataset.productId === tdb.produk_id) {
                exists = true;
                break;
            }
        }

        if (exists === false) {
            transaction_details[i] = {product_id: el.dataset.productId, product_qty: parseInt(el.querySelector('td#qty').dataset.qty)};
            i++;
        }
    }

    // get product id and product qty from transaction detail backup
    for (const tdb of transaction_details_backup) {
        // find right product qty
        let product_qty_cart_table = 0;
        for (const el of transaction_details_cart_table) {
            if (tdb.produk_id === el.dataset.productId) {
                product_qty_cart_table = el.querySelector('td#qty').dataset.qty;
                break;
            }
        }

        let product_qty = 0;
        // if product qty cart table != 0, this mean product not remove yet
        if (product_qty_cart_table !== 0) {
            product_qty = parseInt(product_qty_cart_table) - tdb.jumlah_produk;
        } else {
            product_qty = 0 - tdb.jumlah_produk;
        }

        transaction_details[i] = {product_id: tdb.produk_id, product_qty: product_qty};
        i++;
    }

    return transaction_details;
}

// generate transaction detail ids for remove transaction detail not exists in backup file when cancel rollback transaction
function generate_transaction_detail_ids(transaction_details_cart_table)
{
    let transaction_detail_ids = [];
    transaction_details_cart_table.forEach((el, i) => {
        transaction_detail_ids[i] = el.dataset.transactionDetailId;
    });

    return transaction_detail_ids;
}

function cancel_rollback_transaction(csrf_name, csrf_value, cart_table, main)
{
    const transaction_details_cart_table = cart_table.querySelectorAll('tbody tr[data-product-id]');
    // generate transaction detail ids for remove transaction detail not exists in backup file
    const transaction_detail_ids = generate_transaction_detail_ids(transaction_details_cart_table);

    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/rollback_transaksi_batal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `transaction_detail_ids=${transaction_detail_ids}&${csrf_name}=${csrf_value}`
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
            // generate data transaction detail for update product sales
            const transaction_details = generate_transaction_details_for_update_product_sale(
                json.transaction_details,
                transaction_details_cart_table
            );

            // update product sales in product items
            transaction_details.forEach (tdcb => {
                const product_sale_el = document.querySelector(`div.product__item[data-product-id="${tdcb.product_id}"] p.product__sale`);
                // if exists product sales el
                if (product_sale_el !== null) {
                    // product sale new = product sales old - product qty
                    const product_sale_new = parseInt(product_sale_el.dataset.productSale) - tdcb.product_qty;
                    product_sale_el.dataset.productSale = product_sale_new;
                    product_sale_el.innerText = `Terjual ${product_sale_new}`;
                }
            });

            // remove attribute transaction-id
            cart_table.removeAttribute('data-transaction-id');
            // reset shopping cart
            reset_shopping_cart(cart_table);
        }
    })
    .catch(error => {
        console.error(error);
    });
}

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
            const products_in_cart_table = cart_table.querySelectorAll('tbody tr[data-product-id]');
            products_in_cart_table.forEach (el => {
                const product_sale_el = document.querySelector(`div.product__item[data-product-id="${el.dataset.productId}"] p.product__sale`);

                // if exists product item
                if (product_sale_el !== null) {
                    // product sale new = product sale old - product qty
                    const product_sale_new = parseInt(product_sale_el.dataset.productSale) - parseInt(el.querySelector('td#qty').dataset.qty);
                    product_sale_el.dataset.productSale = product_sale_new;
                    product_sale_el.innerText = `Terjual ${product_sale_new}`;
                }
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

    // if exists attribute aria-label = transaction
    if (cart_table.getAttribute('aria-label') === 'transaction') {
        cancel_transaction(csrf_name, csrf_value, cart_table, main);
    }
    // else if exists attribute aria-label = rollback-transaction and transaction-id in cart table
    else if (cart_table.getAttribute('aria-label') === 'rollback-transaction') {
        cancel_rollback_transaction(csrf_name, csrf_value, cart_table, main);
    }
});

const modal = document.querySelector('.modal');
const modal_content = modal.querySelector('.modal__content');
// show transaction three days ago in select input
document.querySelector('a#rollback-transaction').addEventListener('click', e => {
    e.preventDefault();

    // if exists attribute aria-label = transaction in cart table
    if (cart_table.getAttribute('aria-label') === 'transaction') {
        const alert_node = create_alert_node(
            ['alert--warning', 'mb-3'],
            'Tidak bisa melakukan rollback transaksi, karena kamu masih melakukan transaksi. Selesaikan atau batalkan transaksi, lalu coba kembali!'
        );
        e.target.parentElement.insertBefore(alert_node, e.target);
        return false;
    }

    // if exists attribute aria-label = rollback-transaction in cart table
    if (cart_table.getAttribute('aria-label') === 'rollback-transaction') {
        const alert_node = create_alert_node(
            ['alert--warning', 'mb-3'],
            `Tidak bisa melakukan rollback transaksi lagi, karena kamu masih melakukan rollback transaksi. Selesaikan atau batalkan rollback transkasi, lalu coba kembali!`
        );
        e.target.parentElement.insertBefore(alert_node, e.target);
        return false;
    }

    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;

    // loading
    document.querySelector('div#cart-loading').classList.remove('d-none');

    fetch('/kasir/tampil_transaksi_tiga_hari_yang_lalu', {
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

        // if exists transaction
        if (json.transactions_three_days_ago.length > 0) {
            // show modal
            show_modal(modal, modal_content);

            // show data in select input
            let options = '<option>Riwayat Transaksi</option>';
            json.transactions_three_days_ago.forEach(t => {
                options += `<option value="${t.transaksi_id}">${t.waktu_buat}</option>`;
            });

            // inner html to select
            modal_content.querySelector('select[name="transactions_three_days_ago"]').innerHTML = options;
        } else {
            const alert_node = create_alert_node(
                ['alert--info', 'mb-3'],
                `Tidak ada transaksi dari 3 hari yang lalu.`
            );
            e.target.parentElement.insertBefore(alert_node, e.target);
        }
    })
    .catch(error => {
        console.error(error);
    });
});

// close modal
modal_content.querySelector('a#btn-close').addEventListener('click', e => {
    e.preventDefault();

    // hide modal
    hide_modal(modal, modal_content);
    // reset modal
    modal_content.querySelector('select[name="transactions_three_days_ago"]').innerHTML = '';
});

// show transaction detail based on transaction selected in modal
document.querySelector('div.modal a#show-transaction-detail').addEventListener('click', e => {
    e.preventDefault();

    const csrf_name = main.dataset.csrfName;
    const csrf_value = main.dataset.csrfValue;
    const transaction_id = modal_content.querySelector('select[name="transactions_three_days_ago"]').value;

    // if transaction not selected
    if (transaction_id.toLowerCase() === 'riwayat transaksi') {
        return false;
    }

    // loading
    e.target.nextElementSibling.classList.remove('d-none');

    fetch('/kasir/tampil_transaksi_detail_tiga_hari_yang_lalu', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `transaction_id=${transaction_id}&${csrf_name}=${csrf_value}`
    })
    .finally(() => {
        // loading
        e.target.nextElementSibling.classList.add('d-none');
    })
    .then(response => {
        return response.json();
    })
    .then(json => {
        // set new csrf hash to table tag
        if (json.csrf_value !== undefined) {
            main.dataset.csrfValue = json.csrf_value;
        }

        // if exists customer_money
        if (json.customer_money !== null) {
            // hide and reset modal
            hide_modal(modal, modal_content);
            // reset modal
            modal_content.querySelector('select[name="transactions_three_days_ago"]').innerHTML = '';

            // show transaction detail in cart table
            show_transaction_details(cart_table, json.transaction_details);

            // show customer money
            const customer_money = parseInt(json.customer_money);
            document.querySelector('input[name="customer_money"]').value = customer_money;

            // show change money
            const total_payment = parseInt(document.querySelector('aside.cart td#total-payment').dataset.totalPayment);
            if (customer_money >= total_payment) {
                document.querySelector('input[name="change_money"]').value = number_formatter_to_currency(customer_money - total_payment);
            } else {
                document.querySelector('input[name="change_money"]').value = '';
            }

            // add Attribute arial-label = rollback-transaction
            cart_table.setAttribute('aria-label', 'rollback-transaction');
        }
    })
    .catch(error => {
        console.error(error);
    });
});
