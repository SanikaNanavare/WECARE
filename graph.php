<?php
// Include your database connection file or establish a connection here
$servername = "127.0.0.1";
$username = "localhost";
$password = "Sakshi@123";
$db_name = "wecare";
$conn = new mysqli($servername, $username, $password, $db_name, 3308);

// Start the session
session_start();

// Check if the username is set in the session
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM register WHERE username = '$username'";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_array($res);
        $sugar = $data['sugar'];
        $bp = $data['bp'];
        $heartRate = $data['heartRate'];
        $cholesterol = $data['cholesterol'];
    } else {
        // Handle the case where no data is available for the user
        echo "No health data available for the user.";
        exit();
    }
} else {
    // Redirect to login or another page if session username is not set
    header("Location: login.html");
    exit();
}
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sugar', 'BP', 'HeartRate', 'Cholesterol'],
          <?php
            // Output the health data for the current user
            echo "['$sugar', $bp, $heartRate, $cholesterol]";
          ?>
        ]);

        var options = {
            chart: {
                title: 'My Health Dashboard',
                subtitle: 'Navigating the Peaks and Valleys of Well-being',
            },
            titleTextStyle: {
                fontSize: 20, // Adjust the font size as needed
                bold: true, // Make the title bold if desired
            },
            subtitleTextStyle: {
                fontSize: 16, // Adjust the font size as needed
            },
            bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="barchart_material" style="width: 1400px; height: 700px;"></div>
  </body>
</html>
