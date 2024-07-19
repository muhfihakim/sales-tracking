@extends('admin.Layout.Index')
@section('css')
@endsection
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div>
                            <h2 class="text-white pb-2 fw-bold">Dashboard Sistem Informasi Sales dan Pengiriman</h2>
                            <h5 class="text-white op-7 mb-2">by : BBS-Web Developer</h5>
                        </div>
                        <div class="ml-md-auto py-2 py-md-0">
                            <a href="{{ route('tambah.sales') }}" class="btn btn-secondary btn-round btn-sm"> <i
                                    class="fas fa-plus">
                                </i> Sales</a>
                            <a href="{{ route('tambah.tugas') }}" class="btn btn-secondary btn-round btn-sm"> <i
                                    class="fas fa-plus">
                                </i> Tugas</a>
                            <a href="{{ route('tambah.outlet') }}" class="btn btn-secondary btn-round btn-sm"> <i
                                    class="fas fa-plus">
                                </i> Outlet</a>
                            <a href="{{ route('daftar.tugas') }}" class="btn btn-secondary btn-round btn-sm"> <i
                                    class="fas fa-map-marked-alt">
                                </i> Lacak</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-inner mt--5">
                <div class="row mt--2">
                    <div class="col-md-6">
                        <div class="card full-height">
                            <div class="card-body">
                                <div class="card-title">Total Data Aplikasi</div>
                                <div class="card-category">Data Keseluruhan dari Sales, Outlet, dan Tugas Pending.</div>
                                <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                                    <div class="px-2 pb-2 pb-md-0 text-center">
                                        <div id="circles-1"></div>
                                        <h6 class="fw-bold mt-3 mb-0">Sales</h6>
                                    </div>
                                    <div class="px-2 pb-2 pb-md-0 text-center">
                                        <div id="circles-2"></div>
                                        <h6 class="fw-bold mt-3 mb-0">Outlet</h6>
                                    </div>
                                    <div class="px-2 pb-2 pb-md-0 text-center">
                                        <div id="circles-4"></div>
                                        <h6 class="fw-bold mt-3 mb-0">Tugas Pending</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card full-height">
                            <div class="card-body">
                                <div class="card-title">Total Penugasan Harian</div>
                                <div class="row py-3">
                                    <div class="col-md-4 d-flex flex-column justify-content-around">
                                        <div>
                                            <h6 class="fw-bold text-uppercase text-success op-8">Tugas Selesai</h6>
                                            <h3 class="fw-bold">{{ $totalSelesaiHariIni[0] ?? 0 }}</h3>
                                            <!-- Jumlah tugas selesai hari ini -->
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-uppercase text-danger op-8">Tugas Dibatalkan</h6>
                                            <h3 class="fw-bold">{{ $totalDibatalkanHariIni[0] ?? 0 }}</h3>
                                            <!-- Jumlah tugas dibatalkan hari ini -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="chart-container">
                                            <canvas id="ChartTugas"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card full-height">
                            <div class="card-body">
                                <div class="card-title">Riwayat Tugas Selesai</div>
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Tugas</th>
                                                <th>Outlet</th>
                                                <th>Sales</th>
                                                <th>Deskripsi Tugas</th>
                                                <th>Waktu Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($completedTaskLogs as $log)
                                                <tr>
                                                    <td>{{ $log->task->id }}</td>
                                                    <td>{{ $log->task->outlet->nama }}</td>
                                                    <td>{{ $log->task->sales->nama }}</td>
                                                    <td>{{ $log->task->deskripsi }}</td>
                                                    <td>
                                                        @if ($log->updated_at)
                                                            {{ $log->updated_at->format('H:i / d-m-Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>s
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Circles.js untuk Sales
            Circles.create({
                id: 'circles-1',
                radius: 45,
                value: {{ $totalSales }}, // Ganti dengan variabel dari controller yang menyimpan jumlah sales
                maxValue: 100,
                width: 7,
                text: '{{ $totalSales }}', // Teks yang ditampilkan di tengah lingkaran
                colors: ['#f1f1f1', '#FF9E27'],
                duration: 400,
                wrpClass: 'circles-wrp',
                textClass: 'circles-text',
                styleWrapper: true,
                styleText: true
            });

            // Circles.js untuk Outlet
            Circles.create({
                id: 'circles-2',
                radius: 45,
                value: {{ $totalOutlets }}, // Ganti dengan variabel dari controller yang menyimpan jumlah outlets
                maxValue: 100,
                width: 7,
                text: '{{ $totalOutlets }}', // Teks yang ditampilkan di tengah lingkaran
                colors: ['#f1f1f1', '#2BB930'],
                duration: 400,
                wrpClass: 'circles-wrp',
                textClass: 'circles-text',
                styleWrapper: true,
                styleText: true
            });

            // Circles.js untuk Tugas Pending
            Circles.create({
                id: 'circles-4',
                radius: 45,
                value: {{ $totalPendingTasksToday }},
                maxValue: 100,
                width: 7,
                text: '{{ $totalPendingTasksToday }}',
                colors: ['#f1f1f1', '#FF5733'],
                duration: 400,
                wrpClass: 'circles-wrp',
                textClass: 'circles-text',
                styleWrapper: true,
                styleText: true
            });

            // Bar Chart untuk Tugas Selesai dan Dibatalkan
            var ChartTugas = document.getElementById('ChartTugas').getContext('2d');
            var myChartTugas = new Chart(ChartTugas, {
                type: 'bar',
                data: {
                    labels: [
                        "{{ Carbon\Carbon::today()->subDays(9)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(8)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(7)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(6)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(5)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(4)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(3)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(2)->format('D') }}",
                        "{{ Carbon\Carbon::today()->subDays(1)->format('D') }}",
                        "{{ Carbon\Carbon::today()->format('D') }}"
                    ], // Label hari ini hingga 9 hari yang lalu
                    datasets: [{
                        label: "Tugas Selesai",
                        backgroundColor: '#36a2eb', // Warna untuk tugas selesai
                        borderColor: 'rgb(23, 125, 255)',
                        data: [
                            {{ $totalSelesaiHariIni[9] ?? 0 }},
                            {{ $totalSelesaiHariIni[8] ?? 0 }},
                            {{ $totalSelesaiHariIni[7] ?? 0 }},
                            {{ $totalSelesaiHariIni[6] ?? 0 }},
                            {{ $totalSelesaiHariIni[5] ?? 0 }},
                            {{ $totalSelesaiHariIni[4] ?? 0 }},
                            {{ $totalSelesaiHariIni[3] ?? 0 }},
                            {{ $totalSelesaiHariIni[2] ?? 0 }},
                            {{ $totalSelesaiHariIni[1] ?? 0 }},
                            {{ $totalSelesaiHariIni[0] ?? 0 }},
                        ],
                    }, {
                        label: "Tugas Dibatalkan",
                        backgroundColor: '#ff6384', // Warna untuk tugas dibatalkan
                        borderColor: 'rgb(255, 99, 132)',
                        data: [
                            {{ $totalDibatalkanHariIni[9] ?? 0 }},
                            {{ $totalDibatalkanHariIni[8] ?? 0 }},
                            {{ $totalDibatalkanHariIni[7] ?? 0 }},
                            {{ $totalDibatalkanHariIni[6] ?? 0 }},
                            {{ $totalDibatalkanHariIni[5] ?? 0 }},
                            {{ $totalDibatalkanHariIni[4] ?? 0 }},
                            {{ $totalDibatalkanHariIni[3] ?? 0 }},
                            {{ $totalDibatalkanHariIni[2] ?? 0 }},
                            {{ $totalDibatalkanHariIni[1] ?? 0 }},
                            {{ $totalDibatalkanHariIni[0] ?? 0 }},
                        ],
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: true, // Menampilkan legenda
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            /* $('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
                type: 'line',
                height: '70',
                width: '100%',
                lineWidth: '2',
                lineColor: '#ffa534',
                fillColor: 'rgba(255, 165, 52, .14)'
            }); */
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });
    </script>
@endsection
