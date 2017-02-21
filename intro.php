<?php
include 'header.php';

switch ($_POST['mode']) {
case 'sharp-and-round':
    $intro = '"尖圓測試"';
    $path  = '/pretest.php';
    $page_title = 'IntroA';
    break;
case 'mood-distingulish':
    $intro = '"情緒認知測驗" intro';
    $path  = '/select-intro.php';
    $page_title = 'IntroB';
    break;
}
?>
<title><?php echo $page_title; ?></title>
<h3>您好，請遵循實驗助理的指示以及說明： <br> 
       此實驗需要您集中精神進行，如果在實驗中有任何不適，請立刻通知實驗人員，謝謝您的參與。<br> <?php echo $_POST['tester']; ?></h3>
<p><?php echo $intro; ?></p>
<br>
<form id="intro-form" action="<?php echo $path; ?>" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>" />
    <input type="hidden" name="total_set" value="<?php echo $_POST['total_set']; ?>" />
    <button type="submit" class="btn btn-primary btn-lg pull-right">Next</button>
    <div style="clear: both;"></div>
</form>
<?php
include 'footer.php';
?>