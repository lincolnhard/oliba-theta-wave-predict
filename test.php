<?php 
include 'header.php';

switch ($_POST['mode']) {
case 'sharp-and-round':
    $prefix_1                     = $_SERVER['DOCUMENT_ROOT'].'/_data/sharp/';
    $prefix_2                     = $_SERVER['DOCUMENT_ROOT'].'/_data/round/';
    $rule_1                       = '哪張圖較 "尖"?';
    $rule_2                       = '哪張圖較 "圓"?';
    $rest_content_1               = '"尖圓測試" 本實驗將請您依照指示進行選擇，請依照： (odd)';
    $rest_content_2               = '"尖圓測試" 本實驗將請您依照指示進行選擇，請依照： (even)';
    $upset_content                = '你做的速度跟準確程度比其他人還要低，請在提升速度跟準確度，打起精神!';
    $the_second_last_rest_content = '"尖圓測試" the second last rest content';
    $rule_complex_1               = '"尖" -> "圓" -> "尖" -> "圓" -> ...進行挑選，謝謝～';
    $the_last_rest_content        = '"尖圓測試" the last rest content';
    $rule_complex_2               = '"圓" -> "尖" -> "圓" -> "尖" -> ...進行挑選，謝謝～';
    break;
case 'mood-distingulish':
    $prefix_1                     = $_SERVER['DOCUMENT_ROOT'].'/_data/positive/';
    $prefix_2                     = $_SERVER['DOCUMENT_ROOT'].'/_data/negative/';
    $rule_1                       = 'Which picture is "Positive"?';
    $rule_2                       = 'Which picture is "Negative"?';
    $rest_content_1               = '"mood distingulish" rest content (odd)';
    $rest_content_2               = '"mood distingulish" rest content (even)';
    $upset_content                = 'You sucks!';
    $the_second_last_rest_content = '"mood distingulish" the second last rest content';
    $rule_complex_1               = '"Positive" -> "Negative" -> "Positive" -> "Negative" -> ...';
    $the_last_rest_content        = '"mood distingulish" the last rest content';
    $rule_complex_2               = '"Negative" -> "Positive" -> "Negative" -> "Positive" -> ...';
    break;
}

$pool_1 = array();
foreach (glob($prefix_1.'*') as $filename) {
    $pool_1[] = str_replace($prefix_1, '', $filename);
}
$pool_2 = array();
foreach (glob($prefix_2.'*') as $filename) {
    $pool_2[] = str_replace($prefix_2, '', $filename);
}
?>
<audio id="music-obj" src="/_asset/music/music_1.mp3" loop></audio>
<h3>&nbsp;</h3>
<div id="test-section" style="display: none;">
    <div style="clear: both; margin-top: 100px;">
        <a id="left-link" class="answer-link" data-tag="">
            <img src="" style="width: 270px; height: 270px;" />
        </a>
        <a id="right-link" class="answer-link" data-tag="">
            <img src="" style="width: 270px; height: 270px; float: right;" />
        </a>
        <div style="clear: both; margin-bottom: 10px;"></div>
        <img id="left-pointer" src="/_asset/img/pointer.png" style="width: 50px; margin-left: 110px; display: none;" />
        <img id="right-pointer" src="/_asset/img/pointer.png" style="width: 50px; margin-right: 110px; float: right; display: none;" />
        <div style="clear: both;"></div>
    </div>
</div>
<div id="rest-section-1" style="display: none;">
    <p><?php echo $rest_content_1; ?></p>
    <p><?php echo $rule_1; ?></p>
    <button type="button" class="btn btn-primary btn-lg pull-right rest-btn">Continue</button>
    <div style="clear: both;"></div>
</div>
<div id="rest-section-2" style="display: none;">
    <p><?php echo $rest_content_2; ?></p>
    <p><?php echo $rule_2; ?></p>
    <button type="button" class="btn btn-primary btn-lg pull-right rest-btn">Continue</button>
    <div style="clear: both;"></div>
</div>
<div id="upset-section" style="display: none;">
    <p><?php echo $upset_content; ?></p>
    <button type="button" class="btn btn-primary btn-lg pull-right upset-btn">Continue</button>
    <div style="clear: both;"></div>
