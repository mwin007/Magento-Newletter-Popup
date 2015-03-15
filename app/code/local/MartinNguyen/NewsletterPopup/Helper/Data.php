<?php
/**
 * Adminhtml newsletter subscribers helper
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Helper_Data extends Mage_Core_Helper_Abstract
{   
    
    /**
     * Get popup config
     * 
     * @return array
     */
    public function getPopupConfig()
    {
        return Mage::getStoreConfig('newsletterpopup/popup');
    }
    
    /**
     * Get popup delay
     * 
     * @param bool $returnSeconds
     * @return int
     */
    public function getPopupDelay($returnSeconds = false)
    {
        $milliseconds = (int) Mage::getStoreConfig('newsletterpopup/popup/delay');
        return $returnSeconds ? $milliseconds / 1000 : $milliseconds;
    }
    
    /**
     * Get popup fadeout duration
     * 
     * @param bool $returnSeconds
     * @return int
     */
    public function getPopupFadeDuration($returnSeconds = false)
    {
        $milliseconds = (int) Mage::getStoreConfig('newsletterpopup/popup/fadeout_duration');
        return $returnSeconds ? $milliseconds / 1000 : $milliseconds;
    }
    
    /**
     * Check if popup is enabled
     * 
     * @return bool
     */
    public function isPopupEnabled()
    {
        return (int) Mage::getStoreConfig('newsletterpopup/popup/enabled') > 0;
    }
    
    /**
     * Check if popup should only be embedded
     * 
     * @return bool
     */
    public function isEmbedOnly()
    {
        return (int) Mage::getStoreConfig('newsletterpopup/popup/enabled') === 2;
    }
    
    /**
     * Set mwin_hide cookie
     * 
     * @return void
     */
    public function setHideCookie()
    {
        // get expiration time from configuration (defaults to 2592000 seconds == 720 h == 30 days)
        $expires = Mage::getStoreConfig('newsletterpopup/popup/expires') ? (Mage::getStoreConfig('newsletterpopup/popup/expires') * 60) : 2592000;
        Mage::getModel('core/cookie')->set('mwin_hide', time(), (time() + $expires));
    }
    
}