<?php
$carpeta_docs = '/docs/'; //carpeta para guardar los documentos
$ruta_docs = seleccionar_web() . $carpeta_docs; //ruta completa

function seleccionar_almacenamiento($ruta)
{
    global $carpeta_docs;
    if (is_dir($ruta)) {
        if ($dh = opendir($ruta)) {
            while (($file = readdir($dh)) !== false) {
                if (is_dir($ruta . $file) && $file != "." && $file != ".." && $file != "\$RECYCLE.BIN" && $file != "System Volume Information") {
                    $cadena = explode($carpeta_docs, $ruta . $file);
                    echo "<option value='" . $ruta . $file . "'>" . $cadena[1] . "</option>";
                    array_map('unlink', glob($ruta . $file . "/*.pdftemp")); //eliminar temporales
                    seleccionar_almacenamiento($ruta . $file . "/");
                }
            }
            closedir($dh);
        }
    }
}

function seleccionar_web()
{
    $ruta = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $ruta = $_SERVER['DOCUMENT_ROOT'] . '/' . $ruta[1];
    return $ruta;
}

function subir($t, $a)
{
    global $carpeta_docs;
    $ok = "<div class='container alert alert-success' role='alert'>Archivo subido. Copia el siguiente texto para mostrar un enlace al pdf: <span class='alert-link'>[pdfjs-viewer url=" . explode($carpeta_docs, $a)[1] . "]</span></div>";
    $error = "<div class='container alert alert-danger' role='alert'><span class='alert-link'>Error:</span> El archivo no ha sido subido</div>";
    echo (move_uploaded_file($t, $a)) ? $ok : $error;
}
