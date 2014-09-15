<?php 
class Error_404 extends MY_Controller
{
	 	public $pathtoclass;    

	    public function __construct()
	    {
	        try
	        {
				parent::__construct();
				$this->data['title'] = 'Page Not Found';
				$this->pathtoclass = base_url().$this->router->fetch_class()."/"; //for redirecting from this class
	        }
	        catch(Exception $err_obj)
	        {
	            show_error($err_obj->getMessage());
	        }
		}
		
		public function index()
		{
			$this->render();
		}
}
?>