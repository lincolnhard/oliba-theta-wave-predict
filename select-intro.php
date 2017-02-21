<?php
include 'header.php';
?>
<title>Select Intro</title>
<h3>您好, <?php echo $_POST['tester']; ?></h3>
<p>本實驗進行的是"情緒認知測驗"請依照以下步驟進行:<br>
   首先，您會看到100個負面字眼，從其中挑出50個您覺得形容在您身上是相對符合的，<br>
   請盡量挑選直到選出50個為主，謝謝。</p>
<br>
<form id="intro-form" action="select.php" method="post">
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