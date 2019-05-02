<?php session_start();?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subir Pdf</title>
    <?php include_once 'pdfjs-rutas.php'; ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
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
</head>

<body>
    <div id="container" class="container p-4">
        <form id="form" action="sobreescribir/index.php" method="POST" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="listas">Lista</label>
                </div>
                <select class="custom-select" id="listas">
                    <option value=" " selected>Selecciona...</option>
                    <option value="LP_admitidos">Lista provisional de admitidos</option>
                    <option value="LD_admitidos">Lista definitiva de admitidos</option>
                    <option value="LP_seleccionados">Lista provisional de seleccionados</option>
                    <option value="LD_seleccionados">Lista definitiva de seleccionados</option>
                </select>
            </div>
            <!-- Seleccionar un fichero para subir -->
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input id="archivo" class="form-control-file" type="file" name="archivo" accept=".pdf">
                </div>
            </div>
            <!-- Cambiar el nombre. nombre con el que se guardara -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nuevo nombre</span>
                </div>
                <input type="text" name="filename" class="form-control" id="file-name" readonly>
            </div>
            <!-- Carpeta para almacenar los pdf de una categoria/subcategoria-->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="categorias-select">Selecciona una Categoria</label>
                </div>
                <select class="custom-select" id="categorias-select" name="categorias-select">
                    <?php seleccionar_almacenamiento($ruta_docs); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success" id="aceptar" hidden>Aceptar</button>
        </form>
    </div>
</body>

</html>