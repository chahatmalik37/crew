<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Home');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->post('Login/AuthLogin', 'Login::AuthLogin');
$routes->get('Login/logout', 'Login::logout');



//route for Question
$routes->get('Question', 'Question::index');
$routes->post('Question/insert', 'Question::insert');
$routes->post('Question/addvalue', 'Question::addvalue');
$routes->post('Question/interview', 'Question::interview');
$routes->post('Question/update', 'Question::update');
$routes->post('Question/delete', 'Question::delete');
$routes->post('Question/pass_check', 'Question::pass_check');
$routes->post('Question/search_data', 'Question::search_data');
$routes->get('Question/get_detail/(:num)', 'Question::get_detail/$1');
$routes->post('Question/delete_review', 'Question::delete_review');
$routes->post('Question/edit_review', 'Question::edit_review');
// $routes->get('Question/get_detail/(:num)', 'Question::get_detail/$1');
$routes->post('Question/get_id', 'Question::get_id');


//route for Employee
$routes->get('Employee', 'Employee::index');
$routes->post('Employee/insert', 'Employee::insert');
$routes->post('Employee/store', 'Employee::store');
$routes->post('Employee/sendmail', 'Employee::sendmail');
$routes->get('Employee/edit/(:num)', 'Employee::edit/$1');
$routes->put('Employee/update/(:num)', 'Employee::update/$1');
$routes->get('Employee/get_detail/(:num)', 'Employee::get_detail/$1');
$routes->get('Employee/delete/(:num)/(:num)', 'Employee::delete/$1/$2');


//route for SearchStaff
$routes->get('SearchStaff', 'SearchStaff::index');
$routes->post('SearchStaff/search_data', 'SearchStaff::search_data');

//Dashboard
$routes->get('Dashboard', 'Dashboard::index');
$routes->get("Dashboard/event", "Dashboard::loadData");
$routes->post("Dashboard/eventAjax", "Dashboard::ajax");
$routes->get("Dashboard/loadNotes", "Dashboard::loadNotes");
$routes->get("Dashboard/loadLeave", "Dashboard::loadLeave");
$routes->get("Dashboard/eventa", "Dashboard::loadDataA");
$routes->get("Dashboard/email_expiry", "Dashboard::email_expiry");
$routes->get("Dashboard/renewal", "Dashboard::renewal");

//route for simcard
$routes->get('SimCard', 'SimCard::index');
$routes->post('SimCard/insert', 'SimCard::insert');
$routes->post('SimCard/store', 'SimCard::store');
$routes->put('SimCard/update/(:num)', 'SimCard::update/$1');
$routes->get('SimCard/edit/(:num)', 'SimCard::edit/$1');
$routes->get('SimCard/delete/(:num)', 'SimCard::delete/$1');
//route for simcard allotment
$routes->get('Allotment', 'Allotment::index');
$routes->post('Allotment/sim_insert', 'Allotment::sim_insert');
$routes->post('Allotment/get_detail', 'Allotment::get_detail');
//route for Designation
$routes->get('OnceDesignation', 'OnceDesignation::index');
$routes->post('OnceDesignation/insert', 'OnceDesignation::insert');
$routes->post('OnceDesignation/store', 'OnceDesignation::store');
$routes->put('OnceDesignation/update/(:num)', 'OnceDesignation::update/$1');
$routes->get('OnceDesignation/edit/(:num)', 'OnceDesignation::edit/$1');
$routes->get('OnceDesignation/delete/(:num)', 'OnceDesignation::delete/$1');
//route for Department
$routes->get('OnceDepartment', 'OnceDepartment::index');
$routes->post('OnceDepartment/insert', 'OnceDepartment::insert');
$routes->post('OnceDepartment/store', 'OnceDepartment::store');
$routes->put('OnceDepartment/update/(:num)', 'OnceDepartment::update/$1');
$routes->get('OnceDepartment/edit/(:num)', 'OnceDepartment::edit/$1');
$routes->get('OnceDepartment/delete/(:num)', 'OnceDepartment::delete/$1');
//route for Star n Square
$routes->get('OnceStarSquare', 'OnceStarSquare::index');
$routes->post('OnceStarSquare/insert', 'OnceStarSquare::insert');
$routes->post('OnceStarSquare/store', 'OnceStarSquare::store');
$routes->put('OnceStarSquare/update/(:num)', 'OnceStarSquare::update/$1');
$routes->get('OnceStarSquare/edit/(:num)', 'OnceStarSquare::edit/$1');
$routes->get('OnceStarSquare/delete/(:num)', 'OnceStarSquare::delete/$1');

//route for Antivirus
$routes->get('OnceAntivirus', 'OnceAntivirus::index');
$routes->post('OnceAntivirus/insert', 'OnceAntivirus::insert');
$routes->post('OnceAntivirus/store', 'OnceAntivirus::store');
$routes->put('OnceAntivirus/update/(:num)', 'OnceAntivirus::update/$1');
$routes->get('OnceAntivirus/edit/(:num)', 'OnceAntivirus::edit/$1');
$routes->get('OnceAntivirus/delete/(:num)', 'OnceAntivirus::delete/$1');

