<?php

trimbom_recursion("./");
    
 function trimbom_recursion($path) {
    $flag = FilesystemIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO;
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, $flag),RecursiveIteratorIterator::CHILD_FIRST);
    foreach($objects as $value) {
        $realpath = $value->getRealpath();
        $value->isFile() ? var_dump(checkBOM($value)) : true;
    }
}

   function checkBOM ($filename, $auto = true) {
        $contents = file_get_contents($filename);
        $charset[1] = substr($contents, 0, 1);
        $charset[2] = substr($contents, 1, 1);
        $charset[3] = substr($contents, 2, 1);
        if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
            if ($auto == 1) {
                $rest = substr($contents, 3);
                file_put_contents($filename, $rest);
                return ("<font color=red>BOM found, automatically removed.</font>");
            } else {
                return ("<font color=red>BOM found.</font>");
            }
        }
        else return ("BOM Not Found.");
    }
