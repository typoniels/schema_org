<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'CodingMs.schema_org',
    'Schema',
    [
        'Schema' => 'inject',
    ],
    // non-cacheable actions
    [
        //'Address' => '',
    ]
);
