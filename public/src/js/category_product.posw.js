import {create_alert_node} from './module.posw.js';

// remove category product
const table = document.querySelector('table.table');
table.querySelector('tbody').addEventListener('click', (e) => {
    let target = e.target;

    if (target.getAttribute('id') !== 'remove-category-product') target = target.parentElement;
    if (target.getAttribute('id') !== 'remove-category-product') target = target.parentElement;

    if (target.getAttribute('id') === 'remove-category-product') {
        e.preventDefault();

        // data for remove category product
        const category_product_id = target.dataset.categoryProductId;
        const csrf_name = table.dataset.csrfName;
        const csrf_value = table.dataset.csrfValue;

        // loading
        table.parentElement.nextElementSibling.classList.remove('d-none');

        fetch('/admin/hapus_kategori_produk_di_db', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `${csrf_name}=${csrf_value}&category_product_id=${category_product_id}`
        })
        .finally(() => {
            // loading
            table.parentElement.nextElementSibling.classList.add('d-none');
        })
        .then(response => {
            return response.json();
        })
        .then(json => {
            // set new csrf hash to table tag
            if (json.csrf_value !== undefined) {
                table.dataset.csrfValue = json.csrf_value;
            }

            // if fail remove category product
            if (json.success === false && json.error_message !== undefined) {
                const alert = create_alert_node('alert--warning', `<strong>Warning</strong>, ${json.error_message}`);

                // append alert to before div.main__box element
                document.querySelector('main.main > div').insertBefore(alert, document.querySelector('div.main__box'));
            }
            // if success remove category product
            else if (json.success === true) {
                target.parentElement.parentElement.remove();
            }
        })
        .catch(error => {
            console.error(error);
        });
    }
});
