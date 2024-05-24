@extends('system')
@section('content-admin')
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Basic styling */
        .dashboard {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: pink;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Dashboard cards */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .card {
            flex: 1 1 300px;
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }

        .card i {
            font-size: 40px;
            color: #1abc9c;
            float: right;
        }

        
    </style>
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('/Dashboard') }}" title="Go to Home" class="tip-bottom current"><i
                        class="icon-home"></i> Home</a></div>
            <h1>Dashboard</h1>
        </div>
        <div class="dashboard">
            <div class="container">
                <div class="cards-container">
                    <div class="card">
                        <h2>Tổng danh thu</h2>
                        <p>{{ number_format($totalRevenue) }} ₫</p>
                        <br>
                        <br>
                        <canvas id="totalRevenueChart"></canvas>
                    </div>
                    <div class="card">
                        <h2>Số lượng sản phẩm đã bán</h2>
                        <p>{{ $totalSoldQuantity }}</p>
                        <br>
                        <br>
                        <canvas id="totalSoldQuantityChart"></canvas>
                    </div>
                    <div class="card">
                        <h2>Sản phẩm bán chạy nhất</h2>
                        <p>{{ $bestSellingProduct->name }}</p>
                        <p>Số lượng đã bán: {{ $bestSellingProduct->sold_quantity }}</p>
                        <br>
                        <canvas id="bestSellingProductChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Lấy dữ liệu từ blade template
        var totalRevenue = {{ $totalRevenue }};
        var totalSoldQuantity = {{ $totalSoldQuantity }};
        var bestSellingProduct = "{{ $bestSellingProduct->name }}";

        // Khởi tạo biểu đồ hình tròn cho Tổng doanh thu
        var totalRevenueChart = new Chart(document.getElementById('totalRevenueChart'), {
            type: 'doughnut',
            data: {
                labels: ['Tổng doanh thu', ''],
                datasets: [{
                    data: [{{ $totalRevenue }}, 100 - {{ $totalRevenue }}],
                    backgroundColor: ['#E65C19', '#f9f9f9'],
                }]
            }

        });

        // Khởi tạo biểu đồ hình tròn cho Số lượng sản phẩm đã bán
        var totalSoldQuantityChart = new Chart(document.getElementById('totalSoldQuantityChart'), {
            type: 'doughnut',
            data: {
                labels: ['Số lượng đã bán', ''],
                datasets: [{
                    data: [{{ $totalSoldQuantity }}, 100 - {{ $totalSoldQuantity }}],
                    backgroundColor: ['#FDDE55', '#f9f9f9'],
                }]
            }

        });

        // Khởi tạo biểu đồ hình tròn cho Sản phẩm bán chạy nhất
        var bestSellingProductChart = new Chart(document.getElementById('bestSellingProductChart'), {
            type: 'doughnut',
            data: {
                labels: ['{{ $bestSellingProduct->name }}', ''],
                datasets: [{
                    data: [100, 0], 
                    backgroundColor: ['#03AED2', '#f9f9f9'],
                }]
            }

        });
    </script>
@endsection
