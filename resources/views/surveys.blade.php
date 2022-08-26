@extends('layouts.app')

@section('title', 'Surveys')

<!-- Content Section -->
@section('content')

<!-- Navbar -->
@include('layouts.navbar')
<!-- /Navbar -->

<div class="container flex-grow-1 pt-5">

  <!-- Success Message -->
  @include('components.success')
  <!-- /Success Message -->

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
  var userChart,finished_survey_id;
  var labels,category_ids = [];
  loadData();

  @if(session()->has('success'))
  finished_survey_id = {{ session()->get('survey_id') }};
  @endif

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
    const extractedCategoryData =   extractLabelsAndIDS(categories);
    labels = extractedCategoryData.labels;
    ids = extractedCategoryData.ids;


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
        data: [0, 0, 0],
        tooltip: {
        callbacks: {
            label: function(context) {
                let label = context.label;
                let value = context.formattedValue;

                if (!label)
                    label = 'Unknown'

                let sum = 0;
                let dataArr = context.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += Number(data);
                });

                let percentage = (value * 100 / sum).toFixed(2) + '%';
                return label + ": " + percentage;
            }
        }
    }
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

    // check if redirected with survey then show survey result
    if(finished_survey_id){
    document.getElementById('toggle-modal-'+finished_survey_id).click();
    finished_survey_id = undefined;
    }

  }

  function extractLabelsAndIDS(categories){
    let labels = [];
    let ids = [];
    // Fill labels from json data
    for(key in categories) {
      if(categories.hasOwnProperty(key)) {
           labels.push(categories[key]['text']);
          ids.push(key);
      }
    }
    return {labels,ids};
  }
</script>


<script type="text/javascript">
  // Make Menu Link Active
  document.getElementById('nav_surveys').classList.add('active');


  document.getElementById("exampleModalCenter").addEventListener('show.mdb.modal', function (e) {
    document.getElementById('exampleModalLongTitle').innerHTML = (finished_survey_id)?"Congratulations!":e.relatedTarget.getAttribute('data-user');
    let data = e.relatedTarget.getAttribute('data-chart');
    let total_questions = e.relatedTarget.getAttribute('data-total-questions');
    data = JSON.parse(data);
    const dataset = [];
    ids.forEach(id => {
      if(data[id]){
        dataset.push(data[id])
      }else {
        dataset.push(0)
      }
    });

    userChart.data.datasets[0].data = dataset
    userChart.update();
  })
</script>
@endsection
<!-- / Content Section -->