
<?php

    session_start();

    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];

        // Kiểm tra xem có dữ liệu tìm kiếm được gửi từ biểu mẫu hay không
        if (isset($_GET['search'])) {
            $keyword = urlencode($_GET['search']);
            $api_url = "https://evaluation-technique.lundimatin.biz/api/clients?search={$keyword}";

            $options = array(
                'http' => array(
                    'method'  => 'GET',
                    'header'  => 'Content-type: application/json' . "\r\n" .
                                'Authorization: Bearer ' . $token,
                ),
            );

            $context = stream_context_create($options);
            $response = @file_get_contents($api_url, false, $context);

            if ($response) {
                $data = json_decode($response, true);
                header("Location: index.php");
            } else {
                echo 'Có lỗi khi thực hiện request.' . error_get_last()['message'];
            }
        }
    }
?>
