<?php
class MartinNguyen_NewsletterPopup_IndexController extends Mage_Core_Controller_Front_Action
{
	public function hidepopupAction()
	{
	    Mage::helper('martinnguyen_newsletterpopup')->setHideCookie();
        $this->getResponse()->setHeader('Content-type', 'application/json');
		$this->getResponse()->setBody('1');
	}
}
