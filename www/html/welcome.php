<?php include "session.php";
include "../inc/dbinfo.inc"; 

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$database = mysqli_select_db($connection, DB_DATABASE);
$hazard = $_GET["hazID"]

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
        <!-- logged in user information -->
        <?php  if (isset($_SESSION['username'])) : ?>
        <div style="width: 60%; float:left" style="border:none padding:0">
          <h1>Welcome Page</h1><br>
          <h3>Logged in as <?php echo $_SESSION['username']; ?> <a href="welcome.php?logout='1'">logout</a> </h3>
        </div>
        <div style="width: 20%; float:right; align:right border:none; padding:0">
          <img src="img/logosm.png" width="80px"/>
        </div>
        <?php endif ?>
      </div>
    </div>
    <!-- Main Splash Page Sections -->

    <section>
      <!-- Left division -->
      <article> 
        <div>
          <h2>List of Active Hazards</h2>
          <!-- get hazards from database -->
          <?php
          $query = "select * from hazard";
          $result = mysqli_query($connection, $query); 
          
          while ($row = mysqli_fetch_array($result)) {
            echo '<p class="tile_hazard"><b><a href="RiskView.php?hazID=' . $row['hazID'] . '">' . $row['hazID'] . ' - ' . $row['hazDesc'] . '</a></b></p>' ;
          }
          ?>
        </div>
      </article>

      <!-- Centre article -->
      <article>
        <div>
          <h2>List of Active Controls</h2>
          <!-- Get controls from database -->
          <?php
          $query = "SELECT * FROM controls ORDER BY conWRAG";
          $result = mysqli_query($connection, $query); 
          
          while ($row = mysqli_fetch_array($result)) {
            echo '<p class="' . $row['conWRAG'] . ' tile_control"><b><a href="controls.php?conID=' . $row['conID'] . '">' . $row['conID'] . ' - ' . $row['conDesc'] . '</a></b></p>' ;
          }
          ?>	
        </div>
      </article>

      <!-- Right article -->
      <article>
        <!-- Right top article -->
        <div width="400" !important>
          <h2>Key Performance Indicators</h2>

          <?php
          $query = "SELECT kpiID, kpiDesc FROM kpis";
          $result = mysqli_query($connection, $query); 
          while ($row = mysqli_fetch_array($result)) {
            echo '<div id="kpiblock">';
              echo '<canvas id="#kpicanvas' . $row['kpiID'] . '" class="kpi"></canvas>';
              echo '<div id="kpititle">' . $row['kpiDesc'] . '</div>';
            echo '</div>';
          }
          ?>

          <!-- javascript -->
          <script type="text/javascript" src="js/jquery.js"></script>
          <script type="text/javascript" src="js/Chart.js"></script>
          <script type="text/javascript" src="js/app.js"></script>
        </div>
        <!-- Right top article -->
        <div>
          <h2>My Actions and Issues</h2>
        </div>
      </article>
    </section>

  </body>
</html>
