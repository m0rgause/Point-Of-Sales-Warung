// show modal
function show_modal(modal, modal_content)
{
    modal.classList.add('d-block');
    setTimeout(() => {
        modal.classList.add('modal--fade-in');
    }, 50);

    setTimeout(() => {
        modal_content.classList.add('modal__content--animate-show');
    }, 200);
}

// hide modal
function hide_modal(modal, modal_content)
{
    modal_content.classList.replace('modal__content--animate-show', 'modal__content--animate-hide');
    setTimeout(() => {
        modal_content.classList.remove('modal__content--animate-hide');
        modal.classList.replace('modal--fade-in', 'modal--fade-out');
    }, 100);

    setTimeout(() => {
        modal.classList.remove('modal--fade-out');
        modal.classList.remove('modal--show');
        modal.classList.remove('d-block');;
    }, 200);
}

// add form input magnitude and price
function add_form_input_magnitude_price(target_append)
{
    const new_form_magnitude_price = document.createElement('div');
    new_form_magnitude_price.classList.add('mb-3');
    new_form_magnitude_price.innerHTML = `<div class="input-group">
        <input class="form-input" type="text" placeholder="Besaran..." name="product_magnitudes[]">
        <input class="form-input" type="number" placeholder="Harga..." name="product_prices[]">
        <a class="btn btn--gray-outline" id="remove-form-input-magnitude-price" href="#">Hapus</a>
    </div>`;

    // append new form magnitude price to target_append
    target_append.append(new_form_magnitude_price);
}

function show_password(e)
{
    e.preventDefault();

    let target = e.target;
    if(!/^show-password.*/.test(target.getAttribute('id'))) target = target.parentElement;
    if(!/^show-password.*/.test(target.getAttribute('id'))) target = target.parentElement;

    if(/^show-password.*/.test(target.getAttribute('id'))) {
        const input = target.previousElementSibling;
        if(input.getAttribute('type') === 'password') {
            input.setAttribute('type','text');
            target.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/></svg>`;
        } else {
            input.setAttribute('type','password');
            target.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="19" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg>`;
        }
    }
}

function create_alert_node(type_alert_class, message)
{
    const alert = document.createElement('div');
    alert.classList.add('alert');
    alert.classList.add(type_alert_class);
    alert.classList.add('mb-3');

    alert.innerHTML = `<span class="alert__icon"></span>
    <p>${message}</p>
    <a class="alert__close" href="#"></a>`;

    return alert;
}

// number formatter currency
function number_formatter_to_currency(number)
{
    return number.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0});
}

export {
    show_modal,
    hide_modal,
    add_form_input_magnitude_price,
    show_password,
    create_alert_node,
    number_formatter_to_currency
};
