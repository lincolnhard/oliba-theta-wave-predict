<?php
include 'header.php';

switch ($_POST['mode']) {
case 'sharp-and-round':
    $text = '"尖圓測試" ';
    break;
case 'mood-distingulish':
    $text = '"mood distingulish" text';
    break;
}

$response = json_decode(str_replace("'", '"', $_POST['response']));

$correct = 0;
foreach ($response as $record) {
    if ($record[1] == 'c') {
        $correct++;
    }
}
?>
<title>Pretest Result</title>
<h3>Hi, <?php echo $_POST['tester']; ?></h3>
<p>您剛剛的測試成績:</p>
<p>正確: <?php echo $correct; ?></p>
<p>錯誤: <?php echo count($response) - $correct; ?></p>
<br>
<p><?php echo $text; ?></p>
<form id="pretest-result-form" action="/test.php" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>" />
    <input type="hidden" name="total_set" value="<?php echo $_POST['total_set']; ?>" />
    <input type="hidden" name="set" value="1" />
    <button type="submit" class="btn btn-primary btn-lg pull-right">Start</button>
    <div style="clear: both;"></div>
</form>
<?php
include 'footer.php';
?>