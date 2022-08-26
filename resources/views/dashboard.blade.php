@extends('layouts.app')

@section('title', 'Dashboard')

<!-- Content Section -->
@section('content')

<div class="flex-grow-1 mt-4">
  <div class="d-flex justify-content-center align-items-center">
    <div>
      <canvas id="allUsersResult"></canvas>
    </div>
    <div>
      <canvas id="currentUserResult"></canvas>
    </div>
  </div>
  <div id="description_container" class="container m-auto pt-4"></div>
</div>


<!-- Page variables for initialization -->
<script type="text/javascript">
  // Make Menu Link Active
  document.getElementById('nav_dashboard').classList.add('active');

  // variables
  const allResults = {!! $all_surveys !!},
   userResults = {!! $user_surveys !!},
   jsonFileURL = "{{ asset('data.json') }}";

   
</script>
<!-- Page Script -->
<script type="module" src="{{ asset('js/pages/dashboard.js') }}"></script>

@endsection
<!-- / Content Section -->