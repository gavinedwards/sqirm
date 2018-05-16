<?php
include "session.php";
include "../inc/dbinfo.inc";
/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
$database = mysqli_select_db($connection, DB_DATABASE);
$hazard = $_GET["conID"]
?>
<html>
  <head>
    <style>
      <?php include "class.css"; ?>
    </style>
  </head>
  <body>
    <div class="content">
      <div>
        <div class="a">
          <h1>Key Performance Inditcators Page</h1>
          <?php  if (isset($_SESSION['username'])) : ?>
          <h3>Logged in as <?php echo $_SESSION['username']; ?> <a href="welcome.php?logout='1'">logout</a> </h3>
          <?php endif ?>
        </div>
        <div class="c" width=100px>
          <img src="img/logosm.png" width="100px"/>
        </div>
      </div>
    </div>
    <?php include "navbar.php"; ?>
      <div class="content">
        <table style="width: 100%;">
          <th style="width:15%;">Gas Gauge</th>
          <th style="width:20%;">Title</th>
          <th style="width:20%;">Green Threshold</th>
          <th style="width:20%;">Amber Threshold</th>
          <th style="width:20%;">Red Threshold</th>
          <th style="width:5%;">Submit</th>
          <?php
          $query = "SELECT * FROM kpis";
          $result = mysqli_query($connection, $query); 
          while ($row = mysqli_fetch_array($result)) {
            echo '<tr>';
              echo '<form action="sumbitkpis.php" name="kpiAdd" method="post">';
                echo '<td>';
                  echo '<canvas id="#kpicanvas' . $row['kpiID'] . '" class="kpi"></canvas>';
                echo '</td>';
                echo '<td>';
                  echo '<input type="text" id="' . $row['kpiDesc'] . '" placeholder="' . $row['kpiDesc']. '">';
                echo '</td>';
                echo '<td>';
                  echo '<input type="text" id="' . $row['kpiDesc1'] . '" placeholder="' . $row['kpiDesc1']. '">';
                  echo '<input type="text" id="' . $row['kpiVal1'] . '" placeholder="' . $row['kpiVal1']. '">';
                echo '</td>';
                echo '<td>';
                  echo '<input type="text" id="' . $row['kpiDesc2'] . '" placeholder="' . $row['kpiDesc2']. '">';
                  echo '<input type="text" id="' . $row['kpiVal2'] . '" placeholder="' . $row['kpiVal2']. '">';
                echo '</td>';
                echo '<td>';
                  echo '<input type="text" id="' . $row['kpiDesc3'] . '" placeholder="' . $row['kpiDesc3']. '">';
                  echo '<input type="text" id="' . $row['kpiVal3'] . '" placeholder="' . $row['kpiVal3']. '">';
                echo '</td>';
                echo '<td>';
                  echo '<input type="submit" value="Sumbit"/>';
                echo '</td>';
              echo '</form>';
            echo '</tr>';
          }
          ?>
        <table>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/Chart.js"></script>
        <script type="text/javascript" src="js/app.js"></script>
      </div>
  </body>
</html>
