@extends('layouts.app')

@section('content')
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

                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
                    </head>

                    <body>
                       
                            <div class="container">
                               
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID Transaksi</th>
                                            <th>Pemesan</th>
                                            <th>Jumlah Jenis Buku</th>
                                            <th>Tanggal Pengembalian</th>
                                            
                                            <th>Action</th> 
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->customer_name }}</td>
                                            <td>{{ count($item->orders) }}</td>
                                            <td>{{ $item->staff_name }}</td>

                                            <td>
                                                @if(Auth::user()->role == Auth::user()->getRoleCustomer() && (!isset($item->ReturnDate) || !$item->ReturnDate))
                                                <a href="{{ route('sales.submit', $item->id) }}" title="Kembalikan"><button class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>Kembalikan</button></a> &nbsp;
                                                @endif
                                                <a href="{{ route('sales.show', $item->id) }}" title="View Sales"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> &nbsp;
                                               

                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection