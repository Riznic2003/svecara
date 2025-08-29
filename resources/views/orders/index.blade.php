@extends('layouts.app')
@section('title','Porudžbine')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Porudžbine</h1>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Kupac</th>
            <th>Status</th>
            <th class="text-end">Ukupno (RSD)</th>
            <th class="text-center">Stavke</th>
            <th class="text-end">Akcija</th>
          </tr>
        </thead>
        <tbody>
        @forelse($orders as $o)
          @php
            $badge = [
              'primljena'   => 'secondary',
              'u_pripremi'  => 'warning',
              'isporučena'  => 'success',
              'otkazana'    => 'danger',
            ][$o->status] ?? 'secondary';
          @endphp
          <tr>
            <td>#{{ $o->id }}</td>
            <td>
              <div class="fw-semibold">{{ $o->full_name }}</div>
              <div class="text-muted small">{{ $o->email }}</div>
            </td>
            <td><span class="badge text-bg-{{ $badge }}">{{ $o->status }}</span></td>
            <td class="text-end">{{ number_format($o->total,2,',','.') }}</td>
            <td class="text-center">{{ $o->items_count }}</td>
            <td class="text-end">
              <a href="{{ route('orders.show', $o) }}" class="btn btn-sm btn-outline-primary">Pregled</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4">Nema porudžbina.</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <div class="card-footer">
        {{ $orders->links() }}
      </div>
    @endif
  </div>
@endsection
