<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });

//Route::get('/home', 'HomeController@index')->name('home');

// ********************************Login*********************************//
Auth::routes(['register' => false]);
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');
Route::group([  'middleware' => 'AuthChecking'], function () {
// ********************************Dashboard*********************************//
Route::get('/dashboard','DashboardController@dashboard');

// ********************************Designation*********************************//
Route::get('/designation','DesignationController@designation');
Route::get('/add_designation','DesignationController@add_designation');
Route::post('/designation_save_update','DesignationController@designation_save_update');
Route::post('/list_designation','DesignationController@list_designation');
Route::post('/designation_edit','DesignationController@designation_edit');
Route::post('/designation_delete','DesignationController@designation_delete');

// ********************************Department*********************************//
Route::get('/department_details','DepartmentController@department_details');
Route::get('/add_department','DepartmentController@add_department');
Route::post('/department_save_update','DepartmentController@department_save_update');
Route::post('/list_department','DepartmentController@list_department');
Route::post('/department_edit','DepartmentController@department_edit');
Route::post('/department_delete','DepartmentController@department_delete');

// ********************************Employee*********************************//
Route::get('/employee_details','EmployeeController@employee_details');
Route::get('/add_employee','EmployeeController@add_employee');
Route::post('/get_all_designation','EmployeeController@get_all_designation');
Route::post('/get_all_department','EmployeeController@get_all_department');
Route::post('/personaldetails_save_update','EmployeeController@personaldetails_save_update');
Route::post('/get_personal_details','EmployeeController@get_personal_details');
Route::post('/contactdetails_save_update','EmployeeController@contactdetails_save_update');
Route::post('/get_contact_details','EmployeeController@get_contact_details');
Route::post('/workingdetails_save_update','EmployeeController@workingdetails_save_update');
Route::post('/list_employee','EmployeeController@list_employee');
Route::post('/employee_edit','EmployeeController@employee_edit');
Route::post('/get_working_details','EmployeeController@get_working_details');
Route::post('/employee_delete','EmployeeController@employee_delete');
Route::post('/view_employee_details','EmployeeController@view_employee_details');
Route::post('/salarydetails_save_update','EmployeeController@salarydetails_save_update');
Route::post('/get_salary_details','EmployeeController@get_salary_details');



// ********************************Supervisor Wise Worker*********************************//
Route::get('/supervisor_wise_worker_details','SupervisorWiseWorkerController@supervisor_wise_worker_details');
Route::get('/add_supervisor_wise_worker','SupervisorWiseWorkerController@add_supervisor_wise_worker');
Route::post('/get_all_supervisor','SupervisorWiseWorkerController@get_all_supervisor');
Route::post('/get_all_worker','SupervisorWiseWorkerController@get_all_worker');
Route::post('/get_worker_name','SupervisorWiseWorkerController@get_worker_name');
Route::post('/save_supervisorwiseworker','SupervisorWiseWorkerController@save_supervisorwiseworker');
Route::post('/list_supervisorwiseworker','SupervisorWiseWorkerController@list_supervisorwiseworker');
Route::post('/get_supervisor_wise_worker','SupervisorWiseWorkerController@get_supervisor_wise_worker');
Route::post('/supervisorwiseworker_delete','SupervisorWiseWorkerController@supervisorwiseworker_delete');

// ********************************User*********************************//
Route::get('/user_details','UserController@user_details');
Route::get('/add_user','UserController@add_user');
Route::post('/get_all_employee_name','UserController@get_all_employee_name');
Route::post('/user_save_update','UserController@user_save_update');
Route::post('/list_user','UserController@list_user');
Route::post('/active_deactive_user','UserController@active_deactive_user');
Route::post('/user_edit','UserController@user_edit');

// ********************************Attendance Report*********************************//
Route::get('/attendance_report','AttendanceReportController@attendance_report');
Route::post('/list_attendance_report','AttendanceReportController@list_attendance_report');
Route::post('/get_all_employee','AttendanceReportController@get_all_employee');
Route::post('/get_att_lat_lang','AttendanceReportController@get_att_lat_lang');



// ********************************Allowance*********************************//

Route::get('/allowance_details','AllowanceController@allowance_details');
Route::get('/add_allowance','AllowanceController@add_allowance');
Route::post('/allowance_save_update','AllowanceController@allowance_save_update');
Route::post('/list_allowance','AllowanceController@list_allowance');
Route::post('/allowance_edit','AllowanceController@allowance_edit');
Route::post('/allowance_delete','AllowanceController@allowance_delete');

// ********************************Designation Wise Allowance*********************************//

Route::get('/dsignation_wise_allowance_details','AllowanceController@dsignation_wise_allowance_details');
Route::get('/add_designation_wise_allowance','AllowanceController@add_designation_wise_allowance');
Route::post('/get_all_allowance','AllowanceController@get_all_allowance');
Route::post('/get_allowance_name','AllowanceController@get_allowance_name');
Route::post('/save_designationwiseallowance','AllowanceController@save_designationwiseallowance');
Route::post('/list_designation_wise_allowance','AllowanceController@list_designation_wise_allowance');
Route::post('/get_designation_wise_allowance','AllowanceController@get_designation_wise_allowance');
Route::post('/designation_wise_allowance_delete','AllowanceController@designation_wise_allowance_delete');

// ********************************Salary Sheet*********************************//
Route::get('/salary_sheet','SalaryReportController@salary_sheet');
Route::post('/designation_wise_salary','SalaryReportController@designation_wise_salary');
Route::post('/save_salary_generate','SalaryReportController@save_salary_generate');
Route::get('/salary_generated_list','SalaryReportController@salary_generated_list');
Route::post('/list_salary_generated_details','SalaryReportController@list_salary_generated_details');
Route::post('/regenerate_salary_details','SalaryReportController@regenerate_salary_details');

Route::post('/salary_generate_excel_report','SalaryReportController@salary_generate_excel_report');
Route::post('/salary_generate_pdf_report','SalaryReportController@salary_generate_pdf_report');
Route::post('/pay_slip_generate','SalaryReportController@pay_slip_generate');







// ********************************Monthly Attendance Report*********************************//
Route::get('/monthly_attendance_report','AttendanceReportController@monthly_attendance_report');
//Route::get('/add_designation_wise_allowance','AllowanceController@add_designation_wise_allowance');
Route::post('/get_designation_wise_employee','AttendanceReportController@get_designation_wise_employee');
Route::post('/list_tbl_monthly_attendance_entry','AttendanceReportController@list_tbl_monthly_attendance_entry');
Route::post('/get_all_leave_details','AttendanceReportController@get_all_leave_details');
Route::post('/save_leave_employee','AttendanceReportController@save_leave_employee');
Route::post('/countAbsentPresentHolidayLeave','AttendanceReportController@countAbsentPresentHolidayLeave');



//******************************Leave Head*************************************** //
Route::get('/leave_head','LeaveMasterController@leave_head');
Route::get('/add_leave_head','LeaveMasterController@add_leave_head');
Route::post('/leave_save_update','LeaveMasterController@leave_save_update');
Route::post('/list_of_leave','LeaveMasterController@list_of_leave');
Route::post('/leave_edit','LeaveMasterController@leave_edit');
Route::post('/leave_delete','LeaveMasterController@leave_delete');

//******************************Holidays List*************************************** //
Route::get('/holiday_details','HolidayListController@holiday_details');
Route::get('/add_holidays','HolidayListController@add_holidays');
Route::post('/holiday_save_update','HolidayListController@holiday_save_update');
Route::post('/list_of_holidays','HolidayListController@list_of_holidays');
Route::post('/holidays_edit','HolidayListController@holidays_edit');
Route::post('/holidays_delete','HolidayListController@holidays_delete');

//******************************Shift*************************************** //
Route::get('/shift_details','ShiftController@shift_details');
Route::get('/add_shift','ShiftController@add_shift');
Route::post('/shift_save_update','ShiftController@shift_save_update');
Route::post('/list_of_shift','ShiftController@list_of_shift');
Route::post('/shift_edit','ShiftController@shift_edit');
Route::post('/shift_delete','ShiftController@shift_delete');



//******************************P-TAX*************************************** //
Route::get('/p_tax_details','PTaxController@p_tax_details');
Route::get('/add_p_tax','PTaxController@add_p_tax');
Route::post('/p_tax_save_update','PTaxController@p_tax_save_update');
Route::post('/list_of_p_tax','PTaxController@list_of_p_tax');
Route::post('/p_tax_edit','PTaxController@p_tax_edit');
Route::post('/p_tax_delete','PTaxController@p_tax_delete');



//******************************Employee Wise Shift Allocation*************************************** //
Route::get('/employee_wise_shift_allocation','EmployeeWiseShiftController@employee_wise_shift_allocation');
Route::get('/add_employee_wise_shift_allocation','EmployeeWiseShiftController@add_employee_wise_shift_allocation');
Route::post('/get_employee_wise_shift','EmployeeWiseShiftController@get_employee_wise_shift');
Route::post('/employee_wise_shift_save_update','EmployeeWiseShiftController@employee_wise_shift_save_update');
Route::post('/search_designation_wise_employee','EmployeeWiseShiftController@search_designation_wise_employee');

Route::post('/list_of_employee_wise_shift','EmployeeWiseShiftController@list_of_employee_wise_shift');// ***************************Designation Wise leave Assign**************************************//
Route::get('/leave_assign','LeaveAssignController@leave_assign');
Route::get('/leave_assign_details','LeaveAssignController@leave_assign_details');
Route::post('/get_all_year','LeaveAssignController@get_all_year');
Route::post('/get_all_designation','LeaveAssignController@get_all_designation');
Route::post('/leave_assign_save_update','LeaveAssignController@leave_assign_save_update');
Route::post('/list_of_leave_assign','LeaveAssignController@list_of_leave_assign');
Route::post('/get_designation_wise_leave','LeaveAssignController@get_designation_wise_leave');





});






















