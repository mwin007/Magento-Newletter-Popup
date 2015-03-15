<?php
/**
 * NewsletterPopup module subscriber model
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Model_Subscriber extends Mage_Newsletter_Model_Subscriber
{
    /**
     * Customer model
     *
     * @var Mage_Customer_Model_Customer
     */
    protected $customer;
    
    public function getCustomer()
    {
        if (!isset($this->customer)) {
            $this->customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
        }
        
        return $this->customer;
    }
    
    /**
     * Get the subscribers mobile number 
     *
     * @return string
     */
    public function getSubscriberMobile()
    {
        $mobile = parent::getSubscriberMobile();       
        return $mobile;
    }

    /**
     * Get the subscribers postal code 
     *
     * @return string
     */
    public function getSubscriberPostal()
    {
        $postal = parent::getSubscriberPostal();      
        return $postal;
    }

    /**
     * Get the subscribers country
     *
     * @return string
     */
    public function getSubscriberCountry()
    {
        $country = parent::getSubscriberCountry();      
        return $country;
    }
    
    /**
     * Get the subscribers dob (date of birth) 
     *
     * @return string
     */
    public function getSubscriberDob()
    {
        $dob = parent::getSubscriberDob();
        return $dob;
    }

}