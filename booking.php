<!DOCTYPE html>
<html>
<?php
include 'session_customer.php';
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
}
?>
<title>Book Car </title>
<head>
    <script type="text/javascript" src="assets/ajs/angular.min.js"> </script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/custom.js"></script>
 <link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
</head>
<body ng-app="">


      <!-- Navigation -->
     <!-- Navigation -->
     <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Axl Rentals </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
if (isset($_SESSION['login_client'])) {
    ?>
                       <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a>
                    </li>
                    <li>
                    <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="entercar.php">Add Car</a></li>

              <li> <a href="clientview.php">History</a></li>
              <li> <a href="pending_bookings_admin.php">Pending Bookings</a></li>
              <li> <a href="pending_users.php">Pending Users</a></li>
              <li> <a href="all_users.php">Users</a></li>

            </ul>
            </li>
          </ul>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
} else if (isset($_SESSION['login_customer'])) {
    ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="customer_index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <li> <a href="pending_bookings.php"> Pending Bookings</a></li>
                    <li> <a href="mybookings.php"> Booking History</a></li>

                    <li> <a href="prereturncar.php">Return My Car</a></li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
} else {
    ?>

            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                                <li>
                                    <a href="customerlogin.php">Login</a>
                                </li>
                                <li>
                                    <a href="customersignup.php">Sign Up</a>
                                </li>
                    <li>
                        <a href="#"> FAQ </a>
                    </li>
                </ul>
            </div>
                <?php }
?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="bookingconfirm.php" enctype="multipart/form-data" method="POST">
        <br style="clear: both">
          <br>

        <?php
$car_id = $_GET["id"];
$sql1 = "SELECT * FROM cars WHERE car_id = '$car_id'";
$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $car_name = $row1["car_name"];
        $car_nameplate = $row1["car_nameplate"];
        $ac_price = $row1["car_fare"];
    }
}

?>
           <h3>Gcash Number of Axl Rentals: 09392452175</h3>
          <!-- <div class="form-group"> -->
              <h5> Selected Car:&nbsp;  <b><?php echo ($car_name); ?></b></h5>
         <!-- </div> -->

          <!-- <div class="form-group"> -->
            <h5> Number Plate:&nbsp;<b> <?php echo ($car_nameplate); ?></b></h5>
            <h5> Fare per Day:&nbsp;<b> <?php echo '₱' . number_format($ac_price, 2); ?></b></h5>
          <!-- </div>      -->
        <!-- <div class="form-group"> -->
        <?php $today = date("Y-m-d")?>
          <label><h5>Start Date:</h5></label>
            <input type="date" name="rent_start_date" min="<?php echo ($today); ?>" required="">
            <br>
          <label><h5>End Date:</h5></label>
          <input type="date" name="rent_end_date" min="<?php echo ($today); ?>" required="">
        <!-- </div>      -->
        <br>
        <br>
        <hr>
        <label><h5>Gcash Reference Number:</h5></label>
        <input type="number" name="reference_number" min="0" required="">

        <label><h5>Gcash Reciept Image:</h5></label>
        <input class="form-control" id="uploadedimage" type="file" name="uploadedimage" placeholder="Receipt" required>

            <br><br>

                <input type="hidden" name="hidden_carid" value="<?php echo $car_id; ?>">


           <input type="submit"name="submit" value="Rent Now" class="btn btn-warning pull-right">
        </form>

      </div>
      <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6><strong>Note:</strong> You will be charged with extra <span class="text-danger">₱500</span> for each day after the due date ends.</h6>
        </div>
    </div>

</body>
<footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© <?php echo date("Y"); ?> Axl Rentals</h5>
                </div>
            </div>
        </div>
    </footer>
</html>