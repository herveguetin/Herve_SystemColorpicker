<?php
/**
 * @category    Herve
 * @package     Herve_SystemColorpicker
 * @copyright   Copyright (c) 2013 Hervé Guétin (http://www.herveguetin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * This code uses ProColor color picker for prototype. See licence below
 */

/**
ProColor licence :

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
THIS SOFTWARE IS PROVIDED BY THE PHANTOM INKER AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class Herve_SystemColorpicker_Block_Adminhtml_System_Config_Form_Field_Colorpicker
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Generate HTML code for color picker
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Include Procolor library JS file which is in [magento_base_dir]/js/herve/systemcolorpicker/procolor-1.0/procolor.compressed.js
        $html = '<script type="text/javascript" src="' . Mage::getBaseUrl('js') . 'herve/systemcolorpicker/procolor-1.0/procolor.compressed.js' .'"></script>';

        // Use Varien text element as a basis
        $input = new Varien_Data_Form_Element_Text();

        // Set data from config element on Varien text element
        $input->setForm($element->getForm())
            ->setElement($element)
            ->setValue($element->getValue())
            ->setHtmlId($element->getHtmlId())
            ->setName($element->getName())
            ->setStyle('width: 60px') // Update style in order to shrink width
            ->addClass('validate-hex'); // Add some Prototype validation to make sure color code is correct

        // Inject uddated Varien text element HTML in our current HTML
        $html .= $input->getHtml();

        // Inject Procolor JS code to display color picker
        $html .= $this->_getProcolorJs($element->getHtmlId());

        // Inject Prototype validation
        $html .= $this->_addHexValidator();

        return $html;
    }

    /**
     * Procolor JS code to display color picker
     *
     * @see http://procolor.sourceforge.net/examples.php
     * @param string $htmlId
     * @return string
     */
    protected function _getProcolorJs($htmlId)
    {
        return '<script type="text/javascript">ProColor.prototype.attachButton(\'' . $htmlId . '\', { imgPath:\'' . Mage::getBaseUrl('js') . 'herve/systemcolorpicker/procolor-1.0/' . 'img/procolor_win_\', showInField: true });</script>';
    }

    /**
     * Prototype validation
     *
     * @return string
     */
    protected function _addHexValidator()
    {
        return '<script type="text/javascript">Validation.add(\'validate-hex\', \'' . Mage::helper('systemcolorpicker')->__('Please enter a valid hex color code') . '\', function(v) {
				return /^#(?:[0-9a-fA-F]{3}){1,2}$/.test(v);
			});</script>';
    }
}
