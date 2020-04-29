<?php

namespace CodingMs\SchemaOrg\Controller;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * AddressController
 */
class SchemaController extends ActionController
{

    /**
     * Inject
     *
     * @return void
     */
    public function injectAction()
    {
        if(isset($this->settings['page'])) {
            $pageSchema = $this->parseSettings($this->settings['page']);
            $pageSchema['@context'] = 'http://www.schema.org';
            $json = json_encode($pageSchema);
            $this->response->addAdditionalHeaderData('<script type="application/ld+json">' . $json . '</script>');
        }
    }

    /**
     * @param $settings
     * @return array
     */
    protected function parseSettings($settings)
    {
        $pageSchema = [];
        foreach ($settings as $key => $item) {
            if(is_array($item)) {
                if(isset($item['ARRAY'])) {
                    $pageSchema[$key] = GeneralUtility::trimExplode(',', $item['ARRAY'], true);
                }
                else {
                    $tempArray = $this->parseSettings($item);
                    if(!empty($tempArray)) {
                        $pageSchema[$key] = $tempArray;
                    }
                }
            }
            else {
                if(trim($item) !== '') {
                    if($key == 'type') {
                        $key = '@type';
                    }
                    $pageSchema[$key] = $item;
                }
            }
        }
        return $pageSchema;
    }

}
