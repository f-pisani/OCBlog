<?php
spl_autoload_register(function($class){
	$autoload_path = '../'.  str_replace('\\', '/', $class) .".php";

	if(file_exists($autoload_path))
		require_once($autoload_path);
});
