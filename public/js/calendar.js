/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/calendar.js ***!
  \**********************************/
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  if (calendarEl) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: '/getAppointmentsCalendar' // Endpoint to fetch appointments data
    });
    calendar.render();
  } else {
    console.log('Element with ID "calendar" not found.');
  }
});
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('patientCalendar');
  if (calendarEl) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: '/patient/patientCalendar',
      // Endpoint to fetch appointments data
      eventContent: function eventContent(info) {
        // Format the time
        var time = new Date(info.event.start).toLocaleTimeString([], {
          hour: '2-digit',
          minute: '2-digit',
          hour12: true
        });

        // Combine the time, appointment type, and employee name
        var content = time + ' ' + info.event.extendedProps.type;

        // Create a new HTML element for the event content
        var element = document.createElement('div');
        element.innerHTML = content;

        // Return the custom element to be rendered in the calendar
        return {
          domNodes: [element]
        };
      }
    });
    calendar.render();
  } else {
    console.log('Element with ID "patientCalendar" not found.');
  }
});
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('list');
  if (calendarEl) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'listWeek',
      events: '/appointment-list'
    });
    calendar.render();
  } else {
    console.log('Element with ID "list" not found.');
  }
});
/******/ })()
;