@extends('layouts.app')

@section('content')
<div class="container">
    @php
     
        $bg = ['bg-secondary', 'bg-success', 'bg-info', 'bg-warning'];
    @endphp
    @foreach ($category as $i)
        <br />
        <div class="card-header">{{ $i->BookType}}</div>

        <div class="row">
            @php
                $color = $bg[array_rand($bg)];
                $books = $i->getBooks($i->id)
            @endphp
                            @if(!count($books))
                            <h5 class="card-title">Belum ada buku</h5>

                            @endif

            @foreach ($books as $book)
                <div class="col-sm py-2">
                    <div class="card {{ $color }}" style="width: 18rem;">
                        <img src="https://4.bp.blogspot.com/-iCLjx5TNVo8/UeNbi07KWbI/AAAAAAAAF6U/KqDyHT8cBFw/s1600/geometry+16+72.jpg" class="card-img-top" style="opacity:0.3;" />
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->BookName }}</h5>
                            <p class="card-text">{{ $book->Description }}</p>
                            <p class="card-text">Stock: {{ $book->Stock }}</p>
                            @if($book->Stock>0)
                                <a href="#" 
                                onclick="addCart({{$book->id}})"
                                class="btn btn-primary">Add to Cart</a>
                            @endif
                            @if($book->Stock==0)
                            <a href="#" class="btn btn-danger">Stok Habis</a>
                        @endif
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    @endforeach

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      window.addCart = (id)=>{
        if(!localStorage.getItem("cart")){
            localStorage.setItem("cart", JSON.stringify([]));
        }
        const old = JSON.parse(localStorage.getItem("cart"));
        if(!old.includes(id)){
            localStorage.setItem("cart", JSON.stringify([...JSON.parse(localStorage.getItem("cart")), id]));
        }
        location.href = '{{route('item.loan')}}'
      }
    });
  </script>
@endsection