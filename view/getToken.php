<?php
    session_start();
    $api_url = 'https://evaluation-technique.lundimatin.biz/api/auth';

    $data = array(
        'username' => 'test_api',
        'password' => 'api123456',
        'password_type' => 0,
        'code_application' => 'webservice_externe',
        'code_version' => '1'
    );

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => json_encode($data),
        ),
    );

    $context = stream_context_create($options);

    $response = @file_get_contents($api_url, false, $context);

    if ($response) {
        $response_data = json_decode($response, true);
        $_SESSION['token'] = $response_data['datas']['token'];
        
    } else {
        echo 'Có lỗi khi thực hiện request.' .  error_get_last()['message'];
    }
?>