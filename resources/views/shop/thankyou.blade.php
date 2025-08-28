@extends('layouts.app')
@section('title','Hvala!')

@section('content')
  <div class="text-center py-5">
    <h1 class="display-6 mb-3">Hvala na porudžbini!</h1>
    <p class="lead">Vaša porudžbina #{{ $order->id }} je primljena. Uskoro ćemo je obraditi.</p>
    <div class="mt-4">
      <a href="{{ route('shop.index') }}" class="btn btn-primary">Nazad na katalog</a>
      <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary ms-2">Pregled porudžbina (admin)</a>
    </div>
  </div>
@endsection
