@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Alumni Dashboard</h1>
        <div class="text-muted">Welcome back, Admin</div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Alumni</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAlumni }}</div>
                        </div>
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tracer Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tracerFilled }}</div>
                            <div class="mt-2 text-xs">
                                <span class="{{ $tracerFilled/$totalAlumni*100 >= 70 ? 'text-success' : 'text-danger' }}">
                                    {{ round($tracerFilled/$totalAlumni*100) }}% completion
                                </span>
                            </div>
                        </div>
                        <div class="icon-circle bg-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Survey Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $surveyFilled }}</div>
                            <div class="mt-2 text-xs">
                                <span class="{{ $surveyFilled/$totalAlumni*100 >= 70 ? 'text-success' : 'text-warning' }}">
                                    {{ round($surveyFilled/$totalAlumni*100) }}% completion
                                </span>
                            </div>
                        </div>
                        <div class="icon-circle bg-warning text-white">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Avg. Survey Rating</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(array_sum($surveyRatings)/count($surveyRatings), 1) }}/4
                            </div>
                            <div class="mt-2">
                                @for ($i = 1; $i <= 4; $i++)
                                    <span style="font-size: 16px;"
                                        class="{{ $i <= round(array_sum($surveyRatings)/count($surveyRatings)) ? 'text-warning' : 'text-secondary' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <div class="icon-circle bg-info text-white">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Profession Category Pie Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Profession Category Distribution</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="categoryPie"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($categoryCounts as $category)
                            <span class="mr-3">
                                <i class="fas fa-circle" style="color: {{ $loop->index == 0 ? '#4e73df' : '#858796' }}"></i> 
                                {{ $category->category_name }} ({{ $category->total }})
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Profession Bar Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Top Professions</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="professionBar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Survey Ratings -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Survey Ratings</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($surveyRatings as $key => $rating)
                            <div class="col-md-3 col-6 mb-4">
                                <div class="card border-left-primary h-100">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </div>
                                        <div class="h5 mb-1 font-weight-bold text-gray-800">
                                            {{ number_format($rating, 1) }}/4
                                        </div>
                                        <div class="mb-1">
                                            @for ($i = 1; $i <= 4; $i++)
                                                <span style="font-size: 16px;"
                                                    class="{{ $i <= round($rating) ? 'text-warning' : 'text-secondary' }}">★</span>
                                            @endfor
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                 style="width: {{ $rating/4*100 }}%" 
                                                 aria-valuenow="{{ $rating }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .chart-pie {
        position: relative;
        height: 250px;
    }
    .chart-bar {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart
    new Chart(document.getElementById('categoryPie'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryCounts->pluck('category_name')) !!},
            datasets: [{
                data: {!! json_encode($categoryCounts->pluck('total')) !!},
                backgroundColor: ['#4e73df', '#858796'],
                hoverBackgroundColor: ['#2e59d9', '#6c757d'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });

    // Bar Chart
    new Chart(document.getElementById('professionBar'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($professionCounts->pluck('nama_profesi')) !!},
            datasets: [{
                label: "Alumni Count",
                backgroundColor: '#4e73df',
                hoverBackgroundColor: '#2e59d9',
                borderColor: '#4e73df',
                data: {!! json_encode($professionCounts->pluck('total')) !!},
            }]
        },
        options: {
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 5
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush