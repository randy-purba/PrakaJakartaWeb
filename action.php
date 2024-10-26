<?php
  session_start();

  function logout(){
    session_destroy();
    header('Location: login.php');
  }

  if(isset($_GET["logout"])){
    logout();
  }

  function paginationMap(){
    $_SESSION["page"]=$_GET["page"];
    header('Location: map.php');
  }

  if(isset($_GET["page"])){
    paginationMap();
  }

  function paginationMapNew(){
    $_SESSION["pagemapnew"]=$_GET["pagemapnew"];
    header('Location: mapnew.php');
  }

  if(isset($_GET["pagemapnew"])){
    paginationMapNew();
  }

  function paginationReport(){
    $_SESSION["pageReport"]=$_GET["pageReport"];
    header('Location: report.php');
  }

  if(isset($_GET["pageReport"])){
    paginationReport();
  }

  function paginationNewReport(){
    $_SESSION["pageNewReport"]=$_GET["pageNewReport"];
    header('Location: reportnew.php');
  }

  if(isset($_GET["pageNewReport"])){
    paginationNewReport();
  }

  function paginationKoordinator(){
    $_SESSION["pageKoordinator"]=$_GET["pageKoordinator"];
    header('Location: koordinator.php');
  }

  if(isset($_GET["pageKoordinator"])){
    paginationKoordinator();
  }

  function paginationSurveyor(){
    $_SESSION["pageSurveyor"]=$_GET["pageSurveyor"];
    header('Location: surveyor.php');
  }

  if(isset($_GET["pageSurveyor"])){
    paginationSurveyor();
  }

  function paginationNewSurveyor(){
    $_SESSION["pageNewSurveyor"]=$_GET["pageNewSurveyor"];
    header('Location: surveyornew.php');
  }

  if(isset($_GET["pageNewSurveyor"])){
    paginationNewSurveyor();
  }



  function onLoad(){
    $post_data = $_POST;
    if($post_data['mapData'] != ''){
      $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC');
      $options = array(
        'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
          'method'  => 'GET',
        )
      );
      $contentData=http_build_query($data);
      $context  = stream_context_create($options);

      $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/reports/dashboard?'.$contentData, false, $context);
      if ($result === FALSE) {
        return '';
      }else{
        return $result;
      }
    }else{
      return '';
    }
  }

  if(function_exists($_GET['f'])) {
    $_GET['f']();
  }

  function getSession(){
    return $_SESSION;
  }
  

?>