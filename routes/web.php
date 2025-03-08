<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\EmployeeProfileController;
use App\Http\Controllers\Admin\AdminPrescriptionController;
use App\Http\Controllers\Admin\CareDeliveryController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminVideoCallController;

use App\Http\Controllers\Patient\PatientRegisterController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\Patient\PatientHomeController;
use App\Http\Controllers\Patient\PatientLoginController;
use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Patient\PatientPrescriptionController;
use App\Http\Controllers\Patient\patientHealthRecordController;
use App\Http\Controllers\Patient\PatientCareTeamController;
use App\Http\Controllers\Patient\PatientCareDeliveryController;
use App\Http\Controllers\Patient\LiveChatController;
use App\Http\Controllers\Patient\PatientVideoCallController;


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


//patient 
//------------------------------------------------------------------------------------------------//
//patient appointments
Route::get('/', function(){
    return view('patient.patientLogin');
});

Route::get('/patient/patientHome', [PatientHomeController::class, 'showPatientHome'])->name('showPatientHome');
Route::get('/patient/requestAppointment', [PatientAppointmentController::class, 'showAppointmentForm'])->name('showAppointmentPatientForm');
Route::post('/patient/requestAppointment', [PatientAppointmentController::class, 'addAppointment'])->name('addPatientAppointment');
Route::get('/patient/patientCalendar', [PatientHomeController::class, 'showPatientAppointmentCalendar'])->name('showPatientAppointmentCalendar');
Route::get('/patient/patientAppointment', [PatientAppointmentController::class, 'showAppointmentPage'])->name('showAppointmentPage');
Route::get('/patient/patientAppointment/{id}', [PatientAppointmentController::class, 'showAppointmentDetails'])->name('showPatientAppointmentDetails');

