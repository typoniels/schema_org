<?php

namespace CodingMs\SchemaOrg\ViewHelpers;

/***************************************************************
 *
 * Copyright notice
 *
 * (c) 2019 Thomas Deuling <typo3@coding.ms>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DateTime;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use UnexpectedValueException;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;

class VideoViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('file', 'object', 'File', true);
    }

    /**
     * Render a given media file
     *
     * @return string Rendered tag
     * @throws UnexpectedValueException
     */
    public function render()
    {
        $tag = '';
        $file = $this->arguments['file'];
        // get Resource Object (non ExtBase version)
        if (is_callable([$file, 'getOriginalResource'])) {
            // We have a domain model, so we need to fetch the FAL resource object from there
            $file = $file->getOriginalResource();
        }
        if (!($file instanceof FileInterface || $file instanceof AbstractFileFolder)) {
            throw new UnexpectedValueException(
                'Supplied file object type ' . get_class($file) . ' must be FileInterface or AbstractFileFolder.',
                1454252193
            );
        }
        $json = GeneralUtility::getUrl(
            'https://noembed.com/embed?url=https://www.youtube.com/watch?v=' . $file->getContents()
        );
        $jsonArray = json_decode($json, true);
        if (is_array($jsonArray)) {
            $creationDate = new DateTime();
            $creationDate->setTimestamp($file->getCreationTime());
            $schemaArray = [
                '@context' => 'https://schema.org',
                '@type' => 'VideoObject',
                'contentURL' => $jsonArray['url'],
                'description' => $file->getProperty('description') ?  $file->getProperty('description') : $jsonArray['title'],
                'name' => $jsonArray['title'],
                'thumbnailUrl' => $jsonArray['thumbnail_url'],
                'uploadDate' => $creationDate->format('c'),
            ];
            $schemaJson = json_encode($schemaArray, JSON_PRETTY_PRINT | JSON_HEX_TAG);
            $tag = '<script type="application/ld+json">' . $schemaJson . '</script>';
        }
        return $tag;
    }

}
