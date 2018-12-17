$(document).ready(function(){
	$.ajax({
		url: "http://localhost/motor/backend/web/index.php?r=transaksi%2Fchart",
		method: "GET",
		success: function(data) {
			console.log(data);
			var transaksi = [];
			var payment = [];

			for(var i in data) {
				transaksi.push("Player " + data[i].transaksiId);
				payment.push(data[i].payment);
			}

			var chartdata = {
				labels: transaksi,
				datasets : [
					{
						label: 'Payment Transaksi',
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: score
					}
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});
