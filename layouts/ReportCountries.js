function doDrawGeneralChart(ctx_string,data,myLabels)
{

	var ctx = document.getElementById(ctx_string);
	myGeneralChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: myLabels,
        datasets: [{
            label: 'Кол-во паспортов',
            data: data.a1,
            backgroundColor: [
                'rgb(77, 178, 179)',
                /*'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'*/
            ],
            borderColor: [
                'rgb(38, 165, 166)',
                /*'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'*/
            ],
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        scales: {
            y: {
                beginAtZero: true
            }
        },
		plugins: {
			legend: {
				position: 'none',
			},
			title: {
				display: true,
				text: 'Кол-во паспортов'
			}
		}
    }
});
}