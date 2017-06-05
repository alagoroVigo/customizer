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
        $fsvar = new fs_var();
        $this->customizer_setup = $fsvar->array_get(
                array(
            'customizer_sha1' => '',
            'customizer_file' => ''
                ), FALSE);

        $camino = 'view/img/favicon.ico';
        if (file_exists($camino) && ($this->customizer_setup['customizer_sha1'] != '')) {
            $sha1 = sha1_file($camino);
            $sha2 = $this->customizer_setup['customizer_sha1'];

            if ($sha1 !== $sha2) {
                $customizer_file = $this->customizer_setup['customizer_file'];
                if (file_exists($customizer_file)) {
                    $sha3 = sha1_file($this->customizer_setup['customizer_file']);
                    if ($sha2 == $sha3) {
                        if (file_exists($camino . '_old')) {
                            if (!unlink($camino . '_old')) {
                                $this->new_error_msg('Error al eliminar .old.');
                            }
                        }
                        rename($camino, $camino . '_old');
                        if (!copy($customizer_file, $camino)) {
                            $this->new_error_msg('Error al copiar .ico.');
                        }
                    }
                }
            }
        } 


        $files = $_FILES;

        if (isset($files['favicon'])) {
            $fichero = $files['favicon'];
            $filename = tempnam('plugins/customizer/files', 'icono' . '_');
            move_uploaded_file($fichero['tmp_name'], $filename);

            if (file_exists($filename)) {
                if (file_exists($camino)) {
                    if (file_exists($camino . '_old')) {
                        if (!unlink($camino . '_old')) {
                            $this->new_error_msg('Error al eliminar .old.');
                        }
                    }
                    rename($camino, $camino . '_old');
                }
                if (copy($filename, $camino)) {
                    $this->new_message('Fichero copiado correctamente.');

                    $this->customizer_setup['customizer_file'] = $filename;
                    $this->customizer_setup['customizer_sha1'] = sha1_file($filename);
                    $fsvar->array_save($this->customizer_setup);
                    $this->new_message('Datos guardados para futuro' . $filename);
                } else {
                    $this->new_error_msg('Error al renombrar. 9');
                }
            }
        } 
    }

    private function comprobar(){
        $fsvar = new fs_var();
        $this->customizer_setup = $fsvar->array_get(
                array(
            'customizer_sha1' => '',
            'customizer_file' => ''
                ), FALSE);

        $camino = 'view/img/favicon.ico';
        if (file_exists($camino) && ($this->customizer_setup['customizer_sha1'] != '')) {
            $sha1 = sha1_file($camino);
            $sha2 = $this->customizer_setup['customizer_sha1'];
            if ($sha1 !== $sha2) {
                $customizer_file = $this->customizer_setup['customizer_file'];
                if (file_exists($customizer_file)) {
                    $sha3 = sha1_file($this->customizer_setup['customizer_file']);
                    if ($sha2 == $sha3) {
                        if (file_exists($camino . '_old')) {
                            if (!unlink($camino . '_old')) {
                                $this->new_error_msg('Error al eliminar .old.');
                            }
                        }
                        rename($camino, $camino . '_old');
                        if (!copy($customizer_file, $camino)) {
                            $this->new_error_msg('Error al copiar .ico.');
                        }
                    }
                }
            }
        }
        
    }
}
