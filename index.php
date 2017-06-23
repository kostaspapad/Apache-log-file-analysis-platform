<?php
  session_start();
  require('./lib/connectdb.php');
  require_once("./lib/userfunctions.php");
?>

<html>
  <head>
  <title>Log Analysis</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./lib/css/all.css">
  <link rel="stylesheet" type="text/css" href="./lib/css/datatables.css">
  <!-- <link rel="stylesheet" href="./css/css.css">
  <link rel="stylesheet" href="css/bootstrap-dropdownhover.css">

  <link rel="stylesheet" type="text/css" href="./css/datatables.css">
  <link rel="stylesheet" type="text/css" href="./css/daterangepicker.css" />
  <link href="./css/bootstrap-toggle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrapValidator.css"/>
  <link rel="stylesheet" href="css/query-builder.css"/>
  <link rel='stylesheet' href='css/spectrum.css' />
  <link href="css/simple-sidebar.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css.map"> -->
  <script src="./lib/js/jquery-1.12.4.min.js"></script>
  <script src="./lib/js/bootstrap.min.js"></script>
  <script src="./lib/js/bootstrap-dropdownhover.js"></script>
  <script src="./lib/js/datatables/datatables.js"></script>
  <script src="./lib/js/highcharts.js"></script>
  <script src="./lib/js/no-data-to-display.js"></script>
  <script src="./lib/js/exporting.js"></script>
  <script src="./lib/js/moment.js"></script>
  <script src="./lib/js/daterangepicker.js"></script>
  <script src="./lib/js/bootstrap-toggle.min.js"></script>
  <script src="./lib/js/bootstrap-validator/bootstrapValidator.js"></script>

  <script src="./lib/js/query-builder.standalone.js"></script>
  <script src="./lib/js/sql-parser/browser.js"></script>
  <script src="./lib/js/sql-parser/compiled_parser.js"></script>
  <script src="./lib/js/sql-parser/grammar.js"></script>
  <script src="./lib/js/sql-parser/lexer.js"></script>
  <script src="./lib/js/sql-parser/nodes.js"></script>
  <script src="./lib/js/sql-parser/sql_parser.js"></script>
  <script src="./lib/js/sql-parser/parser.js"></script>

  <script src='./lib/js/spectrum.js'></script>
  <script src="./lib/js/rgbcolor.js"></script>
  <script src="./lib/js/StackBlur.js"></script>
  <script src="./lib/js/canvg.js"></script>
  <script src="./lib/js/timezones.full.js"></script>
  <script src="./lib/js/jquery.validate.js"></script>
  <script src="./lib/js/additional-methods"></script>
  <script src='./lib/js/md5.js'></script>


  <script src="./lib/js/datatables/dataTables.buttons.min.js"></script>
  <script src="./lib/js/datatables/buttons.flash.min.js"></script>
  <script src="./lib/js/datatables/jszip.min.js"></script>
  <script src="./lib/js/datatables/vfs_fonts.js"></script>
  <script src="./lib/js/datatables/buttons.html5.min.js"></script>


  </head>

  <?php  //https://stackoverflow.com/questions/1545357/how-to-check-if-a-user-is-logged-in-in-php
  if (isset($_SESSION['userID'])) {
      require('main.php');
  } else {
      require('pages/loginForm.php');
  }

  if (isset($_GET['o'])) {
      require('pages/'.$_GET['o'].'.php');
  } elseif (isset($_GET['admin'])) { //oti exei sxesi me admin
      require('pages/admin/' . $_GET['admin'] . '.php');
  }

  ?>
</html>
