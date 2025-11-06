Chart.register(ChartDataLabels);
var options = {
    maintainAspectRatio: false,
    responsive: true,
    plugins: { legend: { display: false } },
    layout: { padding: { right: 17, left: 15, top: 15 } },
    scales: {
        x: { display: true, grid: { display: false } },
        y: { display: false, grid: { display: false } }
    },
}

// console.log(dados.sql_rv);

const dataRV = {
    labels: dados.legends_graf,
    datasets: [{
        type: 'line',
        label: 'Historico Quadrante',
        backgroundColor: (context) => {
            const bgColor = [
                'rgba(26, 188, 156, 1)',
                'rgba(76, 196, 172, .7)',
                // 'rgba(136, 206, 191, .5)',
                'rgba(194, 249, 237, .5)',
            ];
            if (!context.chart.chartArea) {
                return;
            }
            const { ctx, data, chartArea: { top, bottom } } = context.chart;
            const gradientBg = ctx.createLinearGradient(0, top, 0, bottom);
            const colorTranches = 1 / (bgColor.length - 1);
            for (let i = 0; i < bgColor.length; i++) {
                gradientBg.addColorStop(0 + i * colorTranches, bgColor[i])
            }
            return gradientBg;
        },
        pointBachgroundColor: '#000',
        fill: true,
        data: dados.histRV,
        tension: 0.3,
        datalabels: {
            align: 'start',
            anchor: 'end',
            align: 'end',
            color: '#000',
            font: {
                size: 10
            }
        },
        order: 1
    }]
};

new Chart("myChart1", {
    data: dataRV,
    options: options,
    plugins: [ChartDataLabels]
})
            

