@extends('layouts.app')

@section('title', 'Take a Survey')

<!-- Content Section -->
@section('content')

<div class="m-auto flex-grow-1 py-5">
  <div class="mx-0 mx-sm-auto" style="min-width: 420px">
    <form class="card" action="{{ route('surveys.store') }}" method="post">
      @csrf
      <div class="card-header bg-primary rounded">
        <h5 class="card-title text-white mt-2" id="exampleModalLabel">Take a Survey</h5>
      </div>
      <div class="modal-body">
        <!--  Errors -->
        @include('components.alerts')
        <!-- / Errors -->


        <!--  sruvey -->
        <div id="survey-container" class="px-4">
        </div>
        <!-- / survey -->
      </div>
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Submit
        </button>
      </div>
    </form>
  </div>
</div>


<script type="text/javascript">
  var jsonFileURL = "{{ asset('data.json') }}";
  // Make Menu Link Active
  document.getElementById('nav_take_survey').classList.add('active');
</script>


<!-- Page Script -->
<script type="module" src="{{ asset('js/pages/take-survey.js') }}"></script>
@endsection
<!-- / Content Section -->