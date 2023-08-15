@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('User') }}</div>

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
                        <a href="{{ route('customer.create') }}" class="btn btn-success btn-sm" title="Add New Customer">
                            Add New
                        </a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>TTL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->gender }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->born_place . ", " . $customer->born_date }}</td>
                                    <td>
                                        <a href="{{ route('customer.show', $customer->id) }}" title="View customer"><button class="btn btn-info btn-sm mt-1"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> &nbsp;
                                        <a href="{{ route('customer.edit', $customer->id) }}" title="Edit customer"><button class="btn btn-primary btn-sm mt-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> &nbsp;
                                        @if(Auth::user()->role == Auth::user()->getRoleSuperAdmin())
                                        <a href="{{ route('customer.delete', $customer->id) }}" title="Delete customer"><button class="btn btn-danger btn-sm mt-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Delete</button></a>
                                        @endif
                                    </td>
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
@endsection