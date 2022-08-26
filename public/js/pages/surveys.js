// Import Modules
import { config, chartData } from "../config.chart.js";
import {
    extractLabelsAndIDS,
    loadJSON,
    modalOnShowListener,
} from "../functions.js";

// start loading data from json and init page after data has been fetched
loadJSON(jsonFileURL, init);

// page initialization
function init(data) {
    // Result Categories
    const categories = data.categories;

    // Extract Labels for chart.js
    const extractedCategoryData = extractLabelsAndIDS(categories);
    const labels = extractedCategoryData.labels;
    const category_ids = extractedCategoryData.ids;

    // Chart.js Initialization
    const userChart = new Chart(
        document.getElementById("usersResult"),
        config(chartData(labels))
    );

    // add listener on show modal
    modalOnShowListener(
        userChart,
        "exampleModalCenter",
        "exampleModalLongTitle",
        category_ids,
        finished_survey_id
    );

    // check if redirected with survey result then show survey in graph
    if (finished_survey_id) {
        document.getElementById("toggle-modal-" + finished_survey_id).click();
        finished_survey_id = undefined;
    }
}
