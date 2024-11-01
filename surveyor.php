<?php
  session_start();
  if(!isset($_SESSION["pageSurveyor"])){
    $_SESSION["pageSurveyor"]=1;
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
    <title>Surveyor | Praka-Jakarta</title>
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
        <a class="active" href="surveyor.php"><i class="icons icon-customers"></i>surveyor</a>
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
            <select id="filterText" onChange="window.location='<? print 'surveyor'; ?>.php?coordinatorId='+this.value">
            <option value="" selected></option>
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

                // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                // var_dump($result);
                if ($result === FALSE) {
                  echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
                }else{
                  $data = json_decode($result);
                  for($i = 0; $i < sizeof($data->data->rows); $i++){
                    echo '<option value="'.$data->data->rows[$i]->id.'">'.$data->data->rows[$i]->name.'</option>';
                  }
                }
              ?>
              <!-- <option value="1" selected>Koordinator 1</option>
              <option value="2">Koordinator 2</option>
              <option value="3">Koordinator 3</option> -->
            </select>
            <?php 
              if($_SESSION["roleId"]=="jmkt41ot"){
                echo '<button type="button" data-toggle="modal" data-target="#addSurveyor"><i class="icons icon-add-white"></i>tambah surveyor</button>';
              }
            ?>
            <!-- <button type="button" onclick="exportTableToExcel('tblData', 'surveyor-data')"><i class="icons icon-invoices-white"></i>cetak data</button> -->
            <button type="button" data-toggle="modal" data-target="#cetakLaporan"><i class="icons icon-invoices-white"></i>cetak data</button>
          </div>
          <table id="tblData">
            <thead>
              <td>No</td>
              <td>nama</td>
              <td>NIK</td>
              <td>koordinator</td>
              <td>username</td>
              <td>password</td>
              <?php
                if($_SESSION["roleId"]=="jmkt41ot"){
                  echo '<td>action</td>';
                }
              ?>
              <!-- <td>action</td> -->
            </thead>
            <tbody id="myTable">
              <?php
                $data = null;
                if(isset($_GET["coordinatorId"])){
                  $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageSurveyor"], 'filterbycoordinator' => $_GET["coordinatorId"]);
                }else{
                  $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageSurveyor"]);
                }
                // echo 'kunam'.$_SESSION["Authorization"];
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
                    echo '<tr>';
                    // echo '<td>'.$data->data->rows[$i]->id.'</td>';
                    echo '<td>'.($i+1).'</td>';
                    echo '<td>'.$data->data->rows[$i]->name.'</td>';
                    echo '<td>'.$data->data->rows[$i]->dateOfBirth.'</td>';
                    echo '<td class="coordinator-name">'.$data->data->rows[$i]->coordinatorName.'</td>';
                    echo '<td class="confidential">'.$data->data->rows[$i]->username.'</td>';
                    echo '<td class="confidential">'.$data->data->rows[$i]->password.'</td>';
                    if($_SESSION["roleId"]=="jmkt41ot"){
                      echo '<td class="action"><button onclick="surveyor.php?
                      id='.$data->data->rows[$i]->id.'&
                      name='.$data->data->rows[$i]->name.'&
                      dateOfBirth='.$data->data->rows[$i]->dateOfBirth.'&
                      wilayah='.$data->data->rows[$i]->wilayah.'&
                      kabupaten='.$data->data->rows[$i]->kabupaten.'&
                      dapil='.$data->data->rows[$i]->dapil.'" data-toggle="modal" data-target="#editSurveyor" class="edit" data-id="'.$data->data->rows[$i]->id.'"
                      data-name="'.$data->data->rows[$i]->name.'"
                      data-birth="'.$data->data->rows[$i]->dateOfBirth.'"
                      data-wilayah="'.$data->data->rows[$i]->coordinatorId.'"
                      ><i class="material-icons">edit</i></button>
                      <input hidden type="text" class="form-control" placeholder="Nama" value="'. $data->data->rows[$i]->id .'" aria-label="Nama" name="id" id="id">
                      <button type="button" onClick="myFunctionDeleteSurveyor()"><i class="material-icons">delete_outline</i></button>
                      </td>';
                    }
                    echo '</tr>';
                  }
                }
              ?>
            </tbody>
          </table>
          <ul class="pagination">
            <li class="page-item">
              <?php
                echo '<a class="page-link" href="action.php?pageSurveyor=1" aria-label="Previous">'
              ?>
              <!-- <a class="page-link" href="#" aria-label="Previous"> -->
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php
              $pages=$_SESSION["pageSurveyor"];
              if($pages+9 > $data->data->page){
                // $pages=$data->data->page - 9;
                for($i = 1; $i <= $data->data->page; $i++){
                  $status =  $i==$_SESSION["pageSurveyor"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageSurveyor='.$i.'">'. $i .'</a></li>';
                }
              }else{
                for($i = $pages; $i <= $pages+9; $i++){
                  $status =  $i==$_SESSION["pageSurveyor"] ? 'active' : '';
                  echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageSurveyor='.$i.'">'. $i .'</a></li>';
                }
              }

              // for($i = 1; $i <= $data->data->page; $i++){
              //   $status =  $i==$_SESSION["pageSurveyor"] ? 'active' : '';
              //   echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageSurveyor='.$i.'">'. $i .'</a></li>';
              // }
            ?>
            <li class="page-item">
            <?php
                echo '<a class="page-link" href="action.php?pageSurveyor='.$data->data->page.'" aria-label="Next">'
              ?>
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addSurveyor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">daftarkan surveyor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" method="post">
          <div class="modal-body">
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

                // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                // var_dump($result);
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
            <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" name="name" id="name">
            <input type="number" class="form-control" placeholder="NIK" aria-label="NIK" name="dob" id="dob">
          </div>
          <div class="modal-footer">
            <!-- <button type="submit" name="submitSurveyor">simpan</button> -->
            <button type="button" onClick="myFunctionAddSurveyor()">simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="editSurveyor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ubah surveyor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" method="post">
          <div class="modal-body">
            <select id="filterEditByKoordinator" name="CoordinatorId">
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

                // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                // var_dump($result);
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
            <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" name="surveyorId" id="surveyorId" hidden>
            <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" name="name" id="nameEdit">
            <input type="number" class="form-control" placeholder="NIK" aria-label="NIK" name="dob" id="dobEdit">
          </div>
          <div class="modal-footer">
            <!-- <button type="submit" name="submitEditSurveyor">simpan</button> -->
            <button type="button" onClick="myFunctionEditSurveyor()">simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="cetakLaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">cetak data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="export.php" method="post">
          <div class="modal-body">
            <select id="filterByKoordinator" name="koordinatorId">
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

                // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);
                // var_dump($result);
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
            <button type="submit" name="cetakSurveyor">cetak</button>
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
    <!-- <script>
    function filterText()
    {
      var rex = $('#filterText').val();
      var a = rex.replace("/");
      var input, filter, table, tr, td, i, txtValue;
      // input = document.getElementById("myInput");
      filter = a.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }

    $(document).ready(function(){
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableSurveyor tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script> -->
  </body>
</html>
