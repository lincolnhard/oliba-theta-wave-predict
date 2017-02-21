<?php
include 'header.php';

function get_standard_deviation($avg, $list) {
    $total_var = 0;
    foreach ($list as $lv) {
        $total_var += pow(($lv - $avg), 2);
    }

    return sqrt($total_var / (count($list) - 1));
}

switch ($_POST['type']) {
case '1':
    $type = 'Single1';
    break;
case '2':
    $type = 'Single2';
    break;
case '3':
    $type = 'Alternately';
    break;
case '4':
    $type = 'Complex';
    break;
}
$response = json_decode(str_replace("'", '"', $_POST['response']));
$total_time_array = array();
$left_time_array = array();
$right_time_array = array();

// detail record
$detail_file_path = $_SERVER['DOCUMENT_ROOT'].'/_record/'.str_replace('-', '_', $_POST['mode']).
                    '/detail/'.date('Ymd_Hi_').$_POST['tester'].'.csv';
$detail_file_content = '';
$detail_file_content .= "Tester: ".$_POST['tester']."\n";
$detail_file_content .= "Test Date: ".date('Y-m-d H:i')."\n";
$detail_file_content .= "Test Mode: ".str_replace('-', ' ', $_POST['mode'])."\n";
$detail_file_content .= "Test Type: ".$type."\n";
$detail_file_content .= "Test Round: ".($_POST['total_set'] * 30)."\n";
$detail_file_content .= "Test Result:\n";
$detail_file_content .= "No.,Side,Answer,Response Time\n";
$serial = 0;
$left_correct = 0;
$right_correct = 0;
$left_wrong = 0;
$right_wrong = 0;
$left_time = 0;
$right_time = 0;
foreach ($response as $record) {
    $serial++;
    if ($record[0] == 'left') {
        if ($record[1] == 'c') {
            $left_correct++;
        } else {
            $left_wrong++;
        }
        $left_time += $record[2];
        $left_time_array[] = $record[2];
    } else {
        if ($record[1] == 'c') {
            $right_correct++;
        } else {
            $right_wrong++;
        }
        $right_time += $record[2];
        $right_time_array[] = $record[2];
    }
    $detail_file_content .= "$serial,".$record[0].",".$record[1].",".($record[2] / 1000)."\n";
}
file_put_contents($detail_file_path, $detail_file_content);

// statistics record
$record_file_path = $_SERVER['DOCUMENT_ROOT'].'/_record/'.str_replace('-', '_', $_POST['mode']).
                    '/test_result.csv';
$record_file_content = '';
if (!file_exists($record_file_path)) {
    $record_file_content .= ucfirst(str_replace('-', ' ', $_POST['mode']))."\n";
    $record_file_content .= "Tester,".
                            "Test Date,".
                            "Round,".
                            "Click-Left,".
                            "Click-Right,".
                            "Correct,".
                            "Correct-Left,".
                            "Correct-Right,".
                            "Correctness(%),".
                            "Correctness(%)-Left,".
                            "Correctness(%)-Right,".
                            "Average Response Time,".
                            "Average Response Time-Left,".
                            "Average Response Time-Right,".
                            "Standard Deviation,".
                            "Standard Deviation-Left,".
                            "Standard Deviation-Right\n";
}
$total_round      = $left_correct + $left_wrong + $right_correct + $right_wrong;
$left_round       = $left_correct + $left_wrong;
$right_round      = $right_correct + $right_wrong;
$total_correct    = $left_correct + $right_correct;
$total_percentage = 100 * $total_correct / $total_round;
$left_percentage  = $left_round > 0 ? (100 * $left_correct / $left_round) : 0;
$right_percentage = $right_round > 0 ? (100 * $right_correct / $right_round) : 0;
$total_time       = $left_time + $right_time;
$total_time_array = array_merge($left_time_array, $right_time_array);
$total_average    = $total_time / $total_round;
$left_average     = array_sum($left_time_array) / ($left_correct + $left_wrong);
$rigth_average    = array_sum($right_time_array) / ($right_correct + $right_wrong);
$record_file_content .= $_POST['tester'].",".
                        date('Y-m-d H:i').",".
                        "$total_round,".
                        "$left_round,".
                        "$right_round,".
                        "$total_correct,".
                        "$left_correct,".
                        "$right_correct,".
                        "$total_percentage,".
                        "$left_percentage,".
                        "$right_percentage,".
                        ($total_average / 1000).",".
                        ($left_average / 1000).",".
                        ($rigth_average / 1000).",".
                        (get_standard_deviation($total_average, $total_time_array) / 1000).",".
                        (get_standard_deviation($left_average, $left_time_array) / 1000).",".
                        (get_standard_deviation($rigth_average, $right_time_array) / 1000)."\n";
file_put_contents($record_file_path, $record_file_content, FILE_APPEND)."\n";
?>
<title>Test Result</title>
<h3>Hi, <?php echo $_POST['tester']; ?></h3>
<p>It's over, thanks.</p>
<?php
include 'footer.php';
?>