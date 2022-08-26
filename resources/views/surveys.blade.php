@extends('layouts.app')

@section('title', 'Surveys')

<!-- Content Section -->
@section('content')

<div class="container flex-grow-1 pt-5">

  <!-- Success Message -->
  @include('components.success')
  <!-- /Success Message -->

  @if (count($surveys) == 0)
  <div class="alert alert-primary alert-dismissible" role="alert">
    You have not done any surveys yet! <a href="{{ route('surveys.take') }}">Start one?</a>
    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
  </div>
  <div class="d-flex justify-content-center mt-5">
    <img src="{{ asset('img/start.svg') }}" class="w-75">
  </div>
  @else
  <table class="table align-middle table-hover mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>Name</th>
        <th>Number of Questions</th>
        <th>Status</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($surveys as $survey)
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <span class="fw-bold">{{ $survey->username }}</span>
          </div>
        </td>
        <td>
          <span class="fw-bold px-1 ">{{ $survey->total_questions }}</span>
        </td>
        <td>
          <span class="badge badge-success rounded-pill d-inline">Completed</span>
        </td>
        <td>{{ $survey->created_at->diffForHumans() }}</td>
        <td>
          <button type="button" class="btn btn-link btn-rounded btn-sm fw-bold" id="toggle-modal-{{ $survey->id }}"
            data-mdb-toggle="modal" data-mdb-target="#exampleModalCenter" data-user="{{ $survey->username }}"
            data-chart="{{ $survey->answers->pluck('category_count','category_id') }}" data-mdb-ripple-color="dark">
            View
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>

<!-- Chart Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
          <canvas id="usersResult"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Chart Modal -->
<script>
  // set global variables
  var finished_survey_id;
  const jsonFileURL = "{{ asset('data.json') }}";

  // Make Menu Link Active
  document.getElementById('nav_surveys').classList.add('active');

  // check if redirected from taking survey page
  @if(session()->has('success'))
   finished_survey_id = {{ session()->get('survey_id') }};
  @endif
</script>

<!-- Page Script -->
<script type="module" src="{{ asset('js/pages/surveys.js') }}"></script>


@endsection
<!-- / Content Section -->