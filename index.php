<?php

if ($_SERVER['ENVIRONMENT'] !== strtolower('PROD')) {
    define('SERVER_DB', 'localhost'); // ENTORNO de DESARROLLO [dev] 
    define('PORT_DB', 3310);
    define('DATABASE_NAME', 'store');
    define('USER_DB', 'root');
    define('PASSWORD_DB', 'MH124');
} else {
    define('SERVER_DB', ''); // ENTORNO de PRODUCCIÓN [prod] 
    define('PORT_DB', 3307);
    define('DATABASE_NAME', '');
    define('USER_DB', '');
    define('PASSWORD_DB', '');
}

define('DSN_DB', 'mysql:host=' . SERVER_DB . ':' . @strval(PORT_DB) . ';dbname=' . DATABASE_NAME . ';charset=utf8');
define('KEY_CRYPT', '+++');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

require_once __DIR__ . '/vendor/autoload.php';
use Steampixel\Route;

//Ver todas las tiendas disponibles
Route::add('/ClothingStore_Branch/v1/ViewBranchs/', function() {
    require_once "./controller/01.Controller_GET.php";
    $View = new ClothingStore_Branch_GET();
    $View->ViewBranches();
}, 'GET');
//Ver una tienda segun su id
Route::add('/ClothingStore_Branch/v1/ViewBranchs/Id/(\d+)/', function($Id) {
    require_once "./controller/01.Controller_GET.php";
    $ViewId = new ClothingStore_Branch_GET();
    $ViewId -> ViewBRanchId($Id);
}, 'GET');


//Crear una tienda nueva
Route::add('/ClothingStore_Branch/v1/CreateBranchs/',function(){
    require_once "./controller/02.Controller_POST.php";
    // Recibir datos del cuerpo de la solicitud POST
    $RecivedData = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400); // Bad Request
        die(json_encode(array('message' => 'JSON inválido')));
    }

    $RecivedData1 = [
        //'Id_' => FILTER_SANITIZE_NUMBER_INT,
        'NameBranch_' => FILTER_SANITIZE_SPECIAL_CHARS,
        'Street_' => FILTER_SANITIZE_SPECIAL_CHARS,
        'Description_' => FILTER_SANITIZE_SPECIAL_CHARS ,
    ];

    $RecivedData = filter_var_array($RecivedData,$RecivedData1);

    if(!(   isset($RecivedData['NameBranch_'])&&
            isset($RecivedData['Street_'])
    )){
        http_response_code(403);
        die(json_encode(array('msg' => 'Parametros no apropiados')));
    }

    $InsertBranch_ = new ClothingStore_Branch_POST();
    $InsertBranch_ -> CreateBranch(
        $RecivedData['NameBranch_'],
        $RecivedData['Street_'],
        $RecivedData['Description_'] ?? ''
    );
},'POST');

//Modificar la informacion de una tienda 
Route::add('/ClothingStore_Branch/v1/UpdateBranchs/',function(){

},'PUT');

//Modificar el nombre de la tienda
Route::add('/ClothingStore_Branch/v1/UpdateNameStore/',function(){

},'PATCH');

//Modificar la direccion de la tienda
Route::add('/ClothingStore_Branch/v1/UpdateStreetStore/',function(){

},'PATCH');

//Modificar la descripcion de la tienda
Route::add('/ClothingStore_Branch/v1/UpdateDescriptionStore/',function(){

},'PATCH');

Route::add('/ClothingStore_Branch/v1/__version__/', function() {
    $months_ = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    echo '&mu;Servicio para poder crear sucursales para la tienda <br />UNA / Puno <br />', @strval($months_[4]), '.2024 &mdash; ', $months_[@intval(date("m") - 1)], '.', date("Y"),'<br />  Gabriel Sebastian Lauracio Quispe &mdash; versi&oacute;n ', $_SERVER['SERVER_SOFTWARE'];
}, 'GET');

Route::pathNotFound(function($path) {
    echo '<h1>Error 404 - ["'.$path.'"]<br /> URL/Página no encontrada</h1>';
});

Route::methodNotAllowed(function($path, $method) {
    echo "El método $method no está permitido para la ruta '$path'.";
});

Route::run('/', true, true);
