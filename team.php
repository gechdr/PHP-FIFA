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
    
    $teamName = $_GET["teamName"];
    $currentTeam = "";
    for ($i=0; $i < count($acc); $i++) { 
        $tempAcc = $acc[$i];
        if ($tempAcc["teamName"] == $teamName) {
            $currentTeam = $tempAcc;
        }
    }
    $coachName = $currentTeam["coachName"];
    $phoneNumber = $currentTeam["phoneNumber"];
    
    if (isset($_GET["tanding"])) {
        $teamName = $_GET["teamName"];
        $key = $_GET["curPertandingan"];
        $pertandingan = $_GET["show"];
        $pertandingan = json_decode($pertandingan,true);
        $curPertandingan = $pertandingan[$key];

        $homeTurn = $curPertandingan["homeTurn"];
        $scoreHome = $curPertandingan["scoreHome"];
        $home = $curPertandingan["home"];
        $away = $curPertandingan["away"];
        $scoreAway = $curPertandingan["scoreAway"];
        $awayTurn = $curPertandingan["awayTurn"];
        $done = $curPertandingan["done"];
        
        if ($teamName == $home) {
            $homeTurn = false;
            $scoreHome = rand(0,5);

            echo "<script>alert('Kamu mencetak goal: $scoreHome')</script>";
        } else if ($teamName == $away) {
            $awayTurn = false;
            $scoreAway = rand(0,5);            

            echo "<script>alert('Kamu mencetak goal: $scoreAway')</script>";
        }

        if ($homeTurn == false && $awayTurn == false) {
            $done = true;
        }

        $pertandingan[$key] = array (
            "home" => $home,
            "scoreHome" => $scoreHome,
            "away" => $away,
            "scoreAway" => $scoreAway,
            "done" => $done,
            "homeTurn" => $homeTurn,
            "awayTurn" => $awayTurn
        );
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
    <title>Tim</title>
</head>
<body style="padding-left: 20px;">
    <form action="" method="get">
        <input type="hidden" name="hidden" value='<?= $acc ?>'>
        <input type="hidden" name="show" value='<?= $pertandingan ?>'>
        <input type="hidden" name="teamName" value='<?= $teamName ?>'>
        <h1 style="font-size: 3em; font-weight: bold;"><?= $teamName ?></h1>
        Nama Coach: <?= $coachName ?> <br>
        Nomor Nomor Telepon: <?= $phoneNumber ?> <br>
    </form>
    <form action="index.php" method="get">
        <input type="hidden" name="hidden" value='<?= $acc ?>'>
        <input type="hidden" name="show" value='<?= $pertandingan ?>'>
        <input type="hidden" name="teamName" value='<?= $teamName ?>'>
        <button>Logout</button>
    </form>
    
    <h2>Schedules</h2>

    <table style="width:fit-content" border="1">
        <tr>
            <th>Action</th>
            <th>Score</th>
            <th>Event</th>
            <th>Score</th>
            <th>Action</th>
        </tr>
        <?php
            $pertandingan = json_decode($pertandingan,true);

            foreach ($pertandingan as $key => $value) {
                $actionHome = $value["homeTurn"];
                $scoreHome = $value["scoreHome"];
                $home = $value["home"];
                $away = $value["away"];
                $scoreAway = $value["scoreAway"];
                $actionAway = $value["awayTurn"];
                $event = $home . " vs " . $away;

                ?>

                <form action="" method="get">
                    <?php
                        $pertandingan = json_encode($pertandingan);
                    ?>
                    <input type="hidden" name="hidden" value='<?= $acc ?>'>
                    <input type="hidden" name="show" value='<?= $pertandingan ?>'>
                    <input type="hidden" name="curPertandingan" value='<?= $key ?>'>
                    <input type="hidden" name="teamName" value='<?= $teamName ?>'>

                    <tr>
                        <?php
                            $pertandingan = json_decode($pertandingan,true);
                            if ($home == $teamName) {
                                if ($actionHome == true) {
                                    ?>
                                    <td style="text-align: center; font-weight: bold;"><button name="tanding">Tanding</button></td>
                                    <?php
                                } else {
                                    ?>
                                    <td style="text-align: center; font-weight: bold;"></td>
                                    <?php
                                }
                                ?>
                                <td style="text-align: center; font-weight: bold;"><?= $scoreHome?></td>
                                <td style="text-align: center; font-weight: bold;"><?= $event ?></td>
                                <td style="text-align: center; font-weight: bold;"><?= $scoreAway?></td>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <?php
                            } else if ($away == $teamName) {
                                ?>
                                <td style="text-align: center; font-weight: bold;"></td>
                                <td style="text-align: center; font-weight: bold;"><?= $scoreHome?></td>
                                <td style="text-align: center; font-weight: bold;"><?= $event ?></td>
                                <td style="text-align: center; font-weight: bold;"><?= $scoreAway?></td>
                                <?php
                                if ($actionAway == true) {
                                    ?>
                                    <td style="text-align: center; font-weight: bold;"><button name="tanding">Tanding</button></td>
                                    <?php
                                } else {
                                    ?>
                                    <td style="text-align: center; font-weight: bold;"></td>
                                    <?php
                                }
                            }
                        ?>
                    </tr>
                </form>
                <?php
            }

            $pertandingan = json_encode($pertandingan);
        ?>
    </table>
</body>
</html>