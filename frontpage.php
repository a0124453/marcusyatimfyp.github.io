<!DOCTYPE html>
<html>

  <!-- Head -->
  <head>
    <meta http-equiv="refresh" content="3" >    <!--     Refresh page after every n secs -->
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
            <a href="#about">About</a>
          </li>
          <li>
            <a href="#datareadings">Data Readings</a>
          </li>
          <li>
            <a href="previousreadings.php#previousreadings">Previous Readings</a>
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
          	include 'upload.php';
          ?>

          <!-- Load Button -->
          <form action = "#" method = "POST">
            <label for = "load"> Load Readings: </label>
            <button type = "submit" name = "load">Load</button>
          </form>

          <?php
            if (isset($_POST['load'])) {
            	$sql = "INSERT uploads2
					    SELECT * FROM uploads 
					    ORDER BY id ASC LIMIT 1";

				      mysql_query($sql);

              header('Location: frontpage.php#datareadings');
            }
          ?>

          <!-- Reset Button -->
          <form action = "#" method = "POST">
            <label for = "reset"> Reset to Zero: </label>
            <button type = "submit" name = "reset">Reset</button>
          </form>

          <?php
            if (isset($_POST['reset'])) {
              mysql_connect('localhost','root','');
              mysql_select_db('fypwebsite');

              $tru="truncate table uploads2";
              mysql_query($tru);

              header('Location: frontpage.php#datareadings');
            }
          ?>
        </div>

    		<!--   Display Readings  -->
    		<div 
    			class="iframe-container iframe-container-for-wxh-500x350" style="-webkit-overflow-scrolling: touch; overflow: auto;">
    		</div>

		    <iframe width="100%" height="660" src="http://localhost/fypwebsite/chartjs/graph_upload.html" frameborder="0" allowfullscreen></iframe>

        <!-- Previous Readings -->
        <div id = "previousreadings">
          <h2> Previous Readings </h2>
          <p>
            Click <a href="previousreadings.php#previousreadings">here</a> to view previous time readings.
          </p>
        </div>

      <!-- Footer -->
      <footer class="footer">
        Contact me via <a href="mailto:a0124453@u.nus.edu">email</a>
      </footer>

    </section>
  </body>
</html>