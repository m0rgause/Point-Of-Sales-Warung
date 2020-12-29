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
navbar_toggler.addEventListener('click', (e) => {
    e.preventDefault();

    navbar_collapse.classList.toggle('navbar__right--collapse-show');
});
