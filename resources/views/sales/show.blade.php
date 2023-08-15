@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $sales->TransCode }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        Fine Total : {{$sales->FineTotal}}
                        @if (count($sales->orders))
                            @foreach ($sales->orders as $key => $items)
                                @if (!isset($items->BookName))
                                    <div class="container">
                                        Item dengan id {{ $items->BookID }} telah di hapus.
                                    </div>
                                @endif
                                @if (isset($items->BookName))
                                    <div class="container">
                                        <table class="table">
                                            <tr>
                                                <td>Nama Barang</td>
                                                <td>{{ $items->BookName }}</td>
                                            </tr>
                                            <tr>
                                                <td>Deskripsi</td>
                                                <td>{{ $items->Description }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jenis</td>
                                                <td>{{ $items->BookType }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>{{ number_format($items->Qty) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tahun</td>
                                                <td>{{ $items->Year }}</td>
                                            </tr>
                                            <tr>
                                                <td>Penerbit</td>
                                                <td>{{ $items->Publisher }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
