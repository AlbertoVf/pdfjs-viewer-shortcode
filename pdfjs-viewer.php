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
        var rutaActual = window.location.href;
        rutaActual = rutaActual.split('/');
        var t = screen.width / 3;
        var l = screen.height / 3;
        $('#pdf-viewer').click(() => {
            window.open(rutaActual[0] + '//' + rutaActual[2] + '/' + rutaActual[3] + '/wp-content/plugins/pdfjs-viewer-shortcode/lib/pdfjs-insert.php', "Subir PDF", "left=" + t + ", top=" + l + ", height=320,width=700");
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

if (is_admin()) {
 add_action('admin_bar_menu', 'pdfjs_media_button', 25);
}
function pdfjs_media_button()
{
    //echo  '<button id="pdf-viewer">PDF Viewer</button>';
    echo ('<div class="mt-2 mr-2 mb-2 ml-2 d-flex"> <button id="pdf-viewer" class="btn btn-dark">PDF Viewer</button> </div>');
}
?>