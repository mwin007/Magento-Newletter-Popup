<?php
class MartinNguyen_NewsletterPopup_Model_System_Config_Source_Dropdown_Popupmode
{
	/**
	 * returns Option Array for the visibility mode
	 * 
	 * @return array
	 */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 1,
                'label' => 'Yes',
            ),
            array(
                'value' => 0,
                'label' => 'No',
            ),
            array(
                'value' => 2,
                'label' => 'Use Onclick Button',
            ),
        );
    }
}