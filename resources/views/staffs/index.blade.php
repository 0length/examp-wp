@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin') }}</div>

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
                        <a href="{{ route('staff.create') }}" class="btn btn-success btn-sm" title="Add New Staff">
                            Add New
                        </a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($staffs as $staff)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->gender }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>
                                        <a href="{{ route('staff.show', $staff->id) }}" title="View staff"><button class="btn btn-info btn-sm mt-1"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> &nbsp;
                                        <a href="{{ route('staff.edit', $staff->id) }}" title="Edit staff"><button class="btn btn-primary btn-sm mt-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> &nbsp;
                                        <a href="{{ route('staff.delete', $staff->id) }}" title="Delete staff"><button class="btn btn-danger btn-sm mt-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Delete</button></a>
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