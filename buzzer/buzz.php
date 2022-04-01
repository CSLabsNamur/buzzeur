<?php

$buzz_delay = 4; //4 secondes pour parler après le buzz.

if(isset($_GET["reset"]) && $_GET["reset"]=="true") {
    $data = array(
        "buzz_time" => 0,
        "equipe" => ""
    );
    file_put_contents("data.json", json_encode($data));
    echo "buzzer reset!";
    exit();
} else if(isset($_GET["pseudo"])) {
    $file = fopen(".tmp_locker", "a+");
    if(flock($file, LOCK_EX)) {
        $data = json_decode(file_get_contents("data.json"), true);
        if(time() - $data["buzz_time"] >= 5) {
            $data["buzz_time"] = time();
            $data["equipe"] = $_GET["pseudo"];
            file_put_contents("data.json", json_encode($data));
            echo "OK";
            exit();
        } else {
            echo $data["buzz_time"];
            exit();
        }
    } else {
        echo "not locked wtf";
    }
    exit();
} else if(isset($_GET["status"])) {
    $data = json_decode(file_get_contents("data.json"), true);
    if(time() - $data["buzz_time"] >= 5) {
        exit();
    } else {
        echo $data["equipe"];
        exit();
    }
} else {
    echo "error";
    exit();
}


