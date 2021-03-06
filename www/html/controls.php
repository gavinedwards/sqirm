<?php
include "session.php";
include "../inc/dbinfo.inc";

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$database = mysqli_select_db($connection, DBNAME);
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
          <h1>Controls Page</h1>
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
    <!-- Main Splash Page Sections -->
    <section>
      <!-- Left division -->
      <article> 
        <div style="overflow:scroll; height: 500px">
          <h2>Control Details</h2>
<?php
  $query = "SELECT * FROM controls WHERE conID='" . $hazard . "'";
$result = mysqli_query($connection, $query); 

while ($row = mysqli_fetch_array($result)) {
  $conID = $row['conID'];
  $conDesc = $row['conDesc'];
  $conActive = $row['conActive'];
  $conWRAG = $row['conWRAG'];
  $kpiPriID = $row['kpiPriID'];
  $kpiSecID = $row['kpiSecID'];
}
?>
          <p id="pcontrol" class=<?php echo $conWRAG; ?>>
            <b><?php echo $conDesc; ?></b>
          </p>

          <form method="POST" <?php echo 'action="updatecontrol.php?conID=' . $conID . '"' ?>>
            <label>Description</label><input type="text" name="description" size="40" value="<?php echo $conDesc; ?>"/><br>
            <label>Active</label><input type="checkbox" name="active" <?php if ($conActive = "Y") echo 'checked';?>/> <br>
            <input type="radio" name="WRAGradio" value="red" <?php if ($conWRAG == "red") echo 'checked';?>/> Red<br>
            <input type="radio" name="WRAGradio" value="amber" <?php if ($conWRAG == "yellow") echo 'checked';?>/> Amber<br>
            <input type="radio" name="WRAGradio" value="green" <?php if ($conWRAG == "green") echo 'checked';?>/> Green<br>
            <input type="radio" name="WRAGradio" value="white" <?php if ($conWRAG == "white") echo 'checked';?>/> White<br>
            <input type="submit" value="Sumbit"/>
          </form>

          <h3>Select associated primary KPI</h3>

          <form method="POST" <?php echo 'action="associatekpi.php?conID=' . $conID . '"' ?>>
<?php
$query = "SELECT kpiID, kpiDesc FROM kpis";
$result = mysqli_query($connection, $query); 

while ($row = mysqli_fetch_array($result)) {
  $kpiID = $row['kpiID'];
  $kpiDesc = $row['kpiDesc'];
  echo '<input type="radio" name="kpiPriID" value="' .$kpiID . '"' . (($kpiID == $kpiPriID)?'checked':'') . '> ' . $kpiID . ' - ' . $kpiDesc ;
  echo '</input>';
  echo '<br>';
}
?>
            <input type="submit" value="Sumbit"/>
          </form>

        </div>
      </article>
      <!-- Center division -->
      <article> 
        <div style="height:500px">
<?php
$query = "SELECT * FROM controls WHERE conID='" . $hazard . "'";
$result = mysqli_query($connection, $query); 

while ($row = mysqli_fetch_array($result)) {
  $conID = $row['conID'];
  $conDesc = $row['conDesc'];
  $conActive = $row['conActive'];
  $conWRAG = $row['conWRAG'];
}
?>

          <h2>Associated Hazards</h2>

          <!-- Get hazards from database -->
<?php
$query1 = "SELECT DISTINCT hazard.hazID, hazard.hazDesc 
  FROM hazard 
  INNER JOIN hazard_consequence
  ON hazard.hazID=hazard_consequence.hazID 
  INNER JOIN consequence_control 
  ON hazard_consequence.csqID=consequence_control.csqID 
  INNER JOIN controls 
  ON consequence_control.conID=controls.conID 
  WHERE controls.conID=" . $conID;
$result1 = mysqli_query($connection, $query1); 

while ($row1 = mysqli_fetch_array($result1)) {
  echo '<p class="tile_hazard"><b><a href="RiskView.php?hazID=' . $row1['hazID'] . '">' . $row1['hazID'] . ' - ' . $row1['hazDesc'] . '</a></b></p>' ;
};

$query2 = "SELECT DISTINCT hazard.hazID, hazard.hazDesc 
  FROM hazard 
  INNER JOIN threat_hazard 
  ON hazard.hazID=threat_hazard.hazID 
  INNER JOIN threat_control 
  ON threat_hazard.thrID=threat_control.thrID 
  INNER JOIN controls 
  ON threat_control.conID=controls.conID 
  WHERE controls.conID=" . $conID;
$result2 = mysqli_query($connection, $query2); 

while ($row2 = mysqli_fetch_array($result2)) {
  echo '<p class="tile_hazard"><b><a href="RiskView.php?hazID=' . $row2['hazID'] . '">' . $row2['hazID'] . ' - ' . $row2['hazDesc'] . '</a></b></p>' ;
}
?>

          <h2>Associated Threats and Consequences</h2>

          <!-- Get hazards from database -->
<?php
$query = "SELECT DISTINCT threat.thrID, threat.thrDesc 
  FROM threat
  INNER JOIN threat_control 
  ON threat.thrID=threat_control.thrID 
  INNER JOIN controls 
  ON threat_control.conID=controls.conID 
  WHERE controls.conID=" . $conID;
$result = mysqli_query($connection, $query); 

while ($row = mysqli_fetch_array($result)) {
  echo '<p class="tile_threat"><b>' . $row['thrDesc'] . '</b></p>' ;
};

$query = "SELECT DISTINCT consequence.csqID, consequence.csqDesc 
  FROM consequence
  INNER JOIN consequence_control 
  ON consequence.csqID=consequence_control.csqID 
  INNER JOIN controls 
  ON consequence_control.conID=controls.conID 
  WHERE controls.conID=" . $conID;
$result = mysqli_query($connection, $query); 

while ($row = mysqli_fetch_array($result)) {
  echo '<p class="tile_consequence"><b>' . $row['csqDesc'] . '</b></p>' ;
}
?>
        </div>
      </article>
      <article>
        <div style="height:500px; overflow:scroll">
          <?php
          $query = "SELECT DISTINCT comments.* FROM comments INNER JOIN comment_links ON comments.comID=comment_links.comID INNER JOIN controls ON comment_links.conID=controls.conID WHERE controls.conID='" . $conID . "'ORDER BY comments.comID ASC";
          $result = mysqli_query($connection, $query); 
          
          while ($row = mysqli_fetch_array($result)) {
            echo '<div class="cl">';
            echo '<p>' . $row['comment'] .'</p>' ;
            echo '<p><b>By: </b>' . $row['username'] . '<b> on </b>' . $row['date'] .'</p>' ;
            echo '</div>';
            echo '<hr>';
          }
          ?>
          <div class="textwrapper">
            <form action="addcontrolcomment.php?conID=<?php echo $conID ?>" name="commentControlAdd" method="post">
              <textarea id="comment" class="text" rows ="10" name="comment">Insert new comment here.</textarea>
              <input type="submit" value="Sumbit"/>
            </form>
          </div>
        </div>
      <!-- Right division -->
      </article> 
    </section>
  </body>
</html>
