import {add_form_input_magnitude_price, create_alert_node} from './module.posw.js';

// get file name and replace text in label with it
const form_file = document.querySelector('div.form-file input[type="file"]');
form_file.addEventListener('change', (e) => {
    e.target.nextElementSibling.innerText = e.target.files[0].name;
});

// add form input magnitude and price
const magnitude_price = document.querySelector('div#magnitude-price');
document.querySelector('a#add-form-input-magnitude-price').addEventListener('click', e => {
    e.preventDefault();
    add_form_input_magnitude_price(magnitude_price);
});

// remove product price
magnitude_price.addEventListener('click', e => {
    const target = e.target;
    if (target.getAttribute('id') === 'remove-form-input-magnitude-price') {
        e.preventDefault();

        // if product_price_id exists in btn
        if (target.dataset.productPriceId !== undefined) {
            // remove product price from db
            const csrf_name = document.querySelector('main.main').dataset.csrfName;
            const csrf_input = document.querySelector(`input[name=${csrf_name}]`);
            const csrf_value = csrf_input.value;
            const product_price_id = target.dataset.productPriceId;

            // loading
            const loading = document.querySelector('div.loading-bg');
            loading.classList.remove('d-none');

            fetch('/admin/hapus_harga_produk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `${csrf_name}=${csrf_value}&product_price_id=${product_price_id}`
            })
            .finally(() => {
                // loading
                loading.classList.add('d-none');
            })
            .then(response => {
                return response.json();
            })
            .then(json => {
                // set new csrf hash to table tag
                if (json.csrf_value !== undefined) {
                    csrf_input.value = json.csrf_value;
                }

                // if fail remove product price
                if (json.success === false && json.error_message !== undefined) {
                    const alert = create_alert_node(['alert--warning', 'mb-3'], `<strong>Peringatan</strong>, ${json.error_message}`);

                    // append alert to before div.main__box element
                    document.querySelector('main.main > div > div > div').insertBefore(alert, document.querySelector('div.main__box'));
                }

                // if success remove product price
                if (json.success === true) {
                    target.parentElement.parentElement.remove();
                }
            })
            .catch(error => {
                console.error(error);
            });

        } else {
            // remove form product price only
            target.parentElement.parentElement.remove();
        }
    }
});
