<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'CodingMs.' . $_EXTKEY,
	'Schema',
	array(
		'Schema' => 'inject',
	),
	// non-cacheable actions
	array(
		//'Address' => '',
	)
);
