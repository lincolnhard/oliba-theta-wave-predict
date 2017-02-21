<?php
include 'header.php';
?>
<p>
 接下來，螢幕中央會顯示不同字彙，您將進行的步驟是：<br>
 1.如果是負面字眼(ex:討厭的，暴躁)則按下空白鍵。<br>
 2.如果是單純的中性字眼(ex:電腦，山丘)則不做任何動作。<br>
 <br>
 如果有任何問題請詢問測試人員，謝謝。
</p>
<br>
<form id="check-intro-form" action="/check1-intro2.php" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="selected_word" value="<?php echo $_POST['selected_word']; ?>" />
    <input type="hidden" name="unselected_word" value="<?php echo $_POST['unselected_word']; ?>" />
    <button type="submit" class="btn btn-primary btn-lg pull-right">Next</button>
</form>
<?php
include 'footer.php';
?>
