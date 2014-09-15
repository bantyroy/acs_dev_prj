<?php
/*
+---------------------------------------------------------------+
| For site error and success massege list						|
+---------------------------------------------------------------+
| Return all the message list if called with blank parameter	|
+---------------------------------------------------------------+
| Return only the matching message if called by key				|
+---------------------------------------------------------------+
| Author: Acumen CS												|
+------------------------------+--------------------------------+
| Date: 31-Jan-2014            | Modified on: 31-Jan-2014		|
+------------------------------+--------------------------------+
*/

function get_message($key = '')
{
	$message = array(
						'save_success' 					=> t('Information has been saved.'),
			    		'save_failed' 					=> t('Failed to save your information.'),
						'del_success' 					=> t('Information has been removed.'),
						'del_failed' 					=> t('Information has failed to removed.'),
						'no_result' 					=> t('No information found.'),
						'country'						=> t('Please provide country.'),
						'currency'						=> t('Please provide currency.'),
						'language'						=> t('Please provide language.'),
						'cou_cur_exist'					=> t('Currency exist corresponding to the country.'),
						'cou_lan_exist'					=> t('Language exist corresponding to the country.'),
						'category'						=> t('Please provide category.'),
						'cat_exist'						=> t('This category already exist. Please provide a separate category.'),
						'con_name'						=> t('Please provide your name'),
						'con_email'						=> t('Please provide valid email'),
						'captcha'						=> t('Please provide image text'),
						'captcha_not_match'				=> t('Image text does not match.'),
						'contact_send_succ'				=> t('Thank you for your email. We will contact you soon!'),
						'contact_send_failed'			=> t('Sorry unable to send email this time. Plesase try again later.'),
						'contact_reply_send_succ'		=> t('Reply has been sent successfully to the user ##NAME##'),
						'welcome_text'					=> t('Dream Wedding Auctions is the only place on the web where you can start an<br/>auction for the services you require for your wedding and allow suppliersto bid on these<br/>services online. We create a space where you can be in afull control of your dream wedding,<br/>where for the first time ever allsuppliers will come to you!<br/>'),
						'footer_text'					=> t('Nulla et erat et elit pharetra tempor. Mauris egestas est vel ante pellentesqu porta. Fusce a es mauris. Morbi consequat, massa ut tempus cursus, magna augue luctus est,'),
						'reg_username'					=> t('Please provide username.'),
						'reg_first_name'				=> t('Please provide first name.'),
						'reg_last_name'					=> t('Please provide last name.'),
						'reg_email'						=> t('Please provide valid email'),
						'reg_password'					=> t('Please provide password'),
						'reg_con_password'				=> t('Please provide confirm password'),
						'reg_succss'					=> t('Registration has been successful'),
						'vrf_cd_nt_match'				=> t('Verification code not found.'),
						'already_verified'				=> t('Already verified. Please login to view your account.'),
						'verified_success'				=> t('Your account has been verified successfully. Please login to view your account.'),
						'inactive_account'				=> t('It seems your account has been deactivated. Please contact Dream Wedding Auctions Team for any assistance.'),
						'not_verified'					=> t('It seems your account has not verified yet. Please contact Dream Wedding Auctions Team for any assistance.'),
						'account_remove_success'		=> t('Your account has been removed successfully.'),
						'verified_acc_err'				=> t('This is a verified account. You can not remove this aacount from here.'),
						'login_failed'					=> t('Login failed! Please check the data you have entered.'),
						'password_reset'				=> t('Password has been reset and a temporary password sent to ##EMAIL##. Please login and change your password.'),
						'password_reset_failed'			=> t('Failed to reset password. Please try again later.'),
						'ana_address'					=> t('Please provide address.'),
						'ana_city'						=> t('Please provide city.'),
						'ana_post'						=> t('Please provide post code.'),
						'login_to_bid'					=> t('Please login to buy bid packages.'),
						'add_to_cart_failed'			=> t('Item already added to your cart.'),
						'confirm_cart_del'				=> t('Are you sure, you want to remove cart item?'),
						'empty_cart'					=> t('No item in your cart.'),
						'payment_failed'				=> t('Sorry your payment has been failed.'),
						'payment_success'				=> t('Your order has been palced successfully. Please check your e-mail account for order confirmation e-mail.'),
						'payment_greet'					=> t('Redirecting to Payment Gateway. Please wait! Do not Press BackButton / Refresh'),
						'prod_images_upload_error'		=> t('Please try again later.'),
						'pro_img_del_confirm'			=> t('Are you sure, you want to delete?'),
						'product_name'					=> t('Please provide product name.'),
						'start_price'					=> t('Please provide auction start price.'),
						'price'							=> t('Price must be greater than 0.'),
					);
					
	return $key == '' ? $message : $message[$key];
}