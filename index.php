<?php
include 'header.php';

$default_set           = 6;
$max_set               = 6;
$min_set               = 2;
$sharp_and_round_img   = 'mark1.jpg';
$mood_distingulish_img = 'mark2.jpg';
?>
<title>Welcome</title>
<form id="index-form" action="/intro.php" method="post">
    <div id="tester-field" class="form-group">
        <label class="control-label" for="tester">Please input your name:</label>
        <input type="text" id="tester" name="tester" class="form-control" placeholder="Name" required autofocus />
        <input type="hidden" name="mode" />
    </div>
    <div style="margin-top: 15px;">
        <button type="button" id="add-user-btn" class="btn btn-lg btn-primary pull-left" style="margin-right: 50px;">Start</button>
        <div style="padding-top: 10px;">
            <button type="button" id="add-set-btn" class="btn btn-default pull-right">+</button>
            <input type="text" readonly="readonly" name="total_set" class="form-control pull-right" value="<?php echo $default_set; ?>" class="input-large" style="width: 34px; height: 34px; text-align: center; margin: 0 5px;" />
            <button type="button" id="subtract-set-btn" class="btn btn-default pull-right">-</button>
            <h4 class="pull-right" style="padding: 0 5px;">set:&nbsp;</h4>
            <select name="type" class="pull-right" style="height: 34px; -webkit-appearance: menulist-button;">
                <option value="1">Sharper</option>
                <option value="2">Rounder</option>
                <option value="3">Alternately</option>
                <option value="4">Complex</option>
            </select>
            <div style="clear: both;"></div>
        </div>
    </div>
    <div id="index-main-section">
        <a class="intro-link" data-mode="sharp-and-round">
            <img src="/_asset/img/<?php echo $sharp_and_round_img; ?>" style="width: 270px; height: 270px;" />
        </a>
        <a class="intro-link" data-mode="mood-distingulish">
            <img src="/_asset/img/<?php echo $mood_distingulish_img; ?>" style="width: 270px; height: 270px; float: right;" />
        </a>
        <div style="clear: both;"></div>
    </div>
</form>
<script>
$(document).ready(function() {

    $(document.body).on('click', '#add-set-btn', function() {
        var total_set = parseInt($('input[name="total_set"]').val());
        if (total_set < <?php echo $max_set; ?>) {
            $('input[name="total_set"]').attr('value', total_set + 1)
        }
    });

    $(document.body).on('click', '#subtract-set-btn', function() {
        var total_set = parseInt($('input[name="total_set"]').val());
        if (total_set > <?php echo $min_set; ?>) {
            $('input[name="total_set"]').attr('value', total_set - 1)
        }
    });

    $(document.body).on('click', '#add-user-btn', function() {
        if ($('input[name="tester"]').val()) {
            $('#tester-field').removeClass('has-error');
            $('#index-main-section').fadeIn();
        } else {
            $('#tester-field').addClass('has-error');
        }
    });

    $(document.body).on('click', '.intro-link', function() {
        $('input[name="mode"]').val($(this).attr('data-mode'));
        $('#index-form').submit();
    });

});
</script>
<?php
include 'footer.php';
?>