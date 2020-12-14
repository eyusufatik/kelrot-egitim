<?php
// Initialize the session
    session_start();
            
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    require_once "config.php";
    $id = $_SESSION["id"];
    $userName = $_SESSION["username"];
    //sorular hep burada. sorular 1den başlıyor unutma
    $questions = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `profile_questions` WHERE USRNAME = 'questions'"), MYSQLI_NUM);
    $arr = mysqli_fetch_array(mysqli_query($link, "SELECT REALNAME, PPURL FROM users WHERE ID = ".$id ));
    $realName = $arr[0];
    $ppURL = $arr[1];
    $usersAnswers = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `profile_questions` WHERE USRNAME = '".$userName."'"));
    $answeredBefore = ($usersAnswers != NULL);

    if($_SERVER["REQUEST_METHOD"] ==  "POST"){
        if($answeredBefore){
            //update query
            $sql = "UPDATE `profile_questions` SET ";
            $counter = 0;

            $answers = array();
            foreach($_POST as $key => $value){
                array_push($answers, $value);
                if($counter == 0){
                    $sql = $sql.$key." = ?";
                }else{
                    $sql = $sql.", ".$key." = ?";
                }
                $counter++;
            }
            $sql = $sql." WHERE USRNAME = '".$userName."'";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, str_repeat("s",count($_POST)), ...$answers);
            mysqli_stmt_execute($stmt);
        }else{
            //insert query
            $answers = array();
            $sql = "INSERT INTO `profile_questions` VALUES ('".$userName."'";
            foreach($_POST as $key => $value ){
                $sql = $sql.", ?";
                array_push($answers, $value);
            }
            $sql=$sql.")";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, str_repeat("s",count($_POST)), ...$answers);
            mysqli_stmt_execute($stmt);
        }
        header("location: profile.php");
    }

?>

<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        <title>KelRot Ders</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link rel="stylesheet" href="tasks.css">
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>
        <style type="text/css">
            body{ font: 14px sans-serif; }
        </style>
    </head>
    <body>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">Anasayfa</a>
            <a href="profile.php">Profil</a>
            <a href="tasks.php">Dersler</a>
            <a href="#">Log out</a>
        </div>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
        <div style = "text-align: center;  display: flex; justify-content: center; ">
            <div style="text-align:center; width: 60%;">
                <img src="<?php echo $ppURL ?>" alt="">
                <h1>Merhabalar, <?php echo htmlspecialchars($realName);?></h1>
                <form action="profile.php" method="post">
                    <div class = "form-group">
                        <?php
                            for($i = 1; $i<count($questions); $i++){
                                $question = $questions[$i];
                                $temp = "";
                                if($answeredBefore){
                                    $temp = $usersAnswers[$i];
                                }
                                echo '
                                    <h4>'.$question.'</h4>
                                    <input class = "form-control" id = "answer" name = "Q'.$i.'" value = "'.$temp.'"type="text"></input>
                                '; 
                            }
                            echo "<br>";
                        ?>
                        <button class="btn btn-primary" type = "submit">Cevaplarımı kaydet</button>
                        </div>
                </form>

            </div>
        </div>
    </body>
</html>