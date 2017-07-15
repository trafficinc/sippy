<?php
/**
 * Sippy 2.0
 * Quick and Dirty Tasks
 * Usage: $ php bin/sippy.php [options]
 *
 * todos: clear logs??, generate auth library
 *
 */

error_reporting(0);

define('BASE_DIR', dirname(__DIR__));

//require 'actions/Clear.php';

$arguments = array_slice($argv, 1);
$flags = [];

//all main commands need a ':'
$mainCommand = '';
foreach ($arguments as $id) {
    if (strpos($id, ':') !== false) {
        /** @var string $mainCommand */
        $mainCommand = $id;
    }
    if (strpos($id, '-') !== false) {
        /** @var array $flags */
        $flags[] = $id;
    }

}

if (!empty($mainCommand)) {
    $command = explode(":", $mainCommand);

    /* *
     * Check set URL
     * */

    if ($command[0] === 'check') {
        if ($command[1] === 'url') {
            include(BASE_DIR. DIRECTORY_SEPARATOR. 'Application/config/config.php');
            echo $config['base_url'] ."\n";
        }
    }
    
    //    Add more main commands


}

if (!empty($flags)) {
    foreach ($flags as $flag) {
        $flag = str_replace("-", '', $flag);

        if ($flag === 'help') {
            echo <<<USAGE
$ php bin/sippy.php [options]          \r
------------ Options ----------------- \r
check:url         Show current set URL \r
-help             help                 \n
USAGE;
        }

//    Add more flags

    }
}
