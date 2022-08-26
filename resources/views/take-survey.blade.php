@extends('layouts.app')

@section('title', 'Take a Survey')

<!-- Content Section -->
@section('content')

<!-- Navbar -->
@include('layouts.navbar')
<!-- /Navbar -->
<div class="m-auto flex-grow-1 py-5">
  <div class="mx-0 mx-sm-auto" style="min-width: 420px">
    <form class="card" action="{{ route('surveys.store') }}" method="post">
      @csrf
      <div class="card-header bg-primary">
        <h5 class="card-title text-white mt-2" id="exampleModalLabel">Take a Survey</h5>
      </div>
      <div class="modal-body">
        <!--  Errors -->
        @include('components.alerts')
        <!-- / Errors -->


        <!--  sruvey -->
        <div id="survey-container" class="px-4">
        </div>
        <!-- / survey -->
      </div>
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Submit
        </button>
      </div>
    </form>
  </div>
</div>


<script type="text/javascript">
  // Make Menu Link Active
  document.getElementById('nav_take_survey').classList.add('active');
</script>



<script type="text/javascript">
  loadData();

  // Load data from JSON file
  async function loadData() {
    const response = await fetch("{{ asset('data.json') }}");
    const data = await response.json();
    const objQuestions = data.questions;
    const questions = Object.keys(objQuestions).map((k) => objQuestions[k])
    const randomKey = Math.floor(Math.random()* questions.length);
    renderSurvey(randomKey+1, questions[randomKey]);
    addListenerForBranching();
  } 


  // Render survey questions
  function renderSurvey(id, question){
    let mainQuestion = `<div><p><strong>${question['text']}</strong></p>
      <input type="hidden" name="answers[${id}][category_id]" value="" disabled>`;
    let branchingQuestions  = `<div id="question_branches">`;
    const answers = question.answers;

    for(key in answers){
      const questionID = `question_${id}_answer_${key}`
      const child = (answers[key].hasOwnProperty('questions'))? `${questionID}_container`:"";
        mainQuestion += `<div class="form-check mb-2">
              <input class="form-check-input" type="radio" data-child="${child}"
                name="answers[${id}][answer]" data-category="${answers[key]['category_id']}" value="${key}" id="${questionID}" />
              <label class="form-check-label" for="${questionID}">
                ${answers[key].answer}
              </label>
            </div>`;
            const questions = answers[key].questions;
            if(questions){
            let resultRenderedChilds = `<div id="${questionID}_container" class="d-none">`;
            for(key in questions){
              resultRenderedChilds += createChild(questionID, `answers[${id}]`, key, questions[key] );
            }
            resultRenderedChilds += "</div>"
            branchingQuestions += resultRenderedChilds;
        }
    }

    branchingQuestions += "</div>";
    mainQuestion += "</div>";
    document.getElementById('survey-container').innerHTML += mainQuestion+branchingQuestions;



  }

  function createChild(parentID, parentName, id, question){
    let mainQuestion = `<div><p><strong>${question['text']}</strong></p>
      <input type="hidden" name="${parentName}[answers][${id}][category_id]" value="" disabled>`;
    const answers = question.answers;

    for(key in answers){
      const questionID = ((parentID)?parentID+"_":parentID)+`question_${id}_answer_${key}`
      const child = (!parentID) ? `${questionID}_container`:"";
        mainQuestion += `<div class="form-check mb-2">
              <input class="form-check-input" type="radio" data-child="${child}"
                name="${parentName}[answers][${id}][answer]"  data-category="${answers[key]['category_id']}" value="${key}" id="${questionID}" />
              <label class="form-check-label" for="${questionID}">
                ${answers[key].answer}
              </label>
            </div>`;
  }

  mainQuestion+= "</div>";

  return mainQuestion;
}

</script>




<script type="text/javascript">
  function addListenerForBranching(){
  var radios = document.getElementById('survey-container').querySelectorAll('input[type="radio"]');
  for (var i = 0; i < radios.length; i++) {
    radios[i].addEventListener('change', function() {
          const child = this.getAttribute('data-child')
          // update category id input
          const category_id = this.getAttribute('data-category')
          this.parentElement.parentElement.children[1].disabled = false;
          this.parentElement.parentElement.children[1].value = category_id;

          if(child.length){
            const questionBranch = document.getElementById('question_branches');
            // uncheck all checked radios
            const checkedRadios = questionBranch.querySelectorAll('input[type="radio"]:checked');
            const categoryInputs = questionBranch.querySelectorAll('input[type="hidden"]');
            checkedRadios.forEach(checkedRadio => {
              checkedRadio.checked = false;
            });
            // disable all category inputs
            categoryInputs.forEach(categoryInput => {
              categoryInput.disabled = true;
            })
            // hide other question branches
            const siblings = questionBranch.querySelectorAll(':scope > div');
            siblings.forEach(sibling => {
              sibling.classList.add('d-none')
            })
            // show the selected branch based on answers
            document.getElementById(child).classList.remove('d-none')
          }
      });
  }
  }
</script>

@endsection
<!-- / Content Section -->