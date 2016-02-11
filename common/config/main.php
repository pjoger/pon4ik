<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
          'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@app/messages',
                'sourceLanguage' => 'en-US',
                /*'fileMap' => [
                    //'app' => 'app.php',
                    'app' => 'app.po',
                    //'app/error' => 'error.php',
                ],
                 *
                 */
            ],
          ],
        ],
    ],
/*
    // set source language to be English
    'sourceLanguage' => 'en-US',
 *
 */
    // set target language to be Russian
    'language' => 'ru-RU',
];
