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

// navbar collapse
const navbar_toggler = document.querySelector('.navbar a.btn--toggler');
const navbar_collapse = document.querySelector('.navbar__right--collapse');
if(navbar_toggler !== null) {
    navbar_toggler.addEventListener('click', e => {
        e.preventDefault();

        navbar_collapse.classList.toggle('navbar__right--collapse-show');
    });
}

// alert close
document.querySelector('main.main').addEventListener('click', e => {
    if (e.target.classList.contains('alert__close')) { e.preventDefault(); e.target.parentElement.remove(); }
})
