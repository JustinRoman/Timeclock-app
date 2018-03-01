$(document).ready(function(e) {
    $.getJSON("temp.json", function(result) {
        result = JSON.parse(result);
        var labels = [], data = [];

        for (var i = 0;i < result.length; i++){
                labels.push(result[i]);
                data.push(result[i]);
        }


        var ctx = document.getElementById("chart-area").getContext("2d");
        var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                        labels: labels,
                datasets: [
                {
                        label: "The Greymouse Team",
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: data
                }
                ]}
    });
    });
});