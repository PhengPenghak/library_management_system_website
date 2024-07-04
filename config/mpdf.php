<?php
return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font' => 'khmeros',
    'default_font_size' => 12,
    'fontDir' => array_merge((new Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [
        Yii::getAlias('@app/fonts'),
    ]),
    'fontdata' => array_merge((new Mpdf\Config\FontVariables())->getDefaults()['fontdata'], [
        'khmeros' => [
            'R' => 'KhmerOS.ttf',
            'B' => 'KhmerOS.ttf',
        ],
    ]),
    'default_font' => 'khmeros',
];
