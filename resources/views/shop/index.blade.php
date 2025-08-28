@extends('layouts.app')
@section('title','Katalog')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Katalog</h1>
    <a href="{{ route('shop.cart') }}" class="btn btn-outline-primary">
      Korpa @isset($cartCount)<span class="badge text-bg-primary ms-1">{{ $cartCount }}</span>@endisset
    </a>
  </div>

  <div class="row g-3">
    @foreach($products as $p)
      <div class="col-md-3">
        <div class="card h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-1">{{ $p->name }}</h5>
            <div class="text-muted small mb-2">{{ optional($p->category)->name }}</div>
            <div class="mt-auto">
              <div class="h5 mb-2">{{ number_format($p->price,2,',','.') }} RSD</div>
              <form method="POST" action="{{ route('shop.add',$p) }}" class="d-flex gap-2">
                @csrf
                <input type="number" name="qty" value="1" min="1" max="100" class="form-control" style="max-width:90px">
                <button class="btn btn-primary w-100" type="submit">Dodaj u korpu</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  @if($products->hasPages())
    <div class="mt-3">
      {{ $products->links() }}
    </div>
  @endif
@endsection
