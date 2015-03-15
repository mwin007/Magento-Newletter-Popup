<?php
/**
 * Adminhtml newsletter subscribers grid block
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid extends Mage_Adminhtml_Block_Newsletter_Subscriber_Grid
{
	protected function _prepareCollection()
	{
        $collection = Mage::getResourceSingleton('newsletter/subscriber_collection');
        $collection->showCustomerInfo();
        
        // add custom fields
        if (Mage::getStoreConfig('newsletterpopup/fields/show_dob'))
            $collection->showCustomerGender();
        if (Mage::getStoreConfig('newsletterpopup/fields/show_postal'))
            $collection->showCustomerPrefix();
        if (Mage::getStoreConfig('newsletterpopup/fields/show_country'))
            $collection->showCustomerSuffix();
        if (Mage::getStoreConfig('newsletterpopup/fields/show_mobile'))
            $collection->showCustomerDob();
        // <- end add custom fields
        
        $collection->addSubscriberTypeField()
            ->showStoreInfo();

        if($this->getRequest()->getParam('queue', false)) {
            $collection->useQueue(Mage::getModel('newsletter/queue')
                ->load($this->getRequest()->getParam('queue')));
        }

        $this->setCollection($collection);
		
		/* 	we have to copy the following lines from Mage_Adminhtml_Block_Widget_Grid because we need  
			a new collection but Mage_Adminhtml_Block_Newsletter_Subscriber_Grid would overwrite it */
        if ($this->getCollection()) {

            $this->_preparePage();

            $columnId = $this->getParam($this->getVarNameSort(), $this->_defaultSort);
            $dir      = $this->getParam($this->getVarNameDir(), $this->_defaultDir);
            $filter   = $this->getParam($this->getVarNameFilter(), null);

            if (is_null($filter)) {
                $filter = $this->_defaultFilter;
            }

            if (is_string($filter)) {
                $data = $this->helper('adminhtml')->prepareFilterString($filter);
                $this->_setFilterValues($data);
            }
            else if ($filter && is_array($filter)) {
                $this->_setFilterValues($filter);
            }
            else if(0 !== sizeof($this->_defaultFilter)) {
                $this->_setFilterValues($this->_defaultFilter);
            }

            if (isset($this->_columns[$columnId]) && $this->_columns[$columnId]->getIndex()) {
                $dir = (strtolower($dir)=='desc') ? 'desc' : 'asc';
                $this->_columns[$columnId]->setDir($dir);
                $this->_setCollectionOrder($this->_columns[$columnId]);
            }

            if (!$this->_isExport) {
                $this->getCollection()->load();
                $this->_afterLoadCollection();
            }
        }
    }

	protected function _prepareColumns()
	{
		// prepare columns and sort them by order (see Mage_Adminhtml_Block_Widget_Grid)
		parent::_prepareColumns();
		
		// remove old columns
        $this->removeColumn('dob'); // futureproof
        $this->removeColumn('postal'); // futureproof
        $this->removeColumn('country'); // futureproof
        $this->removeColumn('mobile'); // futureproof
		
		// add new columns
        if (Mage::getStoreConfig('newsletterpopup/fields/show_gender')) {
    		$this->addColumnAfter('gender', array(
    			'header'    => Mage::helper('newsletter')->__('Gender'),
                'index'     => 'customer_gender',
                'type'      => 'options',
                'options'   => array(
                    1  => Mage::helper('newsletter')->__('Mr'),
                    2  => Mage::helper('newsletter')->__('Ms/Mrs')
                ),
    			'renderer'	=> 'MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Gender'
    		), 'type');
        }
        
        if (Mage::getStoreConfig('newsletterpopup/fields/show_prefix')) {
            $this->addColumnAfter('prefix', array(
                'header'    => Mage::helper('newsletter')->__('Prefix'),
                'index'     => 'customer_prefix',
                'renderer'  => 'MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Prefix'
            ), Mage::getStoreConfig('newsletterpopup/fields/show_gender') ? 'gender' : 'type');
        }
		
		$this->addColumnAfter('firstname', array(
			'header'    => Mage::helper('newsletter')->__('First Name'),
            'index'     => 'customer_firstname',
			'renderer'	=> 'MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Firstname'
		), Mage::getStoreConfig('newsletterpopup/fields/show_prefix') ? 'prefix' : (Mage::getStoreConfig('newsletterpopup/fields/show_gender') ? 'gender' : 'type'));
		
		$this->addColumnAfter('lastname', array(
			'header'    => Mage::helper('newsletter')->__('Last Name'),
            'index'     => 'customer_lastname',
			'renderer'	=> 'MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Lastname'
		), 'firstname');
        
        if (Mage::getStoreConfig('newsletterpopup/fields/show_suffix')) {
            $this->addColumnAfter('suffix', array(
                'header'    => Mage::helper('newsletter')->__('Suffix'),
                'index'     => 'customer_suffix',
                'renderer'  => 'MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Suffix'
            ), 'lastname');
        }
        
        if (Mage::getStoreConfig('newsletterpopup/fields/show_dob')) {
            $this->addColumnAfter('dob', array(
                'header'    => Mage::helper('newsletter')->__('Date of Birth'),
                'index'     => 'customer_dob',
                'renderer'  => 'MartinNguyen_NewsletterPopup_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Dob'
            ), Mage::getStoreConfig('newsletterpopup/fields/show_suffix') ? 'suffix' : 'lastname');
        }

		// manually sort again, that our custom order works
		$this->sortColumnsByOrder();
		
        return $this;
    }
}
