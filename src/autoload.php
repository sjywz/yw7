<?php
spl_autoload_register('mAutoload');
function mAutoload($class){
    $class = str_replace('\\','/',$class).'.php';
    $classFile = MODULE_ROOT.'/'.$class;
    if(file_exists($classFile)){
        include_once $classFile;
    }
}