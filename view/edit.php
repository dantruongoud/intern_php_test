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
            
            
            $submit = $_POST['submit'];
            if (isset($submit)) {

                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $zipcode = $_POST['zipcode'];
                $city = $_POST['city'];
                $msg = "";

                if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($zipcode) || empty($city)) {
                    $msg = "Please enter all fill";
                } else {
                    $new_data = array(
                        'nom' => $name,
                        'tel' => $phone,
                        'email' => $email,
                        'adresse' => $address,
                        'code_postal' => $zipcode,
                        'ville' => $city
                    );
    
                    $options = array(
                        'http' => array(
                            'method'  => 'PUT',
                            'header'  => 'Content-type: application/json' . "\r\n" .
                                        'Authorization: Bearer ' . $token,
                            'content' => json_encode($new_data)
                        ),
                    );
    
                    $context = stream_context_create($options);
                    $response = @file_get_contents($api_url, false, $context);
                    
                    if ($response) {
                        $msg = "Update Success";
                    } else {
                        $msg = "Update Failed..." . error_get_last()['message'];
                    }
                }
                
            }
            
        }
    ?>
    <div id="main">
        <div id="head">
            <div>Edit member</div>
        </div>
        <div id="container">
            <div id="inside">
                <section>
                    <div class="info">
                        <div class="controls">
                            <div class="fullname">
                                <p>Nguyen</p>
                                <p class="lastname">Dan Truong</p>
                            </div>
                            <div class="buttons">
                                <a href="index.php" class="button is-links">Index Page</a>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="show">
                    <h1>INFOMATIONS</h1>
                    <hr>
                    <form method="post">
                        <div class="show-info">

                            <div class="title">
                                <p>Name</p>
                                <p>Phone</p>
                                <p>Email</p>
                                <p>Address</p>
                                <p>ZipCode</p>
                                <p>City</p>
                            </div>
    
                            <div style="height: 250px;" class="vertical-hr"></div>
    
                            <div class="detail" style="gap: 8px;">
                                <div class="control">
                                    <input class="input" value="<?php echo $data['nom'] ?>" type="text" name="name" placeholder="Enter Name...">
                                </div>
                                <div class="control">
                                    <input class="input" value="<?php echo $data['tel'] ?>" type="text" name="phone" placeholder="Enter Phone...">
                                </div>
                                <div class="control">
                                    <input class="input" value="<?php echo $data['email'] ?>" type="email" name="email" placeholder="Enter Email...">
                                </div>
                                <div class="control">
                                    <input class="input" value="<?php echo $data['adresse'] ?>" type="text" name="address" placeholder="Enter Address...">
                                </div>
                                <div style="width: 100px;" class="control">
                                    <input class="input" value="<?php echo $data['code_postal'] ?>" type="text" name="zipcode" placeholder="Zip Code...">
                                </div>
                                <div class="control">
                                    <input class="input" value="<?php echo $data['ville'] ?>" type="text" name="city" placeholder="Enter City...">
                                </div>
                            </div>
    
                        </div>
                        <hr>
                        <div class="foot-form buttons">
                            <a href="index.php" class="button">Cancel</a>
                            <button type="submit" name="submit" class="button is-success">Update</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>