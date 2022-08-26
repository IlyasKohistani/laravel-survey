const chartData = (
    labels,
    data = [0, 0, 0],
    backgroundColor = [
        "rgb(255, 99, 132)",
        "rgb(54, 162, 235)",
        "rgb(255, 205, 86)",
    ]
) => {
    return {
        labels,
        datasets: [
            {
                backgroundColor,
                hoverOffset: 4,
                data,
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.label;
                            let value = context.formattedValue;

                            if (!label) label = "Unknown";

                            let sum = 0;
                            let dataArr = context.chart.data.datasets[0].data;
                            dataArr.map((data) => {
                                sum += Number(data);
                            });

                            let percentage =
                                ((value * 100) / sum).toFixed(2) + "%";
                            return label + ": " + percentage;
                        },
                    },
                },
            },
        ],
    };
};

const config = (data, type = "doughnut", title) => {
    let config = {
        type: type,
        data,
    };
    if (title)
        config.options = {
            plugins: {
                title: {
                    display: true,
                    text: title,
                },
            },
        };

    return config;
};

export { chartData, config };
