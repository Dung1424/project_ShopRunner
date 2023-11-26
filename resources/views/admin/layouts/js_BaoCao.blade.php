<script src="admin/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="admin/js/plugins/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script type="text/javascript">

    $( function() {
        $( "#datepicker1" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat:"yy-mm-dd",
            dayNamesMin: ["thứ 2","thứ 3","thứ 4","thứ 5","thứ 6","thứ 7","chủ nhật"],
            duration: "slow"
        });
        $( "#datepicker2" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat:"yy-mm-dd",
            dayNamesMin: ["thứ 2","thứ 3","thứ 4","thứ 5","thứ 6","thứ 7","chủ nhật"],
            duration: "slow"
        });
        $( "#datepicker3" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat:"yy-mm-dd",
            dayNamesMin: ["thứ 2","thứ 3","thứ 4","thứ 5","thứ 6","thứ 7","chủ nhật"],
            duration: "slow"
        });
        $( "#datepicker4" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat:"yy-mm-dd",
            dayNamesMin: ["thứ 2","thứ 3","thứ 4","thứ 5","thứ 6","thứ 7","chủ nhật"],
            duration: "slow"
        });
    } );


</script>
<!-- Script cho biểu đồ đầu tiên -->
<script>
    let ctxSoldChart = document.getElementById('productSoldChart').getContext('2d');
    let chartSold;

    function fetchSoldChartData(year) {
        fetch(`/admin/revenue-chart?year=${year}`)
            .then(response => response.json())
            .then(data => {
                if (chartSold) {
                    chartSold.data.labels = data.labels;
                    chartSold.data.datasets[0].data = data.productsSold;
                    chartSold.update();
                } else {
                    createSoldChart(data); // Tạo biểu đồ nếu chưa có
                }
            });
    }

    // Hàm thay đổi năm cho biểu đồ đầu tiên
    function changeYearProductSold(year) {
        fetchSoldChartData(year);
    }

    function createSoldChart(data) {
        chartSold = new Chart(ctxSoldChart, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Products sold',
                    data: data.productsSold,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 10,
                        max: 100,
                        min: 0,
                    }
                }
            }
        });
    }

    // Fetch dữ liệu mặc định khi trang được load
    fetchSoldChartData(2023); // Thay đổi ngày mặc định cho phù hợp với nhu cầu của bạn

</script>

<!-- Script cho biểu đồ thứ hai -->
<script>
    let ctxRevenueChart = document.getElementById('revenue').getContext('2d');
    let chartRevenue;

    function fetchRevenueData(year) {
        fetch(`/admin/revenue-chart-doanh-thu?year=${year}`)
            .then(response => response.json())
            .then(data => {
                if (chartRevenue) {
                    chartRevenue.data.labels = data.labels;
                    chartRevenue.data.datasets[0].data = data.revenue;
                    chartRevenue.update();
                } else {
                    createRevenueChart(data);
                }
            });
    }

    // Hàm thay đổi năm cho biểu đồ thứ hai
    function changeYearRevenue(year) {
        fetchRevenueData(year);
    }

    function createRevenueChart(data) {
        chartRevenue = new Chart(ctxRevenueChart, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Revenue',
                    data: data.revenue,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 10,
                        max: 10000,
                        min: 0,
                    }
                }
            }
        });
    }

    // Fetch dữ liệu mặc định khi trang được load
    fetchRevenueData(2023); // Thay đổi ngày mặc định cho phù hợp với nhu cầu của bạn

</script>

