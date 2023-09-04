{{-- 
<script>
    var taskCounts = @json($taskCounts);
    var ctx = document.getElementById('taskChart').getContext('2d');

    //pie chart data
    var data = {
        labels: Object.keys(taskCounts),
        datasets: [{
            label: 'Tasks Status',
            data: Object.values(taskCounts),
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
        }]
    };

    //options
    var options = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Last Week Registered Users -  Day Wise Count",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        }
    };

    //create Pie Chart class object
    var chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: options
    });
</script> --}}
