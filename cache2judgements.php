<?php

$years = array('1997', '1998', '1999', '2002', '2004', '2005', '2007', '2011');

$command = '/usr/bin/ruby ' . __DIR__ . '/judgements_html2json.rb';

foreach ($years AS $year) {
    $yPath = __DIR__ . '/cache/' . $year;
    $yFh = opendir($yPath);
    while (false !== ($m = readdir($yFh))) {
        if ($m !== '.' && $m !== '..') {
            $mPath = $yPath . '/' . $m;
            $mFh = opendir($mPath);
            while (false !== ($d = readdir($mFh))) {
                if ($d !== '.' && $d !== '..') {
                    $targetPath = __DIR__ . "/cache/jrf_data_judgements/{$year}/{$m}/{$d}";
                    if (!file_exists($targetPath)) {
                        mkdir($targetPath, 0777, true);
                    }
                    foreach (glob($mPath . '/' . $d . '/case_*') AS $caseFile) {
                        exec("{$command} {$caseFile} {$targetPath}");
                    }
                }
            }
        }
    }
}