<!-- Script cho biểu đồ thứ ba -->
<script>
    let ctxSoldChartDay = document.getElementById('productSoldChartDay').getContext('2d');
    let chartSoldDay;

    document.getElementById('btn-dashboard-filter').addEventListener('click', function () {
        let startDate = document.getElementById('datepicker1').value;
        let endDate = document.getElementById('datepicker2').value;

        fetchSoldChartDataDay(startDate, endDate);
    });

    function fetchSoldChartDataDay(startDate, endDate) {
        fetch(`/admin/revenue-chart-day?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                updateSoldChartDay(data);
            });
    }

    function updateSoldChartDay(data) {
        if (chartSoldDay) {
            chartSoldDay.data.labels = data.labels;
            chartSoldDay.data.datasets[0].data = data.productsSoldDay;
            chartSoldDay.update();
        } else {
            createSoldChartDay(data);
        }
    }

    function createSoldChartDay(data) {
        chartSoldDay = new Chart(ctxSoldChartDay, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Products sold',
                    data: data.productsSoldDay,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 10,
                        max: 100,
                        min: 0,
                    }
                }
            }
        });
    }

    // Thực hiện fetch dữ liệu mặc định khi trang được load
    fetchSoldChartDataDay('2023-11-01', '2023-11-25'); // Thay đổi ngày mặc định cho phù hợp với nhu cầu của bạn

</script>
<!-- Script cho biểu đồ thứ bốn -->
<script>
    let ctxRevenueDay = document.getElementById('revenueDay').getContext('2d');
    let chartRevenueDay;

    document.getElementById('btn-dashboard-filter1').addEventListener('click', function () {
        let startDate = document.getElementById('datepicker3').value;
        let endDate = document.getElementById('datepicker4').value;

        fetchRevenueDataDay(startDate, endDate);
    });

    function fetchRevenueDataDay(startDate, endDate) {
        fetch(`/admin/revenue-chart-doanh-thu-day?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                updateRevenueChartDay(data);
            });
    }

    function updateRevenueChartDay(data) {
        if (chartRevenueDay) {
            chartRevenueDay.data.labels = data.labels;
            chartRevenueDay.data.datasets[0].data = data.revenueDay;
            chartRevenueDay.update();
        } else {
            createRevenueChartDay(data);
        }
    }

    function createRevenueChartDay(data) {
        chartRevenueDay = new Chart(ctxRevenueDay, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Revenue',
                    data: data.revenueDay,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 10,
                        max: 3000,
                        min: 0,
                    }
                }
            }
        });
    }

    // Thực hiện fetch dữ liệu mặc định khi trang được load
    fetchRevenueDataDay('2023-11-01', '2023-11-25'); // Thay đổi ngày mặc định cho phù hợp với nhu cầu của bạn

</script>




<script>
    oTable = $('#sampleTable').dataTable();
    $('#all').click(function (e) {
        $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
        e.stopImmediatePropagation();
    });

    //EXCEL
    // $(document).ready(function () {
    //   $('#').DataTable({

    //     dom: 'Bfrtip',
    //     "buttons": [
    //       'excel'
    //     ]
    //   });
    // });


    //Thời Gian
    function time() {
        var today = new Date();
        var weekday = new Array(7);
        weekday[0] = "Chủ Nhật";
        weekday[1] = "Thứ Hai";
        weekday[2] = "Thứ Ba";
        weekday[3] = "Thứ Tư";
        weekday[4] = "Thứ Năm";
        weekday[5] = "Thứ Sáu";
        weekday[6] = "Thứ Bảy";
        var day = weekday[today.getDay()];
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        nowTime = h + " giờ " + m + " phút " + s + " giây";
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = day + ', ' + dd + '/' + mm + '/' + yyyy;
        tmp = '<span class="date"> ' + today + ' - ' + nowTime +
            '</span>';
        document.getElementById("clock").innerHTML = tmp;
        clocktime = setTimeout("time()", "1000", "Javascript");

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    }
    //In dữ liệu
    var myApp = new function () {
        this.printTable = function () {
            var tab = document.getElementById('sampleTable');
            var win = window.open('', '', 'height=700,width=700');
            win.document.write(tab.outerHTML);
            win.document.close();
            win.print();
        }
    }
    //     //Sao chép dữ liệu
    //     var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

    // copyTextareaBtn.addEventListener('click', function(event) {
    //   var copyTextarea = document.querySelector('.js-copytextarea');
    //   copyTextarea.focus();
    //   copyTextarea.select();

    //   try {
    //     var successful = document.execCommand('copy');
    //     var msg = successful ? 'successful' : 'unsuccessful';
    //     console.log('Copying text command was ' + msg);
    //   } catch (err) {
    //     console.log('Oops, unable to copy');
    //   }
    // });


    //Modal
    $("#show-emp").on("click", function () {
        $("#ModalUP").modal({ backdrop: false, keyboard: false })
    });
</script>

<!-- Google analytics script-->
<script type="text/javascript">
    if (document.location.hostname == 'pratikborsadiya.in') {
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
    }
</script>



