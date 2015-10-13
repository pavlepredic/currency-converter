<?php

// fix encoding issue while running text on different host with different locale configuration
setlocale(LC_ALL, 'en_US.UTF-8');

if (file_exists($file = __DIR__.'/autoload.php')) {
    require_once $file;
} elseif (file_exists($file = __DIR__.'/autoload.php.dist')) {
    require_once $file;
}
