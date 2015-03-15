<?php
/**
 * Newsletter Popup Subscription block
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Block_Popup extends Mage_Newsletter_Block_Subscribe
{

    protected function _toHtml()
    {
        $helper = Mage::helper('martinnguyen_newsletterpopup');
        $popupConfig = $helper->getPopupConfig();
        
        // fast quit if module is disabled
        if (!$helper->isPopupEnabled()) {
            return;
        }
        
        // show/hide and cookie stuff only if not set to "embed only"
        if (!$helper->isEmbedOnly()) {
        
            // check if customers is logged in
            $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
            if ($isLoggedIn) {
                
                // hide popup from logged-in customers that have already subscribed to the newsletter
                if ($popupConfig['show_already_subscribed'] != 1) {
                    $email = Mage::getSingleton('customer/session')->getCustomer()->getData('email');
                    $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
                    
                    if ($subscriber->getId() && $subscriber->isSubscribed()) {
                        
                        // set long expire cookie
                        if ($popupConfig['customers_longexpire'] == 1) {
                            Mage::getModel('core/cookie')->set('mwin_forcehide', 1, (time() + 31536000)); // hide for one year (if the mode is active)
                        }
                        return;
                    }
                }
            }
            // if not show to everybody
            if ($popupConfig['visibility'] != 0) {
            
                // hide popup if customer is logged in and visibility is set to "guests only"
                // or if customer is logged out and visibility is set to "customers only"
                if (($isLoggedIn && $popupConfig['visibility'] == 2) 
                || (!$isLoggedIn && $popupConfig['visibility'] == 1)) {
                    return;
                }
            }
            
            // hide popup from logged-in customers that have already subscribed to the newsletter
            if (Mage::getModel('core/cookie')->get('mwin_forcehide') == 1 
             && $popupConfig['customers_longexpire'] == 1 
             && $popupConfig['show_already_subscribed'] != 1) {
                return;
            }
            
            
            // check if cookie is set
            if ($cookieTime = Mage::getModel('core/cookie')->get('mwin_hide')) {
                
                // get Zend_Date object for current datetime and the expiration datetime
                $expires = $popupConfig['expires'] ? ($popupConfig['expires'] * 60) : 2592000; // default: 30 days
                
                // dont show popup if expiration date is in the future
                if (time() < $cookieTime + $expires) {
                    return;
                }
            }
            
        }
        
		// set extended template if no template or the default template is set (that makes it possible to override the template via layout.xml)
    	if (!$this->getTemplate()) {
			$this->setTemplate('martinnguyen/newsletterpopup/popup.phtml');
        }
        return parent::_toHtml();
    }
}
