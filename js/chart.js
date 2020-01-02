$(function() {
	var category7Doughnut = document.getElementById("category7Doughnut").getContext('2d');
	var status7Doughnut = document.getElementById("status7Doughnut").getContext('2d');
	var categoryDoughnut = document.getElementById("categoryDoughnut").getContext('2d');
	var statusDoughnut = document.getElementById("statusDoughnut").getContext('2d');
	var categoryLine = document.getElementById("categoryLine").getContext('2d');
	var categoryLine1 = document.getElementById("categoryLine1").getContext('2d');
	var categoryLine2 = document.getElementById("categoryLine2").getContext('2d');
	Chart.defaults.global.defaultFontColor = 'white';
	Chart.defaults.global.defaultFontSize = 18;
	Chart.defaults.global.defaultFontFamily = "微軟正黑體";
	$.ajax({
		url: '../chart/chartCase7Type.php',
		success: function (data) {
			var categoryDoughnutDataAll = JSON.parse(data);
			var categoryDoughnutData = {
				datasets: [{
					data: categoryDoughnutDataAll,
					backgroundColor: [
					'rgba(213, 203, 228, 0.8)',
					'rgba(135, 196, 184, 0.8)',
					'rgba(203, 229, 208, 0.8)',
					'rgba(255, 245, 185, 0.8)',
					'rgba(205, 233, 241, 0.8)',
					'rgba(249, 216, 231, 0.8)'
					]
				}],

				labels: [
				'日常',
				'外送',
				'修繕',
				'除蟲',
				'接送',
				'課業'
				]
			};
			var myCategory7Doughnut = new Chart(category7Doughnut, {
				type: 'doughnut',
				data: categoryDoughnutData,
				options: {
					title: {
						display: true,
						text: '近七天案件分佈',
						fontSize: 21
					},
					legend: {
						position: 'right'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
	$.ajax({
		url: '../chart/chartCase7Status.php',
		success: function (data) {
			var statusDoughnutDataAll = JSON.parse(data);
			var statusDoughnutData = {
				datasets: [{
					data: statusDoughnutDataAll,
					backgroundColor: [
					'rgba(136, 136, 137, 0.8)',
					'rgba(85, 173, 166, 0.8)',
					'rgba(243, 157, 92, 0.8)',
					'rgba(19, 173, 103, 0.8)',
					'rgba(62, 58, 57, 0.8)',
					'rgba(192, 0, 8, 0.8)'
					]
				}],

				labels: [
				'待接案',
				'進行中',
				'確認中',
				'已完成',
				'已過期',
				'爭議中'
				]
			};
			var myStatus7Doughnut = new Chart(status7Doughnut, {
				type: 'doughnut',
				data: statusDoughnutData,
				options: {
					title: {
						display: true,
						text: '近七天案件狀態分佈',
						fontSize: 21
					},
					legend: {
						position: 'right'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
	$.ajax({
		url: '../chart/chartCaseType.php',
		success: function (data) {
			var categoryDoughnutDataAll = JSON.parse(data);
			var categoryDoughnutData = {
				datasets: [{
					data: categoryDoughnutDataAll,
					backgroundColor: [
					'rgba(213, 203, 228, 0.8)',
					'rgba(135, 196, 184, 0.8)',
					'rgba(203, 229, 208, 0.8)',
					'rgba(255, 245, 185, 0.8)',
					'rgba(205, 233, 241, 0.8)',
					'rgba(249, 216, 231, 0.8)'
					]
				}],

				labels: [
				'日常',
				'外送',
				'修繕',
				'除蟲',
				'接送',
				'課業'
				]
			};
			var myCategoryDoughnut = new Chart(categoryDoughnut, {
				type: 'doughnut',
				data: categoryDoughnutData,
				options: {
					title: {
						display: true,
						text: '各類案件分佈',
						fontSize: 21
					},
					legend: {
						position: 'right'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
	$.ajax({
		url: '../chart/chartCaseStatus.php',
		success: function (data) {
			var statusDoughnutDataAll = JSON.parse(data);
			var statusDoughnutData = {
				datasets: [{
					data: statusDoughnutDataAll,
					backgroundColor: [
					'rgba(136, 136, 137, 0.8)',
					'rgba(85, 173, 166, 0.8)',
					'rgba(243, 157, 92, 0.8)',
					'rgba(19, 173, 103, 0.8)',
					'rgba(62, 58, 57, 0.8)',
					'rgba(192, 0, 8, 0.8)'
					]
				}],

				labels: [
				'待接案',
				'進行中',
				'確認中',
				'已完成',
				'已過期',
				'爭議中'
				]
			};
			var myStatusDoughnut = new Chart(statusDoughnut, {
				type: 'doughnut',
				data: statusDoughnutData,
				options: {
					title: {
						display: true,
						text: '各狀態案件分佈',
						fontSize: 21
					},
					legend: {
						position: 'right'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
	$.ajax({
		url: '../chart/chartCase7.php',
		success: function (data) {
			var type7DoughnutDataAll = JSON.parse(data);
			var categoryLineData = {
				datasets: [{
					data: type7DoughnutDataAll[0],
					backgroundColor: 'rgba(213, 203, 228, 0.8)',
					borderColor: 'rgba(213, 203, 228, 0.8)',
					label: '發案次數'
				},
				{
					data: type7DoughnutDataAll[1],
					backgroundColor: 'rgba(85, 173, 166, 0.8)',
					borderColor: 'rgba(85, 173, 166, 0.8)',
					label: '接案次數'
				}],

				labels: type7DoughnutDataAll[2]
			};
			var mycategoryLine = new Chart(categoryLine, {
				type: 'line',
				data: categoryLineData,
				options: {
					elements: {
						line: {
							fill: false
						}
					},
					title: {
						display: true,
						text: '近七天接/發案次數趨勢圖'
					},
					legend: {
						position: 'bottom'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
	$.ajax({
		url: '../chart/chartCaseType7.php',
		success: function (data) {
			var type7DoughnutDataAll = JSON.parse(data);
			var categoryLineData = {
				datasets: [{
					data: type7DoughnutDataAll[0],
					backgroundColor: 'rgba(213, 203, 228, 0.8)',
					borderColor: 'rgba(213, 203, 228, 0.8)',
					label: '日常'
				},
				{
					data: type7DoughnutDataAll[1],
					backgroundColor: 'rgba(135, 196, 184, 0.8)',
					borderColor: 'rgba(135, 196, 184, 0.8)',
					label: '外送'
				},
				{
					data: type7DoughnutDataAll[2],
					backgroundColor: 'rgba(203, 229, 208, 0.8)',
					borderColor: 'rgba(203, 229, 208, 0.8)',
					label: '修繕'
				},
				{
					data: type7DoughnutDataAll[3],
					backgroundColor: 'rgba(255, 245, 185, 0.8)',
					borderColor: 'rgba(255, 245, 185, 0.8)',
					label: '除蟲'
				},
				{
					data: type7DoughnutDataAll[4],
					backgroundColor: 'rgba(205, 233, 241, 0.8)',
					borderColor: 'rgba(205, 233, 241, 0.8)',
					label: '接送'
				},
				{
					data: type7DoughnutDataAll[5],
					backgroundColor: 'rgba(249, 216, 231, 0.8)',
					borderColor: 'rgba(249, 216, 231, 0.8)',
					label: '課業'
				}],

				labels: type7DoughnutDataAll[6]
			};
			var mycategoryLine = new Chart(categoryLine1, {
				type: 'line',
				data: categoryLineData,
				options: {
					elements: {
						line: {
							fill: false
						}
					},
					title: {
						display: true,
						text: '近七天發案種類趨勢圖'
					},
					legend: {
						position: 'bottom'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
	$.ajax({
		url: '../chart/chartCaseStatus7.php',
		success: function (data) {
			var status7DoughnutDataAll = JSON.parse(data);
			var categoryLineData = {
				datasets: [{
					data: status7DoughnutDataAll[0],
					backgroundColor: 'rgba(136, 136, 137, 0.8)',
					borderColor: 'rgba(136, 136, 137, 0.8)',
					label: '待接案'
				},
				{
					data: status7DoughnutDataAll[1],
					backgroundColor: 'rgba(85, 173, 166, 0.8)',
					borderColor: 'rgba(85, 173, 166, 0.8)',
					label: '進行中'
				},
				{
					data: status7DoughnutDataAll[2],
					backgroundColor: 'rgba(243, 157, 92, 0.8)',
					borderColor: 'rgba(243, 157, 92, 0.8)',
					label: '確認中'
				},
				{
					data: status7DoughnutDataAll[3],
					backgroundColor: 'rgba(19, 173, 103, 0.8)',
					borderColor: 'rgba(19, 173, 103, 0.8)',
					label: '已完成'
				},
				{
					data: status7DoughnutDataAll[4],
					backgroundColor: 'rgba(62, 58, 57, 0.8)',
					borderColor: 'rgba(62, 58, 57, 0.8)',
					label: '已過期'
				},
				{
					data: status7DoughnutDataAll[5],
					backgroundColor: 'rgba(192, 0, 8, 0.8)',
					borderColor: 'rgba(192, 0, 8, 0.8)',
					label: '爭議中'
				}],

				labels: status7DoughnutDataAll[6]
			};
			var mycategoryLine = new Chart(categoryLine2, {
				type: 'line',
				data: categoryLineData,
				options: {
					elements: {
						line: {
							fill: false
						}
					},
					title: {
						display: true,
						text: '近七天案件完成度趨勢圖'
					},
					legend: {
						position: 'bottom'
					},
					tooltips: {
						intersect: true
					}
				}
			});
		}
	});
});