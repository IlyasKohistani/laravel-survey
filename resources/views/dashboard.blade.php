@extends('layouts.app')

@section('title', 'Dashboard')

<!-- Content Section -->
@section('content')

<!-- Navbar -->
@include('layouts.navbar')
<!-- /Navbar -->
<div class="flex-grow-1 mt-4">
  <div class="d-flex justify-content-center align-items-center">
    <div>
      <canvas id="allUsersResult"></canvas>
    </div>
    <div>
      <canvas id="currentUserResult"></canvas>
    </div>
  </div>
  <div id="description_container" class="container m-auto pt-4"></div>
</div>


<script type="text/javascript">
  // Make Menu Link Active
  document.getElementById('nav_dashboard').classList.add('active');
  var allSurveysData = {!! $all_surveys !!};
  var currentUserSurveysData = {!! $user_surveys !!};

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

    const config = (title) => {
      return {type: 'doughnut',
              data: chartData,
              options: {
                plugins: {
                    title: {
                        display: true,
                        text: title
                    }
                }
              }
            }
   };

    // Chart.js Initialization
    const allUsersResultChart = new Chart(
      document.getElementById('allUsersResult'),
      config('All Users Result')
    );
    
    const currentUserResultChart = new Chart(
      document.getElementById('currentUserResult'),
      config('Your Result')
    );

    var userSurveysDataset = [];
    var allSurveysDataset = [];
    
    ids.forEach(id => {
      userSurveysDataset.push(currentUserSurveysData[id]??0);
     allSurveysDataset.push(allSurveysData[id]??0);
    });
    allUsersResultChart.data.datasets[0].data = allSurveysDataset
    allUsersResultChart.update();
    currentUserResultChart.data.datasets[0].data = userSurveysDataset
    currentUserResultChart.update();

  }

  function extractLabelsAndIDS(categories){
    let labels = [];
    let ids = [];
    // Fill labels from json data
    for(key in categories) {
      if(categories.hasOwnProperty(key)) {
           labels.push(categories[key]['text']);
           addLabelDescription(key-1, categories[key]['text'],categories[key]['description'])
          ids.push(key);
      }
    }
    return {labels,ids};
  }
  function addLabelDescription(key, label, description){
    const colors = [
      'note-danger',
      'note-primary',
      'note-warning',
    ];
    if(key>2) key -= 3;
    const description_container = document.getElementById('description_container');
    description_container.innerHTML += `<p class="note ${colors[key]}"><strong>${label}: </strong>${description}</p>`

  }
</script>

@endsection
<!-- / Content Section -->