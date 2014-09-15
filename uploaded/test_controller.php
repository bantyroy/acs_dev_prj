<?php 

/***

File Name: test_controller.php 
Created By: ACS Dev 
Created On: Jul 28, 2014 
Purpose: CURD for Test Controller 

*/

class Test_controller extends MY_Controller 
{

	public function __construct(){
                                
		parent::__construct();
                                
		$this->data["title"] = addslashes(t('Test Controller'));//Browser Title            
                         
	}

	public function show_list(){
                                 
		echo "Hello World";
                         
	}
}