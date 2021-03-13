const options = {
    chart: {
        type: 'area',
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false }
    },
    colors: ['#7874f7'],
    series: [{
        name: 'Transaksi',
        data: [250, 123, 320, 210, 410, 350, 450]
    }],
    xaxis: {
        categories: ['22 Dec', '23 Dec', '24 Dec', '25 Dec', '26 Dec', '27 Dec', '1 Dec'],
        labels: {
            style: {
                colors: '#999999',
                fontFamily: 'roboto-regular'
            }
        },
        tooltip: {
            enabled: false
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: '#999999',
                fontFamily: 'roboto-regular'
            }
        }
    },
    dataLabels: {
        enabled: false,
   },
    grid: {
        borderColor: '#e8e8e8',
        strokeDashArray: 4
    }
};
const chart = new ApexCharts(document.querySelector('.chart .chart__body'), options);
chart.render();
