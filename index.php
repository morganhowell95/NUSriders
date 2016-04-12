<!DOCTYPE html>
<html>

    <?php
        include 'php/html_partials.php';
        include 'php/functions.php';
        echo OpenHTMLDefaultApplication("Home");
        echo openGenNavBarHome();
    ?>

    <!-- enable sessions -->
    <?php
        session_name('NUSRiders');
        // Starting the session
        session_set_cookie_params(2*7*24*60*60);
        // Making the cookie live for 2 weeks
        session_start();
    ?>

    <!-- Custom internals to nav bar, dependent on presence of remembered user -->
    <?php if(is_null(current_user())): // If you are not logged in ?>

        <li> <a href="login.php" class="smoothScroll"> Login</a></li>

    <?php else: //if user is logged in  ?>
      <?php if(current_user()->isAdmin()): ?>
        <li>
          <a href="ad-drivers-list.php">Dashboard</a>
        </li>
      <?php endif; ?>

        </li>
        <!-- Ride Management -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Ride Management <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a href="search.php">
                        Search
                    </a>
                    </li>
                <li>
                    <a href="userprofile.php?user=<?php echo current_user()->getUserId(); ?>">
                        Manage
                    </a>
                </li>
                <li>
                     <a href="create.php">
                        Create
                    </a>
                </li>
            </ul>
        </li>


    <!-- Account Management -->
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Account <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a href="#">
                        My Profile
                    </a>
                    </li>
                <li>
                    <a href="#">
                        Settings
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                     <a href="logout.php">
                        Log Out
                    </a>
                </li>
            </ul>
        </li>

    <?php
    endif;
    echo closeNavBar();
    ?>


    <!-- ====== SUCCESS/ERROR MESSAGES =============!-->
    <?php
        if(isset($_SESSION['msg']['reg-err']))
        {
            echo '<div class="alert alert-danger">'.$_SESSION['msg']['reg-err'].'</div>';
            unset($_SESSION['msg']['reg-err']);
            // This will output the registration errors, if any
        }

        if(isset($_SESSION['msg']['reg-success']))
        {
            echo '<div class="alert alert-success">'.$_SESSION['msg']['reg-success'].'</div>';
            unset($_SESSION['msg']['reg-success']);
            // This will output the registration success message
        }
    ?>

    <!-- ==== HEADERWRAP ==== -->
    <div id="headerwrap" id="home" name="home" class="image">
        <header class="clearfix">
                    <p>We're here to make you feel safe.</p>
                    <p>No matter what the time.</p>
                    <h1>NUSRiders</h1>
        </header>
    </div><!-- /headerwrap -->

    <!-- ==== GREYWRAP ==== -->
        <div id="greywrap">
        <div class="row">
            <div class="col-lg-4 callout">
                <span class="icon icon-stack"></span>
                <h2>Platform</h2>
                <p>Find people to carpool with!</p>
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 callout">
                <span class="icon icon-eye"></span>
                <h2>Quick Search</h2>
                <p>Search for rides that best matches your needs quickly with our built in algorithms. </p>
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 callout">
                <span class="icon icon-heart"></span>
                <h2>Easily Share Rides</h2>
                <p>Plan a route once, use it again for future rides!</p>
            </div><!-- col-lg-4 -->
        </div><!-- row -->
    </div><!-- greywrap -->

    <!-- ==== ABOUT ==== -->
    <div class="container" id="about" name="about">
        <div class="row white">
        <br>
            <h1 class="centered">A LITTLE ABOUT NUSriders</h1>
            <hr>

            <div class="col-lg-6">
                <p>We believe ideas come from everyone, everywhere. In fact, at NUSriders, everyone within our agency walls is a designer in their own right. And there are a few principles we believe—and we believe everyone should believe—about our design craft. These truths drive us, motivate us, and ultimately help us redefine the power of design. We’re big believers in doing right by our neighbors. After all, we grew up in the Twin Cities and we believe this place has much to offer. So we do what we can to support the community we love.</p>
            </div><!-- col-lg-6 -->

            <div class="col-lg-6">
                <p>Over the past four years, we’ve provided more than $1 million in combined cash and pro bono support to Way to Grow, an early childhood education and nonprofit organization. Other community giving involvement throughout our agency history includes pro bono work for more than 13 organizations, direct giving, a scholarship program through the Minneapolis College of Art & Design, board memberships, and ongoing participation in the Keystone Club, which gives five percent of our company’s earnings back to the community each year.</p>
            </div><!-- col-lg-6 -->
        </div><!-- row -->
    </div><!-- container -->

    <section class="section-divider textdivider divider6">
            <div class="container" id="make-location">
                <h1>CRAFTED AT NUS</h1>
                <hr>
                <p>173E E Franklin St</p>
                <p>+1 704 985-5705</p>
                <p><a class="icon icon-twitter" href="#"></a> | <a class="icon icon-facebook" href="#"></a></p>
            </div><!-- container -->
    </section><!-- section -->


<?php
    require_once 'php/html_partials.php';
    echo closeHTMLDefaultApplication();
    //exit sessions
    exit();
?>

</html>
