<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NUSRiders - Search</title>
    <!-- META -->
    <link href="assets/css/layout.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/field.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/search.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/cardStyle.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/listStyle.css" type="text/css" rel="stylesheet"/>
    <!-- STYLES -->
  </head>
  <body>
    <div class = "wrapper">
      <div class="box">
        <div id="logout" onclick="location.href='./index.php'">back to home</div>
        <h1>SEARCH</h1>
        <div class="box-fields">
          <input id="pac-input-A" class = "input" type="search" placeholder="From" />
          <input id="pac-input-B" class = "input" type="search" placeholder="To" />
          <a href="javascript:NewCal('pac-input-DT','ddmmmyyyy',true,24)">
            <input id="pac-input-DT" class="input" type="text" placeholder="Trip Start">
          </a>
        </div>
        <div class="profileBtn" onclick="location.href='./user.php?user=<?php echo current_user()->getUserId()?>'">
          <img src="assets/images/userIcon.png" alt="profile" width="25px" height="25px">
          <?php echo current_user()->getFirstName() ?>
        </div>
      </div>
      <div id="list" class="list"></div>
    </div>
  </body>
  <script>
  var uid = <?php echo current_user()-> getUserId(); ?>;
  var qDat = '<?php echo $rows; ?>';</script>
  <!-- PHP JS transfer -->
  <script src="http://momentjs.com/downloads/moment.min.js"></script>
  <script src="assets/javascripts/datetimepicker.js"></script>
  <script src="assets/javascripts/cardList.js"></script>
  <script src="assets/javascripts/googleUtils.js"></script>
  <!-- load libraries -->
  <script src="assets/javascripts/search.js"></script>
  <!-- load page main method -->
  <script src="https://maps.googleapis.com/maps/api/js?callback=init&libraries=places"
      async defer></script>
  <!-- load google maps api -->
</html>
