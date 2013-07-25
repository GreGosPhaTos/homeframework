#!/usr/bin/env php
<?php

/*
 * FROM SYMFONY 2
 * This file is part of the framework.
 *
 */

set_time_limit(0);

if (!is_dir($vendorDir = dirname(__FILE__).'/vendor')) {
    mkdir($vendorDir, 0777, true);
}

$deps = array(
    array('log4php', 'https://github.com/apache/logging-log4php', '2.3.0'),
    array('doctrine2', 'https://github.com/doctrine/doctrine2.git', '2.3.4'),
);

foreach ($deps as $dep) {
    list($name, $url, $rev) = $dep;

    echo "> Installing/Updating $name\n";

    $installDir = $vendorDir.'/'.$name;
    if (!is_dir($installDir)) {
        system(sprintf('git clone %s %s', escapeshellarg($url), escapeshellarg($installDir)));
    }

    system(sprintf('cd %s && git fetch origin && git reset --hard %s', escapeshellarg($installDir), escapeshellarg($rev)));
}
