<?php
if ($_SERVER['REQUEST_URI'] != '/index.php') {
    if (   empty($_POST['tester'])
        || empty($_POST['mode'])
    ) {
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script src="/_asset/js/jquery.js"></script>
        <link href="/_asset/css/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/_asset/css/main.css" rel="stylesheet">
    </head>
    <body>
        <span id="alert-light"></span>
        <div style="position: fixed; width: 100%;">
            <div id="container">