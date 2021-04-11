import {create_alert_node, number_formatter_to_currency} from './module.posw.js';
import flatpickr from 'flatpickr';
import { Indonesian } from "flatpickr/dist/l10n/id.js"

// flatpickr setting
flatpickr('#transaction-date-range', {
    disableMobile: 'true',
    mode: 'range',
    altInput: true,
    altFormat: 'j M, Y',
    altInputClass: 'form-input form-input--rounded-left hover-cursor-pointer',
    locale: Indonesian,
    onReady: () => {
        // this function for change name for 7th day in 1 week
        document.querySelectorAll('.flatpickr-weekdaycontainer .flatpickr-weekday')[6].innerText = 'Ahad';
    }
});

// show hide transaction detail
const tbody = document.querySelector('table.table tbody');
tbody.addEventListener('click', (e) => {
    let target = e.target;
    if(target.getAttribute('id') !== 'show-transaction-detail') target = target.parentElement;
    if(target.getAttribute('id') !== 'show-transaction-detail') target = target.parentElement;
    if(target.getAttribute('id') === 'show-transaction-detail') {
        e.preventDefault();

        // if next element sibling exists and next element sibling is tr.table__row-detail
        const table_row_details = target.parentElement.parentElement.nextElementSibling;
        if(table_row_details !== null && table_row_details.classList.contains('table__row-detail')) {
            table_row_details.classList.toggle('table__row-detail--show');

        // if next element sibling not exits or next element sibling is not tr.table__row-detail
        } else if(table_row_details === null || !table_row_details.classList.contains('table__row-detail')) {
            const tr = document.createElement('tr');
            tr.classList.add('table__row-detail');
            tr.classList.add('table__row-detail--show');
            tr.setAttribute('id',`transaksi_id_${target.dataset.transaksiId}`);
            tr.innerHTML = `<td colspan="6"><ul>
                <li><span class="table__title">Mie Duo</span>
                <span class="table__information">Harga :</span><span class="table__data">Rp 3500 / 1 Bungkus</span>
                <span class="table__information">Jumlah :</span><span class="table__data">2</span>
                <span class="table__information">Bayaran :</span><span class="table__data">Rp 7000</span></li>

                <li><span class="table__title">Telur</span>
                <span class="table__information">Harga :</span><span class="table__data">Rp 2000 / 1 Buah</span>
                <span class="table__information">Jumlah :</span><span class="table__data">1</span>
                <span class="table__information">Bayaran :</span><span class="table__data">Rp 2000</span></li>
            </ul></td>`;
           target.parentElement.parentElement.after(tr);
        }
    }
});
