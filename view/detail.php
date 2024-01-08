<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['token'])) {
            $token = $_SESSION['token'];
            $id_member = $_GET['id'];
            $data = [];

            $api_url = 'https://evaluation-technique.lundimatin.biz/api/clients/{$id_member}';


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
                $response_data = json_decode($response, true);
                $data = $response_data['datas'];
            } else {
                echo 'Có lỗi khi thực hiện request.' .  error_get_last()['message'];
            }

            
        }

    ?>
    <div id="main">
        <div id="head">
            <div>infomation member</div>
        </div>
        <div id="container">
            <div id="inside">
                <section>
                    <div class="info">
                        <div class="controls">
                            <div class="fullname">
                                <p><?php echo $data['firstname'] ?></p>
                                <p class="lastname"><?php echo $data['lastname'] ?></p>
                            </div>
                            <div class="buttons">
                                <a href="index.php" class="button is-links">Index Page</a>
                                <a href="edit.php?id=<?php echo $data['id'] ?>" class="icon-left button is-warning">
                                    <span class="material-icons material-icons-outlined">
                                    edit
                                    </span>
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="show">
                    <h1>INFOMATIONS</h1>
                    <hr>
                    <div class="show-info">
                        <div class="title">
                            <p>Name</p>
                            <p>Phone</p>
                            <p>Email</p>
                            <p>Address</p>
                        </div>

                        <div class="vertical-hr"></div>

                        <div class="detail">
                            <p><?php echo $data['nom'] ?></p>
                            <p><?php echo $data['tel'] ?></p>
                            <p><?php echo $data['email'] ?></p>
                            <p><?php echo $data['adresse'] ?></p>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>