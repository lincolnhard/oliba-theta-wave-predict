<?php
include 'header.php';
$negative_string = file_get_contents('_data/negative_ch.txt');
$negative_array  = explode(',', $negative_string);
$negative_keys   = array_rand($negative_array, 100);
shuffle($negative_keys);
?>
<h3 class="text-right">Selected: <span id="selected-word">0</span>/50</h3>
<div id="word-pool">
    <?php
    for ($i = 0; $i < 100; $i++) {

        $class = '';
        // /*TODO*/
        // if ($i < 50) {
        //     $class = 'btn-selected-word';
        // }
    ?>
    <button class="btn btn-warning btn-word <?php echo $class; ?>" value="<?php echo $negative_keys[$i]; ?>"><?php echo $negative_array[$negative_keys[$i]]; ?></button>
    <?php
    }
    ?>
</div>
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

    var shiftCounter = 0;

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

    $(document.body).on('keydown', function(e) {
        var keyCode = e.keyCode ? e.keyCode : e.charCode;
        if (keyCode == 16) {
            if (shiftCounter == 1) {
                while ($('.btn-selected-word').length < 50) {
                    $('.btn-word:not(.btn-selected-word):first').click();
                }
            } else {
                shiftCounter++;
            }
        } else {
            shiftCounter = 0;
        }
    });

    // /*TODO*/
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