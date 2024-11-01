<?php
  session_start();

  if($_SESSION["username"] == null){
    header('Location: login.php');
  }
  $url = "https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/getAllUser";
  $data = json_decode(file_get_contents($url), true);
  $url2 = "https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/getAllReport";
  $data2 = json_decode(file_get_contents($url2), true);
  $url3 = "https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/getReportToday";
  $data3 = json_decode(file_get_contents($url3), true);
  // echo $_SESSION["Authorization"];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <title>Dashboard | Praka-Jakarta</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <div class="sidebar">
      <div class="header"><h4>Praka Jakarta</h4></div>
      <div class="menu">
        <a class="active" href="dashboard.php"><i class="icons icon-home"></i>dashboard</a>
        <a class="" href="map.php"><i class="icons icon-dashboard"></i>map</a>
        <a class="" href="report.php"><i class="icons icon-invoices"></i>rekap laporan</a>
        <a class="" href="koordinator.php"><i class="icons icon-coordinator"></i>koordinator</a>
        <a class="" href="surveyor.php"><i class="icons icon-customers"></i>surveyor</a>
        <a class="" href="mapnew.php"><i class="icons icon-dashboard"></i>map baru</a>
        <a class="" href="reportnew.php"><i class="icons icon-invoices"></i>rekap laporan baru</a>
        <a class="" href="surveyornew.php"><i class="icons icon-customers"></i>surveyor baru</a>
      </div>
    </div>
    <div class="right-content">
      <div class="header">
        <div class="header-link">
          <h6><?php echo $_SESSION["name"] ?? null;?>&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;</h6>
          <h6><a href="action.php?logout=true" style="color: #43425D; text-decoration: none;">Logout</a></h6>
        </div>
      </div>
      <div class="content">
        <h4>overview</h4>
        <div class="boxs">
          <div class="box">
            <h6>total marker hari ini</h6>
            <h1><?php echo $data3['data'] ?? null;?></h1>
            <img src="img/chart_surveyor.svg" alt="Total Marker Hari ini">
          </div>
          <div class="box">
            <h6>total surveyor</h6>
            <h1><?php echo $data['data']?? null;?></h1>
            <img src="img/chart_surveyor.svg" alt="Total Surveyor">
          </div>
          <div class="box">
            <h6>total banner</h6>
            <h1><?php echo $data2['data']?? null;?></h1>
            <img src="img/chart_banner.svg" alt="Total Banner">
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/master.js"></script>
  </body>
</html>
