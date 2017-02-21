<?php
include 'header.php';
$negative_string = file_get_contents('_data/negative_ch.txt');
$negative_array  = explode(',', $negative_string);
$neutral_string  = file_get_contents('_data/neutral_ch.txt');
$neutral_array   = explode(',', $neutral_string);

$selected_word   = explode(',', $_POST['selected_word']);
$unselected_word = explode(',', $_POST['unselected_word']);

$neutral1 = explode(',', $_POST['check1_neutral']);
$neutral2 = explode(',', $_POST['check2_neutral']);

$check1 = json_decode('{'.str_replace('-', '"', $_POST['check1_result']).'}', true);
$check2 = json_decode('{'.str_replace('-', '"', $_POST['check2_result']).'}', true);

$debug1 = '{'.str_replace('-', '"', $_POST['check1_result']).'}';
$debug2 = '{'.str_replace('-', '"', $_POST['check2_result']).'}';

// detail record
$detail_file_path = $_SERVER['DOCUMENT_ROOT'].'/_record/'.str_replace('-', '_', $_POST['mode']).
                    '/detail/'.date('Ymd_Hi_').$_POST['tester'].'.csv';
$detail_file_content = '';
$detail_file_content .= "Tester: ".$_POST['tester']."\n";
$detail_file_content .= "Test Date: ".date('Y-m-d H:i')."\n";
$detail_file_content .= "Test Mode: ".str_replace('-', ' ', $_POST['mode'])."\n";
$detail_file_content .= "Test Result:\n";
$detail_file_content .= "No.,Stage,Word,Type,Response\n";
$serial = 0;
$count1 = array(
    'correct'   => 0,
    'incorrect' => 0,
    'pass'      => 0,
    'miss'      => 0
);
$count2 = array(
    'correct'   => 0,
    'incorrect' => 0,
    'pass'      => 0,
    'miss'      => 0
);
$d1 = array();
$d2 = array();
foreach ($check1 as $key => $value) {
    $serial++;
    $seg = explode('_', $key);
    if ($seg[0] == c) {
        $word = $negative_array[$unselected_word[$seg[1]]];
        $type = 'Negative';
    } else {
        $word = $neutral_array[$neutral1[$seg[1]]];
        $type = 'Neutral';
    }
    $d1[] = $key;
    $count1[$value]++;
    $detail_file_content .= "$serial,1,$word,$type,$value\n";
}
foreach ($check2 as $key => $value) {
    $serial++;
    $seg = explode('_', $key);
    if ($seg[0] == c) {
        $word = $negative_array[$selected_word[$seg[1]]];
        $type = 'Negative';
    } else {
        $word = $neutral_array[$neutral2[$seg[1]]];
        $type = 'Neutral';
    }
    $d2[] = $key;
    $count2[$value]++;
    $detail_file_content .= "$serial,2,$word,$type,$value\n";
}
file_put_contents($detail_file_path, $detail_file_content);

// debug
// $debug_file_path   = $_SERVER['DOCUMENT_ROOT'].'/_record/'.str_replace('-', '_', $_POST['mode']).
//                      '/debug.csv';
// $debug_file_content = '';
// foreach ($negative_array as $k => $v) {
//     $debug_file_content .= "negative-$k => $v\n";
// }
// $debug_file_content .= "\n";
// foreach ($neutral_array as $k => $v) {
//     $debug_file_content .= "neutral-$k => $v\n";
// }
// $debug_file_content .= "\n";
// foreach ($selected_word as $k => $v) {
//     $debug_file_content .= "c-$k => negative-$v\n";
// }
// $debug_file_content .= "\n";
// foreach ($neutral2 as $k => $v) {
//     $debug_file_content .= "i-$k => neutral-$v\n";
// }
// $debug_file_content .= "\n";
// foreach (explode(',', $_POST['debug']) as $k => $v) {
//     $debug_file_content .= "debug-$k => $v\n";
// }
// file_put_contents($debug_file_path, $debug_file_content);

// statistics record
$record_file_path = $_SERVER['DOCUMENT_ROOT'].'/_record/'.str_replace('-', '_', $_POST['mode']).
                    '/test_result.csv';
$record_file_content = '';
if (!file_exists($record_file_path)) {
    $record_file_content .= ucfirst(str_replace('-', ' ', $_POST['mode']))."\n";
    $record_file_content .= "Tester,".
                            "Test Date,".
                            "Check1 Correct,".
                            "Check1 Incorrect,".
                            "Check1 Pass,".
                            "Check1 Miss,".
                            "Check1 Correctness(%),".
                            "Check2 Correct,".
                            "Check2 Incorrect,".
                            "Check2 Pass,".
                            "Check2 Miss,".
                            "Check2 Correctness(%)\n";
}
$record_file_content .= $_POST['tester'].",".
                        date('Y-m-d H:i').",".
                        $count1['correct'].",".
                        $count1['incorrect'].",".
                        $count1['pass'].",".
                        $count1['miss'].",".
                        (100 * ($count1['correct'] + $count1['pass']) / array_sum($count1))."%,".
                        $count2['correct'].",".
                        $count2['incorrect'].",".
                        $count2['pass'].",".
                        $count2['miss'].",".
                        (100 * ($count2['correct'] + $count2['pass']) / array_sum($count2))."%\n";
file_put_contents($record_file_path, $record_file_content, FILE_APPEND)."\n";
?>
<title>Check Result</title>
<h3>Hi, <?php echo $_POST['tester']; ?></h3>
<p>It's over, thanks.</p>
<!-- <pre><?php print_r($debug1); ?></pre> -->
<!-- <pre><?php print_r($debug2); ?></pre> -->
<?php
include 'footer.php';
?>
