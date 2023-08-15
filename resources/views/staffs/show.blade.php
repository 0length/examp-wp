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
                    <table class="table">
                      <tr>
                        <td>Nama</td>
                        <td>{{ $staff->name }}</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>{{ $staff->email }}</td>
                      </tr>
                      <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $staff->gender }}</td>
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