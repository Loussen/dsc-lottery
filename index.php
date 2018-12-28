<?php
require_once "config.php";
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Lottery for New Year!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="appletouchicon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css_new/jquery.slotmachine.css">
    <link rel="stylesheet" href="css_new/app.css">
</head>
<body>

<div id="plane">
    <div class="well content">
        <div>
            <img src="logo.png" style="width: 20%;" />
            <hr style="border-top: 1px solid #ddd;"/>
            <p>Ready?</p>
            <div id="planeMachine">
                <div class="first_example_number">994XXXXXXX</div>
                <?php
                $stmt_select = mysqli_prepare($db, "SELECT `phone` FROM `numbers` order by RAND()");
                $stmt_select->execute();
                $result = $stmt_select->get_result();
                $stmt_select->close();
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div><?= $row['phone'] ?></div>
                    <?php
                }
                ?>
            </div>

            <div class="buttons">
                <button class="start" onclick="runSpin();">Start spin!</button>
                <button class="stop" onclick="stopSpin();">Stop spin!</button>
                <button class="restart" onclick="restart();">Restart?</button>
            </div>

            <div class="result">
                <h2>Congratulations</h2>

                <p class="user">Full name: <span></span></p>
                <p class="company">Company: <span></span></p>
            </div>
        </div>
        <div style="font-size: 15px;float: right;line-height: 2;"><a style="color: blue;" target="_blank" href="https://gitlab.com/Loussen/dsc-lottery/">https://gitlab.com/Loussen/dsc-lottery/</a></div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js_new/slotmachine.js"></script>
<script src="js_new/jquery.slotmachine.js"></script>
<script>


    var sound = new Audio('ringtones/spinning.mp3');
    var ding = new Audio('ringtones/ding.wav');
    var machine = $('#planeMachine').slotMachine({
        delay: 240,
        // active: Math.floor(Math.random() * $('#planeMachine div').length),
        active: 0,
        spins: 0,
        onComplete(active) {
            ding.play();
            active = parseInt(active)+1;
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {msisdn: $("#planeMachine").find("div:eq(" + active + ")").text()},
                cache: false,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data.code === 1) {
                        $(".result").slideDown();
                        $(".result").find(".user span").text(data.name);
                        $(".result").find(".company span").text(data.company);
                    }
                    sound.pause();
                    $(".stop").hide();
                    $(".restart").show();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    sound.pause();
                }
            });
        }
    });

    sound.addEventListener('ended', function () {
        this.currentTime = 0;
        this.play();
    }, false);

    function stopSpin() {
        machine.stop();
        $(".stop").prop("disabled", true);
    }

    function runSpin() {
        $("div.first_example_number").remove();
        $(".start").hide();
        $(".stop").show();
        sound.play();runSpin
        machine.shuffle(9999999999);
    }

    function restart() {
        // $(".result").slideUp();
        // $(".start").show();
        // $(".restart").hide();
        // $(".stop").hide().prop("disabled", false);

        location.reload();
    }


</script>
</body>
</html>