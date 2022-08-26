<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.css" rel="stylesheet" />
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!--   APP NAME -->
  <title>@yield('title')</title>

</head>

<body>

  <section class="vh-100 d-flex flex-column justify-content-between">

    @if (!isset($full_page_container))
    <!--  Footer -->
    @include('layouts.navbar')
    <!-- / Footer -->
    @endif

    <!--  Content -->
    @yield('content')
    <!-- / Content -->


    @if (!isset($full_page_container))
    <!--  Footer -->
    @include('layouts.footer')
    <!-- / Footer -->
    @endif

  </section>




  <!-- SCRIPTS -->
  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.js"></script>

</body>

</html>