<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<?php session_start(); ?>
<?php
if (!isset($_POST['si'])) {
    unlink($_SESSION['new']);
    rename($_SESSION['new'] . 'temp', $_SESSION['new']);
    echo "<div class='container p-4 m-4 alert alert-success' role='alert'>Archivo reemplazado</div>";
} else {
    unlink($_SESSION['new'] . 'temp');
    echo "<div class='container p-4 m-4 alert alert-danger' role='alert'>El archivo no ha sido subido</div>";
}
?>