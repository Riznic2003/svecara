@extends('layouts.app')
@section('title','Novi proizvod')

@section('content')
  <h1 class="h3 mb-3">Novi proizvod</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('products.store') }}" class="card p-3">
    @csrf
    <div class="mb-3">
      <label class="form-label">Kategorija</label>
      <select name="category_id" class="form-select" required>
        <option value="">-- izaberi --</option>
        @foreach($categories as $id => $name)
          <option value="{{ $id }}" @selected(old('category_id')==$id)>{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Naziv</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Cena (RSD)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price',0) }}" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Jedinica mere</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit','kom') }}" required>
      </div>
    </div>

    <div class="row g-3 mt-0">
      <div class="col-md-6">
        <label class="form-label">SKU</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Minimalna zaliha</label>
        <input type="number" name="min_stock" class="form-control" value="{{ old('min_stock',0) }}">
      </div>
    </div>

    <div class="mb-3 mt-3">
      <label class="form-label">Opis</label>
      <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">Sačuvaj</button>
      <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Nazad</a>
    </div>
  </form>
@endsection
