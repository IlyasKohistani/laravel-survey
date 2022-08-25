@extends('layouts.app')

@section('title', 'Take a Survey')

<!-- Content Section -->
@section('content')

<!-- Navbar -->
@include('layouts.navbar')
<!-- /Navbar -->

<div class="mx-0 mx-sm-auto py-5" style="min-width: 420px">
  <div class="card">
    <div class="card-header bg-primary">
      <h5 class="card-title text-white mt-2" id="exampleModalLabel">Take a Survey</h5>
    </div>
    <div class="modal-body">
      <form class="px-4" action="">
        <p class="text-center"><strong>Your rating:</strong></p>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="exampleForm" id="radio3Example1" />
          <label class="form-check-label" for="radio3Example1">
            Very good
          </label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="exampleForm" id="radio3Example2" />
          <label class="form-check-label" for="radio3Example2">
            Good
          </label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="exampleForm" id="radio3Example3" />
          <label class="form-check-label" for="radio3Example3">
            Medicore
          </label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="exampleForm" id="radio3Example4" />
          <label class="form-check-label" for="radio3Example4">
            Bad
          </label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="exampleForm" id="radio3Example5" />
          <label class="form-check-label" for="radio3Example5">
            Very bad
          </label>
        </div>
      </form>
    </div>
    <div class="card-footer text-end">
      <button type="button" class="btn btn-primary">Submit</button>
    </div>
  </div>
</div>


<script type="text/javascript">
  // Make Menu Link Active
  document.getElementById('nav_take_survey').classList.add('active');
</script>

@endsection
<!-- / Content Section -->