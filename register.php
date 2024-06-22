<?php
    if (isset($_GET["hidden"])) {
        $acc = $_GET["hidden"];
        $acc = json_decode($acc,true);
    } else {
        $acc = array();
    }

    if (isset($_GET["show"])) {
        $pertandingan = $_GET["show"];
        $pertandingan = json_decode($pertandingan,true);
    } else {
        $pertandingan = array();
    }

    if (isset($_GET["btnRegister"])) {
        $safe = true;

        $teamName = $_GET["teamName"];
        $coachName = $_GET["coachName"];
        $password = $_GET["password"];
        $confirmPassword = $_GET["confirmPassword"];
        $phoneNumber = $_GET["phoneNumber"];
    
        // Validation Check
        if ($teamName == "" || $coachName == "" || $password == "" || $confirmPassword == "" || $phoneNumber == "") {
            echo "<script>alert('Semua Field Harus Terisi!')</script>";
            $safe = false;
        } else if ($confirmPassword != $password) {
            echo "<script>alert('Password not Match!')</script>";
            $safe = false;
        } else if (is_numeric($phoneNumber) == false) {
            echo "<script>alert('Nomor Telepon Input Invalid!')</script>";
            $safe = false;
        } else if ($teamName == "FIFA" || strtolower($password) == "admin") {
            if ($teamName == "FIFA" && strtolower($password) == "admin") {
                echo "<script>alert('Not Supposed to Use That Name & Password!')</script>";
            } else if ($teamName == "FIFA") {
                echo "<script>alert('Not Supposed to Use That Name!')</script>";
            } else if (strtolower($password) == "admin") {
                echo "<script>alert('Not Supposed to Use That Password!')</script>";
            }
            $safe = false;
        }

        for ($i=0; $i < count($acc); $i++) { 
            $tempAcc = $acc[$i];
            if ($tempAcc["teamName"] == $teamName) {
                echo "<script>alert('Nama Tim already Registered!')</script>";
                $safe = false;
                break;
            }
        }

        if ($safe == true) {
            $dataAcc = array(
                "teamName" => $teamName,
                "coachName" => $coachName,
                "password" => $password,
                "phoneNumber" => $phoneNumber
            );
            array_push($acc,$dataAcc);
            echo "<script>alert('Register successfully!')</script>";
            $acc = json_encode($acc);
            $pertandingan = json_encode($pertandingan);
            header("Location: index.php?hidden=$acc&show=$pertandingan");
        }

    }

    // var_dump($acc);
    // echo "<br>";
    // var_dump($pertandingan);

    $acc = json_encode($acc);
    $pertandingan = json_encode($pertandingan);

    // echo "<br>";
    // var_dump($acc);
    // echo "<br>";
    // var_dump($pertandingan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body style="padding-left: 20px;">
    <h1>Register</h1>

    <form action="#" method="get">
        <input type="hidden" name="hidden" value='<?= $acc ?>'>
        <input type="hidden" name="show" value='<?= $pertandingan ?>'>
        Nama Tim: <br>
        <input type="text" name="teamName" id=""> <br>
        Nama Coarch: <br>
        <input type="text" name="coachName" id=""> <br>
        Password: <br>
        <input type="text" name="password" id=""> <br>
        Confirm Password: <br>
        <input type="text" name="confirmPassword" id=""> <br>
        Nomor Telepon: <br>
        <input type="tel" name="phoneNumber" id=""> <br>
        <br>
        <button name="btnRegister">Register</button> <br>
        Sudah memiliki akun? <a href='<?="index.php?hidden=".$acc."&show=".$pertandingan?>'> Masuk sekarang!</a>
    </form>
</body>
</html>