//patient registration
Route::get('/registerPatientAccount', [PatientRegisterController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post('/registerPatientAccount', [PatientRegisterController::class, 'registerPatient'])->name('registerPatientAccount');

// Patient login routes
Route::get('/patient/login', [PatientLoginController::class, 'showLoginForm'])->name('patient.login');  // Patient login form
Route::post('/patient/login', [PatientLoginController::class, 'login'])->name('patient.login.submit'); // Patient login submission
Route::post('/patientlogout', [PatientLoginController::class, 'patientLogout'])->name('patientLogout');

//patient profile
Route::get("patient/patientProfile", [PatientProfileController::class, 'showPatientProfile'])->name('patientProfile');
Route::post('/patientProfile/updateBio', [PatientProfileController::class, 'updateBio'])->name('updatePatientBio');
Route::post('/patientProfile/updatePersonalInfo', [PatientProfileController::class, 'updatePersonalInfo'])->name('updatePatientPersonalInfo');
Route::post('/patientProfile/updateAccountInfo', [PatientProfileController::class, 'updateAccountInfo'])->name('updatePatientAccountInfo');
Route::get('/patientProfile/downloadMedicalHistory', [PatientProfileController::class, 'downloadMedicalHistory'])->name('downloadPatientMedicalHistory');
Route::put('/patientProfile/update/profilePicture', [PatientProfileController::class, 'updatePatientProfilePicture'])->name('updatePatientProfilePicture');

//Patient Health Record
Route::get('/patient/patientHealthRecord', [patientHealthRecordController::class, 'showPatientHealthRecord'])->name('showPatientHealthRecord');
Route::get('/patient/Medical_history/{id}', [patientHealthRecordController::class, 'downloadPatientMedicalHistory'])->name('patientMedicalHistory');
Route::post('/patient/update_Medical_History/{id}', [patientHealthRecordController::class, 'updateMedicalHistory'])->name('updatePatientMedicalHistory');

//patient care team
Route::get('/patient/careTeam', [PatientCareTeamController::class, 'showCareTeamPage'])->name('showCareTeamPage');
Route::get('/patient/careTeam/{id}', [PatientCareTeamController::class, 'getCaregiverDetails'])->name('getCaregiverDetails');

//patient care delivery
Route::get('/patient/careDelivery/form', [PatientCareDeliveryController::class, 'showCareDeliveryForm'])->name('showCareDeliveryForm');
Route::get('/patient/address/{id}', [PatientCareDeliveryController::class, 'getPatientLocation'])->name('getPatientLocation');
Route::post('/patient/{id}/care-delivery', [PatientCareDeliveryController::class, 'addnewCareDeliveryRequest'])->name('careDelivery.store');
Route::get('/patient/careDeliveryDetails/{id}', [PatientCareDeliveryController::class, 'showCareDeliveryDetails'])->name('showPatientCareDeliveryDetails');

//patient Prescription
Route::get('/patient/PrescriptionRequest', [PatientPrescriptionController::class, 'showPrescriptionForm'])->name('showPrescriptionForm');
Route::post('/patient/addPrescriptionRequest', [PatientPrescriptionController::class, 'addPrescriptionRequest'])->name('addPrescriptionRequest');
Route::get('/patient/showPrescriptionDetails/{id}', [PatientPrescriptionController::class, 'showPrescriptionDetails'])->name('showPrescriptionDetails');
//patient LiveChat
Route::get('/patient/liveChat', [LiveChatController::class, 'showLiveChatPage'])->name('showLiveChatPage');
Route::post('/patient/sendMessage/{chatId}', [LiveChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/patient/getMessages/{chat_id}', [LiveChatController::class, 'getMessages'])->name('patient.getMessages');

//patient videocall
Route::get('/video-call/{employee_id}', [PatientVideoCallController::class, 'startVideoCall'])->name('startVideoCall');
Route::post('/delete-room', [PatientVideoCallController::class, 'deleteRoom'])->name('deleteRoom');

//admin
//-----------------------------------------------------------------------------//
//admin video call
Route::get('/admin/video-call/{patient_id}', [AdminVideoCallController::class, 'startVideoCall'])->name('AdminStartVideoCall');
Route::post('/admin/delete-room', [AdminVideoCallController::class, 'deleteRoom'])->name('adminDeleteRoom');

//admin livechat
Route::get('/admin/chat', [AdminChatController::class, 'showChatPage'])->name('admin.showChatPage');
Route::post('/admin/sendMessage/{chat_id}', [AdminChatController::class, 'sendMessage'])->name('admin.sendMessage');
Route::get('/admin/getMessages/{chat_id}', [AdminChatController::class, 'getMessages'])->name('admin.getMessages');

//admin Login Route
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login'); // Admin login form
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit'); // Admin login submission

//admin appointment Route
Route::get("/admin/appointment", [AppointmentController::class, 'getAllAppointment'])->name('adminAppointment');
Route::get("/admin/appointment/apptForm", [AppointmentController::class, 'showAppointmentForm'])->name('showAppointmentForm');
Route::post("/admin/appointment/apptForm", [AppointmentController::class, 'addAppointment'])->name('addAppointment');
Route::get("/admin/apptDetails/{id}", [AppointmentController::class, "getAppointmentDetails"])->name('apptDetails'); 
Route::get('/admin/apptDetails/patientDetails/{id}', [AppointmentController::class, 'viewPatientDetails'])->name('viewPatientDetails');
Route::get('/validatePatientID/{id}', [AppointmentController::class, 'validatePatientID']);
Route::get("/admin/upcomingAppt", [AppointmentController::class, "getPendingAppointment"])->name('upcomingAppt');
Route::post('/appointments/{id}/assignCaregiver', [AppointmentController::class, 'assignCaregiver'])->name('appointments.assignCaregiver');
Route::post('/appointments/{id}/approve', [AppointmentController::class, 'approveAppointment'])->name('appointments.approve');
Route::get('/appointments-data', [AppointmentController::class, 'getAppointmentsDataForCircle']);   
Route::get('/getAppointmentsCalendar', [AppointmentController::class, 'showAppointmentsOnCalendar']);
Route::get('/appointment-list', [AppointmentController::class, 'getAppointmentsList']);
Route::delete('/admin/deleteAppointment/{id}', [AppointmentController::class, 'deleteAppointment'])->name('deleteAppointment');
Route::post('/appointments/{id}/complete', [AppointmentController::class, 'completeAppointment'])->name('appointments.complete');

//admin Profile
Route::post("/admin/empProfile/updateBio", [EmployeeProfileController::class, 'updateBio'])->name('updateBio');//
Route::post("/admin/empProfile/updatePersonalInfo", [EmployeeProfileController::class, 'updatePersonalInfo'])->name('updatePersonalInfo');//
Route::post("/admin/empProfile/updateAccountInfo", [EmployeeProfileController::class, 'updateAccountInfo'])->name('updateAccountInfo');//
Route::get("/admin/empProfile", [EmployeeProfileController::class, 'showEmployeeProfile'])->name('empProfile');//
Route::get("/admin/empInfo", [EmployeeController::class, "getEmployeedata"])->name('empInfo');//
Route::get("/admin/empDetails/{id}", [EmployeeController::class, "showEmployeeDetails"])->name('empDetails'); //
Route::put('/admin/updateEmp/{id}', [EmployeeController::class, 'updateEmployeeData'])->name('updateEmployeeData');
Route::get("/admin/empForm",[EmployeeController::class, "showEmployeeForm"])->name('showEmpForm');
Route::post('/admin/empForm', [EmployeeController::class, 'addEmployee'])->name('empForm');
Route::get('/employeeDoughnut', [EmployeeController::class, 'getEmployeeDataForDoughnut']);  
Route::put('/employee/profile', [EmployeeProfileController::class, 'updateEmployeePicture'])->name('employee.profile.update');
Route::put('/admin/empDetails/{id}', [EmployeeController::class, 'updateNewEmployeePicture'])->name('updateNewEmployeePicture');
Route::get('/admin/employeeLine', [EmployeeController::class, 'getEmployeeDataLine']);  
Route::delete('/admin/deleteEmployee/{id}', [EmployeeController::class, 'deleteEmployee'])->name('deleteEmployee');

//admin home Route
Route::get("/admin/adminHome",[AdminHomeController::class, 'showAdminHome'])->name('showAdminHome'); //
Route::get('/admin/appointments-by-week', [AdminHomeController::class, 'getAppointmentsByWeek'])->name('appointments.byWeek');


//admin patientInfo
Route::get("/admin/patientInfo",[PatientController::class, 'getAllPatientData'])->name('patientInfo'); //
Route::get("/admin/patientDetails/{id}", [PatientController::class, "showPatientDetails"])->name('patientDetails'); //
Route::put('/admin/patientDetails/{id}', [PatientController::class, 'updatePatientPicture'])->name('updatePatientPicture');//
Route::get('/patient-ages', [PatientController::class, 'getPatientAges']);
Route::get('/patient-density-data', [PatientController::class, 'getPatientDensityData']);
Route::get('/patient-gender-data', [PatientController::class, 'getPatientGenderData']);
Route::get('/admin/Patient/Medical_history/{id}', [PatientController::class, 'downloadPatientMedicalHistory'])->name('MedicalHistory');
Route::post('/admin/Patient/update_Medical_History/{id}', [PatientController::class, 'updateMedicalHistory'])->name('updateMedicalHistory');
Route::get('/admin/patientDetails/{id}/activity-data', [PatientController::class, 'getPatientActivityDataByDay'])->name('getPatientActivityDataByDay');
Route::delete('/admin/deletePatient/{id}', [PatientController::class, 'deletePatientData'])->name('deletePatientData');
Route::put('/admin/updatePatient/{id}', [PatientController::class, 'updatePatientData'])->name('updatePatientData');

//admin care delivery
Route::get("/admin/careDelivery",[CareDeliveryController::class, 'showCareDeliveryPage'])->name('showCareDeliveryPage');
Route::get("/admin/careDeliveryDetails/{id}",[CareDeliveryController::class, 'showCareDeliveryDetails'])->name('showCareDeliveryDetails');
Route::get("/admin/careDeliveryAddress/{id}",[CareDeliveryController::class, 'getCareDeliveryAddress'])->name('getCareDeliveryAddress');
Route::delete('/admin/deleteCareDelivery/{id}', [CareDeliveryController::class, 'deleteCareDeliveryRequest'])->name('deleteCareDeliveryRequest');
Route::put('/admin/approve/caredelivery/{id}', [CareDeliveryController::class, 'updateCareDeliveryDetails'])->name('approve.caredelivery');//
Route::put('/admin/complete/caredelivery/{id}', [CareDeliveryController::class, 'completeCareDeliveryDetails'])->name('complete.caredelivery');//
//admin prescription
Route::get("/admin/prescription",[AdminPrescriptionController::class, 'showPrescriptionPage'])->name('showPrescriptionPage');
Route::get("/admin/prescriptionForm",[AdminPrescriptionController::class, 'showPrescriptionRequestForm'])->name('showPrescriptionRequestForm');
Route::post("/admin/prescriptionForm", [AdminPrescriptionController::class, 'addAdminPrescriptionRequest'])->name('addAdminPrescriptionRequest');
Route::get("/admin/prescriptionDetails/{id}",[AdminPrescriptionController::class, 'showPrescriptionDetails'])->name('prescriptionDetails');
Route::get('/getPrescriptionAddress/{id}', [AdminPrescriptionController::class, 'getPrescriptionAddress'])->name('prescription.address');
Route::put('/admin/approvePrescription/{id}', [AdminPrescriptionController::class, 'approvePrescription'])->name('approvePrescription');
Route::put('/admin/completePrescription/{id}', [AdminPrescriptionController::class, 'completePrescription'])->name('completePrescription');
Route::delete('/admin/deletePrescription/{id}', [AdminPrescriptionController::class, 'deletePrescriptionRequest'])->name('deletePrescriptionRequest');
//admin chat

Route::get('/access-denied', function () {
    return view('admin.accessDenied');
})->name('access.denied');


