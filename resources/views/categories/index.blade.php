@extends('layouts.app')
@section('title','Kategorije')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kategorije</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Nova kategorija</a>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th><th>Naziv</th><th>Opis</th><th class="text-end">Akcije</th>
          </tr>
        </thead>
        <tbody>
        @forelse($categories as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->name }}</td>
            <td>{{ $c->description }}</td>
            <td class="text-end">
              <a href="{{ route('categories.edit',$c) }}" class="btn btn-sm btn-outline-secondary">Izmeni</a>
              <form action="{{ route('categories.destroy',$c) }}" method="POST" class="d-inline" onsubmit="return confirm('Obrisati?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Obriši</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Nema kategorija.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($categories->hasPages())
      <div class="card-footer">
        {{ $categories->links() }}
      </div>
    @endif
  </div>
@endsection
