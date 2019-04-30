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

//==== Shortcode ====
include_once 'lib/pdfjs-rutas.php';

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

//add_action('media_buttons', 'pdfjs_media_button', 12); //boton en pagina
add_action('after_setup_theme', 'pdfjs_media_button');
function pdfjs_media_button()
{
    echo '<div class="wp-menu-name" style="text-align:right; margin:0.5% 20px;">
            <a href="' . plugins_url() . '/pdfjs-viewer-shortcode/lib/pdfjs-insert.php" target="_target" id="insert-pdfjs" class="button">PDF Viewer</a>
        </div>';
}
?>