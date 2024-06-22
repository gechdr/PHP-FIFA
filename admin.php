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

    if (isset($_GET["createPertandingan"])) {
        $safe = true;

        $home = $_GET["Home"];
        $away = $_GET["Away"];

        if ($home == $away) {
            $safe = false;
            echo "<script>alert('Home & Away is The Same Team!!')</script>";
        }

        if ($safe == true) {

            $curPertandingan = array(
                "home" => $home,
                "scoreHome" => "?",
                "away" => $away,
                "scoreAway" => "?",
                "done" => false,
                "homeTurn" => true,
                "awayTurn" => true
            );

            array_push($pertandingan,$curPertandingan);
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
    <title>Admin</title>
</head>
<body style="padding-left: 20px;">
    <h1>Welcome, Admin</h1>

    <form action="index.php" method="get">
        <input type="hidden" name="hidden" value='<?= $acc ?>'>
        <input type="hidden" name="show" value='<?= $pertandingan ?>'>
        <button>Logout</button>
    </form>

    <h2>Users</h2>

    <table style="width:fit-content" border="1">
        <tr>
            <th>Nama Tim</th>
            <th>Nama Coach</th>
            <th>No Telepon</th>
            <th>W</th>
            <th>D</th>
            <th>L</th>
        </tr>
        <?php
            $acc = json_decode($acc,true);
            $pertandingan = json_decode($pertandingan,true);

            for ($i=0; $i < count($acc); $i++) { 
                $tempAcc = $acc[$i];
                $teamName = $tempAcc["teamName"];
                $coachName = $tempAcc["coachName"];
                $phoneNumber = $tempAcc["phoneNumber"];
                $win = 0;
                $draw = 0;
                $lose = 0;

                foreach ($pertandingan as $key => $value) {
                    $safe = true;

                    $scoreHome = $value["scoreHome"];
                    $scoreAway = $value["scoreAway"];
                    $home = $value["home"];
                    $away = $value["away"];

                    if (is_string($scoreHome) || is_string($scoreAway)) {
                        $safe = false;
                    }

                    if ($safe == true) {
                        if ($teamName == $home) {
                            if ($scoreHome > $scoreAway) {
                                $win += 1;
                            } else if ($scoreHome == $scoreAway) {
                                $draw += 1;
                            } else if ($scoreHome < $scoreAway) {
                                $lose += 1;
                            }
                        } else if ($teamName == $away) {
                            if ($scoreAway > $scoreHome) {
                                $win += 1;
                            } else if ($scoreAway == $scoreHome) {
                                $draw += 1;
                            } else if ($scoreAway < $scoreHome) {
                                $lose += 1;
                            }
                        }
                    }
                }
                ?>

                <form action="" method="get">
                    <tr>
                        <td><?= $teamName ?></td>
                        <td><?= $coachName ?></td>
                        <td><?= $phoneNumber ?></td>
                        <td><?= $win ?></td>
                        <td><?= $draw?></td>
                        <td><?= $lose?></td>
                    </tr>
                </form>

                <?php
            }
        ?>
    </table>

    <h2>Schedules</h2>

    <form action="#" method="get">
        <?php
            $acc = json_encode($acc);
            $pertandingan = json_encode($pertandingan);
        ?>
        <input type="hidden" name="hidden" value='<?= $acc ?>'>
        <input type="hidden" name="show" value='<?= $pertandingan ?>'>
        <select name="Home" id="">
            <?php
                $acc = json_decode($acc,true);
                for ($i=0; $i < count($acc); $i++) { 
                    $tempAcc = $acc[$i];
                    $teamName = $tempAcc["teamName"];   

                    echo "<option value='$teamName'>$teamName</option>";
                }
            ?>
        </select>
        <select name="Away" id="">
            <?php
                for ($i=0; $i < count($acc); $i++) { 
                    $tempAcc = $acc[$i];
                    $teamName = $tempAcc["teamName"];   

                    echo "<option value='$teamName'>$teamName</option>";
                }
            ?>
        </select>
        <button name="createPertandingan">Buat Pertandingan</button>
    </form>
    <br>

    <table style="width: fit-content;" border="1">
        <tr>
            <th>Score</th>
            <th>Event</th>
            <th>Score</th>
        </tr>
        
        <?php
            $pertandingan = json_decode($pertandingan,true);

            foreach ($pertandingan as $key => $value) {
                $scoreHome = $value["scoreHome"];
                $home = $value["home"];
                $away = $value["away"];
                $scoreAway = $value["scoreAway"];
                $event = $home . " vs " . $away;
                
                ?>

                <form action="" method="get">
                    <tr>
                        <td style="text-align: center; font-weight: bold;"><?= $scoreHome ?></td>
                        <td style="text-align: center; font-weight: bold;"><?= $event ?></td>
                        <td style="text-align: center; font-weight: bold;"><?= $scoreAway ?></td>
                    </tr>
                </form>

                <?php
            }
            
            $acc = json_encode($acc);
            $pertandingan = json_encode($acc);
        ?>
    </table>
</body>
</html>