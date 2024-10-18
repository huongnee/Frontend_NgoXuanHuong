@extends('layouts.layout')
@section('title', 'Báo cáo')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        canvas {
            max-width: 50%; /* Điều chỉnh kích thước tối đa của canvas */
            max-height: 50%; /* Điều chỉnh chiều cao tối đa của canvas */
            margin: auto; /* Canh giữa canvas */
        }
        .chart-container {
            width: 800px; /* Chiều rộng tùy chỉnh */
            height: 400px; /* Chiều cao tùy chỉnh */
            margin: auto; /* Canh giữa */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="dashboard">
            <h1 class="text-center mb-5">REPORTS</h1>
            <div class="dashboard-grid">
                <div class="card">
                    <h1>Báo cáo doanh thu</h1>
                    <div class="mt-4">
                        <h4>Tổng số đơn hàng: {{ $totalOrders }}</h4>
                        <h4>Tổng số khách hàng: {{ $totalCustomers }}</h4>
                    </div>

                    <h3>Doanh thu theo từng danh mục</h3>
                    <canvas id="categoryRevenueChart" class="chart-container"></canvas>

                    <h3>Doanh thu theo ngày</h3>
                    <canvas id="revenueByDateChart" class="chart-container"></canvas>

                    <h3>Doanh thu theo tháng</h3>
                    <canvas id="revenueByMonthChart" class="chart-container"></canvas>

                    <h3>Doanh thu theo năm</h3>
                    <canvas id="revenueByYearChart" class="chart-container"></canvas>

                    <h3>Doanh thu theo phương thức thanh toán</h3>
                    <canvas id="revenueByPaymentMethodChart" class="chart-container"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // 1. Biểu đồ doanh thu theo từng danh mục (Bar chart)
                var categoryLabels = @json($categoryRevenue->pluck('category_name'));
                var categoryData = @json($categoryRevenue->pluck('total_revenue'));

                var ctx1 = document.getElementById('categoryRevenueChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: categoryData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' VND'; // Thêm đơn vị VND
                                    }
                                }
                            }
                        }
                    }
                });

                // 2. Biểu đồ doanh thu theo ngày (Line chart)
                var dateLabels = @json($revenueByDate->pluck('date'));
                var dateData = @json($revenueByDate->pluck('total_revenue'));
                var ctx2 = document.getElementById('revenueByDateChart').getContext('2d');
                new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: dateLabels,
                        datasets: [{
                            label: 'Doanh thu theo ngày (VND)',
                            data: dateData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' VND'; // Thêm đơn vị VND
                                    }
                                }
                            }
                        }
                    }
                });

                // 3. Biểu đồ doanh thu theo tháng (Bar chart)
                var monthLabels = @json($revenueByMonth->pluck('month'));
                var monthData = @json($revenueByMonth->pluck('total_revenue'));
                var ctx3 = document.getElementById('revenueByMonthChart').getContext('2d');
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Doanh thu theo tháng (VND)',
                            data: monthData,
                            backgroundColor: 'rgba(153, 102, 255, 0.5)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' VND'; // Thêm đơn vị VND
                                    }
                                }
                            }
                        }
                    }
                });

                // 4. Biểu đồ doanh thu theo năm (Bar chart)
                var yearLabels = @json($revenueByYear->pluck('year'));
                var yearData = @json($revenueByYear->pluck('total_revenue'));
                var ctx4 = document.getElementById('revenueByYearChart').getContext('2d');
                new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: yearLabels,
                        datasets: [{
                            label: 'Doanh thu theo năm (VND)',
                            data: yearData,
                            backgroundColor: 'rgba(255, 159, 64, 0.5)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' VND'; // Thêm đơn vị VND
                                    }
                                }
                            }
                        }
                    }
                });

                // 5. Biểu đồ doanh thu theo phương thức thanh toán (Pie chart)
                var paymentMethodLabels = @json($revenueByPaymentMethod->pluck('payment_method'));
                var paymentMethodData = @json($revenueByPaymentMethod->pluck('total_revenue'));
                var ctx5 = document.getElementById('revenueByPaymentMethodChart').getContext('2d');
                new Chart(ctx5, {
                    type: 'pie',
                    data: {
                        labels: paymentMethodLabels,
                        datasets: [{
                            label: 'Doanh thu theo phương thức thanh toán (VND)',
                            data: paymentMethodData,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                        }]
                    },
                });
            });
        </script>
    </div>
</body>
</html>
@endsection
