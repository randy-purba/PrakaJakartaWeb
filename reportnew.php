<?php
  session_start();
  if(!isset($_SESSION["pageNewReport"])){
    $_SESSION["pageNewReport"]=1;
  }
  
  if(isset($_POST['submitCetak'])){
    $data = array('limit' => '2000', 'sortby' => 'id', 'order' => 'DESC');
      $options = array(
        'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
          'method'  => 'GET',
          )
      );
    $contentData=http_build_query($data);
    $context  = stream_context_create($options);
    $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/otherSurveyors/?'.$contentData, false, $context);

    // var_dump($result);
    if ($result === FALSE) {
      echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
    }else{
      $data = json_decode($result);
      // var_dump($data);
      $boolEchoCsv = true;
      $strTempFile = "reportNewFull.csv";
      $f = fopen($strTempFile,"w+");
      $firstLineKeys = false;
      foreach ($data->data->rows as $line) {
        $WorkingArray = json_decode(json_encode($line),true);
        // var_dump($WorkingArray);
        if (empty($firstLineKeys)) {
          $firstLineKeys = array_keys($WorkingArray);
          fputcsv($f, $firstLineKeys);
          $firstLineKeys = array_flip($firstLineKeys);
        }
        
        // Using array_merge is important to maintain the order of keys acording to the first element
        fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
      }
      fclose($f);
      header("Location: ".$strTempFile);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <title>Rekap Laporan | Praka-Jakarta</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <div class="sidebar">
      <div class="header"><h4>Praka Jakarta</h4></div>
      <div class="menu">
        <a class="" href="dashboard.php"><i class="icons icon-home"></i>dashboard</a>
        <a class="" href="map.php"><i class="icons icon-dashboard"></i>map</a>
        <a class="" href="report.php"><i class="icons icon-invoices"></i>rekap laporan</a>
        <a class="" href="koordinator.php"><i class="icons icon-coordinator"></i>koordinator</a>
        <a class="" href="surveyor.php"><i class="icons icon-customers"></i>surveyor</a>
        <!-- <a class="" href="mapnew.php"><i class="icons icon-dashboard"></i>map baru</a>
        <a class="active" href="reportnew.php"><i class="icons icon-invoices"></i>rekap laporan baru</a>
        <a class="" href="surveyornew.php"><i class="icons icon-customers"></i>surveyor baru</a> -->
      </div>
    </div>
    <div class="right-content">
      <div class="header">
        <div class="header-link">
          <h6><?php echo $_SESSION["name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;</h6>
          <h6><a href="action.php?logout=true" style="color: #43425D; text-decoration: none;">Logout</a></h6>
        </div>
      </div>
      <div class="content">
        <div class="table">
          <h4>surveyor</h4>
          <div class="btn-group">
            <!-- <button type="button"><i class="icons icon-invoices-white"></i>cetak laporan</button>-->
	          <!-- <button type="button" data-toggle="modal" data-target="#cetakLaporan"><i class="icons icon-invoices-white"></i>cetak laporan</button> -->
            <!-- <button type="button" data-toggle="modal" data-target="#cetakLaporanFull"><i class="icons icon-invoices-white"></i>cetak laporan full</button> -->
            <!-- <form action="#" method="post">
            <button type="submit" name="submitCetak"><i class="icons icon-invoices-white"></i>cetak laporan</button>
            </form> -->
            <button type="button" data-toggle="modal" data-target="#cetakLaporanFull"><i class="icons icon-invoices-white"></i>cetak laporan full</button>
            <!-- <button type="button" onclick="exportTableToExcel('tblData', 'report-full-data')"><i class="icons icon-invoices-white"></i>cetak laporan full</button> -->
	    <!--<button type="button" onclick="exportTableToExcel('tblData', 'report-full-data')"><i class="icons icon-invoices-white"></i>cetak laporan full</button>-->
          </div>
          <table id="tblData">
            <thead>
              <td>no</td>
              <td>tanggal</td>
              <td>username</td>
              <td>total marker</td>
            </thead>
            <tbody>
              <?php 
                $data = "";
                $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageNewReport"]);
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
                        'method'  => 'GET',
                    )
                );
                $contentData=http_build_query($data);
                $context  = stream_context_create($options);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/otherSurveyors/?'.$contentData, false, $context);
                // var_dump($result);
                if ($result === FALSE) {
                  echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                }else{
                  $data = json_decode($result);
                  for($i = 0; $i < sizeof($data->data->rows); $i++){
                    $create = explode("T", $data->data->rows[$i]->createdAt);
                    echo '<tr>';
                    echo '<td>'. ($i+1) .'</td>';
                    echo '<td>'.$create[0].'</td>';
                    echo '<td>'.$data->data->rows[$i]->username.'</td>';
                    echo '<td class="confidential">'.$data->data->rows[$i]->totalMarker.'</td>';
                    echo '</tr>';
                  }
                }
              ?>
            </tbody>
          </table>
          <ul class="pagination">
            <li class="page-item">
              <?php
                echo '<a class="page-link" href="action.php?pageNewReport=1" aria-label="Previous">'
              ?>
              <!-- <a class="page-link" href="#" aria-label="Previous"> -->
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php
              $pages=$_SESSION["pageNewReport"];
              if($pages+9 > $data->data->page){
                // $pages=$data->data->page - 9;
                for($i = 1; $i <= $data->data->page; $i++){
                  $status =  $i==$_SESSION["pageNewReport"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageNewReport='.$i.'">'. $i .'</a></li>';
                }
              }else{
                for($i = $pages; $i <= $pages+9; $i++){
                  $status =  $i==$_SESSION["pageNewReport"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageNewReport='.$i.'">'. $i .'</a></li>';
                }
              }
              // for($i = $pages; $i <= $pages+9; $i++){
              //   $status =  $i==$_SESSION["pageReport"] ? 'active' : '';
              //   echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageReport='.$i.'">'. $i .'</a></li>';
              // }
            ?>
            <li class="page-item">
            <?php
                echo '<a class="page-link" href="action.php?pageNewReport='.$data->data->page.'" aria-label="Next">'
              ?>
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="modal fade" id="cetakLaporanFull" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">cetak laporan full</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="export.php" method="post">
          <div class="modal-body">
            <input id="datetimepicker" type="text" class="form-control date" placeholder="Pilih Tanggal" aria-label="Pilih Tanggal" name="reportDateNew">
          </div>
          <div class="modal-footer">
            <button type="submit" name="submitCetakLaporanFull">cetak</button>
          </div>
          </form>
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
