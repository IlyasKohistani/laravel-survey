// add description of each category in specific container
const addLabelDescription = (
    key,
    label,
    description,
    description_container
) => {
    const colors = ["note-danger", "note-primary", "note-warning"];
    if (key > 2) key -= 3;
    document.getElementById(
        description_container
    ).innerHTML += `<p class="note ${colors[key]}"><strong>${label}: </strong>${description}</p>`;
};

// extract the labels and ids and if required append description
const extractLabelsAndIDS = (categories, container) => {
    const labels = [],
        ids = [];
    // Fill labels from json data
    for (let key in categories) {
        if (categories.hasOwnProperty(key)) {
            labels.push(categories[key]["text"]);
            if (container)
                addLabelDescription(
                    key - 1,
                    categories[key]["text"],
                    categories[key]["description"],
                    container
                );
            ids.push(key);
        }
    }
    return { labels, ids };
};

// Load data from JSON file
async function loadJSON(jsonFileLocation, callback) {
    const response = await fetch(jsonFileLocation);
    const data = await response.json();
    callback(data);
}

// add listener on show modal to update chart with each table row data
const modalOnShowListener = (
    chart,
    modalID,
    titleID,
    category_ids,
    finished_survey_id
) => {
    document
        .getElementById(modalID)
        .addEventListener("show.mdb.modal", function (e) {
            // get the chart data from button
            let data = e.relatedTarget.getAttribute("data-chart");
            data = JSON.parse(data);

            // if user just finished a survey, say congratulations
            document.getElementById(titleID).innerHTML = finished_survey_id
                ? "Congratulations!"
                : e.relatedTarget.getAttribute("data-user");

            // check if all categories has data, otherwise set it zero
            const dataset = [];
            category_ids.forEach((id) => {
                dataset.push(data[id] ?? 0);
            });

            // update chart data
            chart.data.datasets[0].data = dataset;
            chart.update();
        });
};

// pick a random
const picRandom = (objQuestions) => {
    const questions = Object.keys(objQuestions).map((k) => objQuestions[k]);
    const randomKey = Math.floor(Math.random() * questions.length);
    return { id: randomKey + 1, question: questions[randomKey] };
};

// reset child branches to default state
const resetBranch = (branchContainer) => {
    // main branch container
    const questionBranch = document.getElementById(branchContainer);

    // uncheck all checked radios
    const checkedRadios = questionBranch.querySelectorAll(
        'input[type="radio"]:checked'
    );
    checkedRadios.forEach((checkedRadio) => {
        checkedRadio.checked = false;
    });

    // disable all category id hidden inputs
    const categoryInputs = questionBranch.querySelectorAll(
        'input[type="hidden"]'
    );
    categoryInputs.forEach((categoryInput) => {
        categoryInput.disabled = true;
    });

    // hide all question branches children
    const siblings = questionBranch.querySelectorAll(":scope > div");
    siblings.forEach((sibling) => {
        sibling.classList.add("d-none");
    });
};

// radio buttons listener
const radiosChangeListener = (event, branchContainer) => {
    // child branch
    const child = event.getAttribute("data-child");

    // update category id input
    const category_id = event.getAttribute("data-category");
    event.parentElement.parentElement.children[1].disabled = false;
    event.parentElement.parentElement.children[1].value = category_id;

    if (child.length) {
        // reset branch all inputs and continers to default
        resetBranch(branchContainer);

        // show the selected branch based on answers
        document.getElementById(child).classList.remove("d-none");
    }
};

// add listener for branching parts
function addListenerForBranching(surveyContainer, branchContainer) {
    // select all radios
    var radios = document
        .getElementById(surveyContainer)
        .querySelectorAll('input[type="radio"]');

    // add listener to radio buttons
    radios.forEach((radio) => {
        radio.addEventListener("change", function () {
            radiosChangeListener(this, branchContainer);
        });
    });
}

// generate survey raw html question and answers
const generateQuestionsHTML = (
    id,
    question,
    parentName = "answers",
    parentID = ""
) => {
    const answers = question.answers;
    let branchingQuestions = "";

    let mainQuestion = `<div><p><strong>${question["text"]}</strong></p>
      <input type="hidden" name="${parentName}[${id}][category_id]" value="" disabled>`;

    if (!parentID) branchingQuestions = `<div id="question_branches">`;

    // loop through answers and check if they have related questions
    for (let key in answers) {
        // generate question id and child container id if has one
        const questionID =
            (parentID ? parentID + "_" : parentID) +
            `question_${id}_answer_${key}`;
        const child = answers[key].hasOwnProperty("questions")
            ? `${questionID}_container`
            : "";
        // add answer to the question anwers
        mainQuestion += `<div class="form-check mb-2">
              <input class="form-check-input" type="radio" data-child="${child}"
                name="${parentName}[${id}][answer]" data-category="${answers[key]["category_id"]}" value="${key}" id="${questionID}" />
              <label class="form-check-label" for="${questionID}">
                ${answers[key].answer}
              </label>
            </div>`;

        // if answer has related questions as child render them with related container
        const questions = answers[key].questions;
        if (questions) {
            let resultRenderedChilds = `<div id="${questionID}_container" class="d-none">`;
            for (key in questions) {
                resultRenderedChilds += generateQuestionsHTML(
                    key,
                    questions[key],
                    `answers[${id}][answers]`,
                    questionID
                );
            }
            branchingQuestions += resultRenderedChilds + "</div>";
        }
    }

    // end the opening questions div
    if (!parentID) branchingQuestions += "</div>";
    mainQuestion += "</div>";

    // return the resulted html
    return mainQuestion + branchingQuestions;
};

export {
    extractLabelsAndIDS,
    loadJSON,
    modalOnShowListener,
    picRandom,
    addListenerForBranching,
    generateQuestionsHTML,
};
