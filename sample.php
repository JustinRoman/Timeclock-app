<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);
      function drawTable() {
        var jsonData = $.ajax({
          url: "getData.php",
          dataType: "json",
          async: false
        }).responseText;
         // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);
        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, width: '100%', height: '49vh'});
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>