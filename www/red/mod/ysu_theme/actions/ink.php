<?php

// Accion de carga de contenidos de Ink

// Accion usada para cargar dinamicamente paginas a ser mostradas en el efecto ink. El JS llama a esta accion pasando un parametro, el nombre de un campo de configuracion cuyo contenido devolvemos como resultado de esta accion. Esto permite editar el contenido de las pantallas de ink directamente desde la configuracion de usuario.

// Carga los campos de configuracion de admin del tema
$settings = elgg_get_plugin_from_id('ysu_theme')->getAllSettings();

// Se carga unicamente del array el elemento que especifica la llamada desde el JS
$setting_field = $settings[get_input('setting_field')];

// Se devuelve como JSON
echo json_encode([
    'page' => $setting_field

]);
