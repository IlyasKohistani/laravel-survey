@if ($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
  <div>
    @foreach ($errors->all() as $error)
    <p class="p-0 m-0">{{ $error }}</p>
    @endforeach
  </div>
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
@endif