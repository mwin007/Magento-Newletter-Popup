<?php


/**
 * Adminhtml newsletter subscribers grid dob item renderer
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Dob extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
        if ($row->getType() != 2) {
            $value = $row->getSubscriberDob();
        }
        // logged-in only use customer data even if it's empty
        else {
            $value = $row->getCustomerDob();
        }

        return $value ? Mage::helper('core')->formatDate($value, 'medium', false) : '---';
	}
}