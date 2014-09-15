<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

#$route['default_controller'] ="web_master/home";
$route['default_controller'] 				= 'home';
$route['(about-us|terms-conditions|privacy-policy|copyright|conflict-resolution|career)']		= 'cms/cms_details/$1';
$route['video-help']						= 'home/video_help';
$route['contact-us']						= 'home/contact_us';
$route['how-it-works']						= 'how_it_works';

$route['registration-successful']			= 'registration/registration_successful';
$route['verify-account/(:any)']				= 'registration/verify_account/$1';
$route['verify-account']					= 'registration/verify_account';
$route['remove-account/(:any)']				= 'registration/remove_account/$1';
$route['remove-account']					= 'registration/remove_account';
$route['forgot-password']					= 'registration/forgot_password';
$route['my-account']						= 'user/my_account';
$route['logout']							= 'registration/logout';
$route['404_override'] 						= 'page_not_found';
//$route['404_override'] = 'web_master/error_404/index';


$route['post-projects'] 					= 'postjob';
$route['review-project'] 					= 'postjob/review_project';
$route['customer-all-projects'] 			= 'customer/all_projects';
$route['customer-posted-projects'] 			= 'customer/posted_projects';

$route['provider-all-projects'] 			= 'provider/all_projects';
$route['proposals/(:num)'] 					= 'provider/give_proposal/$1';
$route['provider-quotes'] 					= 'provider/my_quote_list';

$route['job-detail/(:num)/(:any)'] 			= "job_detail/index/$1";
$route['edit-project/(:num)/(:any)'] 		= "postjob/edit_project/$1";


# ======== Front-End Routing Rule(s) [Begin] ========

    //// SIGNUP pages....
    $route['registration'] = 'signup/common_signup';
        
        // Guest SignUp...
        $route['guest-registration'] = 'signup/guest_signup';
        $route['signup-utils/validate-guest-user-signup-AJAX'] = 'signup_utilities/guest_signup_validation_AJAX';
        // Customer/Buyer SignUp...
        $route['customer-registration'] = 'signup/customer_signup';
        $route['signup-utils/validate-customer-signup-AJAX'] = 'signup_utilities/customer_signup_validation_AJAX';
        // Provider SignUp...
        $route['provider-registration'] = 'signup/provider_signup';
        $route['signup-utils/validate-provider-signup-AJAX'] = 'signup_utilities/provider_signup_validation_AJAX';

        
        $route['signup/activate-account/(:any)'] = 'signup/activate_account/$1';
        
            //// FB & LinkedIN related...
            $route['signup-utils/fconnect/(:any)/(:any)'] = 'signup_utilities/fconnect/$1/$2';
            $route['signup-utils/connect-linkedin/(:any)'] = 'signup_utilities/connect_linkedin/$1';
            $route['signup-utils/linkedin-redirect'] = 'signup_utilities/linkedin_redirect';
            
            
        //// CAPTCHA
        $route['show-captcha'] = 'cool_captcha/index';
        $route['show-captcha/(:num)/(:num)'] = 'cool_captcha/index/$1/$2';
    
    
    //// COMMON-SIGNIN page....
    $route['user-signin'] 				= 'user_signin/index';
	$route['user-signin/(:num)'] 		= 'user_signin/index/$1';
    $route['signin/user-signin-AJAX']  = 'user_signin/user_signin_AJAX';
    
    
    
	/*$route['blog/details/(:num)'] = 'blog/details/$1';*/


# ======== Front-End Routing Rule(s) [End] ========

/* End of file routes.php */
/* Location: ./application/config/routes.php */