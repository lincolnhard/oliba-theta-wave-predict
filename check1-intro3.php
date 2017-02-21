<?php
include 'header.php';
?>
<p>
Introduction 3
</p>
<br>
<form id="check-intro-form" action="/check1.php" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="selected_word" value="<?php echo $_POST['selected_word']; ?>" />
    <input type="hidden" name="unselected_word" value="<?php echo $_POST['unselected_word']; ?>" />
    <button type="submit" class="btn btn-primary btn-lg pull-right">Next</button>
</form>
<?php
include 'footer.php';
?>
