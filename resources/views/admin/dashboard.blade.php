@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>
</div>

<div class="row text-center mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3 shadow-sm">
            <div class="card-header">Total Tiket</div>
            <div class="card-body">
                <h3 class="card-title">{{ $totalTickets }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3 shadow-sm">
            <div class="card-header">Tiket OPEN</div>
            <div class="card-body">
                <h3 class="card-title">{{ $openTickets }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3 shadow-sm">
            <div class="card-header">Tiket PROGRESS</div>
            <div class="card-body">
                <h3 class="card-title">{{ $progressTickets }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3 shadow-sm">
            <div class="card-header">Tiket COMPLETE</div>
            <div class="card-body">
                <h3 class="card-title">{{ $completeTickets }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header">Grafik Tiket per Bulan ({{ date('Y') }})</div>
    <div class="card-body">
        <canvas id="ticketChart" width="100%" height="40"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('ticketChart');
    var ticketChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Jumlah Tiket',
                data: [{{ implode(',', $chartData) }}],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endpush
