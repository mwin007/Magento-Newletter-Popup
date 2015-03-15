<?php
/**
 * Newsletter Subscription block
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

include_once("Mage/Newsletter/controllers/SubscriberController.php");
 
class MartinNguyen_NewsletterPopup_SubscriberController extends Mage_Newsletter_SubscriberController
{
    /**
      * New subscription action override
      */
    public function newAction()
    {
        // this prevents a "Notice: undefined variable" error
        $status = false;
        
        // default new Action
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $session            = Mage::getSingleton('core/session');
            $customerSession    = Mage::getSingleton('customer/session');
            $email              = (string) $this->getRequest()->getPost('email');

            try {
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    Mage::throwException($this->__('Please enter a valid email address.'));
                }

                if (Mage::getStoreConfig(Mage_Newsletter_Model_Subscriber::XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG) != 1 && 
                    !$customerSession->isLoggedIn()) {
                    Mage::throwException($this->__('Sorry, but administrator denied subscription for guests. Please <a href="%s">register</a>.', Mage::helper('customer')->getRegisterUrl()));
                }

                $ownerId = Mage::getModel('customer/customer')
                        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                        ->loadByEmail($email)
                        ->getId();
                if ($ownerId !== null && $ownerId != $customerSession->getId()) {
                    Mage::throwException($this->__('This email address is already assigned to another user.'));
                }

                $status = Mage::getModel('newsletter/subscriber')->subscribe($email);
                if ($status == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                    $session->addSuccess($this->__('Confirmation request has been sent.'));
                }
                else {
                    $session->addSuccess($this->__('Thank you for your subscription.'));
                }
            }
            catch (Mage_Core_Exception $e) {
                $session->addException($e, $this->__('There was a problem with the subscription: %s', $e->getMessage()));
            }
            catch (Exception $e) {
                $session->addException($e, $this->__('There was a problem with the subscription.'));
            }
        }
        
        // json return for ajax request
        if ($this->getRequest()->isXmlHttpRequest()) {
            $messages = NULL;
            
            // set hide cookie if success
            if ($status) {
                Mage::helper('martinnguyen_newsletterpopup')->setHideCookie();
            }
            // get error messages if no success
            else if (isset($session)) {
                
                // get rendered messages html block
                $messages = Mage::app()->getLayout()->getMessagesBlock()->getGroupedHtml();
                
                // use this to get only the text of the messages
                /*foreach ($session->getMessages()->getItems() as $smessage) {
                    $messages .= $smessage->getText();
                }*/
            }

            // return json
            $jsonData = Mage::helper('core')->jsonEncode(array(
                'success' => $status,
                'messages' => $messages
            ));
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody($jsonData);
            return;
        }
        
        // normale redirect for non ajax request
        $this->_redirectReferer();
    }
}
