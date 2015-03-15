<?php
/**
 * NewsletterPopup module observer
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Model_Observer
{
    public function newsletterSubscriberChange(Varien_Event_Observer $observer)
    {
        $subscriber = $observer->getEvent()->getSubscriber();
        $data = Mage::app()->getRequest()->getParams() ? Mage::app()->getRequest()->getParams() : array();
        
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            
            // if the email entered is the same as the one of the logged-in customer, use customer's data as fallback for empty fields
            if (isset($data['email']) && $customer->getEmail() === $data['email']) {               
                // so the grid will allways use the up-to-date customers data
                $data['mobile'] = '';
                $data['dob'] = '';
                $data['postal'] = '';
                $data['country'] = '';
                }
        }
        
        // store data only if email and dob is provided
        if (isset($data['email']) && isset($data['dob'])) {
            
            if (isset($data['mobile'])) $subscriber->setSubscriberGender($data['mobile']);
            if (isset($data['dob'])) $subscriber->setSubscriberPrefix($data['dob']);
            if (isset($data['postal'])) $subscriber->setSubscriberFirstname($data['postal']);
            if (isset($data['country'])) $subscriber->setSubscriberLastname($data['country']);
        }       
        return $this;
    }
}