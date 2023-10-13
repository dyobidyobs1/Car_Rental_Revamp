<!DOCTYPE html>
<html>
<?php
session_start();
require 'connection.php';
$conn = Connect();


if (isset($_SESSION['login_customer'])) {
    header("location: customer_index.php"); //Redirecting
}
?>
<head>
<link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
<link rel="stylesheet" type="text/css" href="assets/css/customerlogin.css">
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
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

<?php $login_customer = $_SESSION['login_client'];

$sql1 = "SELECT * FROM rentedcars rc, cars c
    WHERE c.car_id=rc.car_id AND rc.booking_status='pending' order by rc.id desc";
$result1 = $conn->query($sql1);

if (mysqli_num_rows($result1) > 0) {
    ?>
<div class="container">
      <div class="jumbotron">
        <h1 class="text-center">Pending Bookings</h1>
      </div>
    </div>

    <div class="table-responsive" style="padding-left: 100px; padding-right: 100px;" >
<table class="table table-striped">
  <thead class="thead-dark">
<tr>
<th width="15%">Car</th>
<th width="15%">Start Date</th>
<th width="15%">End Date</th>
<th width="10%">Fare</th>
<th width="15%">Number of Days</th>
<th width="15%">Total Amount</th>
<th width="15%">Action</th>
</tr>
</thead>
<?php
while ($row = mysqli_fetch_assoc($result1)) {

    function dateDiff($start, $end)
        {
            $start_ts = strtotime($start);
            $end_ts = strtotime($end);
            $diff = $end_ts - $start_ts;
            return round($diff / 86400);
        }

    $duration = dateDiff($row['rent_start_date'], $row["rent_end_date"]);
?>
<tr>
<td><?php echo $row["car_name"]; ?></td>
<td><?php echo date('M d, Y', strtotime($row["rent_start_date"])); ?></td>
<td><?php echo date('M d, Y', strtotime($row["rent_end_date"])); ?></td>
<td><?php
if ($row["charge_type"] == "day") {
            echo ('₱' . number_format($row["fare"], 2) . "/day");
        } else {
            echo ('₱' . number_format($row["fare"], 2) . "/day");
        }
        ?></td>
<td><?php echo $duration; ?> </td>
<td><?php echo '₱' . number_format($row["fare"] * $duration, 2); ?></td>
<td>
    <a href="view_pictures.php?src=<?php echo $row["reciept_image"]; ?>"> View Reciept </a>
</td>
<td>
    <a href="approve.php?id=<?php echo $row["id"]; ?>"> Approve </a>
    <a href="decline.php?id=<?php echo $row["id"]; ?>"> Decline </a>
</td>
</tr>
<?php }?>
                </table>
                </div>
        <?php } else {
    ?>
        <div class="container">
      <div class="jumbotron">
        <h1 class="text-center">No Pending Request</h1>
      </div>
    </div>

            <?php
}?>

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