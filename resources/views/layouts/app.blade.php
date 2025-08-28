<!doctype html>
<html lang="sr">
  <head>
    <meta charset="utf-8">
    <title>@yield('title','Aplikacija')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
      <div class="container">
        <a class="navbar-brand" href="/">Svećara</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="/products">Proizvodi</a></li>
            <li class="nav-item"><a class="nav-link" href="/categories">Kategorije</a></li>
            <li class="nav-item"><a class="nav-link" href="/orders">Porudžbine</a></li>
            <li class="nav-item"><a class="nav-link" href="/shop">Katalog</a></li>

          </ul>
        </div>
      </div>
    </nav>

    <main class="container py-4">
      @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
      @endif

      @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
