@extends('layouts.app')
@section('title','Nova kategorija')

@section('content')
  <h1 class="h3 mb-3">Nova kategorija</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('categories.store') }}" class="card p-3">
    @csrf
    <div class="mb-3">
      <label class="form-label">Naziv</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Opis</label>
      <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">Sačuvaj</button>
      <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Nazad</a>
    </div>
  </form>
@endsection
