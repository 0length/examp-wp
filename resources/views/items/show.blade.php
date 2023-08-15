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

                  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
                  </head>
                  <body>
                  <div class="container">
                    <table class="table">
                      <tr>
                        <td>Nama</td>
                        <td>{{ $items->BookName }}</td>
                      </tr>
                      <tr>
                        <td>Deskripsi</td>
                        <td>{{ $items->Description }}</td>
                      </tr>
                      <tr>
                        <td>Jenis</td>
                        <td>{{($items->getBookType($items->BookTypeID))->BookType }}</td>
                      </tr>
                      <tr>
                        <td>Stok</td>
                        <td>{{ $items->Stock}}</td>
                      </tr>
                      <tr>
                        <td>Tahun</td>
                        <td>Rp {{ $items->Year }}</td>
                      </tr>
                      <tr>
                        <td>Penerbit</td>
                        <td>Rp {{ $items->Publisher  }}</td>
                      </tr>
                      
                    </table>
                  </div>
                  </body>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection