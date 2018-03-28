<!DOCTYPE html>
<html>

  <!-- Head -->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eu Jin Marcus Yatim's FYP</title>
    <link rel="stylesheet" href="./includes/style.css">
    <script type = "text/javascript">
    </script>
  </head>

  <!-- Body  -->
  <body>
    <div class="page">
      <header class="header center">
        Eu Jin Marcus Yatim's FYP Page
      </header>
      <nav class="nav center">
        <ul class="nav-list">
          <li>
            <a href="frontpage.php#about">About</a>
          </li>
          <li>
            <a href="frontpage.php#datareadings">Data Readings</a>
          </li>
          <li>
            <a href="#previousreadings">Previous Readings</a>
          </li>
        </ul>
      </nav>
    </div>

    <div>
      <main class="main center">
        <h1>Phasor Measurement Unit for power grids</h1>
        <h2>Developing a web app to aggregate real-time data from power grids</h2>
      </main>
    </div>

      <section class="section">

        <!-- Previous Readings -->
        <div id = "previousreadings">
          <h2> Previous Readings </h2>
          <p>
            Select a time frame to display the readings during that duration.
          </p>

          <!-- Clear Button -->
          <form action = "#" method = "POST">
            <label for = "clear"> Clear Display: </label>
            <button type = "submit" name = "clear">Clear</button>
          </form>

          <?php
            if (isset($_POST['clear'])) {
              mysql_connect('localhost','root','');
              mysql_select_db('fypwebsite');

              $tru="truncate table reloads3";
              mysql_query($tru);

              header('Location: previousreadings.php#previousreadings'); 
            }
          ?>

          <!-- Load Start Time -->
          <form action = "#" method = "POST">
            <label for = "load_start"> Select a Start Time: </label>
            <select name = "select_start">
              <option value = "" selected = "selected"> Select Time </option>
          
              <?php
              mysql_connect('localhost','root','');
              mysql_select_db('fypwebsite');

              $sql = "SELECT time FROM uploads2";
              $result = mysql_query($sql);

              while ($row = mysql_fetch_array($result)) {
                  echo "<option value='" . $row['time'] . "'>" . $row['time'] ."</option>";
              }
              echo "</select>";
              ?>

            </select>
            <input type = "submit" name = "load_start" value = "Load Start" />
          </form>

          <?php
            if (isset($_POST['load_start'])) {
              $selected_start = $_POST['select_start'];

              mysql_connect('localhost','root','');
              mysql_select_db('fypwebsite');

              $tru="truncate table reloads";
              mysql_query($tru);
              
              $sql = "INSERT reloads
                      SELECT * FROM uploads2
                      WHERE time >= ('$selected_start')";
              mysql_query($sql);

              $sql2 = "DELETE FROM reloads2 WHERE time < ('$selected_start')";
              mysql_query($sql2);

              $sql3 = "INSERT reloads2
                       SELECT * FROM uploads2
                       WHERE time >= ('$selected_start') AND time < (SELECT MIN(time) FROM reloads2)";
              mysql_query($sql3);

              $tru2 = "truncate table reloads3";
              mysql_query($tru2);

              $sql4 = "INSERT reloads3
                       SELECT * FROM reloads2 ORDER BY time ASC";
              mysql_query($sql4);

              header('Location: previousreadings.php#previousreadings'); 
            } 
          ?>
          
           <!--  Load End Time -->
           <form action = "#" method = "POST">
              <label for = "load_end"> Select an End Time: </label>
              <select name = "select_end">
                <option value = "" selected = "selected"> Select Time </option>

                <?php
                mysql_connect('localhost','root','');
                mysql_select_db('fypwebsite');

                $sql = "SELECT time FROM uploads2";
                $result = mysql_query($sql);

                while ($row = mysql_fetch_array($result)) {
                    echo "<option value='" . $row['time'] ."'>" . $row['time'] . "</option>";
                }
                echo "</select>";
                ?>

              </select>
              <input type = "submit" name = "load_end" value = "Load End" />
          </form>

          <?php
            if (isset($_POST['load_end'])) {
              $selected_end = $_POST['select_end'];

              mysql_connect('localhost','root','');
              mysql_select_db('fypwebsite');

              $tru="truncate table reloads2";
              mysql_query($tru);

              $sql = "INSERT reloads2
                      SELECT * FROM reloads";
              mysql_query($sql);
              
              $sql2 = "DELETE FROM reloads2 WHERE time > ('$selected_end')";
              mysql_query($sql2);

              $tru2 = "truncate table reloads3";
              mysql_query($tru2);

              $sql3 = "INSERT reloads3
                       SELECT * FROM reloads2 ORDER BY time ASC";
              mysql_query($sql3);

              header('Location: previousreadings.php#previousreadings'); 
            } 
          ?>
        </div>

        <!--   Display Readings  -->
        <div 
          class="iframe-container iframe-container-for-wxh-500x350" style="-webkit-overflow-scrolling: touch; overflow: auto;">
        </div>

        <iframe width="100%" height="660" src="http://localhost/fypwebsite/chartjs/graph_reloaded.html" frameborder="0" allowfullscreen></iframe>

      </section>

      <!-- Footer -->
      <footer class="footer">
        Contact me via <a href="mailto:a0124453@u.nus.edu">email</a>
      </footer>

  </body>
</html>