<?php

class Autoload {
    static function load($clase) {
        $carpetas = array(
            '/',
            '/controladores/',
            '/datos/',
            '/doctrine/',
            '/gestores/',
            '/modelos/',
            '/rest/'
        );
        foreach($carpetas as $carpeta){
            $archivo = __DIR__ . $carpeta .  $clase . '.php';
            if(file_exists($archivo)){
                require_once $archivo;
                return;
            }
        }
    }
}

spl_autoload_register('Autoload::load');