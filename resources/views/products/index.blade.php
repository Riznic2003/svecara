@extends('layouts.app')
@section('title','Proizvodi')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Proizvodi</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Novi proizvod</a>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th><th>Naziv</th><th>Kategorija</th><th>Cena</th><th>JM</th><th>SKU</th><th class="text-end">Akcije</th>
          </tr>
        </thead>
        <tbody>
        @forelse($products as $p)
          <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ optional($p->category)->name }}</td>
            <td>{{ number_format($p->price,2,',','.') }} RSD</td>
            <td>{{ $p->unit }}</td>
            <td>{{ $p->sku }}</td>
            <td class="text-end">
              <a href="{{ route('products.edit',$p) }}" class="btn btn-sm btn-outline-secondary">Izmeni</a>
              <form action="{{ route('products.destroy',$p) }}" method="POST" class="d-inline" onsubmit="return confirm('Obrisati?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Obriši</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted py-4">Nema proizvoda.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($products->hasPages())
      <div class="card-footer">
        {{ $products->links() }}
      </div>
    @endif
  </div>
@endsection
