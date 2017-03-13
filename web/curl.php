<?php

$result = array();
if (isset($_POST['number']) && !empty($_POST['number'])) {
    /*$serverUrl = 'http://uplblibcuts.dev/api/students/' . $_POST['number'];
    $ch = curl_init($serverUrl);

    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERNAME, 'RQggDSufGE7KmFiqJnhxCSLMjQ_C59Rz');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    var_dump($result);*/
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://uplblibcuts.dev/api/students/2011-97549",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_USERNAME => 'RQggDSufGE7KmFiqJnhxCSLMjQ_C59Rz',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    var_dump($response);
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <form action="" method="post" style="margin-top: 50%;">
                    <div class="form-group">
                        <label for="number">Student Number</label>
                        <input type="text" name="number" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>