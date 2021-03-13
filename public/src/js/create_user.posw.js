import {show_password} from './module.posw.js';

// generate password
document.querySelector('a#generate-password').addEventListener('click', (e) => {
    e.preventDefault();

    const chart = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let password = '';

    for(let i = 0; i < 8; i++) {
        password += chart[Math.floor(Math.random()*chart.length)];
    }

    document.querySelector('input[name="password"]').value = password;
});

// show password
document.querySelector('a#show-password').addEventListener('click', show_password);
