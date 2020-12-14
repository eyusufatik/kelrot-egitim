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
    $taskNumber = 2;
    $taskName = "TASK2";
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
                <p>Gfkmn`Vpqmc/^L`c`u`ákÄ+`qpapsjj`jvkéaémf^iná^hdmcjm/^şhgqfxj^êô{céĞém`hêho^udcqjjmds-`@zhodth`hásjq`jjŞjmjm`kbeb^c`lîmlby/^ş`irÄm`fòqéméq`qéscd.h``lkÄ^frfqjmed/^Hôsdwh`sb<wbr>lblm`n`l^jåjm`hisjxbbÄm`nm`o^lne^LîslÄyÄRjxbg/^Ctocbm`rpms`lh`fòqfumdscf^c`á`sîm`s</p>
                <p style = "">Görevi geçmek için yukarıdaki şifreyi kırmanız ve şifredeki kodu aşağıdaki kutucuğa girmeniz gerekmektedir. (Şifrenin tek ve çift indisli karakterlere ayrı ayrı uygulandığı bilinmektedir.)</p>
                <button class="btn btn-primary" type = "submit" onclick = "window.location.href = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?asd=123';">görevi açıkla</button>
                
                <?php
                    if($showContent){
                        echo "<p><a href = 'https://github.com/kelrot17/crypt'> https://github.com/kelrot17/crypt</a>  adresinden Kilit.cpp dosyasını bilgisayarınıza indirin.</p>";
                        echo "<p>Bilgisayarınıza bir C++ IDE indirin. Hangisini indireceğinize kendiniz karar verebilirsiniz.</p>";
                        echo "<p>Bilgisayarınızda bir C++ Compiler’ı olması beklenir ancak yüklü bir derleyici yoksa onu da indirdiğinize emin olun. (örn. GCC compiler)</p>";
                        echo "<p>Kilit.cpp dosyasını indirdiğiniz program ile açın. Programı derleyip çalıştırarak dosyanın hatasız bir şekilde çalıştığından emin olun. (Build and run)</p>";
                        echo "<p>Bilgisayardaki her verinin, anlam kazanması için sahip olduğu bir tipi bulunmaktadır. Birkaç örnek vermek gerekirse “int” tam sayı, “float” ondalık sayı tipleridir. Bu derste yazıların da yazılmasını sağlayan tip olan “char” (karakter) tipi kullanılacaktır. “char” tipinin çalışma şeklini anlamak ve hangi sayının hangi karakter anlamına geldiği hakkında bir fikir kazanmak için linkteki ASCII tablosunu inceleyin.</p>";
                         echo "<a href = 'https://en.cppreference.com/w/cpp/language/ascii' >ASCII</a>";
                        echo "<p>“char” tipi sadece bir karakteri belirtmektedir. Ancak yazılar birçok karakterin yanyana konulmasıyla oluşmaktadır. Bu gibi görevleri yerine getirmesi için kullanılan sistemlere “Array” (dizi) denilmektedir. Bir dizi tanımlandığında bilgisayar belirtilen boyutta aynı tipteki verileri art arda tanımlayarak bir paket oluşturur. Bu paketteki herhangi bir veriye ulaşmak içinse indisler kullanılır. “dizi[indis]” kullanımı dizi arrayinde indis sırasında bulunan veriye ulaşmanızı sağlar. Örneğin “int dizi[10]” şeklinde tanımlanan bir dizi 10 eleman içeren bir tam sayı dizisidir ve ilk elemanı “dizi[0]” , son elemanı ise “dizi[9]” dur.</p>";
                        echo "<p>Bu derste elimizdeki bir şifreyi çözmek için bir şifre çözme programının yazılması gerekmektedir. Çözülmesi gereken şifre aşağıdadır.</p>";
                        echo "<p>Gfkmn`Vpqmc/^L`c`u`ákÄ+`qpapsjj`jvkéaémf^iná^hdmcjm/^şhgqfxj^êô{céĞém`hêho^udcqjjmds-`@zhodth`hásjq`jjŞjmjm`kbeb^c`lîmlby/^ş`irÄm`fòqéméq`qéscd.h``lkÄ^frfqjmed/^Hôsdwh`sb<wbr>lblm`n`l^jåjm`hisjxbbÄm`nm`o^lne^LîslÄyÄRjxbg/^Ctocbm`rpms`lh`fòqfumdscf^c`á`sîm`s</p>";
                        echo "<p>Kilit.cpp dosyasında girdiğiniz metnin her karakterine tek tek işlem yapabilecek bir kod bulunmaktadır. Bu kodun nasıl çalıştığını anlamak için</p>";
                        echo "<p>metin[i]+=0;</p>";
                        echo "<p>kısmında 0 yerine başka bir sayı yazarak programı çalıştırın ve girdiğiniz metnin nasıl değiştiğini gözlemleyin. Değişimi daha iyi kavramak için sayıyı birkaç defa değiştirebilirsiniz.
                        </p>";
                        echo "<p>Şifreyi çözmenize yardımcı olmak üzere sizin için bazı şeyler önceden çözülmüş durumdadır. Basit bir şifreleme tekniği olan Sezar Şifreleme tekniğinin tek ve çift sıradaki karakterler için ayrı ayrı kullanıldığı; ayrıca Gfkmn`Vpqmc kısmının programlama dillerine başlanırken genelde ilk yazılan programın çıktısı olduğu biliniyor. Bu kısım üzerinde yoğunlaşılarak tek ve çift indisli karakterlere doğrudan eklenip çıkarılacak sayıları bulmak için deneme yanılma yöntemi kullanabileceğiniz bir program yazın.</p>";
                        echo "<p>(Input olarak Gfkmn`Vpqmc yazarak tek ve çift indisli karakterleri değiştiren bir kod yazın ve değişimi (+) ve (-) değerler için kodu değiştirerek deneyin. Tekleri ve çiftleri ayırmak için mod alma işlemi (%) kullanabilirsiniz.)</p>";
                        echo "<p>Yazdığınız program şifreyi doğru şekilde kırıyorsa büyük metni de çözün. Ardından metinde bulunan şifreyi sitedeki cevap bölümüne girerek görevi tamamlayın.</p>";
                    }

                    ?>
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