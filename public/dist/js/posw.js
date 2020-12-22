/*!
 * Point Of Sales Warung
 * Licensed under GPL (https://github.com/rezafikkri/Point-Of-Sales-Warung/blob/master/LICENSE)
 */

// dropdown menu
const nav = document.querySelector("nav.header");
nav.addEventListener('click', e => {
    const target = e.target;

    if(target.classList.contains('dropdown-toggle')) {
        e.preventDefault();

        const dropdown_menu = document.querySelector(target.getAttribute('target'));
        dropdown_menu.classList.toggle('d-none');
        dropdown_menu.parentElement.classList.toggle('dropdown--active');

    }
});

// product image zoom
const product = document.querySelector('div.product');
product.addEventListener('click', (e) => {
    let target = e.target;
    if(!target.classList.contains('product__image')) target = target.parentElement;

    if(target.classList.contains('product__image')) {
        target.classList.add('product__image--zoom');
        target.querySelector('.btn--close').classList.remove('d-none');
    }

    // reset target value
    target = e.target;
    if(!target.classList.contains('btn--close')) target = target.parentElement;
    if(!target.classList.contains('btn--close')) target = target.parentElement.parentElement;
    if(target.classList.contains('btn--close')) {
        e.preventDefault();
        target.parentElement.classList.remove('product__image--zoom');
        target.classList.add('d-none');
    }
});
