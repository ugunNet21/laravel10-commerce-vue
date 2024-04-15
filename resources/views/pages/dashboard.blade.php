@extends('layouts.dashboard')

@section('title')
    Store Dashboard
@endsection

@section('content')
<!-- Section Content -->
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
<div class="container-fluid">
    <div class="dashboard-heading">
    <h2 class="dashboard-title">Dashboard</h2>
    <p class="dashboard-subtitle">
        Look what you have made today!
    </p>
    </div>
    <div class="dashboard-content">
    <div class="row">
        {{-- <div class="col-md-4">
        <div class="card mb-2">
            <div class="card-body">
            <div class="dashboard-card-title">
                Customer
            </div>
            <div class="dashboard-card-subtitle">
                {{ number_format($customer) }}
            </div>
            </div>
        </div>
        </div> --}}
        <div class="col-md-4">
        <div class="card mb-2">
            <div class="card-body">
            <div class="dashboard-card-title">
                Revenue
            </div>
            <div class="dashboard-card-subtitle">
                ${{ number_format($revenue) }}
            </div>
            </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card mb-2">
            <div class="card-body">
            <div class="dashboard-card-title">
                Transaction
            </div>
            <div class="dashboard-card-subtitle">
                {{ number_format($transaction_count) }}
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 mt-2">
            <h5 class="mb-3">Recent Transactions</h5>
            @foreach ($transaction_data as $transaction)
              <a
                href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                class="card card-list d-block"
                >
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1">
                            <img
                                src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                class="w-75"
                            />
                        </div>
                        <div class="col-md-4">
                                {{ $transaction->product->name ?? '' }}
                            </div>
                            <div class="col-md-3">
                                {{ $transaction->transaction->user->name ?? '' }}
                            </div>
                            <div class="col-md-3">
                                {{  $transaction->created_at ?? '' }}
                            </div>
                            <div class="col-md-1 d-none d-md-block">
                                <img
                                    src="/images/dashboard-arrow-right.svg"
                                    alt=""
                                />
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Revenue', 'Transaction'],
            datasets: [{
                label: 'Statistics',
                data: [ {{ $revenue }}, {{ $transaction_count }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
