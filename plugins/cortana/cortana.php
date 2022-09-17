<?php
// =========== https://github.com/tazotodua/useful-php-scripts ========== 
//                                 USAGE:
//     new GoodZipArchive('path/to/input/folder',    'path/to/output_zip_file.zip') ;
// ======================================================================
function cortana(){
  ini_set('max_execution_time', 9000);
  ini_set('memory_limit', '-1');

  # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
  $carpeta = "./respaldos";
  if (!file_exists($carpeta)) {
      mkdir($carpeta);
  }

      # Calcular un ID único
      $id = uniqid();

      # También la fecha
      $fecha = date("Y-m-d");

  $nombre_archivo = sprintf('respaldo_%s_%s.zip',$fecha,$id);
  
   new GoodZipArchive('../',    ''.$carpeta.'/'.$nombre_archivo.'');
  echo "<p align='center'>TERMINADO</p>";
  
  if (file_exists(''.$carpeta.'/'.$nombre_archivo.'')) {
      echo "<center><p>Proceso Finalizado!!</p><a class='btn btn-success' href='".$carpeta."/".$nombre_archivo."'>Descargar</a></center><br>";
    } else {
      echo "<p align='center'>Error, archivo zip no ha sido creado!!</p>";
    }
}
  
  /*
  //ENVIO DE CORREO
	$to = "juliocesarleyvarodriguez@gmail.com";
    $from = "sistemas@jcleyva.site";
    $subject = "Backup " . date("Y-m-d-H-i-s");
    $separator = md5(time());
    $filename = 'respaldo.zip';
    $attachment = chunk_split(base64_encode(file_get_contents("respaldo.zip")));
     
    $headers  = "From: ".$from.PHP_EOL;
    $headers .= "MIME-Version: 1.0".PHP_EOL;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
     
    $body .= "--".$separator.PHP_EOL;
    $body .= "Content-Type: application/octet-stream; name=\"respaldo.zip\"".PHP_EOL;
    $body .= "Content-Transfer-Encoding: base64".PHP_EOL;
    $body .= "Content-Disposition: attachment".PHP_EOL.PHP_EOL;
    $body .= $attachment.PHP_EOL;
    $body .= "--".$separator."--";
 
    if (mail($to, $subject, $body, $headers)) {
        //ELIMINA LOS ARCHIVOS
        unlink("respaldo.zip");
        echo "CORREO ENVIADO";
    }
    else{
        echo "ERROR AL ENVIAR CORREO";
    }

*/

class GoodZipArchive extends ZipArchive 
{
	//@author Nicolas Heimann
	public function __construct($a=false, $b=false) { $this->create_func($a, $b);  }
	
	public function create_func($input_folder=false, $output_zip_file=false)
	{
		if($input_folder !== false && $output_zip_file !== false)
		{
			$res = $this->open($output_zip_file, ZipArchive::CREATE);
			if($res === TRUE) 	{ $this->addDir($input_folder, basename($input_folder)); $this->close(); }
			else  				{ echo 'Could not create a zip archive. Contact Admin.'; }
		}
	}
	
    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    // Add Files & Dirs to archive 
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
      // Read all Files in Dir
        $dir = opendir ($location);
        //echo "<BR> AGREGANDO: " .$location;
        
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
          // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}
?>