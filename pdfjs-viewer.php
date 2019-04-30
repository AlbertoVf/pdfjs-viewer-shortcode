<?php
/*
 * Plugin Name: PDF Viewer
 * Plugin URI: http://byterevel.com/
 * Description: Subir ficheros '.pdf' a una ruta seleccionada
 * Version: 2.0
 * Author: Ben Lawson, Alberto Vázquez
 * Author URI: http://byterevel.com/
 * License: GPLv2
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(() => {
        $('#listas').on('change', () => {
            $('.alert').attr('hidden', true);
            var nombre = $('select#listas option:checked').val();
            $('#file-name').attr('value', nombre);
            (nombre != ' ') ? $('#aceptar').attr('hidden', false): $('#aceptar').attr('hidden', true);
        });
    });
</script>
<?php
//==== Shortcode ====
include_once('lib/pdfjs-rutas.php');

add_shortcode("pdfjs-viewer", "pdfjs_handler");
global $carpeta_docs;
$root_pdf = Site_url() . $carpeta_docs;
function pdfjs_handler($incoming_from_post)
{
    $incoming_from_post = shortcode_atts(array('url' => 'bad-url.pdf', 'viewer_height' => '1360px', 'viewer_width' => '100%', 'fullscreen' => 'true', 'download' => 'true', 'print' => 'true', 'openfile' => 'false'), $incoming_from_post);
    $pdfjs_output = pdfjs_generator($incoming_from_post);
    return $pdfjs_output;
}

function pdfjs_generator($incoming_from_handler)
{
    global $root_pdf;
    $file_name = $root_pdf . $incoming_from_handler["url"];
    $fullscreen = $incoming_from_handler["fullscreen"];
    $download = $incoming_from_handler["download"];
    $print = $incoming_from_handler["print"];
    $openfile = $incoming_from_handler["openfile"];
    if ($download != 'true') $download = 'false';
    if ($print != 'true') $print = 'false';
    if ($openfile != 'true') $openfile = 'false';
    $final_url = str_replace(' ', '-', $file_name);
    $fullscreen_link = '';
    if ($fullscreen == 'true') $fullscreen_link = '<a class="pdf-pdfjs" href="' . $final_url . '">Ver</a><br>';
    return $fullscreen_link;
}
add_action('after_setup_theme', 'pdfjs_media_button'); //BUG: la vista se visualiza en todas las paginas. Modificar para que solo se vea en Back-end;
function pdfjs_media_button()
{
    echo ('<div class="mt-2 mr-4 mb-2 ml-2 d-flex justify-content-end">
        <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#myModal">PDF Viewer</button>
    </div>');
}
?>

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="h5">Subir PDF</p>
                <button type="button" class="close h5" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="container">
                <form id="form" action="lib/sobreescribir/index.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend"> <label class="input-group-text" for="listas">Lista</label></div>
                        <select class="custom-select" id="listas">
                            <option selected value=" ">Selecciona...</option>
                            <option value="LP_admitidos">Lista provisional de admitidos</option>
                            <option value="LD_admitidos">Lista definitiva de admitidos</option>
                            <option value="LP_seleccionados">Lista provisional de seleccionados</option>
                            <option value="LD_seleccionados">Lista definitiva de seleccionados</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="custom-file">
                            <input id="archivo" class="form-control-file" type="file" name="archivo" accept=".pdf">
                        </div>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend"> <span class="input-group-text">Nuevo nombre</span></div>
                        <input type="text" name="filename" class="form-control " id="file-name" readonly>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="categorias-select">Selecciona una Categoria</label>
                        </div>
                        <select class="custom-select" id="categorias-select" name="categorias-select">
                            <?php seleccionar_almacenamiento($ruta_docs) ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" id="aceptar" hidden>Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>