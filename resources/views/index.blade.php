@extends('layouts.app', ["full_page_container" => true])

@section('title', 'Sign In')


@section('content')
<div class="container  d-flex align-items-center justify-content-center flex-grow-1 py-5">
    <div class="row">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <img src="{{ asset('img/user-account.svg') }}" class="img-fluid" alt="Phone image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 d-flex flex-column justify-content-center">
            <form action="{{ route('auth.authenticate') }}" method="post">
                @csrf
                <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3 text-primary"></i>
                    <span class="h1 fw-bold mb-0">Sign In</span>
                </div>
                <!--  Errors -->
                @include('components.alerts')
                <!-- / Errors -->

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-control form-control-lg" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control form-control-lg" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <div class="d-flex justify-content-around align-items-center mb-4">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember_me" checked />
                        <label class="form-check-label" for="remember_me"> Remember me </label>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Sign in</button>
                <!-- Register buttons -->
                <div class="text-center">
                    <p>Don't you have an account? <a href="{{ route('auth.signup') }}">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection