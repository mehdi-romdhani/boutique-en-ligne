<?php



function my_autoloader($class)
{
    // var_dump($class);
    $class_path = str_replace("\\", "/", $class);
    // var_dump($class);
    $class_path = str_replace("App", "src", $class_path);
    // var_dump($class_path);

    $file = __DIR__ . '/' . $class_path . ".php";
    // var_dump($file);

    // var_dump($class);
    $class_path = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $class_path = str_replace("App", "src", $class_path);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class_path . ".php";

    // var_dump($file);
    if(file_exists($file))
    {
        require_once $file;
    }
}

spl_autoload_register("my_autoloader");