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
      <div id="ofForm">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
      <div id="createBtn">
        MAKE OFFER
      </div>
    </div>
  </body>
  <script>var qDat = '<?php echo $dat; ?>';</script>
  <!-- PHP JS transfer -->
  <script src="assets/javascripts/cardList.js"></script>
  <script src="assets/javascripts/googleUtils.js"></script>
  <!-- load libraries -->
  <script src="assets/javascripts/offer.js"></script>
  <!-- load page main method -->
  <script src="https://maps.googleapis.com/maps/api/js?callback=init&libraries=places"
      async defer></script>
  <!-- load google maps api -->
</html>
