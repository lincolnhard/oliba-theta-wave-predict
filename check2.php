<?php
include 'header.php';
$negative_string = file_get_contents('_data/negative_ch.txt');
$negative_array  = explode(',', $negative_string);
$neutral_string  = file_get_contents('_data/neutral_ch.txt');
$neutral_array   = explode(',', $neutral_string);
$neutral_diff    = array_diff(range(0, count($neutral_array) - 1), explode(',', $_POST['check1_neutral']));
$neutral_word    = array_rand($neutral_diff, 25);

$selected_word   = explode(',', $_POST['selected_word']);
$unselected_word = explode(',', $_POST['unselected_word']);

$c   = array();
$i   = array();
$seq = array();
shuffle($selected_word);
for ($index = 0; $index < 50; $index++) {
    $c[]   = $negative_array[$selected_word[$index]];
    $seq[] = 'c_'.$index;
}
for ($index = 0; $index < 25; $index++) {
    $i[]   = $neutral_array[$neutral_word[$index]];
    $seq[] = 'i_'.$index;
}
shuffle($seq);
?>
<script>
var c   = [<?php echo '"'.implode('", "', $c).'"'; ?>];
var i   = [<?php echo '"'.implode('", "', $i).'"'; ?>];
var seq = [<?php echo '"'.implode('", "', $seq).'"'; ?>];
</script>
<div id="check-card" style="font-weight: bold; font-size: 60px; text-align: center; margin-top: 30%;"></div>
<input type="hidden" id="round-answer" value="0">
<form id="check-form" action="/check-result.php" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="selected_word" value="<?php echo $_POST['selected_word']; ?>" />
    <input type="hidden" name="unselected_word" value="<?php echo $_POST['unselected_word']; ?>" />
    <input type="hidden" name="check1_neutral" value="<?php echo $_POST['check1_neutral']; ?>" />
    <input type="hidden" name="check1_result" value="<?php echo $_POST['check1_result']; ?>" />
    <input type="hidden" name="check2_neutral" value="<?php echo implode(',', $neutral_word); ?>" />
    <input type="hidden" id="check-result" name="check2_result" value="" />
    <input type="hidden" id="debug" name="debug" value="" />
</form>
<script>
$(document).ready(function() {

    var next_index = 0;
    var debug = [];
    var endConfirm = false;
    function check() {
        if (next_index > 0) {
            if ($('#round-answer').val() == 0) {
                if ($('#check-result').val() != '') {
                    $('#check-result').val($('#check-result').val() + ',');
                }
                if (seq[next_index - 1].split('_')[0] == 'c') {
                    $('#check-result').val($('#check-result').val() + '-' + seq[next_index - 1] + '_' + next_index + '-:-miss-');
                } else {
                    $('#check-result').val($('#check-result').val() + '-' + seq[next_index - 1] + '_' + next_index + '-:-pass-');
                }
            }
        }
        if (next_index < 75) {
            var segment = seq[next_index].split('_'),
                word;
            if (segment[0] == 'c') {
                word = c[segment[1]];
            } else {
                word = i[segment[1]];
            }
            // x = new Date();
            // console.log('[' + x.toLocaleTimeString() + '] ' + next_index + ':' + segment[0] + ', ' + segment[1] + ' => ' + word);
            debug.push(seq[next_index])
            $('#check-card').html(word);
            $('#round-answer').val(0);
            next_index++;
            setTimeout(check, 4000);
        } else {
            $('#debug').val(debug.join(','));
            $('#check-form').submit();
        }
    }
    check();

    $(document.body).on('keydown', function(e) {
        var keyCode = e.keyCode ? e.keyCode : e.charCode;
        if (endConfirm && keyCode == 16) {
            if (next_index > 0) {
                if ($('#round-answer').val() == 0) {
                    if ($('#check-result').val() != '') {
                        $('#check-result').val($('#check-result').val() + ',');
                    }
                    if (seq[next_index - 1].split('_')[0] == 'c') {
                        $('#check-result').val($('#check-result').val() + '-' + seq[next_index - 1] + '_' + next_index + '-:-miss-');
                    } else {
                        $('#check-result').val($('#check-result').val() + '-' + seq[next_index - 1] + '_' + next_index + '-:-pass-');
                    }
                }
            }
            $('#debug').val(debug.join(','));
            $('#check-form').submit();
        }
        endConfirm = false;
        if (keyCode == 32 && $('#round-answer').val() == 0) {
            if ($('#check-result').val() != '') {
                $('#check-result').val($('#check-result').val() + ',');
            }
            if (seq[next_index - 1].split('_')[0] == 'c') {
                $('#check-result').val($('#check-result').val() + '-' + seq[next_index - 1] + '_' + next_index + '-:-correct-');
            } else {
                $('#check-result').val($('#check-result').val() + '-' + seq[next_index - 1] + '_' + next_index + '-:-incorrect-');
            }
            $('#round-answer').val(1);
        } else if (keyCode == 16) {
            endConfirm = true;
        }
    });

});
</script>
<?php
include 'footer.php';
?>
