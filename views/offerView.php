<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NUSRiders - Offer</title>
    <!-- META -->
    <link href="assets/css/layout.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/field.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/offer.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/cardStyle.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/listStyle.css" type="text/css" rel="stylesheet"/>
    <!-- STYLES -->

  </head>
  <body>
    <div class="wrapper">
      <div class="box">
        <div id="logout" onclick="location.href='./index.php'">back to home</div>
        <div id="back" onclick="location.href='./search.php'">back to search</div>
        <h1>OFFER</h1>
      </div>
      <div id="listoffer" class="list"></div>
      <?php if(isset($_GET['err'])) { ?>
      <div id = "offerBoxError">
        Invalid input(s) : Cost must be > $0, Capacity > 0, Trip Start > Now
      </div>
      <?php } ?>
      <div class="box" id = "fbox">
        <input id="f1" class = "input" type="number" min="0.01" step="0.01" placeholder="Cost Per Passenger ($)" />
        <input id="f2" class = "input" type="number" min="1" step="1" placeholder="Total Passenger Capacity" />
        <a href="javascript:NewCal('f3','ddmmmyyyy',true,24)">
          <input id="f3" class="input" type="text" placeholder="Trip Start">
        </a>
      </div>
      <div id="createBtn">
        CREATE OFFER
      </div>
    </div>
  </body>
  <script>var rid = <?php echo $rid; ?>;</script>
  <script>var qDat = '<?php echo $dat; ?>';</script>
  <!-- PHP JS transfer -->
  <script src="http://momentjs.com/downloads/moment.min.js"></script>
  <script src="assets/javascripts/datetimepicker.js"></script>
  <script src="assets/javascripts/cardList.js"></script>
  <script src="assets/javascripts/googleUtils.js"></script>
  <!-- load libraries -->
  <script src="assets/javascripts/offer.js"></script>
  <!-- load page main method -->
  <script src="https://maps.googleapis.com/maps/api/js?callback=init&libraries=places"
      async defer></script>
  <!-- load google maps api -->
</html>
