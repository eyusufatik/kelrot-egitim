<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    require_once("config.php");

    $found == false;

    $tasks;
    $id = $_SESSION["id"];


    $numberOfTasks = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*)-5 as num FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = 'u9842540_kelrot_egitim' AND table_name = 'users' "))["num"];

    for($i = 0; $i < $numberOfTasks; $i++){
        $temp = mysqli_fetch_array(mysqli_query($link, "SELECT TASK".($i + 1)." FROM users WHERE ID = ".$id))[0];
        $tasks[$i] = $temp;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
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
</head>

<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="../">Anasayfa</a>
        <a href="profile.php">Profil</a>
        <a href="tasks.php">Dersler</a>
        <a href="logout.php">Log out</a>
    </div>
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>


    <div class="page-header">
        <h1>Merhaba, <b><?php echo htmlspecialchars($_SESSION["username"]);?></b>. Derslerine aşağıdan erişebilirsin.
        </h1>
    </div>
    <span class="page-header">
        <?php
                foreach ($tasks as $index => $value) {
                    
                    /*if($value == true && $found == false){ //yapılmış
                        echo '<a href = "/task'.($index+1).'.php" > done '.($index+1).'</a>';
                        echo "<br/>";
                    }else */if($value == false && $found == false){ //ilk yapılmamış
                        $found = true;
                        echo '<a class="btn btn-primary" href = "tasks/task'.($index+1).'.php" > go to task '.($index+1).'</a>';
                    }/*else if($value == false && $found == true){ //yapılmamış sonrası
                        echo '<a style="color: red" href = "/task'.($index+1).'.php" > go to task '.($index+1).'</a>';
                        echo "<br/>";
                    }*/
                    
                }
            ?>
    </span>
    <div name="buttons" class="page-header">
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger">Log Out of Your Account</a>
        </p>

    </div>
</body>

</html>