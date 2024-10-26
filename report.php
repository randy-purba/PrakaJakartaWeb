<?php
  session_start();
  if(!isset($_SESSION["pageReport"])){
    $_SESSION["pageReport"]=1;
  }

  if(isset($_GET["wilayah"])){
    $_SESSION['wilayah']=$_GET["wilayah"];
    $_SESSION['kabupaten'] = null;
    $_SESSION['dapil'] = null;
    $_SESSION['mapKoordinatorId'] = null;
    $_SESSION['mapSurveyorId']=null;
  }

  if(isset($_GET["kabupaten"])){
    $_SESSION['kabupaten']=$_GET["kabupaten"];
    $_SESSION['dapil'] = null;
    $_SESSION['mapKoordinatorId'] = null;
    $_SESSION['mapSurveyorId']=null;
  }

  if(isset($_GET["dapil"])){
    $_SESSION['dapil']=$_GET["dapil"];
    $_SESSION['mapKoordinatorId'] = null;
    $_SESSION['mapSurveyorId']=null;
  }

  if(isset($_GET["mapKoordinatorId"])){
    $_SESSION['mapKoordinatorId']=$_GET["mapKoordinatorId"];
    $_SESSION['mapSurveyorId']=null;
  }
  if(isset($_GET["mapSurveyorId"])){
    $_SESSION['mapSurveyorId']=$_GET["mapSurveyorId"];
  }

  if(isset($_POST['reportDate']) && !isset($_POST['CoordinatorId'])){
      $options = array(
        'http' => array(
            'method'  => 'GET',
            "header" => "Authorization: Bearer ". $_SESSION['Authorization']."\r\n"
        )
      );
      $context  = stream_context_create($options);
      $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/downloadFull/'.$_POST['reportDate'], false, $context);
      // var_dump($result);
      if ($result === FALSE) {
        echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
      }else{
        $data = json_decode($result);
        // var_dump($data);
        $boolEchoCsv = true;
        $strTempFile = "reportFull.csv";
        $f = fopen('php://memory',"w+");
        $firstLineKeys = false;
        foreach ($data->data as $line) {
          $WorkingArray = json_decode(json_encode($line),true);
          if (empty($firstLineKeys)) {
            $firstLineKeys = array_keys($WorkingArray);
            fputcsv($f, $firstLineKeys);
            $firstLineKeys = array_flip($firstLineKeys);
          }
          
          fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
        }
        fseek($f, 0);
        header("Content-type: application/csv");
        header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
        fpassthru($f);
      }
  }
  
  if(isset($_POST['CoordinatorId'])){
    $options = array(
      'http' => array(
          'method'  => 'GET',
          "header" => "Authorization: Bearer ". $_SESSION['Authorization']."\r\n"
      )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/downloadPart/'.$_POST['reportDate'].'/'.$_POST['CoordinatorId'], false, $context);
    // var_dump($result);
    if ($result === FALSE) {
      echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
    }else{
      $data = json_decode($result);
      // var_dump($data);
      $boolEchoCsv = true;
      $strTempFile = "report.csv";
      $f = fopen($strTempFile,"w+");
      $firstLineKeys = false;
      foreach ($data->data as $line) {
        $WorkingArray = json_decode(json_encode($line),true);
        // var_dump($WorkingArray);
        if (empty($firstLineKeys)) {
          $firstLineKeys = array_keys($WorkingArray);
          fputcsv($f, $firstLineKeys);
          $firstLineKeys = array_flip($firstLineKeys);
        }
        fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
      }
      fseek($f,0);
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
    <title>Rekap Laporan | Ayo-Jo</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <div class="sidebar">
      <div class="header"><h4>Praka Jakarta</h4></div>
      <div class="menu">
        <a class="" href="index.php"><i class="icons icon-home"></i>dashboard</a>
        <a class="" href="map.php"><i class="icons icon-dashboard"></i>map</a>
        <a class="active" href="report.php"><i class="icons icon-invoices"></i>rekap laporan</a>
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
          <h6><?php echo $_SESSION["name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;</h6>
          <h6><a href="action.php?logout=true" style="color: #43425D; text-decoration: none;">Logout</a></h6>
        </div>
      </div>
      <div class="content">
        <div class="table">
          <h4>surveyor</h4>
          <div class="btn-group">
            <select name="filterWilayah" id="filterWilayah" onChange="myFunction1()">
              <option value="" selected>Wilayah</option>
              <?php
                $options = array(
                    'http' => array(
                        'method'  => 'GET',
                    )
                );
                $context  = stream_context_create($options);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/wilayah', false, $context);
                var_dump($result);
                if ($result === FALSE) {
                  echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
                }else{
                  $data = json_decode($result);
                  $selected = "";
                  for($i = 0; $i < sizeof($data->data); $i++){
                    if(isset($_SESSION["wilayah"])){
                      if($_SESSION["wilayah"]==$data->data[$i]->id){
                        echo '<option selected value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                      }else{
                        echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                      }
                    }else{
                      echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                    }
                  }
                }
              ?>
            </select>
            <select name="filterKabupaten" id="filterKabupaten" onChange="myFunction2()">
              <option value="" selected>Kabupaten</option>
            </select>
            <select name="filterDapil" id="filterDapil" onChange="myFunction3()">
              <option value="" selected>Dapil</option>
            </select>
            <select name="filterKoordinator" id="filterKoordinator" onChange="window.location='<? print 'report'; ?>.php?mapKoordinatorId='+this.value">
              <option value="" selected>Koordinator</option>
              <?php
                if(isset($_SESSION["dapil"]) || isset($_SESSION['kabupaten']) || isset($_SESSION['wilayah'])){
                  $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC', 'filterbywilayah' => $_SESSION['wilayah'], 'filterbykabupaten' => $_SESSION['kabupaten'], 'filterbydapil' => $_SESSION["dapil"]);
                  $options = array(
                      'http' => array(
                          'method'  => 'GET',
                      )
                  );
                  $contentData=http_build_query($data);
                  $context  = stream_context_create($options);

                  $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                  if ($result === FALSE) {
                    echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                  }else{
                    $data = json_decode($result);
                    for($i = 0; $i < sizeof($data->data->rows); $i++){
                      if(isset($_SESSION["mapKoordinatorId"])){
                        if($_SESSION["mapKoordinatorId"]==$data->data->rows[$i]->id){
                          echo '<option selected value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                        }else{
                          echo '<option value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                        }
                      }else{
                        echo '<option value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                      }
                    }
                  }
                }
              ?>
            </select>
	          <button type="button" data-toggle="modal" data-target="#cetakLaporan"><i class="icons icon-invoices-white"></i>cetak laporan</button>
            <button type="button" data-toggle="modal" data-target="#cetakLaporanFull"><i class="icons icon-invoices-white"></i>cetak laporan full</button>
          </div>
          <table id="tblData">
            <thead>
              <td>no</td>
              <td>nama</td>
              <td>koordinator</td>
              <td>total marker</td>
            </thead>
            <tbody>
              <?php
                $data = "";
                $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageReport"]);
                if(isset($_SESSION["wilayah"]) || $_SESSION["wilayah"] !== "" || $_SESSION["wilayah"] !== null){
                  $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageReport"], 'filterbywilayah' => $_SESSION["wilayah"]);
                }
                if(isset($_SESSION["kabupaten"]) || $_SESSION["kabupaten"] !== "" || $_SESSION["kabupaten"] !== null){
                  $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageReport"], 'filterbykabupaten' => $_SESSION["kabupaten"]);
                }
                if(isset($_SESSION["dapil"]) || $_SESSION["dapil"] !== "" || $_SESSION["dapil"] !== null){
                  $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageReport"], 'filterbydapil' => $_SESSION["dapil"]);
                }
                if(isset($_SESSION["mapKoordinatorId"]) || $_SESSION["mapKoordinatorId"] !== "" || $_SESSION["mapKoordinatorId"] !== null){
                  $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageReport"],'filterbycoordinator' => $_SESSION["mapKoordinatorId"]);
                }
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
                        'method'  => 'GET',
                    )
                );
                $contentData=http_build_query($data);
                $context  = stream_context_create($options);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/?'.$contentData, false, $context);
                if ($result === FALSE) {
                  echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                }else{
                  $data = json_decode($result);
                  for($i = 0; $i < sizeof($data->data->rows); $i++){
                    echo '<tr>';
                    echo '<td>'.($i+1).'</td>';
                    echo '<td>'.$data->data->rows[$i]->name.'</td>';
                    echo '<td>'.$data->data->rows[$i]->coordinatorName.'</td>';
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
                echo '<a class="page-link" href="action.php?pageReport=1" aria-label="Previous">'
              ?>
              <!-- <a class="page-link" href="#" aria-label="Previous"> -->
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php
              $pages=$_SESSION["pageReport"];
              if($pages+9 > $data->data->page){
                for($i = 1; $i <= $data->data->page; $i++){
                  $status =  $i==$_SESSION["pageReport"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageReport='.$i.'">'. $i .'</a></li>';
                }
              }else{
                for($i = $pages; $i <= $pages+9; $i++){
                  $status =  $i==$_SESSION["pageReport"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageReport='.$i.'">'. $i .'</a></li>';
                }
              }
            ?>
            <li class="page-item">
            <?php
                echo '<a class="page-link" href="action.php?pageReport='.$data->data->page.'" aria-label="Next">'
              ?>
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="modal fade" id="cetakLaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">cetak laporan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="export.php" method="post">
          <div class="modal-body">
            <input id="datetimepicker" type="text" class="form-control date" placeholder="Pilih Tanggal" aria-label="Pilih Tanggal" name="reportDate">
            <select id="filterByKoordinator" name="CoordinatorId">
            <?php
                $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/';
                $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'ASC', 'page' => $_SESSION["pageKoordinator"]);
                $options = array(
                    'http' => array(
                        'method'  => 'GET',
                    )
                );
                $contentData=http_build_query($data);
                $context  = stream_context_create($options);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                if ($result === FALSE) {
                  echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
                }else{
                  $data = json_decode($result);
                  for($i = 0; $i < sizeof($data->data->rows); $i++){
                    echo '<option value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                  }
                }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" name="submitCetakLaporan">cetak</button>
          </div>
          </form>
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
            <input id="datetimepicker" type="text" class="form-control date" placeholder="Pilih Tanggal" aria-label="Pilih Tanggal" name="reportDate">
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
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/master.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
