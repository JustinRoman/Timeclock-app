$(document).ready(function() {
  //Preloader
  $(window).load(function() {
    function hidePreloader() {
      var preloader = $('.spinner_wrapper');
      preloader.fadeOut(500);
    }
    hidePreloader();
  });
});

  function clock() {
      var today = new Date();

      var hours = today.getHours();
      var minutes = today.getMinutes();

        if (hours >= 12){
          meridiem = " PM";
        } else {
          meridiem = " AM";
        }

        if (hours>12){
          hours = hours - 12;
        } else if (hours===0){
          hours = 12; 
        }

        if (minutes<10){
          minutes = "0" + minutes;
        } else {
          minutes = minutes;
        }
        document.getElementById("clock").innerHTML = (hours + ":" + minutes + meridiem);
      }
      setInterval('clock()', 1000);

// MODAL
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
});

//GCResponsive
$(window).resize(function(){
  drawChart();
});

// Bootstrap Tooltips
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

//DataTable
// $(document).ready(function(){
//   var table = $('#table').DataTable().ajax.reload();
// });

//Setinterval on GC
$(document).ready(function(){
  
});