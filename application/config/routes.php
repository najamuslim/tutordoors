<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'frontpage/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['product/root_cat/(:any)/(:num)'] = 'frontpage/show_root_category/$1/$2';
$route['product/single/(:any)'] = 'frontpage/product_single/$1';
$route['order/place'] = 'order/place_order';

$route['my_account'] = 'frontpage/my_account';
$route['home'] = 'frontpage/home';
$route['order/detail/(:any)'] = 'frontpage/detail_order/$1';
$route['blog/cat/(:any)'] = 'frontpage/blog/$1';
$route['blog/view'] = 'frontpage/blog_view';
$route['page/(:any)'] = 'frontpage/page_view/$1';
$route['order_received/(:any)'] = 'frontpage/order_received/$1';
$route['payment_confirmation'] = 'frontpage/payment_confirmation';
$route['coupon'] = 'frontpage/coupon';
$route['cara_bayar'] = 'frontpage/how_to_pay';
$route['login'] = 'frontpage/login';
$route['signup/(:any)'] = 'frontpage/signup/$1';
$route['profile/(:any)/(:any)'] = 'frontpage/profile/$1/$2';
$route['logout'] = 'users/do_logout';

$route['registration/wizard/tutor'] = 'frontpage/registration_wizard/tutor';
$route['registration/wizard/student'] = 'frontpage/registration_wizard/student';
$route['wizard/user/add'] = 'users/wizard_user_add';
$route['wizard/user/add_personal'] = 'users/wizard_add_personal_info';
$route['wizard/user/add_personal/student'] = 'users/wizard_add_student_personal_info';
$route['wizard/user/add_education'] = 'users/wizard_add_education';
$route['wizard/tutor/add_area'] = 'teacher/wizard_add_area';
$route['wizard/tutor/add_program'] = 'teacher/wizard_add_program';