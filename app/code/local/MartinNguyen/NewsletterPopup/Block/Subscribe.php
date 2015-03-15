<?php
/**
 * Newsletter Subscription block
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Block_Subscribe extends Mage_Newsletter_Block_Subscribe
{

    protected function _toHtml()
    {
		// set extended template if no template or the default template is set (that makes it possible to override the template via layout.xml)
    	if (!$this->getTemplate() || $this->getTemplate() == 'newsletter/subscribe.phtml') {
			$this->setTemplate('martinnguyen/newsletterpopup/button.phtml');
        }
		
        return parent::_toHtml();
    }
}
