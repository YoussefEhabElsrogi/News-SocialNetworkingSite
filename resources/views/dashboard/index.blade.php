@extends('layouts.dashboard.app')

@section('title', 'Home')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Start Content Row -->
        @livewire('dashboard.statistics')
        <!-- End Content Row -->

        <!-- Start Chart Row -->
        <div class="row">
            <div class="col-6">
                <h4>Posts by Month</h4>
                <canvas id="postsChart"></canvas>
            </div>

            <div class="col-6">
                <h4>Users by Month</h4>
                <canvas id="usersChart"></canvas>
            </div>
        </div>
        <!-- End Chart Row -->

        <!-- Start Chart Row -->
        <div class="row">
            <div class="col-6">
                <h4>Comments by Month</h4>
                <canvas id="commentsChart"></canvas>
            </div>

            <div class="col-6">
                <h4>Contacts by Month</h4>
                <canvas id="contactsChart"></canvas>
            </div>
        </div>
        <!-- End Chart Row -->

        <!-- Start Posts && Comments Row -->
        @livewire('dashboard.latest-posts-comments')
        <!-- End Posts && Comments Row -->

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to create a chart
        function createChart(chartId, labels, data, label, borderColor, backgroundColor, type) {
            var ctx = document.getElementById(chartId).getContext('2d');
            return new Chart(ctx, {
                type: type, // Type of chart: line or bar
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: borderColor,
                        backgroundColor: backgroundColor,
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: type === 'bar' ? {
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: label + ' Count'
                            },
                            beginAtZero: true
                        }
                    } : {}, // Only use the scales option for bar charts
                }
            });
        }

        // Creating Posts Chart - Line chart
        createChart('postsChart', @json($postsChart['label']), @json($postsChart['data']), 'Posts Count',
            'rgba(0, 123, 255, 1)', 'rgba(0, 123, 255, 0.2)', 'line');

        // Creating Users Chart - Bar chart
        createChart('usersChart', @json($usersChart['label']), @json($usersChart['data']), 'Users Count',
            'rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 0.2)', 'bar');

        // Creating Comments Chart - Bar chart
        createChart('commentsChart', @json($commentsChart['label']), @json($commentsChart['data']), 'Comments Count',
            'rgba(153, 102, 255, 1)', 'rgba(153, 102, 255, 0.2)', 'bar');

        // Creating Contacts Chart - Line chart
        createChart('contactsChart', @json($contactsChart['label']), @json($contactsChart['data']), 'Contacts Count',
            'rgba(75, 192, 192, 1)', 'rgba(75, 192, 192, 0.2)', 'line');
    </script>
@endpush
