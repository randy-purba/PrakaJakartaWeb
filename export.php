<?php
    session_start();
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
            // var_dump($WorkingArray);
            if (empty($firstLineKeys)) {
              $firstLineKeys = array_keys($WorkingArray);
              fputcsv($f, $firstLineKeys);
              $firstLineKeys = array_flip($firstLineKeys);
            }
            
            // Using array_merge is important to maintain the order of keys acording to the first element
            fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
          }
          fseek($f, 0);
          // header("Location: ".$strTempFile);
          // echo $strTempFile;
          header("Content-type: application/csv");
          header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
          fpassthru($f);
          // readfile($strTempFile);
        }
    }
    
    if(isset($_POST['CoordinatorId'])){
        // echo 'EXPORT';
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
        $f = fopen('php://memory',"w+");
        $firstLineKeys = false;
        foreach ($data->data as $line) {
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
        fseek($f,0);
        // echo $strTempFile;
        header("Content-type: application/csv");
        header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
        fpassthru($f);
      }
    }

    if(isset($_POST['reportDateNew']) && !isset($_POST['CoordinatorId'])){

        $data = "";
        $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC');
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
        //   $data = json_decode($result);
          // var_dump($data);
          $boolEchoCsv = true;
          $strTempFile = "reportFullNew.csv";
          $f = fopen('php://memory',"w+");
          $firstLineKeys = false;

          $data = json_decode($result);
          for($i = 0; $i < sizeof($data->data->rows); $i++){
            $create = explode("T", $data->data->rows[$i]->createdAt);
            $WorkingArray = json_decode(json_encode($data->data->rows[$i]),true);
            // var_dump($WorkingArray);
            if (empty($firstLineKeys)) {
              $firstLineKeys = array_keys($WorkingArray);
              fputcsv($f, $firstLineKeys);
              $firstLineKeys = array_flip($firstLineKeys);
            }
            
            // Using array_merge is important to maintain the order of keys acording to the first element
            fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
          }
          fseek($f, 0);
          // header("Location: ".$strTempFile);
          // echo $strTempFile;
          header("Content-type: application/csv");
          header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
          fpassthru($f);
          // readfile($strTempFile);
        }
    }

    if(isset($_POST['submitCetakNewSurveyor'])){

        $data = "";
        $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC');
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
        //   $data = json_decode($result);
          // var_dump($data);
          $boolEchoCsv = true;
          $strTempFile = "reportNewSurveyor.csv";
          $f = fopen('php://memory',"w+");
          $firstLineKeys = false;

          $data = json_decode($result);
          for($i = 0; $i < sizeof($data->data->rows); $i++){
            $create = explode("T", $data->data->rows[$i]->createdAt);
            $WorkingArray = json_decode(json_encode($data->data->rows[$i]),true);
            // var_dump($WorkingArray);
            if (empty($firstLineKeys)) {
              $firstLineKeys = array_keys($WorkingArray);
              fputcsv($f, $firstLineKeys);
              $firstLineKeys = array_flip($firstLineKeys);
            }
            
            // Using array_merge is important to maintain the order of keys acording to the first element
            fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
          }
          fseek($f, 0);
          // header("Location: ".$strTempFile);
          // echo $strTempFile;
          header("Content-type: application/csv");
          header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
          fpassthru($f);
          // readfile($strTempFile);
        }
    }
    if(isset($_POST['cetakKoordinator'])){

      $data = "";
      $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC');
      $options = array(
          'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
                      'method'  => 'GET',
          )
      );
      $contentData=http_build_query($data);
      $context  = stream_context_create($options);
      $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/dashboardUsers/downloadKoordinator', false, $context);

      // var_dump($result);
      if ($result === FALSE) {
        echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
      }else{
      //   $data = json_decode($result);
        // var_dump($data);
        $boolEchoCsv = true;
        $strTempFile = "cetakKoordinator.csv";
        $f = fopen('php://memory',"w+");
        $firstLineKeys = false;

        $data = json_decode($result);
        // var_dump($data->data[0]);
        // var_dump($data);
        for($i = 0; $i < sizeof($data->data); $i++){
          // $create = explode("T", $data->data[$i]->createdAt);
          $WorkingArray = json_decode(json_encode($data->data[$i]),true);
          // var_dump($WorkingArray);
          if (empty($firstLineKeys)) {
            $firstLineKeys = array_keys($WorkingArray);
            fputcsv($f, $firstLineKeys);
            $firstLineKeys = array_flip($firstLineKeys);
          }
          
          // Using array_merge is important to maintain the order of keys acording to the first element
          fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
        }
        fseek($f, 0);
        // header("Location: ".$strTempFile);
        // echo $strTempFile;
        header("Content-type: application/csv");
        header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
        fpassthru($f);
        readfile($strTempFile);
      }
    }
    if(isset($_POST['cetakSurveyor'])){

      $data = "";
      $data = array('limit' => 'all', 'sortby' => 'id', 'order' => 'DESC');
      $options = array(
          'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".$_SESSION["Authorization"],
                      'method'  => 'GET',
          )
      );
      $contentData=http_build_query($data);
      $context  = stream_context_create($options);
      $result = file_get_contents('https://praka-jakarta-2024-229415464489.asia-southeast2.run.app/api/appUsers/downloadSurveyor/'.$_POST['koordinatorId'], false, $context);

      // var_dump($result);
      if ($result === FALSE) {
        echo "<script type='text/javascript'>alert('Session Anda Habis!'); </script>";
      }else{
      //   $data = json_decode($result);
        // var_dump($data);
        $boolEchoCsv = true;
        $strTempFile = "cetakSurveyor.csv";
        $f = fopen('php://memory',"w");
        $firstLineKeys = false;

        $data = json_decode($result);
        // var_dump($data->data[0]);
        // var_dump($data);
        for($i = 0; $i < sizeof($data->data); $i++){
          // $create = explode("T", $data->data[$i]->createdAt);
          $WorkingArray = json_decode(json_encode($data->data[$i]),true);
          // var_dump($WorkingArray);
          if (empty($firstLineKeys)) {
            $firstLineKeys = array_keys($WorkingArray);
            fputcsv($f, $firstLineKeys);
            $firstLineKeys = array_flip($firstLineKeys);
          }
          
          // Using array_merge is important to maintain the order of keys acording to the first element
          fputcsv($f, array_merge($firstLineKeys, $WorkingArray));
        }
        fseek($f, 0);
        // header("Location: ".$strTempFile);
        // echo $strTempFile;
        header("Content-type: application/csv");
        header('Content-disposition: attachment; filename = "'.$strTempFile.'";');
        fpassthru($f);
        // readfile($strTempFile);
      }
    }
?>