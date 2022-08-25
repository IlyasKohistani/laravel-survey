@extends('layouts.app')

@section('title', 'Dashboard')

<!-- Content Section -->
@section('content')

<!-- Navbar -->
@include('layouts.navbar')
<!-- /Navbar -->
<div class="h-100 mt-4">
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

  }

  function extractLabels(categories){
    let labels = [];
    // Fill labels from json data
    for(key in categories) {
      if(categories.hasOwnProperty(key)) {
           labels.push(categories[key]['text']);
           addLabelDescription(key-1, categories[key]['text'],categories[key]['description'])
      }
    }
    return labels;
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