@if(session()->has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
  {{ session()->get('success') }}
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
@endif