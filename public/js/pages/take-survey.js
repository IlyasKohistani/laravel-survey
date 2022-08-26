import {
    loadJSON,
    picRandom,
    addListenerForBranching,
    generateQuestionsHTML,
} from "../functions.js";

// start loading data from json and init page after data has been fetched
loadJSON(jsonFileURL, init);

// Render survey questions
function init(data) {
    // pick random question from data
    const { id, question } = picRandom(data.questions);

    // insert generated html to survey container
    document.getElementById("survey-container").innerHTML +=
        generateQuestionsHTML(id, question);

    // add branching listener
    addListenerForBranching("survey-container", "question_branches");
}
