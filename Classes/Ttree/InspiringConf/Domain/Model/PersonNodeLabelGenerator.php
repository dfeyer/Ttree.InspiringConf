<?php
namespace Ttree\InspiringConf\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3CR".               *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\AbstractNodeData;
use TYPO3\TYPO3CR\Domain\Model\DefaultNodeLabelGenerator;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * The default node label generator; used if no-other is configured
 *
 * @Flow\Scope("singleton")
 */
class PersonNodeLabelGenerator extends DefaultNodeLabelGenerator {

	/**
	 * Render a node label
	 *
	 * @param \TYPO3\TYPO3CR\Domain\Model\AbstractNodeData $nodeData
	 * @param boolean $crop
	 * @return string
	 */
	public function getLabel(AbstractNodeData $nodeData, $crop = TRUE) {
		if ($nodeData->hasProperty('person') === TRUE && $nodeData->getProperty('person')) {
			$label = 'Link to: ' . strip_tags($nodeData->getProperty('person')->getProperty('personName'));
		} else {
			$label = parent::getLabel($nodeData, FALSE);
		}

		if ($crop === FALSE) {
			return $label;
		}

		$croppedLabel = \TYPO3\Flow\Utility\Unicode\Functions::substr($label, 0, NodeInterface::LABEL_MAXIMUM_CHARACTERS);
		return $croppedLabel . (strlen($croppedLabel) < strlen($label) ? ' …' : '');
	}
}
