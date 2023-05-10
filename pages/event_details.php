<?php
require_once('db.config.php');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(array("message" => "eventID not set!"));
    exit;
}
$eventID = $_GET['id'];
$SQL = "SELECT * FROM events WHERE id=" . $eventID;
$result = pg_query($CONNECTION, $SQL);
$event = pg_fetch_all($result);
?>
<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to Delete this Event?");
    }
    
    let event = <?=json_encode($event)?>;
    localStorage.setItem('event', JSON.stringify(event));
</script>
<?php
if (isset($_POST['delete'])) {
    $SQL = "DELETE FROM events WHERE id = " . $eventID;
    $result = pg_query($CONNECTION, $SQL);

    if (!$result) {
        echo "Error deleting event: " . pg_last_error($CONNECTION);
        exit();
    }

    pg_close($CONNECTION);

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../style/_global.css?<?= filesize('../style/_global.css'); ?>" />
    <script src="../script/_global.js?<?= filesize('../script/_global.js'); ?>"></script>
</head>

<body>
    <div class="background">
        <div id="eventName" class="infoDiv"></div>
        <div id="outerEventCoverPhotoDiv">
            <div id="eventCoverPhoto" class="infoDiv"></div>
        </div>
        <div id="eventDetails" class="infoDiv"></div>
        <div id="eventLocation" class="infoDiv"></div>
        <div id="eventDatetime" class="infoDiv"></div>
        <div id="buttons"></div>
        <form method="POST" action="" onsubmit="return confirmSubmit()">
            <button type="submit" name="delete" class="button" style="margin:auto; display:block;">Delete Event</button>
        </form>
    </div>
</body>

</html>
