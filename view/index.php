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
        include 'getToken.php';
        if (isset($_SESSION['token'])) {
            $token = $_SESSION['token'];
            echo $token;
            $data = [];

            $api_url = 'https://evaluation-technique.lundimatin.biz/api/clients';


            $options = array(
                'http' => array(
                    'method'  => 'GET',
                    'header'  => 'Content-type: application/json' . '\r\n' . 'Authorization: Bearer ' . $token,
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
            <div>Research member</div>
        </div>
        <div id="container">
            <div id="inside">
                <section>
                    <div class="info">Enter the name to search</div>
                </section>

                <section id="search">
                    <div class="control">

                        <form method="post" action="search.php" style="display: flex; flex-direction: column; gap: 10px;">
                            <div>Enter the name to search:</div>

                            <input class="input" name="search" type="text" placeholder="Enter Name Search">

                            <div class="buttons">
                                <button type="submit" name="submit" class="button is-warning">Search</button>
                            </div>
                        </form>

                    </div>
                </section>

                <section>

                    <table>

                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($data as $value) { ?>
                                <tr>
                                    <td class="img">
                                        <figure class="image is-48x48">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
                                        </figure>
                                    </td>
    
                                    <td>
                                        <?php echo $value['nom'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['adresse'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['code_postal'] . "-" . $value['ville'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['tel'] ?>
                                    </td>
                                    <td>
                                        <a href="detail.php?id=<?php echo $value['id'] ?>" class="icons button is-link">
                                            <span class="material-icons material-icons-outlined">
                                            search
                                            </span>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>

                </section>
            </div>
        </div>
    </div>
</body>
</html>