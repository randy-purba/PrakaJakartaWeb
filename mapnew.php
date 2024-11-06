<?php
  session_start();
  // echo 'kun '.$_GET;
  if(!isset($_GET["SurveyorNewId"])){
    $_SESSION['SurveyorId']=null;
  }

  if(!isset($_SESSION["pagemapnew"])){
    $_SESSION["pagemapnew"]=1;
  }

  if(isset($_GET["surveyorNewId"])){
    $_SESSION['SurveyorNewId']=$_GET["surveyorNewId"];
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
    <title>Map | Praka-Jakarta</title>
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
        <!-- <a class="active" href="mapnew.php"><i class="icons icon-dashboard"></i>map baru</a>
        <a class="" href="reportnew.php"><i class="icons icon-invoices"></i>rekap laporan baru</a>
        <a class="" href="surveyornew.php"><i class="icons icon-customers"></i>surveyor baru</a> -->
      </div>
    </div>
    <div class="right-content maps">
      <div class="header">
        <div class="header-link">
          <h6><?php echo $_SESSION["name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;</h6>
          <h6><a href="action.php?logout=true" style="color: #43425D; text-decoration: none;">Logout</a></h6>
        </div>
      </div>
      <div class="content maps">
        <div id="minimizeButton">
          <i class="material-icons">layers</i>
        </div>
        <div class="floating-surveyor">
          <div class="filter">
            <div class="filter-content">
              <a id="closeTab" href="#"><i class="material-icons">close</i></a>
              <form action="#" method="post">
              <select name="filterWilayah" id="filterText" onChange="window.location='<? print 'map'; ?>.php?wilayah='+this.value">
                <!-- <option value="1" selected>Wilayah</option>
                <option value="2">Week</option>
                <option value="3">Month</option> -->
              <?php
                $options = array(
                    'http' => array(
                        'method'  => 'GET',
                    )
                );
                $context  = stream_context_create($options);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/wilayah', false, $context);
                // var_dump($result);
                if ($result === FALSE) {
                  echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
                }else{
                  $data = json_decode($result);
                  echo '<option value=""></option>';
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
              <select name="filterKabupaten" id="filterText" onChange="window.location='<? print 'map'; ?>.php?kabupaten='+this.value">
                <!-- <option value="1" selected>Kabupaten</option>
                <option value="2">Week</option>
                <option value="3">Month</option> -->
                <?php
                  if(isset($_SESSION['wilayah'])){
                    $options = array(
                      'http' => array(
                          'method'  => 'GET',
                      )
                    );
                    $context  = stream_context_create($options);
                    $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/kabupaten?filterbywilayah='.$_SESSION['wilayah'], false, $context);
                    // var_dump($result);
                    if ($result === FALSE) {
                      echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
                    }else{
                      $data = json_decode($result);
                      echo '<option value=""></option>';
                      $selected = "";
                      for($i = 0; $i < sizeof($data->data); $i++){
                        if(isset($_SESSION["kabupaten"])){
                          if($_SESSION["kabupaten"]==$data->data[$i]->id){
                            echo '<option selected value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                          }else{
                            echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                          }
                        }else{
                          echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                        }
                      }
                    }
                  }
                ?>
              </select>
              <select name="filterDapil" id="filterText" onChange="window.location='<? print 'map'; ?>.php?dapil='+this.value">
                <!-- <option value="1" selected>Dapil</option>
                <option value="2">Week</option>
                <option value="3">Month</option> -->
                <?php
                  if(isset($_SESSION['kabupaten'])){
                    $options = array(
                      'http' => array(
                          'method'  => 'GET',
                      )
                    );
                    $context  = stream_context_create($options);
                    $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/dapil?filterbykabupaten='.$_SESSION['kabupaten'], false, $context);
                    // var_dump($result);
                    if ($result === FALSE) {
                      echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
                    }else{
                      $data = json_decode($result);
                      echo '<option value=""></option>';
                      $selected = "";
                      for($i = 0; $i < sizeof($data->data); $i++){
                        if(isset($_SESSION["dapil"])){
                          if($_SESSION["dapil"]==$data->data[$i]->id){
                            echo '<option selected value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                          }else{
                            echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                          }
                        }else{
                          echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                        }
                      }
                    }
                  }
                ?>
              </select>
              <select name="filterKoordinator" id="filterText">
                <!-- <option value="1" selected>Koordinator</option>
                <option value="2">Week</option>
                <option value="3">Month</option> -->
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

                  // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                  $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                  // var_dump($result);
                  if ($result === FALSE) {
                    echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                  }else{
                    $data = json_decode($result);
                    echo '<option value=""></option>';
                    for($i = 0; $i < sizeof($data->data->rows); $i++){
                      if(isset($_SESSION["mapKoordinatorId"])){
                        if($_SESSION["mapKoordinatorId"]==$data->data->rows[$i]->name){
                          echo '<option selected value="'.$data->data->rows[$i]->name.'">'.$data->data->rows[$i]->name.'</option>';
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
              <?php
              ?>
              <!-- </select> -->
              <button type="submit" name="submitFilter">filter</button>
              </form>
            </div>
            <div class="filter-dismiss"></div>
          </div>
          <div class="list-head">
            <h5>surveyor</h5>
            <div class="action-button">
              <a id="minimize" href="#"><i class="material-icons">close</i></a>
              <!-- <a id="filterTab" href="#"><i class="material-icons">filter_list</i></a> -->
            </div>
          </div>
          <ul class="list-surveyor">
              <?php
                if(isset($_POST['submitFilter'])){
                }else{
                  $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pagemapnew"]);
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
                      echo '<a href="mapnew.php?surveyorNewId='.$data->data->rows[$i]->id.'">';
                      echo '<h6>'.$data->data->rows[$i]->username.'</h6>';
                      echo '<h6>'.$data->data->rows[$i]->totalMarker.' Marker</h6>';
                      echo '</a>';
                    }
                  }
                }
              ?>
          </ul>
          <ul class="pagination">
            <li class="page-item">
              <?php
                echo '<a class="page-link" href="action.php?pagemapnew=1" aria-label="Previous">'
              ?>
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php
              $pages=$_SESSION["pagemapnew"];
              if($pages+5 > $data->data->page){
                $pages=$data->data->page - 4;
              }
              // if($pages < 1){
              //   $pages = 1;
              // }
              // if($data->data->page < 5){
              //   for($i = $pages; $i <= $data->data->page; $i++){
              //     $status =  $i==$_SESSION["page"] ? 'active' : '';
              //     echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?page='.$i.'">'. $i .'</a></li>';
              //   }
              // }else{
                for($i = $pages; $i <= $pages+4; $i++){
                  $status =  $i==$_SESSION["pagemapnew"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pagemapnew='.$i.'">'. $i .'</a></li>';
                }
              // }
            ?>
            <li class="page-item">
              <?php
                echo '<a class="page-link" href="action.php?pagemapnew='.$data->data->page.'" aria-label="Next">'
              ?>
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="map-frame">
          <div id="map"></div>
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
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5nZKbeK-WHQ70oqOWo-_4VmwOwKP9YQ"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDb7pxkEbMAiy2RhF4iH98WJ4Zxqs-qWwM"></script>
    <script src="js/customnew.js"></script>
    <!-- <script src="js/Api.js"></script> -->
  </body>
</html>
