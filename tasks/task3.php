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
    $taskNumber = 3;
    $taskName = "TASK3";
    $answerError = "";
    $rightAnswerText = "";
    $previousTaskDone =  mysqli_fetch_array(mysqli_query($link, "SELECT TASK".($taskNumber-1)." FROM users WHERE ID = ".$id))[0];
    $thisTaskDone = mysqli_fetch_array(mysqli_query($link, "SELECT TASK".($taskNumber)." FROM users WHERE ID = ".$id))[0];
    if($previousTaskDone == 0){
        header("location: ../tasks.php");
    }
    

    
    $showContent = false;

    $result = mysqli_query($link, "SELECT * FROM lookups WHERE USRNAME = '".$_SESSION["username"]."' AND TASKNAME = '".$taskName."'");
    $count = 0;
    while($lookUps = mysqli_fetch_array($result)){
        $count++;
    }
    if($count > 0){
        $showContent = true;
    }

    if(isset($_GET["asd"]) && $_GET["asd"] == 123){
        $showContent = true;
        if($count == 0){
            mysqli_query($link,"INSERT INTO lookups (USRNAME, TASKNAME) VALUES ('".$_SESSION["username"]."', '".$taskName."');");
        }
    }

    if($_SERVER["REQUEST_METHOD"] ==  "POST"){
        $answer = mysqli_fetch_array(mysqli_query($link, "SELECT ANSWER FROM answers WHERE TASKNAME = '".$taskName."'"))[0];
        if($answer == $_POST["answer"]){
            $rightAnswerText = "Helal bee! Ne badireler atlattın, ne zorluklar çektin. Fakat yılmadın ve doğru cevabı buldun. İşte bu!!!!";
            $thisTaskDone = 1;
            $sql = "UPDATE users SET ".$taskName." = 1 WHERE ID = ".$id;
            mysqli_query($link, $sql);
        }else{
            $answerError = "Cevap yanlış... Reddedildin... Yine!";
        }
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

        <div style = "text-align: center;  display: flex; justify-content: center; ">
            <div style="text-align:center; width: 60%;">
                <p>2 lik tabandaki 1111111001 sayısını 10 luk tabana geçirecek bir program yazın.</p>           
            </div>
        </div>

        <div style = " text-align: center; width: 100%; display: table;">
            <div style = "display: flex; vertical-align: middle; justify-content: center; align-items: center;">
                <form style = "width: 15%" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class = "form-group <?php echo (!empty($answerError)) ? 'has-error' : ''; ?>">
                        <h4>Cevabı aşağıdaki yere girip butona basınız.</h4>
                        <input class = "form-control" id = "answer" name = "answer" type="text"></input>
                        <span class="help-block"><?php echo $answerError; ?></span>
                        <button class="btn btn-primary" type = "submit" >cevapla</button>
                    </div>
                </form>
            </div>
            <?php 
                    if(!empty($rightAnswerText)){
                        echo "<p class = \"text-success\" style = \"font-size:20px; \">".$rightAnswerText."</p>";
                    }
                ?>
            <?php
                echo "<button class = 'btn btn-info' onclick = 'window.location.href = \"task".($taskNumber-1).".php\"'>Önceki Task</button>";
                if($thisTaskDone==1){
                    echo "&nbsp &nbsp<button class = 'btn btn-success' onclick = 'window.location.href = \"task".($taskNumber+1).".php\"'>Sonraki Task</button><br><br>";
                }
            ?>
        </div>
    </body>
</html>