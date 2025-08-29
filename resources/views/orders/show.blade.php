@extends('layouts.app')
@section('title', 'Porudžbina #'.$order->id)

@section('content')
  @php
    $badge = [
      'primljena'   => 'secondary',
      'u_pripremi'  => 'warning',
      'isporučena'  => 'success',
      'otkazana'    => 'danger',
    ][$order->status] ?? 'secondary';
  @endphp

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Porudžbina #{{ $order->id }}</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">← Nazad</a>
  </div>

  <div class="row g-3">
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header">Podaci o kupcu</div>
        <div class="card-body">
          <div class="mb-2"><span class="text-muted">Ime i prezime:</span> <strong>{{ $order->full_name }}</strong></div>
          <div class="mb-2"><span class="text-muted">Email:</span> {{ $order->email }}</div>
          <div class="mb-2"><span class="text-muted">Telefon:</span> {{ $order->phone }}</div>
          <div class="mb-2"><span class="text-muted">Adresa:</span> {{ $order->address }}</div>
          <div class="mb-2"><span class="text-muted">Način plaćanja:</span> {{ $order->payment_method }}</div>
          <div class="mb-2">
            <span class="text-muted">Status porudžbine:</span>
            <span class="badge text-bg-{{ $badge }}">{{ $order->status }}</span>
          </div>
          <div class="mb-0"><span class="text-muted">Ukupno:</span>
            <strong>{{ number_format($order->total,2,',','.') }} RSD</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header">Plaćanje</div>
        <div class="card-body">
          @if ($order->payment)
            <div class="mb-2"><span class="text-muted">Status:</span> <span class="badge text-bg-success">PAID</span></div>
            <div class="mb-2"><span class="text-muted">Iznos:</span> {{ number_format($order->payment->amount,2,',','.') }} RSD</div>
            @if($order->payment->provider)
              <div class="mb-2"><span class="text-muted">Provider:</span> {{ $order->payment->provider }}</div>
            @endif
            @if($order->payment->reference)
              <div class="mb-0"><span class="text-muted">Referenca:</span> {{ $order->payment->reference }}</div>
            @endif
          @else
            <div class="text-muted">Nije evidentirano plaćanje.</div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header">Stavke porudžbine</div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Proizvod</th>
            <th>Kategorija</th>
            <th class="text-center">Količina</th>
            <th class="text-end">Jed. cena (RSD)</th>
            <th class="text-end">Međuzbir (RSD)</th>
          </tr>
        </thead>
        <tbody>
        @foreach($order->items as $it)
          <tr>
            <td>{{ $it->product->name ?? 'Obrisan proizvod' }}</td>
            <td>{{ $it->product->category->name ?? '-' }}</td>
            <td class="text-center">{{ $it->qty }}</td>
            <td class="text-end">{{ number_format($it->unit_price,2,',','.') }}</td>
            <td class="text-end">{{ number_format($it->qty * $it->unit_price,2,',','.') }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer text-end">
      <strong>Ukupno: {{ number_format($order->total,2,',','.') }} RSD</strong>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-header">Ažuriranje statusa / plaćanja</div>
    <div class="card-body">
      <form method="POST" action="{{ route('orders.updateStatus', $order) }}" class="row g-3">
        @csrf
        <div class="col-md-4">
          <label class="form-label">Status</label>
          @php $opts=['primljena','u_pripremi','isporučena','otkazana']; @endphp
          <select name="status" class="form-select" required>
            @foreach($opts as $opt)
              <option value="{{ $opt }}" @selected($order->status===$opt)>{{ $opt }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-8 d-flex align-items-end gap-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="pay" value="1" id="payCheck">
            <label class="form-check-label" for="payCheck">Označi kao plaćeno</label>
          </div>
          <div class="ms-auto"></div>
        </div>

        <div class="col-md-3">
          <label class="form-label">Iznos (RSD)</label>
          <input type="number" step="0.01" name="amount" class="form-control" value="{{ $order->total }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Provider</label>
          <input type="text" name="provider" class="form-control" value="manual">
        </div>
        <div class="col-md-6">
          <label class="form-label">Referenca</label>
          <input type="text" name="ref" class="form-control">
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">Sačuvaj</button>
          <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary ms-2">Nazad</a>
        </div>
      </form>
    </div>
  </div>
@endsection
