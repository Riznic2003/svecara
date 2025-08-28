@extends('layouts.app')
@section('title','Checkout')

@section('content')
  <h1 class="h3 mb-3">Podaci za poručivanje</h1>

  <div class="row g-3">
    <div class="col-lg-7">
      <form method="POST" action="{{ route('shop.checkout.store') }}" class="card p-3">
        @csrf
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Ime i prezime</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="col-md-12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="col-md-12">
            <label class="form-label">Adresa (ulica, broj, grad)</label>
            <textarea name="address" rows="2" class="form-control" required></textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label">Način plaćanja</label>
            <select name="payment_method" class="form-select" required>
              <option value="pouzećem">Pouzećem</option>
              <option value="uplata">Uplata na račun</option>
            </select>
          </div>
        </div>

        <div class="d-flex gap-2 mt-3">
          <button class="btn btn-primary">Pošalji porudžbinu</button>
          <a href="{{ route('shop.cart') }}" class="btn btn-outline-secondary">Nazad</a>
        </div>
      </form>
    </div>

    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">Sažetak korpe</div>
        <ul class="list-group list-group-flush">
          @php $sum=0; @endphp
          @foreach($cart as $it)
            @php $line = $it['qty']*$it['price']; $sum+=$line; @endphp
            <li class="list-group-item d-flex justify-content-between">
              <div>
                <div class="fw-semibold">{{ $it['name'] }}</div>
                <div class="text-muted small">{{ $it['qty'] }} × {{ number_format($it['price'],2,',','.') }} RSD</div>
              </div>
              <div>{{ number_format($line,2,',','.') }} RSD</div>
            </li>
          @endforeach
        </ul>
        <div class="card-footer text-end">
          <strong>Ukupno: {{ number_format($total,2,',','.') }} RSD</strong>
        </div>
      </div>
    </div>
  </div>
@endsection
