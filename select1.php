<?php
include 'header.php';
$negative_string = file_get_contents('_data/negative.txt');
$negative_array  = explode(',', $negative_string);
$negative_keys   = array_rand($negative_array, 100);
shuffle($negative_keys);
?>
<h3 class="text-right">Selected: <span id="selected-word">0</span>/50</h3>
<?php
for ($section = 0; $section < 5; $section++) {

    $class = 'hide';
    if ($section == 0) {
        $class = '';
    }
?>
<div id="card-<?php echo $section + 1; ?>" class="word-card <?php echo $class; ?>">
    <?php
    for ($i = $section * 20; $i < ($section + 1) * 20; $i++) {

        // TODO
        // $class = '';
        // if ($i < 50) {
        //     $class = 'btn-selected-word';
        // }
    ?>
    <button class="btn btn-warning btn-word <?php echo $class; ?>" value="<?php echo $negative_array[$i]; ?>"><?php echo $negative_array[$negative_keys[$i]]; ?></button>
    <?php
    }
    ?>
</div>
<?php
}
?>
<h4 class="text-center">
    <button type="button" class="btn btn-default pull-left btn-change-card" data-mode="prev">&lt;&lt;Prev Page</button>
    <span id="display-card">1</span> / 5
    <button type="button" class="btn btn-default pull-right btn-change-card" data-mode="next">Next Page&gt;&gt;</button>
</h4>
<br>
<form id="select-form" action="/check1-intro1.php" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="selected_word" value="" />
    <input type="hidden" name="unselected_word" value="" />
    <button type="submit" id="btn-select-done" class="btn btn-primary btn-lg pull-right hide">Next</button>
</form>
<script>
$(document).ready(function() {

    $('button[data-mode="prev"]').prop('disabled', true);

    $(document.body).off('click', '.btn-change-card');
    $(document.body).on('click', '.btn-change-card', function() {
        var mode = $(this).data('mode'),
            display_card = $('#display-card').html();
        if (mode == 'prev') {
            display_card--;
        } else {
            display_card++;
        }
        $('.btn-change-card').prop('disabled', false);
        if (display_card == 1) {
            $('button[data-mode="prev"]').prop('disabled', true);
        }
        if (display_card == 5) {
            $('button[data-mode="next"]').prop('disabled', true);
        }
        $('#display-card').html(display_card);
        $('.word-card').addClass('hide');
        $('#card-' + display_card).removeClass('hide');
    });

    $(document.body).off('click', '.btn-word');
    $(document.body).on('click', '.btn-word', function() {
        var selected_word = parseInt($('#selected-word').html());
        if (selected_word < 50) {
            if ($(this).hasClass('btn-selected-word')) {
                $(this).removeClass('btn-selected-word');
                selected_word -= 1;
            } else {
                $(this).addClass('btn-selected-word');
                selected_word += 1;
            }
            var selected_word_key = '';
            $('.btn-selected-word').each(function () {
                if (selected_word_key != '') {
                    selected_word_key += ',';
                }
                selected_word_key += $(this).val();
            });
            $('input[name="selected_word"]').val(selected_word_key);
            var unselected_word_key = '';
            $('.btn-word:not(.btn-selected-word)').each(function () {
                if (unselected_word_key != '') {
                    unselected_word_key += ',';
                }
                unselected_word_key += $(this).val();
            });
            $('input[name="unselected_word"]').val(unselected_word_key);
            $('#selected-word').html(selected_word);
            $('#btn-select-done').addClass('hide');
            if (selected_word == 50) {
                $('#btn-select-done').removeClass('hide');
            }
        }
    });

    // TODO
    // var selected_word_key = '';
    // $('.btn-selected-word').each(function () {
    //     if (selected_word_key != '') {
    //         selected_word_key += ',';
    //     }
    //     selected_word_key += $(this).val();
    // });
    // $('input[name="selected_word"]').val(selected_word_key);
    // var unselected_word_key = '';
    // $('.btn-word:not(.btn-selected-word)').each(function () {
    //     if (unselected_word_key != '') {
    //         unselected_word_key += ',';
    //     }
    //     unselected_word_key += $(this).val();
    // });
    // $('input[name="unselected_word"]').val(unselected_word_key);
    // $('#btn-select-done').removeClass('hide');

});
</script>
<?php
include 'footer.php';
?>