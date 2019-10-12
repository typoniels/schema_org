<?php

defined('TYPO3_MODE') || die('Access denied.');

// Static template
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('schema_org', 'Configuration/TypoScript', 'Schema.org');
