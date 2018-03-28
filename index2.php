<!DOCTYPE html>
<html>

  <!-- Head -->
  <head>
    <!-- <meta http-equiv="refresh" content="10" >  -->    <!--     Refresh page after every n secs -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eu Jin Marcus Yatim's FYP</title>
    <link rel="stylesheet" href="style.css">
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
            <a href="#about">About</a>
          </li>
          <li>
            <a href="#datareadings">Data Readings</a>
          </li>
          <li>
            <a href="#previousreadings">Previous Readings</a>
          </li>
        </ul>
      </nav>

      <main class="main center">
        <h1>Phasor Measurement Unit for power grids</h1>
        <h2>Developing a web app to aggregate real-time data from power grids</h2>
      </main>
      <section class="section">

        <!-- About -->
        <div id="about">
          <h2>About</h2>
          <p>
            This project will have a phasor measurement unit (PMU) implemented in an FPGA board
            (Altera DE2-115 Cyclone 4) and it will also be configured to contain a communication
            process code. We will make use of the FPGA board’s communication protocols to establish a
            network between the PMU and a server. The data collected from
            the PMU will then be able to be displayed and read online through a graphical user interface
            (e.g. a website). This GUI will have to be robust and appealing. 
          </p>
        </div>

        <!-- Data Readings -->
     	<div id = "datareadings">
        <h2> Data Readings</h2>

           <?php
            mysql_connect('localhost','root','');
            mysql_select_db('fypwebsite');

            $file = fopen("test.txt","r");
            $tru="truncate table uploads";
            mysql_query($tru);
          
            while(!feof($file)) {
              $line = fgets($file);
              $values = str_replace(",","','",$line);
              $sql = "INSERT INTO uploads VALUES('$values')";
              mysql_query($sql);
            }
            fclose($file);
          ?> 

          <!-- Display Current Data Readings -->
          <iframe src="http://localhost/fypwebsite/chartjs/linegraph_upload.html"
                  style = "border: 0; width: 100% ; height: 300px">
          </iframe> 
        </div>

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

              $sql = "SELECT time FROM uploads";
              $result = mysql_query($sql);

              while ($row = mysql_fetch_array($result)) {
                  echo "<option value='" . $row['time'] . "'>" . $row['time'] ."s</option>";
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
                      SELECT * FROM uploads
                      WHERE time >= ('$selected_start')";
              mysql_query($sql);

              $sql2 = "DELETE FROM reloads2 WHERE time < ('$selected_start')";
              mysql_query($sql2);

              $sql3 = "INSERT reloads2
                       SELECT * FROM uploads
                       WHERE time >= ('$selected_start') AND time < (SELECT MIN(time) FROM reloads2)";
              mysql_query($sql3);

              $tru2 = "truncate table reloads3";
              mysql_query($tru2);

              $sql4 = "INSERT reloads3
                       SELECT * FROM reloads2 ORDER BY time ASC";
              mysql_query($sql4);

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

                $sql = "SELECT time FROM uploads";
                $result = mysql_query($sql);

                while ($row = mysql_fetch_array($result)) {
                    echo "<option value='" . $row['time'] ."'>" . $row['time'] . "s</option>";
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
            } 
          ?>

          <!--    Display Readings -->
          <iframe src="http://localhost/fypwebsite/chartjs/linegraph_reload.html"
                    style = "border: 0; width: 100% ; height: 300px">
          </iframe>
        </div>

       <!-- <div id="uploadreadings">
          <h2>Upload Readings</h2>
          <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for = "file"> Select a file to read: </label>l
            <input type = "file" name = "file"/>
            <button type = "submit" name = "Submit">Upload</button>
          </form>
          <p>
            The data from your selected file will be displayed in graph form below:
          </p>
          <iframe src="http://localhost/fypwebsite/chartjs/linegraph_upload.html"
                  style = "border: 0; width: 100% ; height: 300px">
          </iframe> 
        </div> -->
        <!-- <div id = "previousreadings">
          <h2> Previous Readings</h2>
          <p>
            Select a previously uploaded file to read:
          <form action = "#" method = "POST">
            <select name = "select_reading">
              <option value = "" selected = "selected"> -Select File- </option>
              <?php
                $resource = opendir("uploads");
                while(($entry = readdir($resource)) !== FALSE) {
                  if($entry != '.' && $entry != '..' && $entry != '.com.apple.timemachine.supported' && $entry != '.DS_Store') {
                      echo "<option value='{$entry}'" . ($pageImage == $entry ? " selected" : "") . ">{$entry}</option>";
                  }
                }
              ?>
            </select>
            <input type = "submit" name = "load" value = "Load" />
          </form>
          <?php
            if (isset($_POST['load'])) {
              $selected_file = $_POST['select_reading'];

              mysql_connect('localhost','root','');
              mysql_select_db('fypwebsite');

              $file = fopen("uploads/".$selected_file,"r");
              $tru="truncate table reloads";
              mysql_query($tru);
              while(!feof($file)) {
                $line = fgets($file);
                $values = str_replace(",","','",$line);
                $sql = "insert into reloads values('$values')";
                mysql_query($sql);
              }
              fclose($file);
            } 
          ?> -->
          <!-- <p>
            The data from your selected file will be displayed in graph form below:
          </p>
          <iframe src="http://localhost/fypwebsite/chartjs/linegraph_reload.html"
                  style = "border: 0; width: 100% ; height: 300px">
          </iframe> -->

      </section>

      <!-- Footer -->
      <footer class="footer">
        Contact me via <a href="mailto:a0124453@u.nus.edu">email</a>
      </footer>

    </div>
  </body>
</html>