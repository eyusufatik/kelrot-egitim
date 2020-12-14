<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ../login.php");
        exit;
    }

    require_once "../config.php";
    $id = $_SESSION["id"];
    $taskNumber = 1;
    $taskName = "TASK1";
   
    //ÜSTÜ HER YERDE OLACAK
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sql = "UPDATE users SET ".$taskName." = 1, REALNAME = ?, PPURL = ? WHERE ID = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $realName, $ppURL, $id);

        $id = $_SESSION["id"];
        $realName = $_POST["real"];
        $ppURL = $_POST["pp"];

        mysqli_stmt_execute($stmt);
    }
?>

<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src = "task1parser.js"></script>
        <meta charset="UTF-8">
        <title>KelRot Ders</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="sidenav.css">
        <script src = "sidenav.js"></script>
        <style type="text/css">
            body{ font: 14px sans-serif; }
        </style>
    </head>
    <body>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="../../">Anasayfa</a>
            <a href="../profile.php">Profil</a>
            <a href="../tasks.php">Dersler</a>
            <a href="../logout.php">Log out</a>
        </div>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>

        <div style = " height: 100%; width: 100%; display: table; text-align:center;">
            <div style = "display: flex; flex-direction: column;height: 100%; vertical-align: middle; justify-content: center; align-items: center;">
               <div style = ""><h2><a href="https://drive.google.com/drive/folders/1tV27jV4j1OIvkECryKJ52pxO2I032Cr5">Dersi izleyin.</a></h2></div>
                <div style = "width: 15%">
                    <h4>Yaptığınız sitenin linkini aşağıdaki yere girip butona basınız.</h4>
                    <input class = "form-control" style = "" id = "link" type="text"></input>
                    <p class="text-danger" id = "error"></p>
                    <button class="btn btn-primary" onclick="parseURL()">siteme bak</button>
                </div>
            </div>
        </div>   
    </body>
</html>