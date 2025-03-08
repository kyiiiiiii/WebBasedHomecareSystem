

document.addEventListener('DOMContentLoaded', (event) => {
    // Check if the canvas element exists before running the chart code
    const canvasElement = document.getElementById('myDoughnutChart');
    if (canvasElement) {
        const ctx = canvasElement.getContext('2d');
        const myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['pending', 'completed', 'approved'],
                datasets: [{
                    label: 'appointments',
                    data: [0, 0, 0],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let label = tooltipItem.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += tooltipItem.raw;
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: 'rgb(0, 0, 0)',
                            fontSize: 14
                        }
                    }
                }
            }
        });

        function beforePrintHandler() {
            for (let id in Chart.instances) {
                Chart.instances[id].resize();
            }
        }

        window.addEventListener('beforeprint', beforePrintHandler);
        window.addEventListener('afterprint', () => {
            for (let id in Chart.instances) {
                Chart.instances[id].resize();
            }
        });

        fetch('/appointments-data')
            .then(response => response.json())
            .then(data => {
                myDoughnutChart.data.datasets[0].data = [data.pending, data.approved, data.completed];
                myDoughnutChart.update();
            })
            .catch(error => console.error('Error fetching appointments data:', error));
    } else {
        console.log('Canvas element with ID "myDoughnutChart" not found.');
    }
});


document.addEventListener('DOMContentLoaded', (event) => {
    // Check if the canvas element exists before running the chart code
    const canvasElement = document.getElementById('employeeTypeChart');
    if (canvasElement) {
        const ctx = canvasElement.getContext('2d');
        const myDoughnutChart = new Chart(ctx, {
            type: 'doughnut', 
            data: {
                labels: ['Full time', 'Part Time'],
                datasets: [{
                    label: 'employees',
                    data: [0, 0],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            let label = data.labels[tooltipItem.index] || '';
                            if (label) {
                                label += ': ';
                            }
                            label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: 'rgb(0, 0, 0)',
                        fontSize: 14
                    }
                }
            }
        });

        // Fetch data and update the chart
        fetch('/employeeDoughnut')
            .then(response => response.json())
            .then(data => {
                myDoughnutChart.data.datasets[0].data = [data.fullTime, data.partTime];
                myDoughnutChart.update();
            })
            .catch(error => console.error('Error fetching appointments data:', error));
    } else {
        console.log('Canvas element with ID "employeeTypeChart" not found.');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Check if the canvas element exists before running the chart code
    const canvasElement = document.getElementById('appointmentChart');
    if (canvasElement) {
        // Proceed with fetching data and creating the chart
        fetch("/admin/appointments-by-week")
            .then(response => response.json())
            .then(data => {
                const ctx = canvasElement.getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Number of Appointments',
                            data: data.data,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching the appointment data:', error));
    } else {
        console.log('Canvas element with ID "appointmentChart" not found.');
        // Optionally, you can add other global code here that should run on all pages
    }
});



document.addEventListener('DOMContentLoaded', function () {
    // Check if the canvas element exists before running the chart code
    const canvasElement = document.getElementById('turnoverRateChart');
    if (canvasElement) {
        fetch('/admin/employeeLine')
            .then(response => response.json())
            .then(data => {
                // Prepare the data for Chart.js
                const months = data.map(item => item.month);
                const newHires = data.map(item => parseInt(item.new_hires, 10));
                const resignations = data.map(item => parseInt(item.resignations, 10));

                console.log('Months:', months);
                console.log('New Hires:', newHires);
                console.log('Resignations:', resignations);

                // Get the canvas context
                const ctx = canvasElement.getContext('2d');
                console.log('Canvas Context:', ctx);

                // Create the chart
                const turnoverRateChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'New Hires',
                                data: newHires,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Resignations',
                                data: resignations,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                enabled: true,
                            },
                            legend: {
                                display: true,
                                position: 'top',
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching employee data:', error);
            });
    } else {
        console.log('Canvas element with ID "turnoverRateChart" not found.');
    }
});



$(document).ready(function() {
    // Check if the canvas element exists before making the AJAX request
    const canvasElement = document.getElementById('patientDensityChart');
    if (canvasElement) {
        // Make an AJAX request to the /patient-density-data route
        $.ajax({
            url: '/patient-density-data',
            method: 'GET',
            success: function(response) {
                // Process the response data to fit the Chart.js structure
                let labels = [];
                let data = [];
                
                response.forEach(function(item) {
                    labels.push(item.age_group); // Age groups
                    data.push(item.total); // Number of patients in each age group
                });

                // Get the context for the canvas element
                const ctx = canvasElement.getContext('2d');

                // Create the Chart.js density plot (approximated by a smoothed line chart)
                const patientDensityChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Age Density',
                            data: data,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            tension: 0.4, // Smooths the line to approximate a density curve
                            pointRadius: 0 // Hides the points to make the line smoother
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Patients'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Age'
                                }
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching patient data:', error);
            }
        });
    } else {
        console.log('Canvas element with ID "patientDensityChart" not found.');
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
    // Check if the canvas element exists before running the chart code
    const canvasElement = document.getElementById('patientGenderChart');
    if (canvasElement) {
        const ctx = canvasElement.getContext('2d');
        const myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    label: 'Patients by Gender',
                    data: [0, 0], // Initial data, will be updated
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)', // Color for Male
                        'rgba(255, 99, 132, 0.2)', // Color for Female
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)', // Border color for Male
                        'rgba(255, 99, 132, 1)', // Border color for Female
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            let label = data.labels[tooltipItem.index] || '';
                            if (label) {
                                label += ': ';
                            }
                            label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: 'rgb(0, 0, 0)',
                        fontSize: 14
                    }
                }
            }
        });

        // Fetch gender data and update the chart
        fetch('/patient-gender-data')
            .then(response => response.json())
            .then(data => {
                // Update chart data
                myDoughnutChart.data.datasets[0].data = [data.male, data.female];
                myDoughnutChart.update();
            })
            .catch(error => console.error('Error fetching gender data:', error));
    } else {
        console.log('Canvas element with ID "patientGenderChart" not found.');
    }
});



document.addEventListener("DOMContentLoaded", function() {
    // Check if the canvas element exists before running the chart code
    const canvasElement = document.getElementById('patientActivityChart');
    if (canvasElement) {
        const patientId = canvasElement.dataset.patientId;

        $.ajax({
            url: `/admin/patientDetails/${patientId}/activity-data`, // Replace with correct URL if needed
            method: 'GET',
            success: function(response) {
                // Prepare data for the chart
                let dates = [];
                let counts = [];
                
                response.forEach(function(item) {
                    dates.push(item.date); // Date of activity as a string
                    counts.push(item.count); // Total activities on that day
                });

                // Create the Chart.js line chart for patient activities
                const ctx = canvasElement.getContext('2d');
                const patientActivityChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates, // X-axis labels (formatted dates as strings)
                        datasets: [{
                            label: 'Total Activities',
                            data: counts, // Y-axis data (total activities per day)
                            borderColor: 'rgba(39, 245, 84, 1)',
                            backgroundColor: 'rgba(39, 245, 84, 0.1)',
                            fill: true,
                            tension: 0.4, // Smooths the line
                            pointRadius: 3 // Shows points on the line
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Activities'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching patient activity data:', error);
            }
        });
    } else {
        console.log('Canvas element with ID "patientActivityChart" not found.');
    }
});





