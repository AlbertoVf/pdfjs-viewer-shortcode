<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<?php session_start(); ?>
<?php
if (!isset($_POST['no'])) {
    unlink($_SESSION['new'] . 'temp');
    echo "<div class='container p-4 alert alert-danger' role='alert'><span class='alert-link'>Error:</span> El archivo no ha sido subido</div>";
}
?>