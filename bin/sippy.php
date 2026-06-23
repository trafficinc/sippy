<?php

define('ROOT_DIR', realpath(dirname(__DIR__)) . '/');
define('APP_DIR', ROOT_DIR . 'application/');
define('VIEWS_DIR', APP_DIR . 'views/');

require ROOT_DIR . 'system/Config.php';

$arguments = array_slice($argv, 1);
$command = isset($arguments[0]) ? $arguments[0] : 'help';

switch ($command) {
    case 'check:url':
        $config = Config::getInstance()->getconfig();
        echo $config['base_url'] . "\n";
        break;

    case '-help':
    case '--help':
    case 'help':
        echo <<<USAGE
$ php bin/sippy.php [command]

Commands:
  check:url    Show current configured base URL
  help         Show this help text

USAGE;
        break;

    default:
        fwrite(STDERR, "Unknown command: {$command}\n");
        fwrite(STDERR, "Run `php bin/sippy.php help` for usage.\n");
        exit(1);
}
