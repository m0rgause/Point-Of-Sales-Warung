/*!
 * Point Of Sales Warung
 * Licensed under GPL (https://github.com/rezafikkri/Point-Of-Sales-Warung/blob/master/LICENSE)
 */

// dropdown menu
const nav = document.querySelector("nav.navbar");
nav.addEventListener('click', e => {
    const target = e.target;

    if(target.classList.contains('dropdown-toggle')) {
        e.preventDefault();

        const dropdown_menu = document.querySelector(target.getAttribute('target'));
        dropdown_menu.classList.toggle('d-none');
        dropdown_menu.previousElementSibling.classList.toggle('navbar__link--active');

    }
});

// show modal
function show_modal(e)
{
    e.preventDefault();

    modal.classList.add('d-block');
    setTimeout(() => {
        modal.classList.add('modal--fade-in');
    }, 50);

    setTimeout(() => {
        modal_content.classList.add('modal__content--animate-show');
    }, 200);
}

// hide modal
function hide_modal(e)
{
    e.preventDefault();

    modal_content.classList.replace('modal__content--animate-show', 'modal__content--animate-hide');
    setTimeout(() => {
        modal_content.classList.remove('modal__content--animate-hide');
        modal.classList.replace('modal--fade-in', 'modal--fade-out');
    }, 250);

    setTimeout(() => {
        modal.classList.remove('modal--fade-out');
        modal.classList.remove('modal--show');
        modal.classList.remove('d-block');;
    }, 400);
}

// navbar collapse
const navbar_toggler = document.querySelector('.navbar a.btn--toggler');
const navbar_collapse = document.querySelector('.navbar__right--collapse');
if(navbar_toggler !== null) {
    navbar_toggler.addEventListener('click', (e) => {
        e.preventDefault();

        navbar_collapse.classList.toggle('navbar__right--collapse-show');
    });
}

// add form input besaran dan harga
function add_form_input_besaran_harga(e) {
    e.preventDefault();

    const target = e.target;

    const new_form_besaran_harga = document.createElement('div');
    new_form_besaran_harga.classList.add('input-group');
    new_form_besaran_harga.innerHTML = `<input class="form-input" type="text" placeholder="Besaran..." name="besaran">
                <input class="form-input" type="text" placeholder="Harga..." name="harga">
                <a class="btn btn--gray-outline" id="add-form-input-besaran-harga" href="">Tambah</a>`;

    const div_input_group = target.parentElement;

    // add margin bottom to div input group
    div_input_group.classList.add('mb-3');

    // remove button tambah form besaran harga
    target.remove();

    // add button hapus form besaran harga
    const remove_button = document.createElement('a');
    remove_button.classList.add('btn');
    remove_button.classList.add('btn--gray-outline');
    remove_button.setAttribute('id','remove-form-input-besaran-harga');
    remove_button.setAttribute('href','');
    remove_button.innerText = 'Hapus';
    div_input_group.append(remove_button);

    // append new form besaran harga to <form>
    form.append(new_form_besaran_harga);
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