//route for Renewal
$routes->get('Renewal', 'Renewal::index');
$routes->post('Renewal/insert', 'Renewal::insert');
$routes->post('Renewal/store', 'Renewal::store');
$routes->put('Renewal/update/(:num)', 'Renewal::update/$1');
$routes->get('Renewal/edit/(:num)', 'Renewal::edit/$1');
$routes->get('Renewal/delete/(:num)', 'Renewal::delete/$1');

//route for Email
$routes->get('OnceEmail', 'OnceEmail::index');
$routes->post('OnceEmail/insert', 'OnceEmail::insert');
$routes->post('OnceEmail/store', 'OnceEmail::store');
$routes->put('OnceEmail/update/(:num)', 'OnceEmail::update/$1');
$routes->get('OnceEmail/edit/(:num)', 'OnceEmail::edit/$1');
$routes->get('OnceEmail/delete/(:num)', 'OnceEmail::delete/$1');

//route for Allotment Entry
$routes->get('EmailIdController', 'EmailIdController::index');
$routes->get('EmailIdController/redirection/(:alpha)', 'EmailIdController::redirection/$1');
$routes->post('EmailIdController/insert', 'EmailIdController::insert');
$routes->post('EmailIdController/store/(:alpha)', 'EmailIdController::store/$1');
$routes->post('EmailIdController/sendmail/(:alpha)', 'EmailIdController::sendmail/$1');
$routes->get('EmailIdController/edit/(:num)/(:num)/(:alpha)', 'EmailIdController::edit/$1/$2/$3');
$routes->get('EmailIdController/fetch_emp_short_code/(:num)', 'EmailIdController::fetch_emp_short_code/$1');
$routes->post('EmailIdController/update/(:num)/(:num)/(:alpha)', 'EmailIdController::update/$1/$2/$3');
$routes->get('EmailIdController/get_detail/(:num)', 'EmailIdController::get_detail/$1');
$routes->get('EmailIdController/delete/(:num)/(:num)/(:any)', 'EmailIdController::delete/$1/$2/$3');


//route for Attendance
$routes->get('Attendance', 'Attendance::index');
$routes->post('Attendance/add', 'Attendance::add');
$routes->post('Attendance/noteAttendanceAdd', 'Attendance::noteAttendanceAdd');
$routes->get('Attendance/approval/(:num)/(:num)', 'Attendance::approval/$1/$2');
$routes->get('Attendance/leave_approval/(:num)', 'Attendance::leave_approval/$1');
$routes->get('Attendance/view_approval', 'Attendance::view_approval');
$routes->post('Attendance/addLeave', 'Attendance::addLeave');
$routes->post('Attendance/saveLeave', 'Attendance::saveLeave');
$routes->post('Attendance/cancelLeave/(:num)', 'Attendance::cancelLeave/$1');
$routes->post('Attendance/deleteLeave', 'Attendance::deleteLeave');
$routes->get('Attendance/fetch_emp_leave/(:num)', 'Attendance::fetch_emp_leave/$1');
$routes->get('Attendance/fetch_emp_detail_for_approval', 'Attendance::fetch_emp_detail_for_approval');
$routes->post('Attendance/updateNote/(:alpha)', 'Attendance::updateNote/$1');
$routes->post('Attendance/DeleteNote/(:alpha)', 'Attendance::DeleteNote/$1');
$routes->post('Attendance/UpdateAttendance', 'Attendance::UpdateAttendance');
$routes->get('Attendance/get_detail', 'Attendance::get_detail');
$routes->post('Attendance/DeleteAttendance', 'Attendance::DeleteAttendance');


//route for Attendance Report
$routes->get('AttendanceReport', 'AttendanceReport::index');
$routes->post('AttendanceReport/search_report', 'AttendanceReport::search_report');
$routes->get('AttendanceReport/fetch_emp_detail_with_datewise', 'AttendanceReport::fetch_emp_detail_with_datewise');
$routes->get('AttendanceReport/ShowReport/(:num)/(:any)/(:any)', 'AttendanceReport::ShowReport/$1/$2/$3');

//route for Report
$routes->get('Report', 'Report::index');
$routes->post('Report/template_create', 'Report::template_create');
$routes->post('Report/add_report', 'Report::add_report');
$routes->post('Report/add_report_modal', 'Report::add_report_modal');
$routes->post('Report/get_detail', 'Report::get_detail');
$routes->get('Report/get_detail', 'Report::get_detail');
$routes->post('Report/edit_report', 'Report::edit_report');
$routes->post('Report/share_report', 'Report::share_report');
$routes->post('Report/stop_share_report', 'Report::stop_share_report');
$routes->post('Report/get_share_date', 'Report::get_share_date');
$routes->post('Report/del_template', 'Report::del_template');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
