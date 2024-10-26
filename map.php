<?php
  session_start();
  // echo 'kun '.$_GET;
  if(!isset($_GET["wilayah"]) && !isset($_GET["kabupaten"]) && !isset($_GET["dapil"]) && !isset($_POST["mapKoordinatorId"]) && !isset($_GET["surveyorId"])){
    $_SESSION['wilayah']=null;
    $_SESSION['kabupaten'] = null;
    $_SESSION['dapil'] = null;
    $_SESSION['mapKoordinatorId'] = null;
    $_SESSION['SurveyorId']=null;
  }
  
  if(!isset($_SESSION["page"])){
    $_SESSION["page"]=1;
  }

  if(isset($_GET["surveyorId"])){
    $_SESSION['SurveyorId']=$_GET["surveyorId"];
  }

  if(isset($_GET["wilayah"])){
    $_SESSION['wilayah']=$_GET["wilayah"];
    $_SESSION['kabupaten'] = null;
    $_SESSION['dapil'] = null;
    $_SESSION['mapKoordinatorId'] = null;
  }

  if(isset($_GET["kabupaten"])){
    $_SESSION['kabupaten']=$_GET["kabupaten"];
    $_SESSION['dapil'] = null;
    $_SESSION['mapKoordinatorId'] = null;
  }

  if(isset($_GET["dapil"])){
    $_SESSION['dapil']=$_GET["dapil"];
    $_SESSION['mapKoordinatorId'] = null;
  }

  if(isset($_POST["filterKoordinator"])){
    $_SESSION['mapKoordinatorId']=$_POST["filterKoordinator"];
  }


  // $options = array(
  //   'http' => array(
  //       'method'  => 'GET',
  //   )
  // );
  // $context  = stream_context_create($options);
  // $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/kabupaten?filterbywilayah='.$_GET["wilayah"], false, $context);
  // // var_dump($result);
  // if ($result === FALSE) {
  //   echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
  // }else{
  //   $data = json_decode($result);
  //   // echo $data->data->rows;
  //   for($i = 0; $i < sizeof($data->data); $i++){
  //     echo $data->data[$i]->id.'">'.$data->data[$i]->name;
  //   }
  // }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <title>Map | Ayo-Jo</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <div class="sidebar">
      <div class="header"><h4>Praka Jakarta</h4></div>
      <div class="menu">
        <a class="" href="index.php"><i class="icons icon-home"></i>dashboard</a>
        <a class="active" href="map.php"><i class="icons icon-dashboard"></i>map</a>
        <a class="" href="report.php"><i class="icons icon-invoices"></i>rekap laporan</a>
        <a class="" href="koordinator.php"><i class="icons icon-coordinator"></i>koordinator</a>
        <a class="" href="surveyor.php"><i class="icons icon-customers"></i>surveyor</a>
        <a class="" href="mapnew.php"><i class="icons icon-dashboard"></i>map baru</a>
        <a class="" href="reportnew.php"><i class="icons icon-invoices"></i>rekap laporan baru</a>
        <a class="" href="surveyornew.php"><i class="icons icon-customers"></i>surveyor baru</a>
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
              <select name="filterWilayah" id="filterWilayah" onChange="myFunction1();">
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
                  echo '<option value=""></option>';
                  $selected = "";
                  for($i = 0; $i < sizeof($data->data); $i++){
                      echo '<option value="'.$data->data[$i]->id.'">'.$data->data[$i]->name.'</option>';
                  }
                }
              ?>
              </select>
              <select name="filterKabupaten" id="filterKabupaten" onChange="myFunction2()"></select>
              <select name="filterDapil" id="filterDapil" onChange="myFunction3()"></select>
              <select name="filterKoordinator" id="filterKoordinator">
                <!-- <option value="1" selected>Koordinator</option>
                <option value="2">Week</option>
                <option value="3">Month</option> -->
              <?php
                // if(isset($_SESSION["dapil"]) || isset($_SESSION['kabupaten']) || isset($_SESSION['wilayah'])){
                //   $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC', 'filterbywilayah' => $_SESSION['wilayah'], 'filterbykabupaten' => $_SESSION['kabupaten'], 'filterbydapil' => $_SESSION["dapil"]);
                //   $options = array(
                //       'http' => array(
                //           'method'  => 'GET',
                //       )
                //   );
                //   $contentData=http_build_query($data);
                //   $context  = stream_context_create($options);

                //   // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                //   $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                //   // var_dump($result);
                //   if ($result === FALSE) {
                //     echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                //   }else{
                //     $data = json_decode($result);
                //     echo '<option value=""></option>';
                //     for($i = 0; $i < sizeof($data->data->rows); $i++){
                //       if(isset($_SESSION["mapKoordinatorId"])){
                //         if($_SESSION["mapKoordinatorId"]==$data->data->rows[$i]->name){
                //           echo '<option selected value="'.$data->data->rows[$i]->name.'">'.$data->data->rows[$i]->name.'</option>';
                //         }else{
                //           echo '<option value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                //         }
                //       }else{
                //         echo '<option value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                //       }
                //     }
                //   }
                // }
              ?>
              </select>
              <button type="submit" name="submitFilter">filter</button>
              </form>
            </div>
            <div class="filter-dismiss"></div>
          </div>
          <div class="list-head">
            <h5>surveyor</h5>
            <div class="action-button">
              <a id="minimize" href="#"><i class="material-icons">close</i></a>
              <a id="filterTab" href="#"><i class="material-icons">filter_list</i></a>
            </div>
          </div>
          <ul class="list-surveyor">
              <?php
                if(isset($_POST['submitFilter'])){
                  // echo 'kunam berapi '.$_POST['filterKoordinator'];
                  $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'searchbycoordinator' => $_SESSION["mapKoordinatorId"], 'page' => $_SESSION["page"]);
                  if(isset($_SESSION['wilayah']) || $_SESSION['wilayah']!=null){
                    $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'filterbywilayah' => $_SESSION['wilayah'], 'page' => $_SESSION["page"]);
                  }
                  if(isset($_SESSION['kabupaten']) || $_SESSION['kabupaten']!=null){
                    $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'filterbykabupaten' => $_SESSION['kabupaten'], 'page' => $_SESSION["page"]);
                  }
                  if(isset($_SESSION['dapil']) || $_SESSION['dapil']!=null){
                    $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'filterbydapil' => $_SESSION['dapil'], 'page' => $_SESSION["page"]);
                  }
                  if(isset($_SESSION['mapKoordinatorId']) || $_SESSION['mapKoordinatorId']!=null){
                    $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'filterbycoordinator' => $_SESSION['mapKoordinatorId'], 'page' => $_SESSION["page"]);
                  }
                  if(isset($_POST['filterKoordinator']) || $_POST['filterKoordinator']!=null){
                    $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'filterbycoordinator' => $_POST['filterKoordinator'], 'page' => $_SESSION["page"]);
                  }
                  // var_dump($data);
                  $options = array(
                      'http' => array(
                          'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
                          'method'  => 'GET',
                      )
                  );
                  $contentData=http_build_query($data);
                  $context  = stream_context_create($options);
                  $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/?'.$contentData, false, $context);
                  // var_dump($result);
                  if ($result === FALSE) {
                    echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                  }else{
                    $data = json_decode($result);
                    for($i = 0; $i < sizeof($data->data->rows); $i++){
                      echo '<a href="map.php?surveyorId='.$data->data->rows[$i]->id.'">';
                      echo '<h6>'.$data->data->rows[$i]->name.'</h6>';
                      echo '<h6>'.$data->data->rows[$i]->totalMarker.' Marker</h6>';
                      echo '</a>';
                    }
                  }
                }else{
                  $data = array('limit' => '5', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["page"]);
                  $options = array(
                      'http' => array(
                          'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
                          'method'  => 'GET',
                      )
                  );
                  $contentData=http_build_query($data);
                  $context  = stream_context_create($options);
                  $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/?'.$contentData, false, $context);
                  // var_dump($result);
                  if ($result === FALSE) {
                    echo "<script type='text/javascript'>alert('Session Anda Habis!'); window.location = 'login.php';</script>";
                  }else{
                    $data = json_decode($result);
                    for($i = 0; $i < sizeof($data->data->rows); $i++){
                      echo '<a href="map.php?surveyorId='.$data->data->rows[$i]->id.'">';
                      echo '<h6>'.$data->data->rows[$i]->name.'</h6>';
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
                echo '<a class="page-link" href="action.php?page=1" aria-label="Previous">'
              ?>
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php
              $pages=$_SESSION["page"];
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
                  $status =  $i==$_SESSION["page"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?page='.$i.'">'. $i .'</a></li>';
                }
              // }
            ?>
            <li class="page-item">
              <?php
                echo '<a class="page-link" href="action.php?page='.$data->data->page.'" aria-label="Next">'
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVEVkIpcTSn28KbiXazANnPR9unaCau0M"></script>
    <script src="js/custom.js"></script>
    <script>
      
    </script>
    <!-- <script src="js/Api.js"></script> -->
  </body>
</html>
