<?php
namespace FluidTYPO3\FluidcontentCore\Hooks;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@wildside.dk>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use FluidTYPO3\Fluidcontent\Service\ConfigurationService;
use TYPO3\CMS\Backend\Wizard\NewContentElementWizardHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * WizardItems Hook Subscriber
 * @package Fluidcontent
 */
class WizardItemsHookSubscriber implements NewContentElementWizardHookInterface {

	/**
	 * @param array $items
	 * @param \TYPO3\CMS\Backend\Controller\ContentElement\NewContentElementController
	 * @return void
	 */
	public function manipulateWizardItems(&$items, &$parentObject) {
		$definitions = array_slice($GLOBALS['TCA']['tt_content']['columns']['list_type']['config']['items'], 1);
		$plugins = $items['plugins'];
		unset($items['forms'], $items['forms_mailform'], $items['forms_search'], $items['plugins_general'], $items['plugins']);
		$items['plugins'] = $plugins;
		foreach ($definitions as $definition) {
			list ($title, $name, $icon) = $definition;
			$index = 'plugins_' . $name;
			$items[$index] =  array(
				'title' => $title,
				'icon' => '../' . substr(GeneralUtility::getFileAbsFileName($icon, FALSE, TRUE), strlen(PATH_site)),
				'description' => '-',
				'tt_content_defValues' => array(
					'list_type' => $name,
				),
				'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=' . $name,
			);
		}
	}

}