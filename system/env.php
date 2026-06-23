<?php

function sippy_load_env($path) {
    if (! is_file($path)) {
        return;
    }

    $values = parse_ini_file($path, false, INI_SCANNER_RAW);
    if (! is_array($values)) {
        return;
    }

    foreach ($values as $key => $value) {
        if (getenv($key) !== false || isset($_ENV[$key])) {
            continue;
        }

        $_ENV[$key] = $value;
        putenv($key .'='. $value);
    }
}

function sippy_env($key, $default = null) {
    $value = getenv($key);

    if ($value === false && isset($_ENV[$key])) {
        $value = $_ENV[$key];
    }

    if ($value === false || $value === '') {
        return $default;
    }

    $normalized = strtolower($value);
    if ($normalized === 'true') {
        return true;
    }
    if ($normalized === 'false') {
        return false;
    }
    if ($normalized === 'null') {
        return null;
    }

    return $value;
}
