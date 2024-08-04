<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: index.php");
  die();
}

include 'config.php';
include ('admin\includes\header.php');
include ('admin\includes\navbar.php');



$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");


?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <ol class="breadcrumb" style="background-color: transparent;">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ol>
  </div>


  <div>

  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Total number of tenants -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Tenants</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php echo $conn->query("SELECT * FROM tenant where status = 1 ")->num_rows ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- total number of houses -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Number of houses</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php echo $conn->query("SELECT * FROM houses")->num_rows ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-home fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- total income -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Income</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php
                $payment = $conn->query("SELECT sum(amount) as paid FROM payments where date(date_created) = '" . date('Y-m-d') . "' ");
                echo $payment->num_rows > 0 ? number_format($payment->fetch_array()['paid'], 2) : 0;
                ?>
              </div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">

                </div>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contracts -->






    <?php
    include ('admin\includes\scripts.php');
    ?>