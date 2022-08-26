@extends('layouts.app')

@section('title', 'Sign Up')


@section('content')
<div class="container flex-grow-1 py-5">
  <div class="row d-flex align-items-center justify-content-center flex-grow-1">
    <div class="col-md-8 col-lg-7 col-xl-6">
      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
        alt="Phone image">
    </div>
    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
      <form action="{{ route('auth.register') }}" method="post">
        @csrf
        <div class="d-flex align-items-center mb-3 pb-1">
          <i class="fas fa-cubes fa-2x me-3 text-primary"></i>
          <span class="h1 fw-bold mb-0">Sign Up</span>
        </div>
        <!--  Errors -->
        @include('components.alerts')
        <!-- / Errors -->


        <!-- Name input -->
        <div class="form-outline mb-4">
          <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" />
          <label class="form-label" for="name">Full Name</label>
        </div>

        <!-- Email input -->
        <div class="form-outline mb-4">
          <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" />
          <label class="form-label" for="email">Email</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
          <input type="password" id="password" name="password" class="form-control" />
          <label class="form-label" for="password">Password</label>
        </div>

        <!-- Repeat Password input -->
        <div class="form-outline mb-4">
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
          <label class="form-label" for="password_confirmation">Repeat password</label>
        </div>

        <!-- Agreement -->
        <div class="form-check d-flex justify-content-center mb-4">
          <input class="form-check-input me-2" type="checkbox" id="agreement" name="agreement" checked
            aria-describedby="registerCheckHelpText" />
          <label class="form-check-label" for="agreement">
            I have read and agree to the terms
          </label>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Create Account</button>
        <!-- Register buttons -->
        <div class="text-center">
          <p>Already have an account? <a href="{{ route('auth.login') }}">Sign In</a></p>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection