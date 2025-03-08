/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************!*\
  !*** ./resources/js/d3.js ***!
  \****************************/
document.addEventListener('DOMContentLoaded', function () {
  // set the dimensions and margins of the graph
  var margin = {
      top: 30,
      right: 30,
      bottom: 30,
      left: 50
    },
    width = 460 - margin.left - margin.right,
    height = 400 - margin.top - margin.bottom;

  // append the svg object to the body of the page
  var svg = d3.select("#my_dataviz").append("svg").attr("width", width + margin.left + margin.right).attr("height", height + margin.top + margin.bottom).append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  // Fetch the data using D3's callback method
  d3.json("/patient-ages", function (error, data) {
    if (error) {
      console.error("Error loading or processing data:", error);
      return;
    }
    if (!data) {
      throw new Error("No data received");
    }
    console.log("Data received:", data);
    data = data.map(function (d) {
      return +d.age;
    });

    // add the x Axis
    var x = d3.scaleLinear().domain([d3.min(data), d3.max(data)]) // Adjust domain based on the age data
    .range([0, width]);
    svg.append("g").attr("transform", "translate(0," + height + ")").call(d3.axisBottom(x));

    // add the y Axis, with the range reversed
    var y = d3.scaleLinear().range([height, 0]) // Invert the y-axis by setting the range from height to 0
    .domain([0, 0.01]); // Ensure domain is set correctly
    svg.append("g").call(d3.axisLeft(y));

    // Compute kernel density estimation
    var kde = kernelDensityEstimator(kernelEpanechnikov(20), x.ticks(40));
    var density = kde(data);

    // Plot the area
    var curve = svg.append('g').append("path").attr("class", "mypath").datum(density).attr("fill", "#69b3a2").attr("opacity", ".8").attr("stroke", "#000").attr("stroke-width", 1).attr("stroke-linejoin", "round").attr("d", d3.line().curve(d3.curveBasis).x(function (d) {
      return x(d[0]);
    }).y(function (d) {
      return y(d[1]);
    }));

    // A function that updates the chart when slider is moved
    function updateChart(binNumber) {
      // Recompute density estimation
      kde = kernelDensityEstimator(kernelEpanechnikov(7), x.ticks(binNumber));
      density = kde(data);

      // Update the chart
      curve.datum(density).transition().duration(1000).attr("d", d3.line().curve(d3.curveBasis).x(function (d) {
        return x(d[0]);
      }).y(function (d) {
        return y(d[1]);
      }));
    }

    // Listen to the slider
    d3.select("#mySlider").on("change", function (d) {
      selectedValue = this.value;
      updateChart(selectedValue);
    });
  });

  // Function to compute density
  function kernelDensityEstimator(kernel, X) {
    return function (V) {
      return X.map(function (x) {
        return [x, d3.mean(V, function (v) {
          return kernel(x - v);
        })];
      });
    };
  }
  function kernelEpanechnikov(k) {
    return function (v) {
      return Math.abs(v /= k) <= 1 ? 0.75 * (1 - v * v) / k : 0;
    };
  }
});
/******/ })()
;