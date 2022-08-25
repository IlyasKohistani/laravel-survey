@extends('layouts.app')

@section('title', 'Surveys')

<!-- Content Section -->
@section('content')

<!-- Navbar -->
@include('layouts.navbar')
<!-- /Navbar -->

<div class="container h-100 pt-5">
  <table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>Name</th>
        <th>Title</th>
        <th>Status</th>
        <th>Position</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px"
              class="rounded-circle" />
            <div class="ms-3">
              <p class="fw-bold mb-1">John Doe</p>
              <p class="text-muted mb-0">john.doe@gmail.com</p>
            </div>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">Software engineer</p>
          <p class="text-muted mb-0">IT department</p>
        </td>
        <td>
          <span class="badge badge-success rounded-pill d-inline">Active</span>
        </td>
        <td>Senior</td>
        <td>
          <button type="button" class="btn btn-link btn-sm btn-rounded">
            Edit
          </button>
        </td>
      </tr>
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <img src="https://mdbootstrap.com/img/new/avatars/6.jpg" class="rounded-circle" alt=""
              style="width: 45px; height: 45px" />
            <div class="ms-3">
              <p class="fw-bold mb-1">Alex Ray</p>
              <p class="text-muted mb-0">alex.ray@gmail.com</p>
            </div>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">Consultant</p>
          <p class="text-muted mb-0">Finance</p>
        </td>
        <td>
          <span class="badge badge-primary rounded-pill d-inline">Onboarding</span>
        </td>
        <td>Junior</td>
        <td>
          <button type="button" class="btn btn-link btn-rounded btn-sm fw-bold" data-mdb-ripple-color="dark">
            Edit
          </button>
        </td>
      </tr>
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <img src="https://mdbootstrap.com/img/new/avatars/7.jpg" class="rounded-circle" alt=""
              style="width: 45px; height: 45px" />
            <div class="ms-3">
              <p class="fw-bold mb-1">Kate Hunington</p>
              <p class="text-muted mb-0">kate.hunington@gmail.com</p>
            </div>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">Designer</p>
          <p class="text-muted mb-0">UI/UX</p>
        </td>
        <td>
          <span class="badge badge-warning rounded-pill d-inline">Awaiting</span>
        </td>
        <td>Senior</td>
        <td>
          <button type="button" class="btn btn-link btn-rounded btn-sm fw-bold" data-mdb-toggle="modal"
            data-mdb-target="#exampleModalCenter" data-user="Mohammad Ilyas" data-chart="[8,2,5]"
            data-mdb-ripple-color="dark">
            Edit
          </button>
        </td>
      </tr>
    </tbody>
  </table>
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



<script type="text/javascript">
  var userChart;
  loadData();

  // Load data from JSON file
  async function loadData() {
    const response = await fetch("{{ asset('data.json') }}");
    const data = await response.json();
    init(data);
  } 

  function init(data){
    // Result Categories
    const categories = data.categories;

    // Extract Labels for chart.js
    let labels  =   extractLabels(categories);


    const chartData = {
      labels: labels,
      datasets: [{
        label: 'My First dataset',
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)',
          'rgb(255, 205, 86)'
        ],
        hoverOffset: 4,
        data: [0, 10, 5],
      }]
    };

    const config = {
          type: 'doughnut',
          data: chartData,
        };

    // Chart.js Initialization
     userChart = new Chart(
      document.getElementById('usersResult'),
      config
    );

  }

  function extractLabels(categories){
    let labels = [];
    // Fill labels from json data
    for(key in categories) {
      if(categories.hasOwnProperty(key)) {
           labels.push(categories[key]['text']);
      }
    }
    return labels;
  }
</script>


<script type="text/javascript">
  // Make Menu Link Active
  document.getElementById('nav_surveys').classList.add('active');


  document.getElementById("exampleModalCenter").addEventListener('show.mdb.modal', function (e) {
    document.getElementById('exampleModalLongTitle').innerHTML = e.relatedTarget.getAttribute('data-user');
    const data = e.relatedTarget.getAttribute('data-chart');
    userChart.data.datasets[0].data = JSON.parse(data)
    userChart.update();
  })
</script>
@endsection
<!-- / Content Section -->