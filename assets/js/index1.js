$(function(e){
	
	/* Data Table */
	$('#example1').DataTable({
		//"paging":   true,
		paging: true,
      lengthChange: false,
      filter: true,
      ordering: false,
      info: true,
      autoWidth: true,
      pageLength: 10,
      responsive: true,
      //dom: "ilfBpt",


		language: {
			searchPlaceholder: 'Cerca',
			sSearch: '',
			lengthMenu: '_MENU_',
			paginate: {
		        "first":      "First",
		        "last":       "Last",
		        "next":       "Successivo",
		        "previous":   "Precedente"
		    },
		    info: "Risultati _START_ di _END_ di _TOTAL_ Totali",
		    emptyTable: "Nessun record trovato",
		}
	});

	$('#example2').DataTable({
		//"paging":   true,
		paging: false,
      lengthChange: false,
      filter: false,
      ordering: true,
      info: false,
      autoWidth: true,
      pageLength: 25,
      responsive: true,
      //dom: "ilfBpt",


		language: {
			searchPlaceholder: 'Cerca',
			sSearch: '',
			lengthMenu: '_MENU_',
			paginate: {
		        "first":      "First",
		        "last":       "Last",
		        "next":       "Successivo",
		        "previous":   "Precedente"
		    },
		    info: "Risultati _START_ di _END_ di _TOTAL_ Totali",
		    emptyTable: "Nessun record trovato",
		}
	});

	$('#example3').DataTable({
		//"paging":   true,
		paging: false,
      lengthChange: false,
      filter: false,
      ordering: false,
      info: false,
      autoWidth: true,
      pageLength: 25,
      responsive: true,
      language: {
			searchPlaceholder: 'Cerca',
			sSearch: '',
			lengthMenu: '_MENU_',
			paginate: {
		        "first":      "First",
		        "last":       "Last",
		        "next":       "Successivo",
		        "previous":   "Precedente"
		    },
		    info: "Risultati _START_ di _END_ di _TOTAL_ Totali",
		    emptyTable: "Nessun record trovato",
		}
      
      //dom: "ilfBpt",


		// language: {
		// 	searchPlaceholder: 'Cerca',
		// 	sSearch: '',
		// 	lengthMenu: '_MENU_',
		// }
	});
	
	/* Chartjs (#area-chart1) */
	// var myCanvas = document.getElementById("area-chart1");
	// myCanvas.height = "70";
	// var myCanvasContext = myCanvas.getContext("2d");
	// var myChart = new Chart(myCanvas, {
	// 	type: 'line',
	// 	data: {
	// 		labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	// 		type: 'line',
	// 		datasets: [{
	// 			label: 'All Orders',
	// 			data: [0, 45, 93, 53, 61, 27, 54, 43, 19, 46, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 31 ],
	// 			backgroundColor: 'transparent',
	// 			borderColor: '#fff ',
	// 			pointBackgroundColor: '#fff',
	// 			pointHoverBackgroundColor: 'transparent',
	// 			pointBorderColor: 'transparent',
	// 			pointHoverBorderColor: 'transparent',
	// 			pointBorderWidth: 0,
	// 			pointRadius: 0,
	// 			pointHoverRadius: 0,
	// 			borderWidth: 2
	// 		}, ]
	// 	},
	// 	options: {
	// 		maintainAspectRatio: false,
	// 		legend: {
	// 			display: false
	// 		},
	// 		responsive: true,
	// 		tooltips: {
	// 			enabled: false,
	// 			mode: 'index',
	// 			titleFontSize: 12,
	// 			titleFontColor: 'rgba(225,225,225,0.9)',
	// 			bodyFontColor: 'rgba(225,225,225,0.9)',
	// 			backgroundColor: 'rgba(0,0,0,0.7)',
	// 			cornerRadius: 3,
	// 			intersect: false,
	// 		},
	// 		scales: {
	// 			xAxes: [{
	// 				gridLines: {
	// 					color: 'transparent',
	// 					zeroLineColor: 'transparent'
	// 				},
	// 				ticks: {
	// 					fontSize: 2,
	// 					fontColor: 'transparent'
	// 				}
	// 			}],
	// 			yAxes: [{
	// 				display: false,
	// 				ticks: {
	// 					display: false,
	// 				}
	// 			}]
	// 		},
	// 		title: {
	// 			display: false,
	// 		},
	// 		elements: {
	// 			line: {
	// 				borderWidth: 1
	// 			},
	// 			point: {
	// 				radius: 4,
	// 				hitRadius: 10,
	// 				hoverRadius: 4
	// 			}
	// 		}
	// 	}
	// });
	// /* Chartjs (#area-chart1) closed */
	
	// /* Chartjs (#area-chart2) */
	// var myCanvas = document.getElementById("area-chart2");
	// myCanvas.height = "70";
	// var myCanvasContext = myCanvas.getContext("2d");
	// var myChart = new Chart(myCanvas, {
	// 	type: 'line',
	// 	data: {
	// 		labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	// 		type: 'line',
	// 		datasets: [{
	// 			label: 'Pending Orders',
	// 			data: [0, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46,45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51],
	// 			backgroundColor: 'transparent',
	// 			borderColor: '#fff ',
	// 			pointBackgroundColor: '#fff',
	// 			pointHoverBackgroundColor: 'transparent',
	// 			pointBorderColor: 'transparent',
	// 			pointHoverBorderColor: 'transparent',
	// 			pointBorderWidth: 0,
	// 			pointRadius: 0,
	// 			pointHoverRadius: 0,
	// 			borderWidth: 2
	// 		}, ]
	// 	},
	// 	options: {
	// 		maintainAspectRatio: false,
	// 		legend: {
	// 			display: false
	// 		},
	// 		responsive: true,
	// 		tooltips: {
	// 			enabled: false,
	// 			mode: 'index',
	// 			titleFontSize: 12,
	// 			titleFontColor: 'rgba(225,225,225,0.9)',
	// 			bodyFontColor: 'rgba(225,225,225,0.9)',
	// 			backgroundColor: 'rgba(0,0,0,0.7)',
	// 			cornerRadius: 3,
	// 			intersect: false,
	// 		},
	// 		scales: {
	// 			xAxes: [{
	// 				gridLines: {
	// 					color: 'transparent',
	// 					zeroLineColor: 'transparent'
	// 				},
	// 				ticks: {
	// 					fontSize: 2,
	// 					fontColor: 'transparent'
	// 				}
	// 			}],
	// 			yAxes: [{
	// 				display: false,
	// 				ticks: {
	// 					display: false,
	// 				}
	// 			}]
	// 		},
	// 		title: {
	// 			display: false,
	// 		},
	// 		elements: {
	// 			line: {
	// 				borderWidth: 1
	// 			},
	// 			point: {
	// 				radius: 4,
	// 				hitRadius: 10,
	// 				hoverRadius: 4
	// 			}
	// 		}
	// 	}
	// });
	// /* Chartjs (#area-chart2) closed */
	
	// /* Chartjs (#area-chart3) */
	// var myCanvas = document.getElementById("area-chart3");
	// myCanvas.height = "70";
	// var myCanvasContext = myCanvas.getContext("2d");
	// var myChart = new Chart(myCanvas, {
	// 	type: 'line',
	// 	data: {
	// 		labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	// 		type: 'line',
	// 		datasets: [{
	// 			label: 'Refund Orders',
	// 			data: [85, 163, 124, 135, 78, 123, 91, 22, 136, 125, 125, 114, 158, 145, 15, 175, 163, 145],
	// 			backgroundColor: 'transparent',
	// 			borderColor: '#fff ',
	// 			pointBackgroundColor: '#fff',
	// 			pointHoverBackgroundColor: 'transparent',
	// 			pointBorderColor: 'transparent',
	// 			pointHoverBorderColor: 'transparent',
	// 			pointBorderWidth: 0,
	// 			pointRadius: 0,
	// 			pointHoverRadius: 0,
	// 			borderWidth: 2
	// 		}, ]
	// 	},
	// 	options: {
	// 		maintainAspectRatio: false,
	// 		legend: {
	// 			display: false
	// 		},
	// 		responsive: true,
	// 		tooltips: {
	// 			enabled: false,
	// 			mode: 'index',
	// 			titleFontSize: 12,
	// 			titleFontColor: 'rgba(225,225,225,0.9)',
	// 			bodyFontColor: 'rgba(225,225,225,0.9)',
	// 			backgroundColor: 'rgba(0,0,0,0.7)',
	// 			cornerRadius: 3,
	// 			intersect: false,
	// 		},
	// 		scales: {
	// 			xAxes: [{
	// 				gridLines: {
	// 					color: 'transparent',
	// 					zeroLineColor: 'transparent'
	// 				},
	// 				ticks: {
	// 					fontSize: 2,
	// 					fontColor: 'transparent'
	// 				}
	// 			}],
	// 			yAxes: [{
	// 				display: false,
	// 				ticks: {
	// 					display: false,
	// 				}
	// 			}]
	// 		},
	// 		title: {
	// 			display: false,
	// 		},
	// 		elements: {
	// 			line: {
	// 				borderWidth: 1
	// 			},
	// 			point: {
	// 				radius: 4,
	// 				hitRadius: 10,
	// 				hoverRadius: 4
	// 			}
	// 		}
	// 	}
	// });
	/* Chartjs (#area-chart3) closed */
	
	/*-----Select2-----*/
	$('.select2').select2({
		minimumResultsForSearch: Infinity
	});
	/*-----Select2t-----*/
	
	
	/*-----morrisDonut1-----*/
	// new Morris.Donut({
	// 	element: 'morrisDonut1',
	// 	data: [
	// 		{value: 75, label: 'Men'},
	// 		{value: 20, label: 'Womens'},
	// 		{value: 30, label: 'Womens'},
	// 		{value: 56, label: ''},
	// 	],
	// 	colors: ['#ffb35e', '#58deb6', '#4265c1', "#eeeeee"],
	//     resize: true,
	// 	backgroundColor: 'transparent',
	// 	labelColor: '#728096',
	// 	formatter: function (x) { return x + "%"}
	// 	}).on('click', function(i, row){
	// 	  console.log(i, row);
	// });
	// $( "#morrisDonut1" ).mouseover(function() {
	// 	prepareMorrisDonutChart();
	// });
	// $( document ).ready(function() {
	// 	prepareMorrisDonutChart();
	// });
	// function prepareMorrisDonutChart() {
	// 	$("#morrisDonut1 tspan:first").css("display","none");
	// 	$("#morrisDonut1 tspan:nth-child(1)").css("font-size","30px");

	// 	var isi = $("#morrisDonut1 tspan:first").html();
	// 	$('#morrisDonut1Span').text(isi);
	// }
	// /*-----morrisDonut1-----*/

	
	// /* Chart-js (#statistics) */
	// var myCanvas = document.getElementById('statistics').getContext("2d");
	// myCanvas.height="290";
	
	// var gradientStroke = myCanvas.createLinearGradient(0, 100, 0, 280);
	// gradientStroke.addColorStop(0, '#d72e04');
	// gradientStroke.addColorStop(1, '#de3c12');
	
	// var gradientStroke1 = myCanvas.createLinearGradient(0, 80, 0, 280);
	// gradientStroke1.addColorStop(0, '#1c46bd');
	// gradientStroke1.addColorStop(1, '#1744b8');


	// var myChart = new Chart( myCanvas, {
	// 	type: 'line',
	// 	data : {
	// 		labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ''],
	// 		datasets: [
	// 		{
	// 			label: "Expenses",
	// 			data: [210, 140, 110, 140, 210, 250, 240, 190, 150, 150,180, 230,290 ],
	// 			backgroundColor: 'rgba(237, 238 ,244, 0.4)',
	// 			borderColor: gradientStroke,
	// 			pointBackgroundColor:'#fff',
	// 			pointBorderWidth :2,
	// 			pointRadius :0,
	// 			pointHoverRadius :5,
	// 			labelColor:gradientStroke,
	// 			borderWidth: 4,
    //             pointStyle: 'circle',
    //             pointBorderColor: '#d72e04',
	// 			pointBackgroundColor: '#fff',

	// 		}, {
	// 			label: "Budget",
	// 			data: [250, 150, 100,80, 80,100, 140, 200, 220, 180, 120, 120,  220],
	// 			backgroundColor: 'rgba(237, 238 ,244, 0.4)',
	// 			borderColor: gradientStroke1,
	// 			pointBackgroundColor:'#fff',
	// 			pointBorderWidth :2,
	// 			pointRadius :0,
	// 			pointHoverRadius :5,
	// 			borderWidth: 4,
	// 			pointStyle: 'circle',
    //             pointBorderColor: '#163eaf',
	// 			pointBackgroundColor: '#fff',
	// 		}
	// 	  ]
	// 	},
	// 	options: {
	// 		responsive: true,
	// 		maintainAspectRatio: false,
	// 		legend: {
	// 			display:false,
	// 		    labels: {
	// 				fontColor: '#728096'
	// 		    }
	// 		},
	// 		tooltips: {
	// 			show: true,
	// 			showContent: true,
	// 			alwaysShowContent: true,
	// 			triggerOn: 'mousemove',
	// 			trigger: 'axis',
	// 			axisPointer:
	// 			{
	// 				label: {
	// 					show: false,
	// 					color: '#728096',
	// 				},
	// 			}
	// 		},

	// 		scales: {
	// 			xAxes: [ {
	// 				gridLines: {
	// 					drawBorder: false,
	// 					display:false
	// 				},
	// 				ticks: {
	// 					fontColor: '#728096',
	// 				},
	// 				display: true,
	// 				scaleLabel: {
	// 					display: false,
	// 					labelString: 'Month',
	// 					fontColor: '#728096'
	// 				}
	// 			} ],
	// 			yAxes: [ {
	// 				gridLines: {
	// 					color: 'rgba(114 ,128 ,150,0.1)',
	// 					zeroLineColor: 'rgba(114 ,128 ,150,0.5)',
	// 					drawBorder: false,
	// 					display:false
	// 				},
	// 				ticks: {
	// 					fontSize: 12,
	// 					fontColor: '#728096',
	// 					padding: 0,
	// 					beginAtZero: true,
	// 					stepSize: 100,
	// 					max: 500
	// 				},
	// 			} ]
	// 		},
	// 		title: {
	// 			display: false,
	// 		},
	// 		elements: {
	// 			line: {
	// 				borderWidth: 2
	// 			},
	// 			point: {
	// 				radius: 0,
	// 				hitRadius: 10,
	// 				hoverRadius: 5
	// 			}
	// 		}
	// 	}
	// })
	/* Chart-js (#statistics) closed */
	
 });