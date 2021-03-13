import {add_form_input_magnitude_price} from './module.posw.js';

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

// remove form input magnitude and price
magnitude_price.addEventListener('click', e => {
    if(e.target.getAttribute('id') === 'remove-form-input-magnitude-price') {
        e.preventDefault();

        e.target.parentElement.parentElement.remove();
    }
});

