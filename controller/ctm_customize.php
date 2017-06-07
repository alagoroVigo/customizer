<?php

/*
 * @author Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @copyright 2017, Alagoro. All Rights Reserved. 
 */

/**
 * Description of inmo_
 *
 * @author alagoro
 */
class ctm_customize extends fs_controller {

    private $customizer_setup;

    public function __construct() {
        parent::__construct(__CLASS__, 'customize', 'admin', FALSE, TRUE);
    }

    protected function private_core() {

        $camino = 'images/favicon.ico';

        $files = $_FILES;

        if(!is_dir('images')){
            $this->new_message('No existe carpeta images. Creando...');
            if(!mkdir('images')){
                $this->new_error_msg('Error no se pudo crear carpeta images.');
            }
        }        
        
        if (isset($files['favicon'])) {
            $fichero = $files['favicon'];
            $filename = tempnam(sys_get_temp_dir(), 'icono' . '_');
            move_uploaded_file($fichero['tmp_name'], $filename);

            if (file_exists($filename)) {
                if (file_exists($camino)) {
                    if (file_exists($camino . '_old')) {
                        if (!unlink($camino . '_old')) {
                            $this->new_error_msg('Error al eliminar .old.');
                        }
                    }
                    if (!rename($camino, $camino . '_old')) {
                        $this->new_error_msg('Error al copiar .ico a old.');
                    }
                }
                if (copy($filename, $camino)) {
                    $this->new_message('Fichero copiado correctamente.');

                    if(file_exists($camino)){
                        unlink($filename);
                    }
                } else {
                    $this->new_error_msg('Error al renombrar.');
                }
            }
        }
    }

}