</div>
<div id="the-second-last-rest-section" style="display: none;">
    <p><?php echo $the_second_last_rest_content; ?></p>
    <p class="rule-1-text" style="display: none;"><?php echo $rule_1; ?></p>
    <p class="rule-2-text" style="display: none;"><?php echo $rule_2; ?></p>
    <p class="rule-complex-text" style="display: none;"><?php echo $rule_complex_1; ?></p>
    <button type="button" class="btn btn-primary btn-lg pull-right rest-btn">Continue</button>
    <div style="clear: both;"></div>
</div>
<div id="the-last-rest-section" style="display: none;">
    <p><?php echo $the_last_rest_content; ?></p>
    <p class="rule-1-text" style="display: none;"><?php echo $rule_1; ?></p>
    <p class="rule-2-text" style="display: none;"><?php echo $rule_2; ?></p>
    <p class="rule-complex-text" style="display: none;"><?php echo $rule_complex_2; ?></p>
    <p><?php echo $rule_complex; ?></p>
    <button type="button" class="btn btn-primary btn-lg pull-right rest-btn">Continue</button>
    <div style="clear: both;"></div>
</div>
<form id="test-form" action="/test-result.php" method="post">
    <input type="hidden" name="tester" value="<?php echo $_POST['tester']; ?>" />
    <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>" />
    <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>" />
    <input type="hidden" name="total_set" value="<?php echo $_POST['total_set']; ?>" />
    <input type="hidden" name="response" />
