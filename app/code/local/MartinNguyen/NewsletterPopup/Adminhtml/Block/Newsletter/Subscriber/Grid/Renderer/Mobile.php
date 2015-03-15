<?php


/**
 * Adminhtml newsletter subscribers grid gender item renderer
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Mobile extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
        $value = $row->getSubscriberMobile();
			
		return $value ? $value : '---';
	}
}