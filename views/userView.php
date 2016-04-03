<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NUSRiders - <?php echo $pg_username; ?></title>
    <!-- META -->
    <link href="assets/css/layout.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/cardStyle.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/listStyle.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/user.css" type="text/css" rel="stylesheet" />
    <!-- STYLES -->
  </head>
  <body>
    <div class="wrapper">
      <div class="box">
        <div id="logout" onclick="location.href='./index.php'">back to home</div>
        <div id="back" onclick="location.href='./search.php'">back to search</div>
        <img src="assets/images/userIcon.png" alt="userimg" width="150px" height="150px">
        <h1><?php echo $pg_username ?></h1>
        <?php if($pg_ownself || current_user()->isAdmin())
          echo "<div id='pbox-curr'>Wallet: ".$pg_currency."</div>";
        ?>
      </div>
      <div id="subnav">
        <div
          class="subnav-btn <?php
            if(!isset($_GET['pg_view']) || $_GET['pg_view']==1) echo "subnav-btn-active"; ?>"
          onclick="location.href='./user.php?user=<?php echo $idArg?>&amp;pg_view=1'">
          ROUTES</div>
        <div
          class="subnav-btn <?php if($_GET['pg_view']==2) echo "subnav-btn-active"; ?>"
          onclick="location.href='./user.php?user=<?php echo $idArg?>&amp;pg_view=2'">
          PENDING RIDES</div>
        <?php if($pg_ownself || current_user()->isAdmin()) { ?>
          <div
            class="subnav-btn <?php if($_GET['pg_view']==3) echo "subnav-btn-active"; ?>"
            onclick="location.href='./user.php?user=<?php echo $idArg?>&amp;pg_view=3'">
            COMPLETED RIDES</div>
        <?php } ?>
      </div>
      <div id="list" class="list"></div>
    </div>
  </body>
  <script>
  var qDat = '<?php echo $rows; ?>';
  var uid = <?php echo $idArg; ?>;
  </script>
  <?php if(!isset($_GET['pg_view']) || $_GET['pg_view']==1) {
    if($idArg == $idSs) { ?>
    <script>var tpe = 10;</script>
  <?php }else {?>
    <script>var tpe = 11;</script>
  <?php }}else if($_GET['pg_view']==2) {
    if($idArg == $idSs) { ?>
    <script>var tpe = 20;</script>
  <?php }else {?>
    <script>var tpe = 21;</script>
  <?php }}else if($_GET['pg_view']==3 && $pg_ownself || current_user()->isAdmin()) {?>
    <script>var tpe = 3;</script>
  <?php }else { /*someone GET inject 3 even without permission, go to 404 */} ?>
  <!-- PHP JS transfer -->
  <script src="assets/javascripts/googleUtils.js"></script>
  <script src="assets/javascripts/cardList.js"></script>
  <!-- load libraries -->
  <script src="assets/javascripts/user.js"></script>
  <!-- load page main method -->
  <script src="https://maps.googleapis.com/maps/api/js?callback=init&libraries=places"
      async defer></script>
  <!-- load google maps api -->
</html>
