<?php

namespace SysJosSecurity;

use Exception;
use Intervention\Image\ImageManagerStatic as Image;
use GuzzleHttp\Client;

class SysNAND{
    public $jossito = "";
    public $jossito_info = [];
    public $condicion;
    public $directorio = "";
    public $comparador = TRUE;
    private $system_rute;
    private $conexion;
    private Client $client;

    public function __construct(){
        $this->conexion = conect_mysqli();
        $this->system_rute = (__DIR__ . DIRECTORY_SEPARATOR . "../../");
        // Inicializa el cliente HTTP
        $this->client = new Client();
    }

    public function comparar(){
        if($this->condicion == $this->comparador){
            if($this->jossito != ""){
                $jossito_activo = $this->jossito;
                $info_string = implode("," , $this->jossito_info);
                call_user_func_array($jossito_activo, $this->jossito_info);
                return TRUE;
            }else{
                return TRUE;
            }
        }else{
            return FALSE;
        }
    }

    public function comprimir_img(){
        // Directorio con las imágenes originales
        $directorio_originales = $this->system_rute . $this->directorio;
    
        // Directorio donde se guardarán las imágenes reducidas
        if(!is_dir($this->system_rute . "resourses/img_optimizacion/")){
            mkdir($this->system_rute . "resourses/img_optimizacion/", 0777, true);
        }
        $directorio_reducidas = ($this->system_rute . "resourses/img_optimizacion/");
    
        // Calidad deseada para las imágenes reducidas (0-100)
        $calidad = 80;
    
        // Tamaño máximo deseado para las imágenes reducidas (en píxeles)
        $tam_max = 800;
    
        // Obtener todas las imágenes en el directorio principal
        $imagenes_originales_raiz = glob($directorio_originales . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    
        // Iterar sobre cada imagen y reducir su tamaño
        foreach ($imagenes_originales_raiz as $imagen_original_raiz) {
            $imagen_reducida = Image::make($imagen_original_raiz);
            $imagen_reducida->resize($tam_max, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $nombre_archivo = basename($imagen_original_raiz);
            $ruta_destino = $directorio_reducidas . $nombre_archivo;
            $imagen_reducida->save($ruta_destino, $calidad);
        }
    
        // Buscar todas las carpetas en el directorio de originales
        $carpetas_originales = glob($directorio_originales . '*', GLOB_ONLYDIR);
    
        // Iterar sobre cada carpeta y sus imágenes
        foreach ($carpetas_originales as $carpeta_original) {
            // Obtener todas las imágenes en la carpeta actual
            $imagenes_originales = glob($carpeta_original . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    
            // Iterar sobre cada imagen y reducir su tamaño
            foreach ($imagenes_originales as $imagen_original) {
                $imagen_reducida = Image::make($imagen_original);
                $imagen_reducida->resize($tam_max, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $nombre_archivo = basename($imagen_original);
                $ruta_destino = $directorio_reducidas . basename(dirname($imagen_original)) . '/' . $nombre_archivo;
                if (!file_exists(dirname($ruta_destino))) {
                    mkdir(dirname($ruta_destino), 0777, true);
                }
                $imagen_reducida->save($ruta_destino, $calidad);
            }
        }
        return true;
    }

    public function organizar(){
        $extensiones = $this->condicion; //Arreglo de extensiones de archivo a mover
        $carpeta_destino = $this->system_rute . $this->directorio; //Carpeta de destino donde se moverán los archivos
        
        //Recorre cada extensión especificada
        foreach ($extensiones as $extension) {
            $archivos = glob($this->system_rute . "*.$extension"); //Obtiene la lista de archivos con la extensión especificada
            foreach ($archivos as $archivo) {
                $ruta_origen = $archivo; //Ruta de origen del archivo
                $ruta_destino = $carpeta_destino . basename($archivo); //Ruta de destino del archivo
    
                //Mueve el archivo a la carpeta de destino
                rename($ruta_origen, $ruta_destino);
            }
        }
        return true;
    }

    function updateEnvValue($key, $newValue, $filePath = '.env')
    {
        // Verificar si el archivo existe
        $filePath = \JS_ROUTE . $filePath;
        if (!file_exists($filePath)) {
            throw new Exception("El archivo $filePath no existe.");
        }

        // Leer el contenido del archivo
        $envContent = file_get_contents($filePath);

        // Crear un patrón para buscar la línea correspondiente al valor actual
        $pattern = "/^$key=.*$/m";

        // Verificar si la clave existe en el archivo
        if (preg_match($pattern, $envContent)) {
            // Reemplazar la línea existente con el nuevo valor
            $envContent = preg_replace($pattern, "$key=$newValue", $envContent);
        } else {
            // Si no existe, agregar la clave y el valor al final del archivo
            $envContent .= PHP_EOL . "$key=$newValue";
        }

        // Guardar los cambios en el archivo
        file_put_contents($filePath, $envContent);
    }

    public function getLatestVersionName()
    {
        try {
            // Obtén la URL desde el archivo .env
            $updaterUrl = env('UPDATER_URL',"https://jossred.josprox.com/api/version/JosSecurity");

            // Realiza la solicitud HTTP
            $response = $this->client->get($updaterUrl);
            $body = $response->getBody()->getContents();

            // Decodifica el JSON
            $json = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar el JSON: " . json_last_error_msg());
            }

            if (!isset($json['Version'])) {
                throw new Exception("La clave 'Version' no está presente en la respuesta JSON");
            }

            // Devuelve el nombre de la última versión
            return $json;
        } catch (Exception $e) {
            // Manejo de errores
            return "Error: " . $e->getMessage();
        }
    }

}