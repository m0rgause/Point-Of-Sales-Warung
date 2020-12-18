/*!
 * Point Of Sales Warung
 * Licensed under GPL (https://github.com/rezafikkri/Point-Of-Sales-Warung/blob/master/LICENSE)
 */

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
