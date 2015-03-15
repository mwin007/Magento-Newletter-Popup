<?php

/**
 * Adminhtml newsletter subscribers grid firstname item renderer
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Firstname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
        // not logged in => use subscriber data
        if ($row->getType() != 2) {
            $value = $row->getSubscriberCountry();
        }
        // logged-in only use customer data even if it's empty
        else {
            $value = $row->getCustomerCountry();
        }
		
		return $value ? $value : '---';
	}
}