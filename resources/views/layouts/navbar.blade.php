<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container">

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample"
      aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarButtonsExample">
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('surveys.dashboard') }}" id="nav_dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('surveys.index') }}" id="nav_surveys"> Latest Surveys</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('surveys.take') }}" id="nav_take_survey"> Take Survey</a>
        </li>
      </ul>
    </div>
    <!-- Left links -->
    <div class="d-flex align-items-center">
      <a class="btn btn-outline-danger btn-sm btn-floating me-3" href="{{ route('auth.logout') }}" role="button"><i
          class="fa fa-sign-out-alt" style="margin-top: 7px"></i></a>
      <div class="dropdown">
        <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="javascript:void(0)"
          id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
          <img src="{{ asset('img/no-pic.svg') }}" class="rounded-circle" height="28"
            alt="Black and White Portrait of a Man" loading="lazy">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar"
          data-popper-placement="null" data-mdb-popper="none">
          <li>
            <span class="dropdown-item fw-bold border-bottom border-1"> {{ auth()->user()->name }}</span>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>