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
function image_zoom(e)
{
    let target = e.target;
    if(!target.classList.contains('product__image')) target = target.parentElement;

    if(target.classList.contains('product__image')) {
        target.classList.add('product__image--zoom');
        target.querySelector('.btn--close').classList.remove('d-none');
    }

    // reset target value
    target = e.target;
    if(!target.classList.contains('btn--close')) target = target.parentElement;
    if(!target.classList.contains('btn--close')) target = target.parentElement;
    if(target.classList.contains('btn--close')) {
        e.preventDefault();
        target.parentElement.classList.remove('product__image--zoom');
        target.classList.add('d-none');
    }
}

document.querySelector('div.product__populer').addEventListener('click', image_zoom);
document.querySelector('div.product__more').addEventListener('click', image_zoom);


// show hide cart
 const cart = document.querySelector('aside.cart');
document.querySelector('a#show-cart').addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.add('cart--animate-show');
    setTimeout(() => {
        cart.classList.remove('cart--animate-show');
        cart.classList.add('cart--show');

        // if window less than 991.98px add overflow hidden to body tag
        if(window.screen.width <= 991.98) {
            document.querySelector('body').classList.add('overflow-hidden');
        }
    }, 501);
});

// hide cart
cart.querySelector('a.btn--close').addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.replace('cart--show', 'cart--animate-hide');
    setTimeout(() => {
        cart.classList.remove('cart--animate-hide');
    }, 501);

    // remove class overflow hidden in tag body
    document.querySelector('body').classList.remove('overflow-hidden');

});
