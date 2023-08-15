@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Items') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
                            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
                            crossorigin="anonymous">
                        </head>

                        <body>
                            
                                <div class="container">
                                    @if (Auth::user()->role !== Auth::user()->getRoleCustomer())
                                        <a href="{{ route('category.create') }}" class="btn btn-success btn-sm"
                                            title="Add New Item">
                                            Add New
                                        </a>
                                    @endif

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Jenis Buku</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->BookType }}</td>


                                                    <td>
                                                        @if (Auth::user()->role !== Auth::user()->getRoleCustomer())
                                                          
                                                            <a href="{{ route('category.edit', $item->id) }}" title="Edit Item"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                Edit</a> &nbsp;
                                                            <a href="{{ route('category.delete', $item->id) }}"
                                                                title="Delete Item" class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                Delete</a>
                                                        @endif
                                                        @if (Auth::user()->role == Auth::user()->getRoleCustomer() && $item->stok)
                                                            <div class="container">


                                                                <div
                                                                    class="col-md-12 col-sm-12 col-xs-12 col-lg-12 col-xl-12">

                                                                    <input type="number" name="id_item-{{ $item->id }}"
                                                                        min="1" max="{{ $item->stok }}"
                                                                        value="" placeholder="Jumlah"
                                                                        class="form-control">
                                                                </div>


                                                            </div>
                                </div>
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
