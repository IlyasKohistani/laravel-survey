// Import Modules
import { config, chartData } from "../config.chart.js";
import { extractLabelsAndIDS, loadJSON } from "../functions.js";

// start loading data from json and init page after data has been fetched
loadJSON(jsonFileURL, init);

// page initialization
function init(data) {
    // Result Categories
    const categories = data.categories;

    // Extract Labels and ids for chart.js
    const extractedCategoryData = extractLabelsAndIDS(
        categories,
        "description_container"
    );
    const labels = extractedCategoryData["labels"];
    const ids = extractedCategoryData["ids"];

    const userResultsDataset = [],
        allResutlsDataset = [];

    // fill data based on categories
    ids.forEach((id) => {
        allResutlsDataset.push(allResults[id] ?? 0);
        userResultsDataset.push(userResults[id] ?? 0);
    });

    // Chart.js Initialization
    new Chart(
        document.getElementById("allUsersResult"),
        config(
            chartData(labels, allResutlsDataset),
            "doughnut",
            "All Users Result"
        )
    );

    new Chart(
        document.getElementById("currentUserResult"),
        config(chartData(labels, userResultsDataset), "doughnut", "Your Result")
    );
}
