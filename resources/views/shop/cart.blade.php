@extends('layouts.app')
@section('title','Korpa')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Korpa</h1>
    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">← Nazad na katalog</a>
  </div>

  @if(empty($cart))
    <div class="alert alert-info">Korpa je prazna.</div>
  @else
    <form method="POST" action="{{ route('shop.cart.update') }}">
      @csrf
      <div class="card">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Proizvod</th>
                <th class="text-center">Količina</th>
                <th class="text-end">Cena</th>
                <th class="text-end">Međuzbir</th>
                <th class="text-end">Ukloni</th>
              </tr>
            </thead>
            <tbody>
            @foreach($cart as $row)
              <tr>
                <td>
                  <div class="fw-semibold">{{ $row['name'] }}</div>
                  <div class="text-muted small">JM: {{ $row['unit'] }}</div>
                </td>
                <td class="text-center" style="max-width:110px;">
                  <input type="number" name="items[{{ $row['id'] }}]" value="{{ $row['qty'] }}" min="1" max="100" class="form-control text-center">
                </td>
                <td class="text-end">{{ number_format($row['price'],2,',','.') }} RSD</td>
                <td class="text-end">{{ number_format($row['price']*$row['qty'],2,',','.') }} RSD</td>
                <td class="text-end">
                  <form method="POST" action="{{ route('shop.remove',$row['id']) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">X</button>
                  </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
          <button class="btn btn-outline-secondary" type="submit">Ažuriraj korpu</button>
          <div class="h5 mb-0">Ukupno: {{ number_format($total,2,',','.') }} RSD</div>
        </div>
      </div>
    </form>

    <div class="mt-3 text-end">
      <a href="{{ route('shop.checkout') }}" class="btn btn-primary btn-lg">Nastavi na plaćanje</a>
    </div>
  @endif
@endsection
