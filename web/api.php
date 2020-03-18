<?php
require_once 'vendor/autoload.php';



$request = $_REQUEST;
if (isset($request['action'])) {
    $action = $request['action'];
    switch($action) {
        case 'getsentiment':
            getSentiment();
            break;
        case 'getsentimentovertime':
            getSentimentOverTime();
            break;
        case 'getemotion':
            getEmotion();
            break;
    }
}

function getSentimentOverTime() {
    $conn = getSqlConn();
//    $rows = $conn->query($sql)->fetchAll();

    $results = array();


    $startDate = '20200212';
    $endDate = '20200307';
    $interval = '2';

    for ($i = $startDate; $i<$endDate; $i+=$interval) {

        $sql = "SELECT id, sentiment, location, created_at FROM tweets NATURAL JOIN results WHERE created_at >= $i AND created_at < ". "$i+$interval";
//        $sql = "SELECT id, sentiment, location, created_at FROM tweets NATURAL JOIN results WHERE iso_language_code ='en' AND created_at >= $i AND created_at < ". "$i+$interval";

        $results[$i] = calResult($conn->query($sql)->fetchAll());
        if($i == '20200228')
            $i = '20200301';
    }

    die(json_encode($results));

}
function getSentiment() {

    $sql = "SELECT id, sentiment, location FROM tweets NATURAL JOIN results WHERE iso_language_code !='null' ";
//    $sql = "SELECT id, sentiment, location FROM tweets NATURAL JOIN results WHERE iso_language_code ='en' ";
    $conn = getSqlConn();

    if (isset($_REQUEST['favorite']))
        $sql .= " AND favorite_count >= " . $_REQUEST['favorite'];

    elseif (isset($_REQUEST['rt']))
        $sql .= " AND retweet_count >= " . $_REQUEST['rt'];

    elseif (isset($_REQUEST['follower']))
        $sql .= " AND user_followers_count >= " . $_REQUEST['follower'];

    elseif (isset($_REQUEST['date1'])) {
        $date1 = str_replace('/','',$_REQUEST['date1']);
        $sql .= " AND created_at >= $date1";

        if (isset($_REQUEST['date2'])) {
            $date2 = str_replace('/','',$_REQUEST['date2']);
            $sql .= " AND created_at <= $date2";
        }
    }

    elseif (isset($_REQUEST['keyword'])) {
        $keyword = $conn->quote('%'.$_REQUEST['keyword'].'%');
        $sql .= " AND text LIKE $keyword";
    }


    $rows = $conn->query($sql)->fetchAll();


    $result = calResult($rows);
    echo(json_encode($result));
    die();

}

function calResult ($rows) {
    $result['overall']['total'] = 0;
    $result['Hong Kong']['total'] = 0;
    $result['Singapore']['total'] = 0;
    $result['Netherlands']['total'] = 0;
    $result['USA']['total'] = 0;
    foreach ($rows as $row) {
        if (!isset($result['overall'][$row['sentiment']]))
            $result['overall'][$row['sentiment']] = 0;
        $result['overall'][$row['sentiment']] ++;

        if (!isset($result[$row['location']][$row['sentiment']])) {
            $result[$row['location']][$row['sentiment']] = 0;
        }
        $result[$row['location']][$row['sentiment']] ++;
    }

    foreach ($result as $location=>$arr) {
        $thisTotal = 0;
        foreach ($arr as $count) {
            $thisTotal += $count;
        }
        $result[$location]['total'] = $thisTotal;
    }
    return $result;
}

function getEmotion() {
    $emotions = ['disgust','fear','anger'];

    $overallTotal = 0;
    $hkTotal = 0;
    $sgTotal = 0;
    $usTotal = 0;
    $nlTotal = 0;

    $sql = "SELECT id, emotion, location FROM tweets NATURAL JOIN results WHERE iso_language_code = 'en'";
    $rows = getSqlConn()->query($sql)->fetchAll();

    foreach ($rows as $row) {


        if (isset($row['emotion'])) {
            $overallTotal++;

            switch ($row['location']){
                case 'Hong Kong':
                    $hkTotal++;
                    break;
                case 'Singapore':
                    $sgTotal++;
                    break;
                case 'USA':
                    $usTotal++;
                    break;
                case 'Netherlands':
                    $nlTotal++;
                    break;
            }
            $emotionStr = $row['emotion'];
            $thisEmotions = explode(',', $emotionStr);

            foreach ($thisEmotions as $thisEmotion) {

                if (!isset($result['overall'][$thisEmotion]))
                    $result['overall'][$thisEmotion] = 0;
                $result['overall'][$thisEmotion] ++;

                if (!isset($result[$row['location']][$thisEmotion])) {
                    $result[$row['location']][$thisEmotion] = 0;
                }
                $result[$row['location']][$thisEmotion]++;
            }
        }
    }

    $result['Hong Kong']['total'] = $hkTotal;
    $result['Singapore']['total'] = $sgTotal;
    $result['USA']['total'] = $usTotal;
    $result['Netherlands']['total'] = $nlTotal;
    $result['overall']['total'] = $overallTotal;
    echo(json_encode($result));
//    var_dump($result);
    die();
}

function getSqlConn() {
    include 'config.php';

    try {
        $conn = new PDO("mysql:host=$dbhost;dbname=$database", $dbuser, $dbpasswd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

//$sql = "SELECT * FROM tweets WHERE iso_language_code = 'en'";
//$result = $conn->query($sql);
//
//var_dump(json_encode($result->fetchAll()));