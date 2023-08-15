@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Persentase Keterlambatan') }}</div>

                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                    Most Trend Book Now: {{$mostTrendBook->BookName}} by {{$mostTrendBook->Publisher}} ({{$mostTrendBook->Year}})
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Late Returns (%)'],
            datasets: [{
                label: 'Persentase Keterlambatan',
                data: [@php echo json_encode($lateReturnPercentage); @endphp],
                backgroundColor: ['rgba(255, 99, 132, 0.5)'],
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                    }
                }
            }
        }
    });
        });
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('History') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Add date filter form -->
                        <form id="filter-form" action="{{ route('sales:filter') }}" method="POST">
                            @csrf
                            <input type="date" name="start_date">
                            s/d
                            <input type="date" name="end_date">
                            <button type="submit">Filter Tanggal Transaksi</button>
                        </form>
                        <br />

                        <a href="{{ route('sales:late') }}"> Sudah dikembalikan namun Terlambat</a>
                        <br />
                        <a href="{{ route('sales:undone') }}">Filter belum di kembalikan</a>


                        <!-- Display sales history -->
                        <div class="container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Transaksi</th>
                                        <th>Pemesan</th>
                                        <th>Jumlah Buku</th>
                                        <th>Ekspektasi Tanggal Kembali</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Total Denda</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $item)
                                        @if (
                                            !\Illuminate\Support\Str::contains(request()->url(), 'late') &&
                                                !\Illuminate\Support\Str::contains(request()->url(), 'undone'))
                                            <tr
                                                class="{{ isset($item->orders[0]->ReturnDate) && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($item->orders[0]->ReturnDate)) ? 'late-return' : '' }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->TransCode }}</td>
                                                <td>{{ $item->customer_name }}</td>
                                                <td>{{ count($item->orders) }}</td>
                                                <td>{{ $item->TransDate }}</td>
                                                <td>{{ $item->orders[0]->ReturnDate??"-" }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->FineTotal }}</td>

                                                <td>
                                                    @if (Auth::user()->role == Auth::user()->getRoleCustomer() && !$item->orders[0]->ReturnDate)
                                                        <a href="{{ route('sales.submit', $item->id) }}"
                                                            title="Kembalikan"><button class="btn btn-warning btn-sm"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                                Kembalikan</button></a> &nbsp;
                                                    @endif
                                                    <a href="{{ route('sales.show', $item->id) }}"
                                                        title="View Sales"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        @endif
                                        @if (\Illuminate\Support\Str::contains(request()->url(), 'late'))
                                            @if (strtotime($item->orders[0]->ReturnDate) > strtotime($item->TransDate))
                                                <tr
                                                    class="{{ isset($item->orders[0]->ReturnDate) && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($item->orders[0]->ReturnDate)) ? 'late-return' : '' }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->TransCode }}</td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ count($item->orders) }}</td>
                                                <td>{{ $item->TransDate }}</td>


                                                    <td>{{ $item->orders[0]->ReturnDate }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->FineTotal }}</td>

                                                    <td>
                                                        @if (Auth::user()->role == Auth::user()->getRoleCustomer() && !$item->orders[0]->ReturnDate)
                                                            <a href="{{ route('sales.submit', $item->id) }}"
                                                                title="Kembalikan"><button class="btn btn-warning btn-sm"><i
                                                                        class="fa fa-eye" aria-hidden="true"></i>
                                                                    Kembalikan</button></a> &nbsp;
                                                        @endif
                                                        <a href="{{ route('sales.show', $item->id) }}"
                                                            title="View Sales"><button class="btn btn-info btn-sm"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                                View</button></a> &nbsp;
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                        @if (\Illuminate\Support\Str::contains(request()->url(), 'undone'))
                                            @if (!$item->orders[0]->ReturnDate)
                                                <tr
                                                    class="{{ isset($item->orders[0]->ReturnDate) && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($item->orders[0]->ReturnDate)) ? 'late-return' : '' }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->TransCode }}</td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ count($item->orders) }}</td>
                                                <td>{{ $item->TransDate }}</td>

                                                    <td>{{ $item->orders[0]->ReturnDate }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->FineTotal }}</td>

                                                    <td>
                                                        @if (Auth::user()->role == Auth::user()->getRoleCustomer() && !$item->orders[0]->ReturnDate)
                                                            <a href="{{ route('sales.submit', $item->id) }}"
                                                                title="Kembalikan"><button class="btn btn-warning btn-sm"><i
                                                                        class="fa fa-eye" aria-hidden="true"></i>
                                                                    Kembalikan</button></a> &nbsp;
                                                        @endif
                                                        <a href="{{ route('sales.show', $item->id) }}"
                                                            title="View Sales"><button class="btn btn-info btn-sm"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                                View</button></a> &nbsp;
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Highlight late returns
            $('tbody tr').each(function() {
                var returnDate = $(this).find('td:eq(4)').text();
                if (returnDate && new Date(returnDate) < new Date()) {
                    $(this).addClass('late-return');
                }
            });
        });
    </script>

    <style>
        .late-return {
            background-color: #ffcccc;
            /* Example color for highlighting */
        }
    </style>

@endsection
