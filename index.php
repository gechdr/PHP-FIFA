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

    if (isset($_GET["btnLogin"])) {
        $safe = true;

        $teamName = $_GET["teamName"];
        $password = $_GET["password"];
        $currentTeam = "";

        // Validation Check
        if ($teamName == "" || $password == "") {
            echo "<script>alert('Semua Field Harus Terisi!')</script>";
            $safe = false;
        } else if ($teamName == "FIFA" && $password == "admin") {
            $safe = false;
            $acc = json_encode($acc);
            $pertandingan = json_encode($pertandingan);
            header("Location: admin.php?hidden=$acc&show=$pertandingan");
        } else {
            $safe = false;
            for ($i=0; $i < count($acc); $i++) { 
                $tempAcc = $acc[$i];
                if ($tempAcc["teamName"] == $teamName) {
                    $safe = true;
                    if ($tempAcc["password"] != $password) {
                        echo "<script>alert('Wrong Password!')</script>";
                        $safe = false;
                        break;
                    } else {
                        $currentTeam = $tempAcc;
                    }
                }
            }
        }

        if ($safe == true) {
            $acc = json_encode($acc);
            $pertandingan = json_encode($pertandingan);
            header("Location: team.php?hidden=$acc&teamName=$teamName&show=$pertandingan");
        } else {
            $exist = false;
            for ($i=0; $i < count($acc); $i++) { 
                $tempAcc = $acc[$i];
                if ($tempAcc["teamName"] == $teamName) {
                    $exist = true;
                    break;
                }
            }

            if ($exist == false) {
                echo "<script>alert('Nama Tim is Not Registered!')</script>";
            }
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
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="padding-left: 20px;">
    <h1>Login</h1>

    <form action="#" method="get">
        <input type="hidden" name="hidden" value='<?= $acc ?>'>
        <input type="hidden" name="show" value='<?= $pertandingan ?>'>
        Nama Tim: <br>
        <input type="text" name="teamName" id=""> <br>
        Password: <br>
        <input type="text" name="password" id=""> <br>
        <br>
        <button name="btnLogin">Login</button> <br>
        Belum mendaftar? <a href='<?="register.php?hidden=".$acc."&show=".$pertandingan;?>'> Daftar sekarang!</a>

    </form>
</body>
</html>