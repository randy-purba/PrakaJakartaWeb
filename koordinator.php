<?php
  session_start();
  if(!isset($_SESSION["pageKoordinator"])){
    $_SESSION["pageKoordinator"]=1;
  }

  if(isset($_GET["wilayah"])){
    $_SESSION['wilayah']=$_GET["wilayah"];
    $_SESSION['kabupaten'] = null;
    $_SESSION['dapil'] = null;
    // $_SESSION['mapKoordinatorId'] = null;
  }

  if(isset($_GET["kabupaten"])){
    $_SESSION['kabupaten']=$_GET["kabupaten"];
    $_SESSION['dapil'] = null;
    // $_SESSION['mapKoordinatorId'] = null;
  }

  if(isset($_GET["dapil"])){
    $_SESSION['dapil']=$_GET["dapil"];
    // $_SESSION['mapKoordinatorId'] = null;
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
    <title>Koordinator | Praka-Jakarta</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>
    <div class="sidebar">
      <div class="header"><h4>Praka Jakarta</h4></div>
      <div class="menu">
        <a class="" href="dashboard.php"><i class="icons icon-home"></i>dashboard</a>
        <a class="" href="map.php"><i class="icons icon-dashboard"></i>map</a>
        <a class="" href="report.php"><i class="icons icon-invoices"></i>rekap laporan</a>
        <a class="active" href="koordinator.php"><i class="icons icon-coordinator"></i>koordinator</a>
        <a class="" href="surveyor.php"><i class="icons icon-customers"></i>surveyor</a>
        <!-- <a class="" href="mapnew.php"><i class="icons icon-dashboard"></i>map baru</a>
        <a class="" href="reportnew.php"><i class="icons icon-invoices"></i>rekap laporan baru</a>
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
          <h4>koordinator</h4>
          <div class="btn-group">
            <?php
              if($_SESSION["roleId"]=="jmkt41ot"){
                echo '<button type="button" data-toggle="modal" data-target="#addKoordinator"><i class="icons icon-add-white"></i>tambah koordinator</button>';
              }
            ?>
            <!-- <button type="button" data-toggle="modal" data-target="#addKoordinator"><i class="icons icon-add-white"></i>tambah koordinator</button> -->
            <!-- <form action="export.php" method="post">
          <div class="modal-body">
            <input id="datetimepicker" type="text" class="form-control date" placeholder="Pilih Tanggal" aria-label="Pilih Tanggal" name="reportDateNew">
          </div>
          <div class="modal-footer">
            <button type="submit" name="submitCetakLaporanFull">cetak</button>
          </div>
          </form> -->
            <form action="export.php" method="post">
              <button type="submit" name="cetakKoordinator"><i class="icons icon-invoices-white"></i>cetak data</button>
            </form>
          </div>
          <table id="tblData">
            <thead>
              <td>No</td>
              <td>nama</td>
              <td>tanggal lahir</td>
              <td>wilayah</td>
              <td>kabupaten</td>
              <td>dapil</td>
              <td>username</td>
              <td>password</td>
              <?php
                if($_SESSION["roleId"]=="jmkt41ot"){
                  echo '<td>action</td>';
                }
              ?>
            </thead>
            <tbody>
              <?php
                $url = 'https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/';
                $data = array('limit' => '25', 'sortby' => 'id', 'order' => 'DESC', 'page' => $_SESSION["pageKoordinator"]);
                $options = array(
                    'http' => array(
                        'method'  => 'GET',
                    )
                );
                $contentData=http_build_query($data);
                $context  = stream_context_create($options);

                // $result = @file_get_contents($url.'?'.$contentData, false, $context);
                $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/?'.$contentData, false, $context);

                // error_log('$contentData : ' + $contentData);
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
                    echo '<td>'.$data->data->rows[$i]->WilayahName.'</td>';
                    echo '<td>'.$data->data->rows[$i]->KabupatenName.'</td>';
                    echo '<td>'.$data->data->rows[$i]->DapilName.'</td>';
                    echo '<td class="confidential">'.$data->data->rows[$i]->username.'</td>';
                    echo '<td class="confidential">'.$data->data->rows[$i]->password.'</td>';
                    if($_SESSION["roleId"]=="jmkt41ot"){
                      echo '<td class="action"><button onclick="koordinator.php?
                      id='.$data->data->rows[$i]->id.'&
                      name='.$data->data->rows[$i]->name.'&
                      dateOfBirth='.$data->data->rows[$i]->dateOfBirth.'&
                      wilayah='.$data->data->rows[$i]->wilayah.'&
                      kabupaten='.$data->data->rows[$i]->kabupaten.'&
                      dapil='.$data->data->rows[$i]->dapil.'" data-toggle="modal" data-target="#editKoordinator" class="edit" data-id="'.$data->data->rows[$i]->id.'"
                      data-name="'.$data->data->rows[$i]->name.'"
                      data-birth="'.$data->data->rows[$i]->dateOfBirth.'"
                      data-wilayah="'.$data->data->rows[$i]->WilayahName.'"
                      data-kabupaten="'.$data->data->rows[$i]->KabupatenName.'"
                      data-dapil="'.$data->data->rows[$i]->DapilName.'"
                      ><i class="material-icons">edit</i></button>
                      <input hidden type="text" class="form-control" placeholder="Nama" value="'. $data->data->rows[$i]->id .'" aria-label="Nama" name="id" id="id">
                      <button type="button" onClick="myFunctionDeleteKoor()"><i class="material-icons">delete_outline</i></button>
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
                echo '<a class="page-link" href="action.php?pageKoordinator=1" aria-label="Previous">'
              ?>
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php
              for($i = 1; $i <= $data->data->page; $i++){
                $status =  $i==$_SESSION["pageKoordinator"] ? 'active' : '';
                echo '<li class="page-item '. $status .'"><a class="page-link" href="action.php?pageKoordinator='.$i.'">'. $i .'</a></li>';
              }
            ?>
            <li class="page-item">
            <?php
                echo '<a class="page-link" href="action.php?pageKoordinator='.$data->data->page.'" aria-label="Next">'
              ?>
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addKoordinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">daftarkan koordinator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" method="post">
            <div class="modal-body">
              <input id="name" type="text" class="form-control" placeholder="Nama" aria-label="Nama" name="name">
              <input id="dob" type="text" class="form-control date" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" name="dob">
              <select name="filterWilayah" id="filterWilayah" onChange="myFunction1()">
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
              <select name="filterKabupaten" id="filterKabupaten" onChange="myFunction2()">
              </select>
              <select name="filterDapil" id="filterDapil">
              </select>
            </div>
            <div class="modal-footer">
              <!-- <button type="submit" name="submitKoor">simpan</button> -->
              <button type="button" onClick="myFunctionAddKoor()">simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="editKoordinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ubah koordinator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" method="post">
            <div class="modal-body">
              <input hidden type="text" class="form-control" placeholder="Nama" aria-label="Nama" name="koordId" id="koordId">
              <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" name="name" id="bookId">
              <input type="text" class="form-control date" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" name="dob" id="bookDob">
              <select name="editFilterWilayah" id="editFilterWilayah" onChange="editMyFunction1()">
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
              <select name="editFilterKabupaten" id="editFilterKabupaten" onChange="editMyFunction2()">
              </select>
              <select name="editFilterDapil" id="editFilterDapil">
              </select>
            </div>
            <div class="modal-footer">
              <!-- <button type="submit" name="submitEditKoor">simpan</button> -->
              <button type="button" onClick="myFunctionEditKoor()">simpan</button>
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
