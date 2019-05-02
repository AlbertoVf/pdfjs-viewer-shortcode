<?php
include_once('../pdfjs-insert.php');
$a = $_POST['categorias-select'] . '/' . $_POST['filename'] . '.pdf';
$t = $_FILES['archivo']['tmp_name'];
$_SESSION['temp'] = $t;
$_SESSION['new'] = $a;

if (!file_exists($a)) {
    subir_pdf($t, $a);
} else {
    move_uploaded_file($t, $a . 'temp'); ?>
    <script>
        $('#form').attr('hidden', true);
    </script>
    <form method="POST" action="si.php">
        <div class="container">
            <p class="alert alert-warning">El fichero existe. ¿Deseas reemplazarlo?</p>
            <button class="btn btn-success" type="submit" id="si">Si</button>
        </div>
    </form>
    <form method="POST" action="no.php">
        <div class="container">
            <button class="btn btn-success" type="submit" id="no">no</button>
        </div>
    </form>
<?php } ?>