</form>
<script>
$(document).ready(function() {

    var pool_1 = ["<?php echo implode('", "', $pool_1); ?>"];
    var pool_2 = ["<?php echo implode('", "', $pool_2); ?>"];
    var prefix_1 = "<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $prefix_1); ?>";
    var prefix_2 = "<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $prefix_2); ?>";
    var start_time;
    var counter = 0;
    var set = 1;
    var type = <?php echo $_POST['type']; ?>;
    var response = [];
    var current_rule = 1;
    var previous_wrong = false;
    var side = '';
    var endConfirm = false;

    function init() {
        if (type == 2) {
            current_rule = 2;
        }
        if (<?php echo $_POST['total_set']; ?> == 2) {
            if (type == 4) {
                $('.rule-complex-text').show();
            } else if (type == 3) {
                $('.rule-complex-text').text('<?php echo $rule_complex_1; ?>');
                $('.rule-complex-text').show();
            } else {
                $('.rule-' + current_rule + '-text').show();
            }
            $('#the-second-last-rest-section').show();
            var music_obj = document.getElementById('music-obj');
            music_obj.play();
        } else {
            if (type == 3) {
                $('#rest-section-1 > p:nth-child(2)').text('<?php echo $rule_complex_1; ?>');
            }
            $('#rest-section-' + current_rule).show();
        }
    }

    function render_pictures() {
        var random_1 = Math.floor((Math.random() * (pool_1.length - 1)));
        var random_2 = Math.floor((Math.random() * (pool_2.length - 1)));
        if (current_rule == 1) {
            tag_1 = 'c';
            tag_2 = 'w';
        } else {
            tag_1 = 'w';
            tag_2 = 'c';
        }
        if (Math.floor((Math.random() * 2) + 1) == 1) {
            $('#left-link').attr('data-tag', tag_1);
            $('#left-link > img').attr('src', prefix_1 + pool_1[random_1]);
            $('#right-link').attr('data-tag', tag_2);
            $('#right-link > img').attr('src', prefix_2 + pool_2[random_2]);
        } else {
            $('#left-link').attr('data-tag', tag_2);
            $('#left-link > img').attr('src', prefix_2 + pool_2[random_2]);
            $('#right-link').attr('data-tag', tag_1);
            $('#right-link > img').attr('src', prefix_1 + pool_1[random_1]);
        }

        $('#left-pointer').hide();
        $('#right-pointer').hide();
        // if (set > <?php echo $_POST['total_set'] - 2; ?> && previous_wrong) {
        if (previous_wrong) {
            if ($('#left-link').attr('data-tag') == 'c') {
                $('#left-pointer').show();
            } else {
                $('#right-pointer').show();
            }
            previous_wrong = false;
        }

        d = new Date();
        start_time = d.getTime();
        delete d;
    }

    function hide_rest_sections() {
        $('#rest-section-1').hide();
        $('#rest-section-2').hide();
        $('#upset-section').hide();
        $('#the-second-last-rest-section').hide();
        $('#the-last-rest-section').hide();
    }

    $(document.body).on('keydown', function(e) {
        var keyCode = e.keyCode ? e.keyCode : e.charCode;
        if (endConfirm && keyCode == 16) {
            $('input[name="response"]').val(JSON.stringify(response).replace(/\"/g, "'"));
            $('#test-form').submit();
        }
        endConfirm = false;
        if (keyCode == 90) {
            $('#left-link').click();
        } else if (keyCode == 191) {
            $('#right-link').click();
        } else if (keyCode == 16) {
            endConfirm = true;
        }
    });

    $(document.body).on('click', '.answer-link', function() {
        if ($('#test-section').css('display') != 'none') {
            counter++;
            d = new Date();
            var response_time = d.getTime() - start_time;
            delete d;
            if ($(this).attr('data-tag') == 'w') {
                $('#alert-light').hide().show().fadeOut(80);
                // if (set > <?php echo $_POST['total_set'] - 2; ?>) {
                    previous_wrong = true;
                // }
            }
            if ($(this).attr('id') == 'left-link') {
                side = 'left';
            } else {
                side = 'right';
            }
            response.push([side, $(this).attr('data-tag'), response_time]);
            if (counter >= 120) {
                counter = 0;
                if (set == <?php echo $_POST['total_set']; ?>) {
                    $('input[name="response"]').val(JSON.stringify(response).replace(/\"/g, "'"));
                    $('#test-form').submit();
                } else if (set == <?php echo $_POST['total_set'] - 1; ?>) {
                    $('#test-section').hide();
                    if (type == 4) {
                        current_rule = 2;
                    } else if (type == 3) {
                        current_rule = 1;//current_rule == 1 ? 2 : 1;
                    }
                    $('.rule-1-text').hide();
                    $('.rule-2-text').hide();
                    $('.rule-complex-text').hide();
                    if (type == 4) {
                        $('.rule-complex-text').show();
                    } else if (type == 3) {
                        $('.rule-complex-text').text('<?php echo $rule_complex_1; ?>');
                        $('.rule-complex-text').show();
                    } else {
                        $('.rule-' + current_rule + '-text').show();
                    }
                    $('#the-last-rest-section').show();
                    var music_obj = document.getElementById('music-obj');
                    music_obj.play();
                    previous_wrong = false;
                    set++;
                } else if (set == <?php echo $_POST['total_set'] - 2; ?>) {
                    $('#test-section').hide();
                    if (type == 4) {
                        current_rule = 1;
                    } else if (type == 3) {
                        current_rule = 1;//current_rule == 1 ? 2 : 1;
                    }
                    $('.rule-1-text').hide();
                    $('.rule-2-text').hide();
                    $('.rule-complex-text').hide();
                    if (type >= 3) {
                        $('.rule-complex-text').show();
                    } else {
                        $('.rule-' + current_rule + '-text').show();
                    }
                    $('#upset-section').show();
                    var music_obj = document.getElementById('music-obj');
                    music_obj.play();
                    previous_wrong = false;
                    set++;
                } else if (set % 2 == 1) {
                    $('#test-section').hide();
                    if (type == 4) {
                        current_rule = 2;
                    } else if (type == 3) {
                        $('#rest-section-' + current_rule + ' > p:nth-child(1)').text('<?php echo $rest_content_1; ?>');
                        $('#rest-section-' + current_rule + ' > p:nth-child(2)').text('<?php echo $rule_complex_1; ?>');
                    }
                    $('#rest-section-' + current_rule).show();
                    set++;
                } else {
                    $('#test-section').hide();
                    if (type > 2) {
                        current_rule = 1;
                        if (type == 3) {
                            $('#rest-section-' + current_rule + ' > p:nth-child(1)').text('<?php echo $rest_content_1; ?>');
                        }
                    }
                    $('#rest-section-' + current_rule).show();
                    set++;
                }
            } else {
                if (set > <?php echo $_POST['total_set'] - 2; ?> && type == 4) {
                    if (current_rule == 1) {
                        current_rule = 2;
                    } else {
                        current_rule = 1;
                    }
                } else if (type == 3) {
                    if (current_rule == 1) {
                        current_rule = 2;
                    } else {
                        current_rule = 1;
                    }
                }
                render_pictures();
            }
        }
    });

    $(document.body).on('click', '.rest-btn', function() {
        hide_rest_sections();
        render_pictures();
        $('#test-section').show();
    });

    $(document.body).on('click', '.upset-btn', function() {
        hide_rest_sections();
        $('#the-second-last-rest-section').show();
    });

    init();

});
</script>
<?php
include 'footer.php';
?>