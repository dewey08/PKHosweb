<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Http\Controllers\WarehousePayController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RepaireScanController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\UserarticleController;
use App\Http\Controllers\UserComController;
use App\Models\Fire_check;
use App\Models\Fire;


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('fire_detail/{id}', function () {

//     $dataprint = Fire::where('fire_id', '=', $id)->first();
//     $data_detail = Fire_check::where('fire_num', '=', $dataprint->fire_num) 
//     ->leftJoin('users', 'fire_check.user_id', '=', 'users.id')
//     ->get();

//     return view('support_prs.fire.fire_detail', [
//       'dataprint'    => $dataprint,
//       'data_detail'  => $data_detail,
//       'id'           => $id
//   ]);
// });
Route::match(['get','post'],'fire_pramuan',[App\Http\Controllers\FireController::class, 'fire_pramuan'])->name('prs.fire_pramuan');//
Route::match(['get','post'],'fire_pramuan_save',[App\Http\Controllers\FireController::class, 'fire_pramuan_save'])->name('prs.fire_pramuan_save');//
Route::match(['get','post'],'fire_detail/{id}',[App\Http\Controllers\FireController::class, 'fire_detail'])->name('prs.fire_detail');//

Route::match(['get','post'],'air_repaire/{id}',[App\Http\Controllers\AirController::class, 'air_repaire'])->name('prs.air_repaire');//
Route::match(['get','post'],'air_repiare_save',[App\Http\Controllers\AirController::class, 'air_repiare_save'])->name('prs.air_repiare_save');//

// ***************   Report  **********************************
Route::match(['get','post'],'ins_dashboard',[App\Http\Controllers\InstrumentController::class, 'ins_dashboard'])->name('ins.ins_dashboard');//
Route::match(['get','post'],'ins_a',[App\Http\Controllers\InstrumentController::class, 'ins_a'])->name('ins.ins_a');//
Route::match(['get','post'],'ins_b',[App\Http\Controllers\InstrumentController::class, 'ins_b'])->name('ins.ins_b');//

Route::match(['get','post'],'datahosauto',[App\Http\Controllers\AutorpstController::class, 'datahosauto'])->name('sit.datahosauto');//  รพสต
Route::match(['get','post'],'pullhosauto',[App\Http\Controllers\AutorpstController::class, 'pullhosauto'])->name('sit.pullhosauto');//  รพสต
Route::match(['get','post'],'checksit_pullhosauto',[App\Http\Controllers\AutorpstController::class, 'checksit_pullhosauto'])->name('sit.checksit_pullhosauto');//รพสต

Route::match(['get','post'],'contact_save',[App\Http\Controllers\CustormerController::class, 'contact_save'])->name('Cus.contact_save');//

Route::match(['get','post'],'connectdb',[App\Http\Controllers\ConfigDatabaseController::class, 'connectdb'])->name('db.connectdb');//
Route::match(['get','post'],'connectdb_save',[App\Http\Controllers\ConfigDatabaseController::class, 'connectdb_save'])->name('db.connectdb_save');//

// Route::match(['get','post'],'authen_auth_new',[App\Http\Controllers\Auto_authenController::class, 'authen_auth_new'])->name('auto.authen_auth_new');//
// Route::match(['get','post'],'authen_auth_tinew',[App\Http\Controllers\Auto_authenController::class, 'authen_auth_tinew'])->name('auto.authen_auth_tinew');//
Route::match(['get','post'],'pullauthen_spschnew',[App\Http\Controllers\Auto_authenController::class, 'pullauthen_spschnew'])->name('auto.pullauthen_spschnew');//


// Route::match(['get','post'],'fdh_mini_dataset_rep',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_rep'])->name('fdh.fdh_mini_dataset_rep');
// Route::match(['get','post'],'fdh_mini_dataset_pulljong',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pulljong'])->name('fdh.fdh_mini_dataset_pulljong');

//********************* */ KTB  ***********************************
Route::match(['get','post'],'ktb_getcard',[App\Http\Controllers\KTBController::class,'ktb_getcard'])->name('ktb.ktb_getcard');//

Route::match(['get','post'],'ktb_test',[App\Http\Controllers\KTBAPIController::class,'ktb_test'])->name('ktb.ktb_test');//

Route::match(['get','post'],'treedoc',[App\Http\Controllers\KTBController::class,'treedoc'])->name('ktb.treedoc');//

// *******************ทาลัสซีเมีย OPD IPD*******************
Route::match(['get','post'],'thalassemia_opd_new',[App\Http\Controllers\D_thalassemiaController::class, 'thalassemia_opd_new'])->name('t.thalassemia_opd_new');//
Route::match(['get','post'],'thalassemia_ipd_new',[App\Http\Controllers\D_thalassemiaController::class, 'thalassemia_ipd_new'])->name('t.thalassemia_ipd_new');//
Route::match(['get','post'],'getimage/{id}',[App\Http\Controllers\D_thalassemiaController::class, 'getimage'])->name('t.getimage');//

Route::match(['get','post'],'acc_test',[App\Http\Controllers\AccController::class,'acc_test'])->name('ktb.acc_test');

Route::match(['get','post'],'report_authen',[App\Http\Controllers\ReportFontController::class, 'report_authen'])->name('rep.report_authen');// report
Route::match(['get','post'],'report_authen_sub/{month}/{year}',[App\Http\Controllers\ReportFontController::class, 'report_authen_sub'])->name('rep.report_authen_sub');// report
Route::match(['get','post'],'report_authen_subsub/{month}/{year}/{staff}',[App\Http\Controllers\ReportFontController::class, 'report_authen_subsub'])->name('rep.report_authen_subsub');// report

Route::match(['get','post'],'reportauthen_getbar',[App\Http\Controllers\ReportFontController::class, 'reportauthen_getbar'])->name('rep.reportauthen_getbar');// report
Route::match(['get','post'],'reportauthen_getbaripd',[App\Http\Controllers\ReportFontController::class, 'reportauthen_getbaripd'])->name('rep.reportauthen_getbaripd');// report

Route::match(['get','post'],'report_authen_subipd/{month}/{year}',[App\Http\Controllers\ReportFontController::class, 'report_authen_subipd'])->name('rep.report_authen_subipd');// report
Route::match(['get','post'],'report_authen_subsubipd/{month}/{year}/{staff}',[App\Http\Controllers\ReportFontController::class, 'report_authen_subsubipd'])->name('rep.report_authen_subsubipd');// report

Route::match(['get','post'],'authen/getauthen_auto',[App\Http\Controllers\AUTHENCHECKController::class, 'getauthen_auto'])->name('getauthen_auto');
Route::match(['get','post'],'authen_getbar',[App\Http\Controllers\AUTHENCHECKController::class, 'authen_getbar'])->name('authen_getbar');
Route::match(['get','post'],'authen_getbar_days',[App\Http\Controllers\AUTHENCHECKController::class, 'authen_getbar_days'])->name('authen_getbar_days');

Route::match(['get','post'],'report_dashboard',[App\Http\Controllers\ReportFontController::class, 'report_dashboard'])->name('rep.report_dashboard');// report
Route::match(['get','post'],'report_or',[App\Http\Controllers\ReportFontController::class, 'report_or'])->name('rep.report_or');// report
Route::match(['get','post'],'report_ormonth/{month}',[App\Http\Controllers\ReportFontController::class, 'report_ormonth'])->name('rep.report_ormonth');// report
Route::match(['get','post'],'report_refer',[App\Http\Controllers\ReportFontController::class, 'report_refer'])->name('rep.report_refer');// report report_refer
Route::match(['get','post'],'report_refer_thairefer',[App\Http\Controllers\ReportFontController::class, 'report_refer_thairefer'])->name('rep.report_refer_thairefer');// report report_refer
Route::match(['get','post'],'report_refer_thairefer_detail/{newDate}/{datenow}',[App\Http\Controllers\ReportFontController::class, 'report_refer_thairefer_detail'])->name('rep.report_refer_thairefer_detail');// report report_refer
Route::match(['get','post'],'report_refer_hos',[App\Http\Controllers\ReportFontController::class, 'report_refer_hos'])->name('rep.report_refer_hos');// report report_refer
Route::match(['get','post'],'report_refer_opds',[App\Http\Controllers\ReportFontController::class, 'report_refer_opds'])->name('rep.report_refer_opds');// report report_refer
Route::match(['get','post'],'report_refer_opds_sub/{months}/{startdate}/{enddate}',[App\Http\Controllers\ReportFontController::class, 'report_refer_opds_sub'])->name('rep.report_refer_opds_sub');// report report_refer
Route::match(['get','post'],'report_refer_opds_subvn/{months}/{hospcode}/{startdate}/{enddate}',[App\Http\Controllers\ReportFontController::class, 'report_refer_opds_subvn'])->name('rep.report_refer_opds_subvn');// report report_refer
Route::match(['get','post'],'report_refer_opds_subct/{months}/{hospcode}/{startdate}/{enddate}',[App\Http\Controllers\ReportFontController::class, 'report_refer_opds_subct'])->name('rep.report_refer_opds_subct');// report report_refer
Route::match(['get','post'],'refer_opds_cross',[App\Http\Controllers\ReportFontController::class, 'refer_opds_cross'])->name('rep.refer_opds_cross');// report report_refer
Route::match(['get','post'],'refer_opds_cross_excel/{startdate}/{enddate}/{hospcode}',[App\Http\Controllers\ReportFontController::class, 'refer_opds_cross_excel'])->name('rep.refer_opds_cross_excel');// report report_refer
Route::match(['get','post'],'cross_exportexcel',[App\Http\Controllers\ReportFontController::class, 'cross_exportexcel'])->name('rep.cross_exportexcel');// report report_refer

Route::match(['get','post'],'check_knee',[App\Http\Controllers\ReportFontController::class, 'check_knee'])->name('rep.check_knee');// report ข้อเข่า
Route::match(['get','post'],'check_knee_ipddetail/{newDate}/{datenow}',[App\Http\Controllers\ReportFontController::class, 'check_knee_ipddetail'])->name('rep.check_knee_ipddetail');// report ข้อเข่า
Route::match(['get','post'],'check_knee_ipd',[App\Http\Controllers\ReportFontController::class, 'check_knee_ipd'])->name('rep.check_knee_ipd');// report ข้อเข่า
Route::match(['get','post'],'check_knee_opd',[App\Http\Controllers\ReportFontController::class, 'check_knee_opd'])->name('rep.check_knee_opd');// report ข้อเข่า
Route::match(['get','post'],'check_icd9_ipd',[App\Http\Controllers\ReportFontController::class, 'check_icd9_ipd'])->name('rep.check_icd9_ipd');// report

Route::match(['get','post'],'check_colpo_ipd',[App\Http\Controllers\ReportFontController::class, 'check_colpo_ipd'])->name('rep.check_colpo_ipd');// report

Route::match(['get','post'],'report_ct',[App\Http\Controllers\ReportFontController::class, 'report_ct'])->name('rep.report_ct');// report

Route::match(['get','post'],'check_kradook',[App\Http\Controllers\ReportFontController::class, 'check_kradook'])->name('rep.check_kradook');// report แผ่นโลหะดามกระดูก
Route::match(['get','post'],'check_kradookdetail/{newDate}/{datenow}',[App\Http\Controllers\ReportFontController::class, 'check_kradookdetail'])->name('rep.check_kradookdetail');// report แผ่นโลหะดามกระดูก

Route::match(['get','post'],'check_khosaphok',[App\Http\Controllers\ReportFontController::class, 'check_khosaphok'])->name('rep.check_khosaphok');// report ข้อสะโพก
Route::match(['get','post'],'check_khosaphokdetail/{newDate}/{datenow}',[App\Http\Controllers\ReportFontController::class, 'check_khosaphokdetail'])->name('rep.check_khosaphokdetail');// report ข้อสะโพก
Route::match(['get','post'],'check_bumbat_detail/{newDate}/{datenow}',[App\Http\Controllers\ReportFontController::class, 'check_bumbat_detail'])->name('rep.check_bumbat_detail');// 
Route::match(['get','post'],'check_lapo_detail/{newDate}/{datenow}',[App\Http\Controllers\ReportFontController::class, 'check_lapo_detail'])->name('rep.check_lapo_detail');// 

Route::match(['get','post'],'check_bumbat',[App\Http\Controllers\ReportIncomeController::class, 'check_bumbat'])->name('rep.check_bumbat');// ค่าอวัยวะเทียม/อุปกรณ์ในการบำบัดรักษา
Route::match(['get','post'],'check_lapo',[App\Http\Controllers\ReportIncomeController::class, 'check_lapo'])->name('rep.check_lapo');// 

Route::get('book/bookmake_detail/{id}',[App\Http\Controllers\BookController::class, 'bookmake_detail'])->name('book.bookmake_detail');
Route::get('computer/com_repair_add/{id}',[App\Http\Controllers\RepaireScanController::class, 'com_repair_add']);// แจ้งซ่อมคอมพิวเตอร์ ผ่านสแกน
Route::match(['get','post'],'com_repairscan_save',[App\Http\Controllers\RepaireScanController::class, 'com_repairscan_save'])->name('com_repairscan_save');//

Route::get('authen_dashboard',[App\Http\Controllers\AuthenController::class, 'authen_dashboard'])->name('au.authen_dashboard');
Route::get('authen_detail/{dep}',[App\Http\Controllers\AuthenController::class, 'authen_detail'])->name('au.authen_detail');
Route::get('authen_user/{iduser}',[App\Http\Controllers\AuthenController::class, 'authen_user'])->name('au.authen_user');
Route::post('authen_check',[App\Http\Controllers\AuthenController::class, 'authen_check'])->name('au.authen_check');
Route::post('/import',[App\Http\Controllers\AuthenController::class,'import'])->name('import');
Route::get('import_authen_auto',[App\Http\Controllers\AuthenController::class,'import_authen_auto'])->name('import_authen_auto');
Route::get('authen_realtime',[App\Http\Controllers\AuthenController::class,'authen_realtime'])->name('authen_realtime');

Route::match(['get','post'],'token_add',[App\Http\Controllers\AUTHENCHECKController::class,'token_add'])->name('aa.token_add');
Route::match(['get','post'],'token_save',[App\Http\Controllers\AUTHENCHECKController::class,'token_save'])->name('aa.token_save');

Route::match(['get','post'],'authencode_confirm',[App\Http\Controllers\AuthenautoController::class,'authencode_confirm'])->name('authencode_confirm');

Route::match(['get','post'],'authencode_auto',[App\Http\Controllers\AuthenautoController::class,'authencode_auto'])->name('authencode_auto');
Route::match(['get','post'],'authencode_auto_detail',[App\Http\Controllers\AuthenautoController::class,'authencode_auto_detail'])->name('authencode_auto_detail');
Route::match(['get','post'],'authencode_auto_save',[App\Http\Controllers\AuthenautoController::class,'authencode_auto_save'])->name('authencode_auto_save');
Route::match(['get','post'],'getsmartcard_authencode',[App\Http\Controllers\AuthenautoController::class,'getsmartcard_authencode'])->name('getsmartcard_authencode');

Route::get('authen_main', [App\Http\Controllers\AuthencodeController::class, 'authen_main'])->name('authen_main');
Route::get('authen_index', [App\Http\Controllers\AuthencodeController::class, 'authen_index'])->name('authen_index');
Route::get('/read', [App\Http\Controllers\AuthencodeController::class, 'read'])->name('read');
Route::get('authen_cid', [App\Http\Controllers\AuthencodeController::class, 'authen_cid'])->name('authen_cid');
Route::get('check_sit', [App\Http\Controllers\AuthencodeController::class, 'check_sit'])->name('c.check_sit');

// Route::get('fetch','PersonController@fetch')->name('dropdown.fetch');
// Route::get('fetchsub','PersonController@fetchsub')->name('dropdown.fetchsub');
Route::match(['get','post'],'fetch_province', [App\Http\Controllers\AuthencodeController::class, 'fetch_province'])->name('fecth.fetch_province');
Route::match(['get','post'],'fetch_amphur', [App\Http\Controllers\AuthencodeController::class, 'fetch_amphur'])->name('fecth.fetch_amphur');
Route::match(['get','post'],'fetch_tumbon', [App\Http\Controllers\AuthencodeController::class, 'fetch_tumbon'])->name('fecth.fetch_tumbon');
Route::match(['get','post'],'fetch_pocode', [App\Http\Controllers\AuthencodeController::class, 'fetch_pocode'])->name('fecth.fetch_pocode');

Route::POST('authencode', [App\Http\Controllers\AuthencodeController::class, 'authencode'])->name('a.authencode');
Route::match(['get','post'],'authencode_visit', [App\Http\Controllers\AuthencodeController::class, 'authencode_visit'])->name('a.authencode_visit');
Route::match(['get','post'],'authencode_patient_save', [App\Http\Controllers\AuthencodeController::class, 'authencode_patient_save'])->name('a.authencode_patient_save');
Route::match(['get','post'],'authencode_visit_save', [App\Http\Controllers\AuthencodeController::class, 'authencode_visit_save'])->name('a.authencode_visit_save');
Route::POST('authen_save', [App\Http\Controllers\AuthencodeController::class, 'authen_save'])->name('a.authen_save');
Route::match(['get','post'],'authencode_index',[App\Http\Controllers\AUTHENCHECKController::class,'authencode_index'])->name('aa.authencode_index');
// Route::match(['get','post'],'getsmartcard_authencode',[App\Http\Controllers\AUTHENCHECKController::class,'getsmartcard_authencode'])->name('getsmartcard_authencode');
Route::match(['get','post'],'smartcard_authencode_save',[App\Http\Controllers\AUTHENCHECKController::class,'smartcard_authencode_save'])->name('smartcard_authencode_save');

Route::match(['get','post'],'authen/checkauthen_main',[App\Http\Controllers\AUTHENCHECKController::class, 'checkauthen_main'])->name('checkauthen_main');
Route::match(['get','post'],'authen/checkauthen_auto',[App\Http\Controllers\AUTHENCHECKController::class, 'checkauthen_auto'])->name('checkauthen_auto');


Route::match(['get','post'],'authen/checkauthen_update_vn',[App\Http\Controllers\AUTHENCHECKController::class, 'checkauthen_update_vn'])->name('checkauthen_update_vn');
Route::match(['get','post'],'checkauthen_update_vn_data',[App\Http\Controllers\AUTHENCHECKController::class, 'checkauthen_update_vn_data'])->name('Sit.checkauthen_update_vn_data');


Route::match(['get','post'],'checkauthen_autospsch',[App\Http\Controllers\AutoController::class, 'checkauthen_autospsch'])->name('sit.checkauthen_autospsch');
Route::match(['get','post'],'sit',[App\Http\Controllers\AutoController::class, 'sit'])->name('sit.sit');//
Route::match(['get','post'],'sit_pull_auto',[App\Http\Controllers\AutoController::class, 'sit_pull_auto'])->name('sit.sit_pull_auto');//
Route::match(['get','post'],'sit_auto',[App\Http\Controllers\AutoController::class, 'sit_auto'])->name('sit.sit_auto');//
Route::match(['get','post'],'repage',[App\Http\Controllers\AutoController::class, 'repage'])->name('sit.repage');//
Route::match(['get','post'],'sit_pullacc_auto',[App\Http\Controllers\AutoController::class, 'sit_pullacc_auto'])->name('auto.sit_pullacc_auto');//

Route::match(['get','post'],'sss_check_claimcode',[App\Http\Controllers\AutoController::class, 'sss_check_claimcode'])->name('check.sss_check_claimcode');//
Route::match(['get','post'],'check_prb202',[App\Http\Controllers\AutoController::class, 'check_prb202'])->name('check.check_prb202');//
Route::match(['get','post'],'check_304',[App\Http\Controllers\AutoController::class, 'check_304'])->name('check.check_304');//
Route::match(['get','post'],'check_308',[App\Http\Controllers\AutoController::class, 'check_308'])->name('check.check_308');//
Route::match(['get','post'],'check_309',[App\Http\Controllers\AutoController::class, 'check_309'])->name('check.check_309');//
Route::match(['get','post'],'inst_opitemrece',[App\Http\Controllers\AutoController::class, 'inst_opitemrece'])->name('check.inst_opitemrece');//


// Checksit_hos   // เช็คสิทธิ์ สปสช เอาทุกสิทธิ์ 
Route::match(['get','post'],'pull_Checksit_hosauto',[App\Http\Controllers\AutoController::class, 'pull_Checksit_hosauto'])->name('auto.pull_Checksit_hosauto');//
Route::match(['get','post'],'checksit_pullhosmanual',[App\Http\Controllers\AutoController::class, 'checksit_pullhosmanual'])->name('manual.checksit_pullhosmanual');// ดึงข้อมูลแบบ Manual
Route::match(['get','post'],'checksit_hosmanual',[App\Http\Controllers\AutoController::class, 'checksit_hosmanual'])->name('manual.checksit_hosmanual');// ตรวจสิทธิ์ข้อมูลแบบ Manual
Route::match(['get','post'],'checksit_hosauto',[App\Http\Controllers\AutoController::class, 'checksit_hosauto'])->name('auto.checksit_hosauto');//

// Check_sit_auto   // เช็คสิทธิ์ สปสช
Route::match(['get','post'],'pull_hosauto',[App\Http\Controllers\Auto_authenController::class, 'pull_hosauto'])->name('auto.pull_hosauto');//
Route::match(['get','post'],'checksit_auto',[App\Http\Controllers\AutoController::class, 'checksit_auto'])->name('auto.checksit_auto');//

Route::match(['get','post'],'pull_hosallauto',[App\Http\Controllers\AutoController::class, 'pull_hosallauto'])->name('auto.pull_hosallauto');//
Route::match(['get','post'],'checksitall_auto',[App\Http\Controllers\AutoController::class, 'checksitall_auto'])->name('auto.checksitall_auto');//
Route::match(['get','post'],'check_allsit_day',[App\Http\Controllers\AutoController::class, 'check_allsit_day'])->name('auto.check_allsit_day');//
Route::match(['get','post'],'check_allsit_day_send',[App\Http\Controllers\AutoController::class, 'check_allsit_day_send'])->name('auto.check_allsit_day_send');//

Route::match(['get','post'],'pullauthen_spschtohos',[App\Http\Controllers\Auto_authenController::class, 'pullauthen_spschtohos'])->name('auto.pullauthen_spschtohos');//
Route::match(['get','post'],'updateauthen_spschtohos',[App\Http\Controllers\Auto_authenController::class, 'updateauthen_spschtohos'])->name('auto.updateauthen_spschtohos');//205
Route::match(['get','post'],'updateauthen_spschtohos217',[App\Http\Controllers\Auto_authenController::class, 'updateauthen_spschtohos217'])->name('auto.updateauthen_spschtohos217');//217
Route::match(['get','post'],'updateauthen_tispschtohos',[App\Http\Controllers\Auto_authenController::class, 'updateauthen_tispschtohos'])->name('auto.updateauthen_tispschtohos');// 205
Route::match(['get','post'],'updateauthen_tispschtohos217',[App\Http\Controllers\Auto_authenController::class, 'updateauthen_tispschtohos217'])->name('auto.updateauthen_tispschtohos217');// 217
Route::match(['get','post'],'updateauthen_spschtochecksitauto',[App\Http\Controllers\Auto_authenController::class, 'updateauthen_spschtochecksitauto'])->name('auto.updateauthen_spschtochecksitauto');//217

Route::match(['get','post'],'pullauthen_spsch',[App\Http\Controllers\Auto_authenController::class, 'pullauthen_spsch'])->name('auto.pullauthen_spsch');//
Route::match(['get','post'],'updaet_authen_to_checksitauto',[App\Http\Controllers\Auto_authenController::class, 'updaet_authen_to_checksitauto'])->name('auto.updaet_authen_to_checksitauto');//
Route::match(['get','post'],'checksithos_auto',[App\Http\Controllers\Auto_authenController::class, 'checksithos_auto'])->name('auto.checksithos_auto');//
Route::match(['get','post'],'pullauthen_tispsch',[App\Http\Controllers\Auto_authenController::class, 'pullauthen_tispsch'])->name('auto.pullauthen_tispsch');//
Route::match(['get','post'],'updaet_authen_to_checksittiauto',[App\Http\Controllers\Auto_authenController::class, 'updaet_authen_to_checksittiauto'])->name('auto.updaet_authen_to_checksittiauto');//

Route::match(['get','post'],'dbday_auto',[App\Http\Controllers\AutoController::class, 'dbday_auto'])->name('db.dbday_auto');//
Route::match(['get','post'],'depauthen_auto',[App\Http\Controllers\AutoController::class, 'depauthen_auto'])->name('db.depauthen_auto');//
Route::match(['get','post'],'authen_auto_year',[App\Http\Controllers\AutoController::class, 'authen_auto_year'])->name('db.authen_auto_year');//
Route::match(['get','post'],'db_authen_detail',[App\Http\Controllers\AutoController::class, 'db_authen_detail'])->name('db.db_authen_detail');//

Route::match(['get','post'],'check_authen',[App\Http\Controllers\ChecksitController::class, 'check_authen'])->name('claim.check_authen');//
Route::match(['get','post'],'check_authen_excel',[App\Http\Controllers\ChecksitController::class, 'check_authen_excel'])->name('claim.check_authen_excel');//
Route::match(['get','post'],'check_authen_send',[App\Http\Controllers\ChecksitController::class, 'check_authen_send'])->name('claim.check_authen_send');//

Route::match(['get','post'],'check_sit_day',[App\Http\Controllers\ChecksitController::class, 'check_sit_day'])->name('claim.check_sit_day');//
Route::match(['get','post'],'check_sit_daysearch',[App\Http\Controllers\ChecksitController::class, 'check_sit_daysearch'])->name('claim.check_sit_daysearch');//
Route::match(['get','post'],'check_authen_day',[App\Http\Controllers\ChecksitController::class, 'check_authen_day'])->name('claim.check_authen_day');//
Route::match(['get','post'],'import_authen_day',[App\Http\Controllers\ChecksitController::class, 'import_authen_day'])->name('claim.import_authen_day');//
Route::match(['get','post'],'import_authen_daysave',[App\Http\Controllers\ChecksitController::class, 'import_authen_daysave'])->name('claim.import_authen_daysave');//
Route::match(['get','post'],'import_authen_daysend',[App\Http\Controllers\ChecksitController::class, 'import_authen_daysend'])->name('claim.import_authen_daysend');//

Route::match(['get','post'],'check_dashboard',[App\Http\Controllers\ChecksitController::class, 'check_dashboard'])->name('claim.check_dashboard');//
Route::match(['get','post'],'check_dashboard_authen/{day}/{month}/{year}',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_authen'])->name('claim.check_dashboard_authen');//
Route::match(['get','post'],'check_dashboard_noauthen/{day}/{month}/{year}',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_noauthen'])->name('claim.check_dashboard_noauthen');//
Route::match(['get','post'],'check_dashboard_bar',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_bar'])->name('claim.check_dashboard_bar');
Route::match(['get','post'],'check_dashboard_line',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_line'])->name('claim.check_dashboard_line');
Route::match(['get','post'],'check_line',[App\Http\Controllers\ChecksitController::class, 'check_line'])->name('claim.check_line');
Route::match(['get','post'],'check_buble',[App\Http\Controllers\ChecksitController::class, 'check_buble'])->name('claim.check_buble');
Route::match(['get','post'],'check_type_bar',[App\Http\Controllers\ChecksitController::class, 'check_type_bar'])->name('claim.check_type_bar');

Route::match(['get','post'],'check_dashboard_mob',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_mob'])->name('claim.check_dashboard_mob');//
Route::match(['get','post'],'check_dashboard_authen_mob/{day}/{month}/{year}',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_authen_mob'])->name('claim.check_dashboard_authen_mob');//
Route::match(['get','post'],'check_dashboard_noauthen_mob/{day}/{month}/{year}',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_noauthen_mob'])->name('claim.check_dashboard_noauthen_mob');//

Route::match(['get','post'],'check_dashboard_staff/{staff}/{day}/{month}/{year}',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_staff'])->name('claim.check_dashboard_staff');//
Route::match(['get','post'],'check_dashboard_staffno/{staff}/{day}/{month}/{year}',[App\Http\Controllers\ChecksitController::class, 'check_dashboard_staffno'])->name('claim.check_dashboard_staffno');//

Route::match(['get','post'],'check_web',[App\Http\Controllers\ChecksitController::class, 'check_web'])->name('claim.check_web');//
Route::match(['get','post'],'check_spsch',[App\Http\Controllers\ChecksitController::class, 'check_spsch'])->name('claim.check_spsch');//
Route::match(['get','post'],'check_spsch_detail',[App\Http\Controllers\ChecksitController::class, 'check_spsch_detail'])->name('claim.check_spsch_detail');//
Route::match(['get','post'],'check_sit_daysitauto',[App\Http\Controllers\ChecksitController::class, 'check_sit_daysitauto'])->name('claim.check_sit_daysitauto');//
Route::match(['get','post'],'check_sit_daypullauto',[App\Http\Controllers\ChecksitController::class, 'check_sit_daypullauto'])->name('claim.check_sit_daypullauto');//

Route::match(['get','post'],'check_api',[App\Http\Controllers\ChecksitController::class, 'check_api'])->name('claim.check_api');//

Route::match(['get','post'],'check_sit_pull',[App\Http\Controllers\ChecksitController::class, 'check_sit_pull'])->name('claim.check_sit_pull');//
Route::match(['get','post'],'check_sit_font',[App\Http\Controllers\ChecksitController::class, 'check_sit_font'])->name('claim.check_sit_font');//
Route::match(['get','post'],'check_sit_token',[App\Http\Controllers\ChecksitController::class, 'check_sit_token'])->name('claim.check_sit_token');//

Route::match(['get','post'],'check_sit_money',[App\Http\Controllers\ChecksitController::class, 'check_sit_money'])->name('claim.check_sit_money');//
Route::match(['get','post'],'check_sit_money_pk',[App\Http\Controllers\ChecksitController::class, 'check_sit_money_pk'])->name('claim.check_sit_money_pk');//

Route::match(['get','post'],'screening_cigarette',[App\Http\Controllers\PPFSController::class, 'screening_cigarette'])->name('pp.screening_cigarette');//การคัดกรองและบำบัดผู้ติดบุหรี่
Route::match(['get','post'],'screening_spirits',[App\Http\Controllers\PPFSController::class, 'screening_spirits'])->name('pp.screening_spirits');//การคัดกรองและบำบัดผู้ดื่มสุรา

Route::match(['get','post'],'surgery_index',[App\Http\Controllers\SurgeryController::class, 'surgery_index'])->name('s.surgery_index');// รายงานศัลยกรรม
Route::match(['get','post'],'surgery_page/{dep}',[App\Http\Controllers\SurgeryController::class, 'surgery_page'])->name('s.surgery_page');// รายงานศัลยกรรม

Route::match(['get','post'],'telemedicine',[App\Http\Controllers\TelemedicineController::class, 'telemedicine'])->name('s.telemedicine');// telemedicine
Route::match(['get','post'],'telemedicine_visit',[App\Http\Controllers\TelemedicineController::class, 'telemedicine_visit'])->name('s.telemedicine_visit');// telemedicine


Route::match(['get','post'],'import_stm',[App\Http\Controllers\UpstmController::class, 'import_stm'])->name('s.import_stm');// ทดสอบ Import
Route::match(['get','post'],'import_stm_save',[App\Http\Controllers\UpstmController::class, 'import_stm_save'])->name('s.import_stm_save');// ทดสอบ Import

Route::match(['get','post'],'stm_aipn',[App\Http\Controllers\UpstmController::class, 'stm_aipn'])->name('s.stm_aipn');// ทดสอบ Import
Route::match(['get','post'],'import_stm_aipn',[App\Http\Controllers\UpstmController::class, 'import_stm_aipn'])->name('s.import_stm_aipn');// ทดสอบ Import
Route::match(['get','post'],'import_stm_aipnmax',[App\Http\Controllers\UpstmController::class, 'import_stm_aipnmax'])->name('s.import_stm_aipnmax');// ทดสอบ Import
Route::match(['get','post'],'import_stm_aipnsave',[App\Http\Controllers\UpstmController::class, 'import_stm_aipnsave'])->name('s.import_stm_aipnsave');// ทดสอบ Import

Route::match(['get','post'],'import_rep_aipn',[App\Http\Controllers\UpstmController::class, 'import_rep_aipn'])->name('s.import_rep_aipn');// ทดสอบ Import
Route::match(['get','post'],'import_rep_aipn_save',[App\Http\Controllers\UpstmController::class, 'import_rep_aipn_save'])->name('s.import_rep_aipn_save');// ทดสอบ Import

Route::match(['get','post'],'uprep_money',[App\Http\Controllers\UpstmController::class, 'uprep_money'])->name('acc.uprep_money');//
Route::match(['get','post'],'uprep_money_save',[App\Http\Controllers\UpstmController::class, 'uprep_money_save'])->name('acc.uprep_money_save');//
Route::match(['get','post'],'uprep_money_edit/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_money_edit'])->name('acc.uprep_money_edit');//
Route::match(['get','post'],'uprep_money_update',[App\Http\Controllers\UpstmController::class, 'uprep_money_update'])->name('acc.uprep_money_update');//
Route::match(['get','post'],'uprepdestroy/{id}',[App\Http\Controllers\UpstmController::class, 'uprepdestroy'])->name('acc.uprepdestroy');//
// Route::DELETE('uprepdestroy/{id}',[App\Http\Controllers\UpstmController::class, 'uprepdestroy']);//
Route::match(['get','post'],'uprep_money_updatefile',[App\Http\Controllers\UpstmController::class, 'uprep_money_updatefile'])->name('acc.uprep_money_updatefile');//



Route::match(['get','post'],'uprep_sss_304',[App\Http\Controllers\UpstmController::class, 'uprep_sss_304'])->name('acc.uprep_sss_304');//
Route::match(['get','post'],'uprep_sss_304edit/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_304edit'])->name('acc.uprep_sss_304edit');//
Route::match(['get','post'],'uprep_sss_304_update',[App\Http\Controllers\UpstmController::class, 'uprep_sss_304_update'])->name('acc.uprep_sss_304_update');//

Route::match(['get','post'],'uprep_sss_307',[App\Http\Controllers\UpstmController::class, 'uprep_sss_307'])->name('acc.uprep_sss_307');//
Route::match(['get','post'],'uprep_sss_307edit/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_307edit'])->name('acc.uprep_sss_307edit');//
Route::match(['get','post'],'uprep_sss_307_update',[App\Http\Controllers\UpstmController::class, 'uprep_sss_307_update'])->name('acc.uprep_sss_307_update');//

Route::match(['get','post'],'uprep_sss_308',[App\Http\Controllers\UpstmController::class, 'uprep_sss_308'])->name('acc.uprep_sss_308');//
Route::match(['get','post'],'uprep_sss_308edit/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_308edit'])->name('acc.uprep_sss_308edit');//
Route::match(['get','post'],'uprep_sss_308_update',[App\Http\Controllers\UpstmController::class, 'uprep_sss_308_update'])->name('acc.uprep_sss_308_update');//

Route::match(['get','post'],'uprep_sss_309',[App\Http\Controllers\UpstmController::class, 'uprep_sss_309'])->name('acc.uprep_sss_309');//
Route::match(['get','post'],'uprep_sss_309edit/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_309edit'])->name('acc.uprep_sss_309edit');//
Route::match(['get','post'],'uprep_sss_309_update',[App\Http\Controllers\UpstmController::class, 'uprep_sss_309_update'])->name('acc.uprep_sss_309_update');//

Route::match(['get','post'],'uprep_sss_all',[App\Http\Controllers\UpstmController::class, 'uprep_sss_all'])->name('acc.uprep_sss_all');//
Route::match(['get','post'],'uprep_sss_syncall',[App\Http\Controllers\UpstmController::class, 'uprep_sss_syncall'])->name('acc.uprep_sss_syncall');//
// Route::match(['get','post'],'uprep_sss_alledit/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_alledit'])->name('acc.uprep_sss_alledit');//
Route::match(['get','post'],'uprep_sss_alledit/{pang}/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_alledit'])->name('acc.uprep_sss_alledit');//
Route::match(['get','post'],'uprep_sss_alleditpage/{account}/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_sss_alleditpage'])->name('acc.uprep_sss_alleditpage');//
Route::match(['get','post'],'uprep_sss_all_update',[App\Http\Controllers\UpstmController::class, 'uprep_sss_all_update'])->name('acc.uprep_sss_all_update');//
Route::match(['get','post'],'uprep_money_plb',[App\Http\Controllers\UpstmController::class, 'uprep_money_plb'])->name('acc.uprep_money_plb');//
Route::match(['get','post'],'uprep_money_plbop_all',[App\Http\Controllers\UpstmController::class, 'uprep_money_plbop_all'])->name('acc.uprep_money_plbop_all');//
Route::match(['get','post'],'uprep_money_plbop_alledit/{account}/{id}',[App\Http\Controllers\UpstmController::class, 'uprep_money_plbop_alledit'])->name('acc.uprep_money_plbop_alledit');//
Route::match(['get','post'],'uprep_money_plbop_allupdate',[App\Http\Controllers\UpstmController::class, 'uprep_money_plbop_allupdate'])->name('acc.uprep_money_plbop_allupdate');//
Route::match(['get','post'],'uprep_money_plbop',[App\Http\Controllers\UpstmController::class, 'uprep_money_plbop'])->name('acc.uprep_money_plbop');//
Route::match(['get','post'],'uprep_money_plbip',[App\Http\Controllers\UpstmController::class, 'uprep_money_plbip'])->name('acc.uprep_money_plbip');//
Route::match(['get','post'],'uprep_money_plbhn',[App\Http\Controllers\UpstmController::class, 'uprep_money_plbhn'])->name('acc.uprep_money_plbhn');//

Route::match(['get','post'],'report_zero',[App\Http\Controllers\ReportZeroController::class, 'report_zero'])->name('claim.report_zero');//



// *******************Vaccein *******************
Route::match(['get','post'],'hpv_report',[App\Http\Controllers\VaccineController::class, 'hpv_report'])->name('claim.hpv_report');//
Route::match(['get','post'],'hpv_report_pull',[App\Http\Controllers\VaccineController::class, 'hpv_report_pull'])->name('claim.hpv_report_pull');//


// *******************CRRT *******************
Route::match(['get','post'],'crrt',[App\Http\Controllers\CrrtController::class, 'crrt'])->name('claim.crrt');//
Route::match(['get','post'],'crrt_process',[App\Http\Controllers\CrrtController::class, 'crrt_process'])->name('claim.crrt_process');//
Route::match(['get','post'],'crrt_export',[App\Http\Controllers\CrrtController::class, 'crrt_export'])->name('claim.crrt_export');//
Route::match(['get','post'],'crrt_exportapi',[App\Http\Controllers\CrrtController::class, 'crrt_exportapi'])->name('claim.crrt_exportapi');//
Route::match(['get','post'],'crrt_sendapi',[App\Http\Controllers\CrrtController::class, 'crrt_sendapi'])->name('claim.crrt_sendapi');//
Route::match(['get','post'],'crrt_report',[App\Http\Controllers\CrrtController::class, 'crrt_report'])->name('claim.crrt_report');//

// *******************OFC *******************
Route::match(['get','post'],'ofc_401_main',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_main'])->name('claim.ofc_401_main');//
Route::match(['get','post'],'ofc_401',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401'])->name('claim.ofc_401');//
Route::match(['get','post'],'ofc_401_process',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_process'])->name('claim.ofc_401_process');//
Route::match(['get','post'],'ofc_401_export',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_export'])->name('claim.ofc_401_export');//
Route::match(['get','post'],'ofc_401_rep',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_rep'])->name('claim.ofc_401_rep');//
Route::match(['get','post'],'ofc_401_repsave',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_repsave'])->name('claim.ofc_401_repsave');//
Route::match(['get','post'],'ofc_401_repsend',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_repsend'])->name('claim.ofc_401_repsend');//
Route::match(['get','post'],'ofc_401_check',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_check'])->name('claim.ofc_401_check');//
// Route::match(['get','post'],'ofc_401_sendapi',[App\Http\Controllers\Ofc401Controller::class, 'ofc_401_sendapi'])->name('claim.ofc_401_sendapi');//

Route::match(['get','post'],'ofc_401_exportapi',[App\Http\Controllers\Ofc401_apiController::class, 'ofc_401_exportapi'])->name('claim.ofc_401_exportapi');//
Route::match(['get','post'],'ofc_401_sendapi',[App\Http\Controllers\Ofc401_apiController::class, 'ofc_401_sendapi'])->name('claim.ofc_401_sendapi');//


Route::match(['get','post'],'ofc_402',[App\Http\Controllers\Ofc402Controller::class, 'ofc_402'])->name('claim.ofc_402');//
Route::match(['get','post'],'ofc_402_process',[App\Http\Controllers\Ofc402Controller::class, 'ofc_402_process'])->name('claim.ofc_402_process');//
Route::match(['get','post'],'ofc_402_export',[App\Http\Controllers\Ofc402Controller::class, 'ofc_402_export'])->name('claim.ofc_402_export');//
Route::match(['get','post'],'ofc_402_exportapi',[App\Http\Controllers\Ofc402Controller::class, 'ofc_402_exportapi'])->name('claim.ofc_402_exportapi');//
Route::match(['get','post'],'ofc_402_sendapi',[App\Http\Controllers\Ofc402Controller::class, 'ofc_402_sendapi'])->name('claim.ofc_402_sendapi');//

// ******************* LGO *******************
Route::match(['get','post'],'lgo_801',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801'])->name('claim.lgo_801');//
Route::match(['get','post'],'lgo_801_process',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_process'])->name('claim.lgo_801_process');//
Route::match(['get','post'],'lgo_801_export',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_export'])->name('claim.lgo_801_export');//
Route::match(['get','post'],'lgo_801_export_api',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_export_api'])->name('claim.lgo_801_export_api');//
Route::match(['get','post'],'lgo_801_send_api',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_send_api'])->name('claim.lgo_801_send_api');//
Route::match(['get','post'],'lgo_801_main',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_main'])->name('claim.lgo_801_main');//
Route::match(['get','post'],'lgo_801_rep',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_rep'])->name('claim.lgo_801_rep');//
Route::match(['get','post'],'lgo_801_check',[App\Http\Controllers\Lgo801Controller::class, 'lgo_801_check'])->name('claim.lgo_801_check');//

Route::match(['get','post'],'home_ward',[App\Http\Controllers\HomewardController::class, 'home_ward'])->name('claim.home_ward');//
Route::match(['get','post'],'home_ward_process',[App\Http\Controllers\HomewardController::class, 'home_ward_process'])->name('claim.home_ward_process');//
Route::match(['get','post'],'home_ward_export',[App\Http\Controllers\HomewardController::class, 'home_ward_export'])->name('claim.home_ward_export');//
Route::match(['get','post'],'home_ward_exportapi',[App\Http\Controllers\HomewardController::class, 'home_ward_exportapi'])->name('claim.home_ward_exportapi');//
Route::match(['get','post'],'home_ward_sendapi',[App\Http\Controllers\HomewardController::class, 'home_ward_sendapi'])->name('claim.home_ward_sendapi');//

// Route::match(['get','post'],'thalassemia_opd_process',[App\Http\Controllers\D_thalassemiaController::class, 'thalassemia_opd_process'])->name('claim.thalassemia_opd_process');//
// Route::match(['get','post'],'thalassemia_opd_export',[App\Http\Controllers\D_thalassemiaController::class, 'thalassemia_opd_export'])->name('claim.thalassemia_opd_export');//

// ********************************* PPFS 2566  *****************************************
// *******************2001 บริการคัดกรองและประเมินปัจจัยเสี่ยงต่อสุขภาพกาย-สุขภาพจิต(SCR)-12001*******************
Route::match(['get','post'],'ppfs_12001',[App\Http\Controllers\PPfs12001Controller::class, 'ppfs_12001'])->name('claim.ppfs_12001');//
Route::match(['get','post'],'ppfs_12001_process',[App\Http\Controllers\PPfs12001Controller::class, 'ppfs_12001_process'])->name('claim.ppfs_12001_process');//
Route::match(['get','post'],'ppfs_12001_export',[App\Http\Controllers\PPfs12001Controller::class, 'ppfs_12001_export'])->name('claim.ppfs_12001_export');//

// *******************2002 บริการคัดกรองและประเมินปัจจัยเสี่ยงต่อสุขภาพกาย-สุขภาพจิต(SCR)-12002*******************
Route::match(['get','post'],'ppfs_12002',[App\Http\Controllers\PPfs12002Controller::class, 'ppfs_12002'])->name('claim.ppfs_12002');//
Route::match(['get','post'],'ppfs_12002_process',[App\Http\Controllers\PPfs12002Controller::class, 'ppfs_12002_process'])->name('claim.ppfs_12002_process');//
Route::match(['get','post'],'ppfs_12002_export',[App\Http\Controllers\PPfs12002Controller::class, 'ppfs_12002_export'])->name('claim.ppfs_12002_export');//
Route::match(['get','post'],'ppfs_12002_exportapi',[App\Http\Controllers\PPfs12002Controller::class, 'ppfs_12002_exportapi'])->name('claim.ppfs_12002_exportapi');//
Route::match(['get','post'],'ppfs_12002_sendapi',[App\Http\Controllers\PPfs12002Controller::class, 'ppfs_12002_sendapi'])->name('claim.ppfs_12002_sendapi');//

// *******************2003 บริการเจาะเลือดจากหลอดเลือดดำภายหลังอดอาหาร8ชั่วโมง-12003*******************
Route::match(['get','post'],'ppfs_12003',[App\Http\Controllers\PPfs12003Controller::class, 'ppfs_12003'])->name('claim.ppfs_12003');//
Route::match(['get','post'],'ppfs_12003_process',[App\Http\Controllers\PPfs12003Controller::class, 'ppfs_12003_process'])->name('claim.ppfs_12003_process');//
Route::match(['get','post'],'ppfs_12003_export',[App\Http\Controllers\PPfs12003Controller::class, 'ppfs_12003_export'])->name('claim.ppfs_12003_export');//

// *******************2004 4บริการเจาะเลือดจากหลอดเลือดดำภายหลังอดอาหาร8ชั่วโมง-12004*******************
Route::match(['get','post'],'ppfs_12004',[App\Http\Controllers\PPfs12004Controller::class, 'ppfs_12004'])->name('claim.ppfs_12004');//
Route::match(['get','post'],'ppfs_12004_process',[App\Http\Controllers\PPfs12004Controller::class, 'ppfs_12004_process'])->name('claim.ppfs_12004_process');//
Route::match(['get','post'],'ppfs_12004_export',[App\Http\Controllers\PPfs12004Controller::class, 'ppfs_12004_export'])->name('claim.ppfs_12004_export');//

// *******************30101 บริการคัดกรองการขาดธาตุเหล็ก 13-45 ปี*******************
// Route::match(['get','post'],'ppfs_30101',[App\Http\Controllers\PPfs66Controller::class, 'ppfs_30101'])->name('claim.ppfs_30101');//
// Route::match(['get','post'],'ppfs_30101_process',[App\Http\Controllers\PPfs66Controller::class, 'ppfs_30101_process'])->name('claim.ppfs_30101_process');//
// Route::match(['get','post'],'ppfs_30101_export',[App\Http\Controllers\PPfs66Controller::class, 'ppfs_30101_export'])->name('claim.ppfs_30101_export');//

// ******************* HERB ยาสมุนไพร *******************
Route::match(['get','post'],'herb9',[App\Http\Controllers\Herb9Controller::class, 'herb9'])->name('claim.herb9');//
Route::match(['get','post'],'herb9_process',[App\Http\Controllers\Herb9Controller::class, 'herb9_process'])->name('claim.herb9_process');//
Route::match(['get','post'],'herb9_export',[App\Http\Controllers\Herb9Controller::class, 'herb9_export'])->name('claim.herb9_export');//
Route::match(['get','post'],'herb9_export_api',[App\Http\Controllers\Herb9Controller::class, 'herb9_export_api'])->name('claim.herb9_export_api');//
Route::match(['get','post'],'herb9_send_api',[App\Http\Controllers\Herb9Controller::class, 'herb9_send_api'])->name('claim.herb9_send_api');//

// *******************30011 บริการดูแลและฝากครรภ์*******************
Route::match(['get','post'],'ppfs_30011',[App\Http\Controllers\PPfs30011Controller::class, 'ppfs_30011'])->name('claim.ppfs_30011');//
Route::match(['get','post'],'ppfs_30011_process',[App\Http\Controllers\PPfs30011Controller::class, 'ppfs_30011_process'])->name('claim.ppfs_30011_process');//
Route::match(['get','post'],'ppfs_30011_export',[App\Http\Controllers\PPfs30011Controller::class, 'ppfs_30011_export'])->name('claim.ppfs_30011_export');//
Route::match(['get','post'],'ppfs_30011_export_api',[App\Http\Controllers\PPfs30011Controller::class, 'ppfs_30011_export_api'])->name('claim.ppfs_30011_export_api');//
Route::match(['get','post'],'ppfs_30011_send_api',[App\Http\Controllers\PPfs30011Controller::class, 'ppfs_30011_send_api'])->name('claim.ppfs_30011_send_api');//

// *******************30015 บริการตรวจหลังคลอด*******************
Route::match(['get','post'],'ppfs_30015',[App\Http\Controllers\PPfs30015Controller::class, 'ppfs_30015'])->name('claim.ppfs_30015');//
Route::match(['get','post'],'ppfs_30015_process',[App\Http\Controllers\PPfs30015Controller::class, 'ppfs_30015_process'])->name('claim.ppfs_30015_process');//
Route::match(['get','post'],'ppfs_30015_export',[App\Http\Controllers\PPfs30015Controller::class, 'ppfs_30015_export'])->name('claim.ppfs_30015_export');//

// ********************************* นักโทษ  *****************************************
Route::match(['get','post'],'prisoner_opd',[App\Http\Controllers\PrisonerController::class, 'prisoner_opd'])->name('prisoner.prisoner_opd');  //นักโทษ 438
Route::match(['get','post'],'prisoner_opd_detail/{month}/{startdate}/{endtdate}',[App\Http\Controllers\PrisonerController::class, 'prisoner_opd_detail'])->name('prisoner.prisoner_opd_detail');  //นักโทษ 438
Route::match(['get','post'],'prisoner_opd_detail_show/{vn}',[App\Http\Controllers\PrisonerController::class, 'prisoner_opd_detail_show'])->name('prisoner.prisoner_opd_detail_show');  //นักโทษ 438
Route::match(['get','post'],'prisoner_opd_detail_excel/{month}/{startdate}/{endtdate}',[App\Http\Controllers\PrisonerController::class, 'prisoner_opd_detail_excel'])->name('prisoner.prisoner_opd_detail_excel');  //นักโทษ 438

Route::match(['get','post'],'prisoner_ipd',[App\Http\Controllers\PrisonerController::class, 'prisoner_ipd'])->name('prisoner.prisoner_ipd');  //นักโทษ
Route::match(['get','post'],'prisoner_ipd_detail/{month}/{startdate}/{endtdate}',[App\Http\Controllers\PrisonerController::class, 'prisoner_ipd_detail'])->name('prisoner.prisoner_ipd_detail');  //นักโทษ 438
Route::match(['get','post'],'prisoner_ipd_detail_excel/{month}/{startdate}/{endtdate}',[App\Http\Controllers\PrisonerController::class, 'prisoner_ipd_detail_excel'])->name('prisoner.prisoner_ipd_detail_excel');  //นักโทษ 438

Route::match(['get','post'],'kayapap_jitvs_mian',[App\Http\Controllers\PtController::class, 'kayapap_jitvs_mian'])->name('pt.kayapap_jitvs_mian');//
Route::match(['get','post'],'kayapap_jitvs/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_jitvs'])->name('pt.kayapap_jitvs');//
Route::match(['get','post'],'kayapap_jitvs_vn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_jitvs_vn'])->name('pt.kayapap_jitvs_vn');//
Route::match(['get','post'],'kayapap_jitvs_spsch/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_jitvs_spsch'])->name('pt.kayapap_jitvs_spsch');//
Route::match(['get','post'],'kayapap_jitvs_nokey/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_jitvs_nokey'])->name('pt.kayapap_jitvs_nokey');//

Route::match(['get','post'],'restore',[App\Http\Controllers\PtController::class, 'restore'])->name('pt.restore');//
Route::match(['get','post'],'kayapap_vs/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_vs'])->name('pt.kayapap_vs');//
Route::match(['get','post'],'kayapap_vs_sub/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_vs_sub'])->name('pt.kayapap_vs_sub');//
Route::match(['get','post'],'kayapap_vs_spsch/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_vs_spsch'])->name('pt.kayapap_vs_spsch');//
Route::match(['get','post'],'kayapap_vs_nokey/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_vs_nokey'])->name('pt.kayapap_vs_nokey');//

Route::match(['get','post'],'kayapap_Keyspsch/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_Keyspsch'])->name('pt.kayapap_Keyspsch');//

Route::match(['get','post'],'kayapap_hoocojmokvs/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_hoocojmokvs'])->name('pt.kayapap_hoocojmokvs');//
Route::match(['get','post'],'kayapap_tavs/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_tavs'])->name('pt.kayapap_tavs');//
Route::match(['get','post'],'kayapap_tavs_subvn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_tavs_subvn'])->name('pt.kayapap_tavs_subvn');//
Route::match(['get','post'],'kayapap_tavs_subspsch/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_tavs_subspsch'])->name('pt.kayapap_tavs_subspsch');//
Route::match(['get','post'],'kayapap_tavs_subnokey/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_tavs_subnokey'])->name('pt.kayapap_tavs_subnokey');//

Route::match(['get','post'],'kayapap_kratoonvs/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_kratoonvs'])->name('pt.kayapap_kratoonvs');//
Route::match(['get','post'],'kayapap_kratoonvs_sub/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_kratoonvs_sub'])->name('pt.kayapap_kratoonvs_sub');//
Route::match(['get','post'],'kayapap_kratoonvs_spsch/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_kratoonvs_spsch'])->name('pt.kayapap_kratoonvs_spsch');//
Route::match(['get','post'],'kayapap_kratoonvs_nokey/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_kratoonvs_nokey'])->name('pt.kayapap_kratoonvs_nokey');//

Route::match(['get','post'],'kayapap_hoocojmokvs_vs/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_hoocojmokvs_vs'])->name('pt.kayapap_hoocojmokvs_vs');//
Route::match(['get','post'],'kayapap_hoocojmokvs_spsch/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_hoocojmokvs_spsch'])->name('pt.kayapap_hoocojmokvs_spsch');//
Route::match(['get','post'],'kayapap_hoocojmokvs_nokey/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'kayapap_hoocojmokvs_nokey'])->name('pt.kayapap_hoocojmokvs_nokey');//

Route::match(['get','post'],'equipment',[App\Http\Controllers\PtController::class, 'equipment'])->name('pt.equipment');//
Route::match(['get','post'],'equipment_vn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'equipment_vn'])->name('pt.equipment_vn');//
Route::match(['get','post'],'equipment_spsch/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'equipment_spsch'])->name('pt.equipment_spsch');//
Route::match(['get','post'],'equipment_nokey/{months}/{startdate}/{enddate}',[App\Http\Controllers\PtController::class, 'equipment_nokey'])->name('pt.equipment_nokey');//

Route::match(['get','post'],'acc_stm_ct',[App\Http\Controllers\AccdashboardController::class, 'acc_stm_ct'])->name('acc.acc_stm_ct');//
Route::match(['get','post'],'fdh_mini_dataset_authauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_authauto'])->name('fdh.fdh_mini_dataset_authauto');
Route::match(['get','post'],'fdh_mini_dataset_pullauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pullauto'])->name('fdh.fdh_mini_dataset_pullauto');
Route::match(['get','post'],'fdh_mini_dataset_pullnoinauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pullnoinauto'])->name('fdh.fdh_mini_dataset_pullnoinauto'); 
Route::match(['get','post'],'fdh_mini_dataset_apicliamauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_apicliamauto'])->name('fdh.fdh_mini_dataset_apicliamauto');
Route::match(['get','post'],'fdh_mini_dataset_pulljongauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pulljongauto'])->name('fdh.fdh_mini_dataset_pulljongauto');


Route::get('/', function () {


if (Auth::check()) {
    return view('welcome');
}else{
      return view('auth.login');
}
})->name('index');



Auth::routes();


// ฺbackup Database

Route::get('backups', [App\Http\Controllers\BackupController::class, 'index']);
Route::get('backupnow', [App\Http\Controllers\BackupController::class, 'backupnow'])->name('backupnow');
Route::get('backups/getbody', [App\Http\Controllers\BackupController::class, 'listbody'])->name('listbody');
Route::get('backups/total-unit', [App\Http\Controllers\BackupController::class, 'totalUnit'])->name('totalUnit');
Route::get('backup/download/{name}', [App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
Route::delete('backup/delete', [App\Http\Controllers\BackupController::class, 'delete'])->name('backup.delete');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('type');
Route::get('staff/home', [App\Http\Controllers\HomeController::class, 'staffHome'])->name('staff.home')->middleware('type');
Route::get('user/home', [App\Http\Controllers\UserController::class, 'user_index'])->name('user.home')->middleware('type');
Route::get('manage/home', [App\Http\Controllers\HomeController::class, 'manageHome'])->name('manage.home')->middleware('type');

Route::middleware(['type'])->group(function(){

  // Route::get('/', function () {
  //   if (Auth::check()) {
  //     return view('welcome');
  //   }else{
  //       return view('auth.login');
  //   }
  // })->name('index');
  Route::match(['get','post'],'admin_profile_edit/{id}',[App\Http\Controllers\ProfileController::class, 'admin_profile_edit'])->name('pro.admin_profile_edit');//
  Route::match(['get','post'],'admin_profile_update',[App\Http\Controllers\ProfileController::class, 'admin_profile_update'])->name('pro.admin_profile_update');//
  Route::match(['get','post'],'admin_password_update',[App\Http\Controllers\ProfileController::class, 'admin_password_update'])->name('pro.admin_password_update');//
 
  // ******************** USERS Sote ***********************

  Route::match(['get','post'],'audiovisual_work',[App\Http\Controllers\SoteController::class, 'audiovisual_work'])->name('user.audiovisual_work');//
  Route::match(['get','post'],'audiovisual_work_detail/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_work_detail'])->name('user.audiovisual_work_detail');//
  Route::match(['get','post'],'audiovisual_work_add',[App\Http\Controllers\SoteController::class, 'audiovisual_work_add'])->name('user.audiovisual_work_add');//
  Route::match(['get','post'],'audiovisual_work_edit/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_work_edit'])->name('user.audiovisual_work_edit');//
  Route::match(['get','post'],'audiovisual_work_save',[App\Http\Controllers\SoteController::class, 'audiovisual_work_save'])->name('user.audiovisual_work_save');//
  Route::match(['get','post'],'audiovisual_work_update',[App\Http\Controllers\SoteController::class, 'audiovisual_work_update'])->name('user.audiovisual_work_update');//
  Route::match(['get','post'],'audiovisual_work_cancel/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_work_cancel'])->name('user.audiovisual_work_cancel');//

  //  ******************** Admin Sote ***********************
  //  Route::match(['get','post'],'prenatal_care',[App\Http\Controllers\AncController::class, 'prenatal_care'])->name('anc.prenatal_care');//
  //  Route::match(['get','post'],'prenatal_care_/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_check'])->name('user.audiovisual_admin_check');//รับทราบ
  //  Route::match(['get','post'],'prenatal_care/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_going'])->name('user.audiovisual_admin_going');//กำลังดำเนินการ
  //  Route::match(['get','post'],'prenatal_care/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_sendcheck'])->name('user.audiovisual_admin_sendcheck');//ส่งงานตรวจสอบ
  //  Route::match(['get','post'],'prenatal_care/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_finish'])->name('user.audiovisual_admin_finish');//

 // ******************** Admin Sote ***********************
  Route::match(['get','post'],'audiovisual_admin',[App\Http\Controllers\SoteController::class, 'audiovisual_admin'])->name('user.audiovisual_admin');//
  Route::match(['get','post'],'audiovisual_admin_check/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_check'])->name('user.audiovisual_admin_check');//รับทราบ
  Route::match(['get','post'],'audiovisual_admin_going/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_going'])->name('user.audiovisual_admin_going');//กำลังดำเนินการ
  Route::match(['get','post'],'audiovisual_admin_sendcheck/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_sendcheck'])->name('user.audiovisual_admin_sendcheck');//ส่งงานตรวจสอบ
  Route::match(['get','post'],'audiovisual_admin_finish/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_finish'])->name('user.audiovisual_admin_finish');//

  Route::match(['get','post'],'audiovisual_admin_save',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_save'])->name('user.audiovisual_admin_save');//
  Route::match(['get','post'],'audiovisual_admin_cancel/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_cancel'])->name('user.audiovisual_admin_cancel');//ยืนยันการตรวจสอบ

  Route::match(['get','post'],'audiovisual_admin_detail/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_detail'])->name('user.audiovisual_admin_detail');//
  Route::match(['get','post'],'audiovisual_admin_add',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_add'])->name('user.audiovisual_admin_add');//
  Route::match(['get','post'],'audiovisual_admin_edit/{id}',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_edit'])->name('user.audiovisual_admin_edit');//
  Route::match(['get','post'],'audiovisual_admin_update',[App\Http\Controllers\SoteController::class, 'audiovisual_admin_update'])->name('user.audiovisual_admin_update');//
  

  // ******************** ระบบลงเวลา Users ***********************
  Route::match(['get','post'],'user_timeindex',[App\Http\Controllers\UserstimerController::class, 'user_timeindex'])->name('usertime.user_timeindex');// ระบบลงเวลา
  // Route::match(['get','post'],'user_timeindex_excel',[App\Http\Controllers\UserstimerController::class, 'user_timeindex_excel'])->name('usertime.user_timeindex_excel');// ระบบลงเวลา
  // Route::match(['get','post'],'user_timeindex_excel/{startdate}/{enddate}',[App\Http\Controllers\UserstimerController::class, 'user_timeindex_excel'])->name('usertime.user_timeindex_excel');// ระบบลงเวลา
  Route::match(['get','post'],'user_timeindex_excel',[App\Http\Controllers\UserstimerController::class, 'user_timeindex_excel'])->name('usertime.user_timeindex_excel');// ระบบลงเวลา
  Route::match(['get','post'],'user_exportexcel',[App\Http\Controllers\UserstimerController::class, 'user_exportexcel'])->name('usertime.user_exportexcel');// ระบบลงเวลา

  Route::match(['get','post'],'user_timeindex_nurh',[App\Http\Controllers\UserstimerController::class, 'user_timeindex_nurh'])->name('usertime.user_timeindex_nurh');// ระบบลงเวลา
  Route::match(['get','post'],'user_timeindex_nurh_excel/{startdate}/{enddate}',[App\Http\Controllers\UserstimerController::class, 'user_timeindex_nurh_excel'])->name('usertime.user_timeindex_nurh_excel');// ระบบลงเวลา

  Route::match(['get','post'],'user_timeindex_day',[App\Http\Controllers\UserstimerController::class, 'user_timeindex_day'])->name('usertime.user_timeindex_day');// ระบบลงเวลา

  Route::match(['get','post'],'time_dashboard',[App\Http\Controllers\TimerController::class, 'time_dashboard'])->name('t.time_dashboard');// ระบบลงเวลา
  Route::match(['get','post'],'time_dashboard_excel',[App\Http\Controllers\TimerController::class, 'time_dashboard_excel'])->name('t.time_dashboard_excel');// ระบบลงเวลา
  Route::match(['get','post'],'time_dashboard_detail/{id}',[App\Http\Controllers\TimerController::class, 'time_dashboard_detail'])->name('t.time_dashboard_detail');// ระบบลงเวลา
  Route::match(['get','post'],'time_dashboard_detail_excel/{id}',[App\Http\Controllers\TimerController::class, 'time_dashboard_detail_excel'])->name('t.time_dashboard_detail_excel');// ระบบลงเวลา
  Route::match(['get','post'],'time_dashboard_detail_sub/{id}',[App\Http\Controllers\TimerController::class, 'time_dashboard_detail_sub'])->name('t.time_dashboard_detail_sub');// ระบบลงเวลา
  Route::match(['get','post'],'time_dashboard_detail_subexcel/{id}',[App\Http\Controllers\TimerController::class, 'time_dashboard_detail_subexcel'])->name('t.time_dashboard_detail_subexcel');// ระบบลงเวลา
  Route::match(['get','post'],'time_dashboard_detail_sub_person/{id}',[App\Http\Controllers\TimerController::class, 'time_dashboard_detail_sub_person'])->name('t.time_dashboard_detail_sub_person');// ระบบลงเวลา

  Route::match(['get','post'],'time_index',[App\Http\Controllers\TimerController::class, 'time_index'])->name('t.time_index');// ระบบลงเวลา
  Route::match(['get','post'],'time_index_search',[App\Http\Controllers\TimerController::class, 'time_index_search'])->name('t.time_index_search');// ระบบลงเวลา
  Route::match(['get','post'],'time_index_excel',[App\Http\Controllers\TimerController::class, 'time_index_excel'])->name('t.time_index_excel');// excel

  Route::match(['get','post'],'time_dep',[App\Http\Controllers\TimerController::class, 'time_dep'])->name('t.time_dep');// ระบบลงเวลา
  Route::match(['get','post'],'time_depsub',[App\Http\Controllers\TimerController::class, 'time_depsub'])->name('t.time_depsub');// ระบบลงเวลา
  Route::match(['get','post'],'time_depsubsub',[App\Http\Controllers\TimerController::class, 'time_depsubsub'])->name('t.time_depsubsub');// ระบบลงเวลา

  Route::match(['get','post'],'time_dep_excel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_dep_excel'])->name('t.time_dep_excel');// ระบบลงเวลา
  Route::match(['get','post'],'time_depsub_excel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_depsub_excel'])->name('t.time_depsub_excel');// ระบบลงเวลา
  Route::match(['get','post'],'time_depsubsub_excel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_depsubsub_excel'])->name('t.time_depsubsub_excel');// ระบบลงเวลา

  Route::match(['get','post'],'time_backot_dep',[App\Http\Controllers\TimerController::class, 'time_backot_dep'])->name('t.time_backot_dep');// ระบบลงเวลา
  Route::match(['get','post'],'time_backot_depexcel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_backot_depexcel'])->name('t.time_backot_depexcel');// ระบบลงเวลา

  Route::match(['get','post'],'time_backot_depsub',[App\Http\Controllers\TimerController::class, 'time_backot_depsub'])->name('t.time_backot_depsub');// ระบบลงเวลา
  Route::match(['get','post'],'time_backot_depsubexcel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_backot_depsubexcel'])->name('t.time_backot_depsubexcel');// ระบบลงเวลา

  Route::match(['get','post'],'time_backot_depsubsub',[App\Http\Controllers\TimerController::class, 'time_backot_depsubsub'])->name('t.time_backot_depsubsub');// ระบบลงเวลา
  Route::match(['get','post'],'time_backot_depsubsubexcel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_backot_depsubsubexcel'])->name('t.time_backot_depsubsubexcel');// ระบบลงเวลา

  // Route::match(['get','post'],'time_backot_dep',[App\Http\Controllers\TimerController::class, 'time_backot_dep'])->name('t.time_backot_dep');// ระบบลงเวลา
  // Route::match(['get','post'],'time_backot_depexcel',[App\Http\Controllers\TimerController::class, 'time_backot_depexcel'])->name('t.time_backot_depexcel');// ระบบลงเวลา

  Route::match(['get','post'],'time_nurs_dep',[App\Http\Controllers\TimerController::class, 'time_nurs_dep'])->name('t.time_nurs_dep');// ระบบลงเวลา
  Route::match(['get','post'],'time_nurs_depexcel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_nurs_depexcel'])->name('t.time_nurs_depexcel');// ระบบลงเวลา

  Route::match(['get','post'],'time_nurs_depsub',[App\Http\Controllers\TimerController::class, 'time_nurs_depsub'])->name('t.time_nurs_depsub');// ระบบลงเวลา
  Route::match(['get','post'],'time_nurs_depsubexcel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_nurs_depsubexcel'])->name('t.time_nurs_depsubexcel');// ระบบลงเวลา

  Route::match(['get','post'],'time_nurs_depsubsub',[App\Http\Controllers\TimerController::class, 'time_nurs_depsubsub'])->name('t.time_nurs_depsubsub');// ระบบลงเวลา
  Route::match(['get','post'],'time_nurs_depsubsubexcel/{id}/{startdate}/{enddate}',[App\Http\Controllers\TimerController::class, 'time_nurs_depsubsubexcel'])->name('t.time_nurs_depsubsubexcel');// ระบบลงเวลา
    // ******************** ผู้ดูแลงานบุคลากร ***********************
    Route::match(['get','post'],'person/person_index',[App\Http\Controllers\PersonController::class, 'person_index'])->name('person.person_index');//
    Route::match(['get','post'],'person/person_index_add',[App\Http\Controllers\PersonController::class, 'person_index_add'])->name('person.person_index_add');//
    Route::match(['get','post'],'person/person_index_addsub/{id}',[App\Http\Controllers\PersonController::class, 'person_index_addsub'])->name('person.person_index_addsub');//
    Route::match(['get','post'],'person/person_save',[App\Http\Controllers\PersonController::class, 'person_save'])->name('person.person_save');//
    Route::match(['get','post'],'person/person_index_edit/{id}',[App\Http\Controllers\PersonController::class, 'person_index_edit'])->name('person.person_index_edit');//
    Route::get('person/person_index_edittype/{id}',[App\Http\Controllers\PersonController::class, 'person_index_edittype'])->name('person.person_index_edittype');//
    Route::put('person/person_typeupdate',[App\Http\Controllers\PersonController::class, 'person_typeupdate'])->name('person.person_typeupdate');//
    Route::match(['get','post'],'person/person_update',[App\Http\Controllers\PersonController::class, 'person_update'])->name('person.person_update');//
    Route::delete('person/person_destroy/{id}',[App\Http\Controllers\PersonController::class, 'person_destroy'])->name('person.person_destroy');//

    Route::match(['get','post'],'p4p_dashboarduser',[App\Http\Controllers\P4puserController::class, 'p4p_dashboarduser'])->name('user.p4p_dashboarduser');//
    Route::match(['get','post'],'p4p_user',[App\Http\Controllers\P4puserController::class, 'p4p_user'])->name('user.p4p_user');//
    Route::match(['get','post'],'p4p_user_save',[App\Http\Controllers\P4puserController::class, 'p4p_user_save'])->name('user.p4p_user_save');//
    Route::match(['get','post'],'p4p_user_edit/{id}',[App\Http\Controllers\P4puserController::class, 'p4p_user_edit'])->name('user.p4p_user_edit');//
    Route::match(['get','post'],'p4p_user_update',[App\Http\Controllers\P4puserController::class, 'p4p_user_update'])->name('user.p4p_user_update');//

    Route::match(['get','post'],'workgroupset',[App\Http\Controllers\P4puserController::class, 'workgroupset'])->name('user.workgroupset');//
    Route::match(['get','post'],'workgroupset_save',[App\Http\Controllers\P4puserController::class, 'workgroupset_save'])->name('user.workgroupset_save');//
    Route::match(['get','post'],'workgroupset_edit/{id}',[App\Http\Controllers\P4puserController::class, 'workgroupset_edit'])->name('user.workgroupset_edit');//
    Route::match(['get','post'],'workgroupset_update',[App\Http\Controllers\P4puserController::class, 'workgroupset_update'])->name('user.workgroupset_update');//
    Route::match(['get','post'],'workset_switchactive',[App\Http\Controllers\P4pController::class, 'workset_switchactive'])->name('user.workset_switchactive');//

    Route::match(['get','post'],'workset',[App\Http\Controllers\P4puserController::class, 'workset'])->name('user.workset');//
    Route::match(['get','post'],'workset_save',[App\Http\Controllers\P4puserController::class, 'workset_save'])->name('user.workset_save');//
    Route::match(['get','post'],'workset_edit/{id}',[App\Http\Controllers\P4puserController::class, 'workset_edit'])->name('user.workset_edit');//
    Route::match(['get','post'],'workset_update',[App\Http\Controllers\P4puserController::class, 'workset_update'])->name('user.workset_update');//
    Route::match(['get','post'],'workset_switch',[App\Http\Controllers\P4puserController::class, 'workset_switch'])->name('user.workset_switch');//

    Route::match(['get','post'],'work_choose_detail/{id}',[App\Http\Controllers\P4puserController::class, 'work_choose_detail'])->name('user.work_choose_detail');//
    Route::match(['get','post'],'work_choose/{id}',[App\Http\Controllers\P4puserController::class, 'work_choose'])->name('user.work_choose');//
    Route::match(['get','post'],'work_choose_save',[App\Http\Controllers\P4puserController::class, 'work_choose_save'])->name('user.work_choose_save');//
    Route::match(['get','post'],'work_choose_worksetsave',[App\Http\Controllers\P4puserController::class, 'work_choose_worksetsave'])->name('user.work_choose_worksetsave');//

    Route::match(['get','post'],'work_choose_processpdf/{id}',[App\Http\Controllers\P4puserController::class, 'work_choose_processpdf'])->name('user.work_choose_processpdf');//
    Route::match(['get','post'],'work_choose_pdf/{id}',[App\Http\Controllers\P4puserController::class, 'work_choose_pdf'])->name('user.work_choose_pdf');//
    Route::match(['get','post'],'work_export_excel/{id}',[App\Http\Controllers\P4puserController::class, 'work_export_excel'])->name('user.work_export_excel');//
    Route::match(['get','post'],'work_export_excel2/{id}',[App\Http\Controllers\P4puserController::class, 'work_export_excel2'])->name('user.work_export_excel2');//

    Route::match(['get','post'],'work_load_save',[App\Http\Controllers\P4puserController::class, 'work_load_save'])->name('user.work_load_save');//
    Route::match(['get','post'],'work_load_saveCopy',[App\Http\Controllers\P4puserController::class, 'work_load_saveCopy'])->name('user.work_load_saveCopy');//
    Route::match(['get','post'],'work_load_update',[App\Http\Controllers\P4puserController::class, 'work_load_update'])->name('user.work_load_update');//
    Route::delete('work_load_destroy/{id}',[App\Http\Controllers\P4puserController::class, 'work_load_destroy'])->name('user.work_load_destroy');//


    Route::get('person/addpre',[App\Http\Controllers\PersonController::class, 'addpre'])->name('person.addpre');//  เพิ่มคำนำหน้า
    Route::match(['get','post'],'p4p_dayoff',[App\Http\Controllers\PersonController::class, 'p4p_dayoff'])->name('person.p4p_dayoff');//
    Route::match(['get','post'],'p4p_dayoff_save',[App\Http\Controllers\PersonController::class, 'p4p_dayoff_save'])->name('person.p4p_dayoff_save');//
    Route::match(['get','post'],'p4p_dayoff_edit/{id}',[App\Http\Controllers\PersonController::class, 'p4p_dayoff_edit'])->name('person.p4p_dayoff_edit');//
    Route::match(['get','post'],'p4p_dayoff_update',[App\Http\Controllers\PersonController::class, 'p4p_dayoff_update'])->name('person.p4p_dayoff_update');//

    Route::match(['get','post'],'person/department',[App\Http\Controllers\PersonController::class, 'department'])->name('person.department');//
    Route::match(['get','post'],'person/departmenthsub',[App\Http\Controllers\PersonController::class, 'departmenthsub'])->name('person.departmenthsub');//
    // Route::match(['get','post'],'person/person_index',[App\Http\Controllers\PersonController::class, 'person_index'])->name('person.person_index');//

    Route::get('province_fect',[App\Http\Controllers\PersonController::class, 'province_fect'])->name('fect.province_fect');//
    Route::get('district_fect',[App\Http\Controllers\PersonController::class, 'district_fect'])->name('fect.district_fect');//

     // ******************** ระบบการลา ***********************
 Route::match(['get','post'],'gleave',[App\Http\Controllers\GleaveController::class, 'gleave'])->name('gl.gleave');//
 Route::match(['get','post'],'gleave_calenda',[App\Http\Controllers\GleaveController::class, 'gleave_calenda'])->name('gl.gleave_calenda');//
 Route::match(['get','post'],'gleave_main',[App\Http\Controllers\GleaveController::class, 'gleave_main'])->name('gl.gleave_main');//
 Route::match(['get','post'],'gleave_config',[App\Http\Controllers\GleaveController::class, 'gleave_config'])->name('gl.gleave_config');//


  // ******************** งานสารบรรณ  ***********************

    Route::match(['get','post'],'book/book_dashboard',[App\Http\Controllers\BookController::class, 'book_dashboard'])->name('book.book_dashboard');//
    // Route::get('book/bookmake_detail/{id}',[App\Http\Controllers\BookController::class, 'bookmake_detail'])->name('book.bookmake_detail')->withoutMiddleware('type');
    // Route::get('bookdetail/{idref}','ManagerbookController@bookdetail')->name('book.book')->withoutMiddleware('type');

    Route::get('book/bookmake_index',[App\Http\Controllers\BookController::class, 'bookmake_index'])->name('book.bookmake_index');//
    Route::get('book/bookmake_index_edit/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_edit'])->name('book.bookmake_index_edit');//
    Route::match(['get','post'],'book/bookmake_index_update',[App\Http\Controllers\BookController::class, 'bookmake_index_update'])->name('book.bookmake_index_update');//

    Route::delete('bookmake_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookmake_destroy'])->name('bookmake_destroy');//

    Route::get('book/bookrep_file1_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookrep_file1_destroy'])->name('book.bookrep_file1_destroy');//
    Route::get('book/bookrep_file2_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookrep_file2_destroy'])->name('book.bookrep_file2_destroy');//
    Route::get('book/bookrep_file3_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookrep_file3_destroy'])->name('book.bookrep_file3_destroy');//
    Route::get('book/bookrep_file4_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookrep_file4_destroy'])->name('book.bookrep_file4_destroy');//
    Route::get('book/bookrep_file5_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookrep_file5_destroy'])->name('book.bookrep_file5_destroy');//

    Route::get('book/bookmake_index_send/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send'])->name('book.bookmake_index_send');//   ไปหน้ารายละเอียด
    Route::get('book/bookmake_index_send_deb/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_deb'])->name('book.bookmake_index_send_deb');//   ไปหน้าส่งกลุ่ม
    Route::get('book/bookmake_index_send_debsub/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_debsub'])->name('book.bookmake_index_send_debsub');// ไปหน้าส่ง ฝ่าย/แผนก
    Route::get('book/bookmake_index_send_debsubsub/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_debsubsub'])->name('book.bookmake_index_send_debsubsub');// ไปหน้าส่ง หน่วยงาน
    Route::get('book/bookmake_index_send_person/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_person'])->name('book.bookmake_index_send_person');// ไปหน้าส่ง หน่วยงาน
    Route::get('book/bookmake_index_send_team/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_team'])->name('book.bookmake_index_send_team');// ไปหน้าส่ง ทีมนำองค์กร
    Route::get('book/bookmake_index_send_fileplus/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_fileplus'])->name('book.bookmake_index_send_fileplus');// ไปหน้าไฟล์แนบ
    Route::get('book/bookmake_index_send_open/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_open'])->name('book.bookmake_index_send_open');// ไปหน้าเปิดอ่าน
    Route::get('book/bookmake_index_send_file/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_send_file'])->name('book.bookmake_index_send_file');// ไปหน้าไฟล์ส่ง

    Route::get('book/bookmake_index_senddebindex/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_senddebindex'])->name('book.bookmake_index_senddebindex');//
    Route::get('book/process/{id}',[App\Http\Controllers\BookController::class, 'process'])->name('book.process');//

    Route::post('book/bookmake_sendretire/{id}',[App\Http\Controllers\BookController::class, 'bookmake_sendretire'])->name('book.bookmake_sendretire');// เสนอหัวหน้าบริหาร
    Route::post('book/bookmake_sendpo/{id}',[App\Http\Controllers\BookController::class, 'bookmake_sendpo'])->name('book.bookmake_sendpo');// เสนอ ผอ.

    Route::post('book/bookmake_index_senddep',[App\Http\Controllers\BookController::class, 'bookmake_index_senddep'])->name('book.bookmake_index_senddep');//ส่งกลุ่มงาน
    Route::delete('/book/bookmake_senddep_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookmake_senddep_destroy'])->name('book.bookmake_senddep_destroy');//

    Route::post('book/bookmake_index_senddepsub',[App\Http\Controllers\BookController::class, 'bookmake_index_senddepsub'])->name('book.bookmake_index_senddepsub');//ส่งฝ่าย/แผนก
    Route::delete('/book/bookmake_senddepsub_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookmake_senddepsub_destroy'])->name('book.bookmake_senddepsub_destroy');//

    Route::match(['get','post'],'book/bookmake_index_senddepsubsub',[App\Http\Controllers\BookController::class, 'bookmake_index_senddepsubsub'])->name('book.bookmake_index_senddepsubsub');//ส่งฝ่าย/แผนก
    Route::delete('/book/bookmake_senddepsubsub_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookmake_senddepsubsub_destroy'])->name('book.bookmake_senddepsubsub_destroy');//

    Route::post('book/bookmake_index_sendperson',[App\Http\Controllers\BookController::class, 'bookmake_index_sendperson'])->name('book.bookmake_index_sendperson');//ส่งบุคคล
    Route::delete('/book/bookmake_sendperson_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookmake_sendperson_destroy'])->name('book.bookmake_sendperson_destroy');//

    Route::post('book/bookmake_index_sendteam',[App\Http\Controllers\BookController::class, 'bookmake_index_sendteam'])->name('book.bookmake_index_sendteam');//ส่งทีมนำองค์กร
    Route::delete('/book/bookmake_sendteam_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookmake_sendteam_destroy'])->name('book.bookmake_sendteam_destroy');//

    Route::get('book/bookmake_index_openpdf/{id}',[App\Http\Controllers\BookController::class, 'bookmake_index_openpdf'])->name('book.bookmake_index_openpdf');//

    Route::get('/book/addtype',[App\Http\Controllers\BookController::class, 'addtype'])->name('book.addtype');//  เพิ่มประเภทหนังสือ
    Route::get('/book/addfam',[App\Http\Controllers\BookController::class, 'addfam'])->name('book.addfam');//  เพิ่มนำเข้าไว้ในแฟ้ม
    Route::match(['get','post'],'book/signature_save',[App\Http\Controllers\BookController::class, 'signature_save'])->name('book.signature_save');//บันทึกลายเซนต์
    Route::match(['get','post'],'book/comment1_save',[App\Http\Controllers\BookController::class, 'comment1_save'])->name('book.comment1_save');//บันทึกความคิดเห็น

     // -------------------------หนังสือรับ-------------------------
    Route::match(['get','post'],'book/bookrep_index',[App\Http\Controllers\BookController::class, 'bookrep_index'])->name('book.bookrep_index');//
    Route::match(['get','post'],'book/bookrep_index_add',[App\Http\Controllers\BookController::class, 'bookrep_index_add'])->name('book.bookrep_index_add');//
    Route::match(['get','post'],'book/bookrep_index_save',[App\Http\Controllers\BookController::class, 'bookrep_index_save'])->name('book.bookrep_index_save');//
    Route::get('book/bookrep_index_edit/{id}',[App\Http\Controllers\BookController::class, 'bookrep_index_edit'])->name('book.bookrep_index_edit');//
    Route::match(['get','post'],'book/bookrep_index_update',[App\Http\Controllers\BookController::class, 'bookrep_index_update'])->name('book.bookrep_index_update');//
    Route::delete('/book/bookrep_index_destroy/{id}',[App\Http\Controllers\BookController::class, 'bookrep_index_destroy'])->name('book.bookrep_index_destroy');//

 // -------------------------หนังสือส่ง-------------------------
    Route::match(['get','post'],'book/booksend_index',[App\Http\Controllers\BookController::class, 'booksend_index'])->name('book.booksend_index');//
    Route::match(['get','post'],'book/booksend_index_add',[App\Http\Controllers\BookController::class, 'booksend_index_add'])->name('book.booksend_index_add');//
    Route::match(['get','post'],'book/booksend_index_save',[App\Http\Controllers\BookController::class, 'booksend_index_save'])->name('book.booksend_index_save');//
    Route::get('book/booksend_index_edit/{id}',[App\Http\Controllers\BookController::class, 'booksend_index_edit'])->name('book.booksend_index_edit');//
    Route::match(['get','post'],'book/booksend_index_update',[App\Http\Controllers\BookController::class, 'booksend_index_update'])->name('book.booksend_index_update');//
    Route::delete('/book/booksend_index_destroy/{id}',[App\Http\Controllers\BookController::class, 'booksend_index_destroy'])->name('book.booksend_index_destroy');//

    Route::get('book/book_send_email/{id}',[App\Http\Controllers\BookController::class, 'book_send_email'])->name('book.book_send_email');//
    Route::get('book/book_sendemail_file/{id}',[App\Http\Controllers\BookController::class, 'book_send_emailfile'])->name('book.book_send_emailfile');//
    Route::get('dis-send-mail', [App\Http\Controllers\BookController::class, 'disSendMail']); // ส่งเมล์
    // Route::post('send_mailnew', [App\Http\Controllers\SendMailController::class, 'send_mailnew'])->name('book.send_mailnew');//
    Route::post('send_mailnewbook', [App\Http\Controllers\BookController::class, 'send_mailnewbook'])->name('book.send_mailnewbook');//


    // ******************** พัสดุ ***********************
    Route::match(['get','post'],'supplies/supplies_dashboard',[App\Http\Controllers\SuppliesController::class, 'supplies_dashboard'])->name('sup.supplies_dashboard');//
    Route::match(['get','post'],'supplies/supplies_index',[App\Http\Controllers\SuppliesController::class, 'supplies_index'])->name('sup.supplies_index');//
    Route::match(['get','post'],'supplies/supplies_index_add',[App\Http\Controllers\SuppliesController::class, 'supplies_index_add'])->name('sup.supplies_index_add');//
    Route::match(['get','post'],'supplies/supplies_index_save',[App\Http\Controllers\SuppliesController::class, 'supplies_index_save'])->name('sup.supplies_index_save');//
    Route::get('supplies/supplies_index_edit/{id}',[App\Http\Controllers\SuppliesController::class, 'supplies_index_edit'])->name('sup.supplies_index_edit');//
    Route::match(['get','post'],'supplies/supplies_index_update',[App\Http\Controllers\SuppliesController::class, 'supplies_index_update'])->name('sup.supplies_index_update');//
    Route::delete('supplies/supplies_destroy/{id}',[App\Http\Controllers\SuppliesController::class, 'supplies_destroy'])->name('sup.supplies_destroy');//

  // ******************** ครุภัณฑ์ ***********************
    Route::match(['get','post'],'article/article_dashboard',[App\Http\Controllers\ArticleController::class, 'article_dashboard'])->name('art.article_dashboard');//
    Route::match(['get','post'],'article/article_index',[App\Http\Controllers\ArticleController::class, 'article_index'])->name('art.article_index');//
    Route::match(['get','post'],'article/article_index_add',[App\Http\Controllers\ArticleController::class, 'article_index_add'])->name('art.article_index_add');//
    Route::match(['get','post'],'article/article_index_save',[App\Http\Controllers\ArticleController::class, 'article_index_save'])->name('art.article_index_save');//
    Route::get('article/article_index_edit/{id}',[App\Http\Controllers\ArticleController::class, 'article_index_edit'])->name('art.article_index_edit');//
    Route::match(['get','post'],'article/article_index_update',[App\Http\Controllers\ArticleController::class, 'article_index_update'])->name('art.article_index_update');//
    Route::delete('article/article_destroy/{id}',[App\Http\Controllers\ArticleController::class, 'article_destroy'])->name('art.article_destroy');//
    Route::get('article/selectfsn',[App\Http\Controllers\ArticleController::class, 'selectfsn'])->name('art.selectfsn'); // Select FSN
    Route::get('article/addunit',[App\Http\Controllers\ArticleController::class, 'addunit'])->name('art.addunit');//  เพิ่มหน่วยนับ
    Route::get('article/addbrand',[App\Http\Controllers\ArticleController::class, 'addbrand'])->name('art.addbrand');//  เพิ่มยี่ห้อ

    // ******************** ที่ดิน ********************
    Route::match(['get','post'],'land/land_index',[App\Http\Controllers\LandController::class, 'land_index'])->name('land.land_index');//
    Route::match(['get','post'],'land/land_index_add',[App\Http\Controllers\LandController::class, 'land_index_add'])->name('land.land_index_add');//
    Route::match(['get','post'],'land/land_index_save',[App\Http\Controllers\LandController::class, 'land_index_save'])->name('land.land_index_save');//
    Route::get('land/land_index_edit/{id}',[App\Http\Controllers\LandController::class, 'land_index_edit'])->name('land.land_index_edit');//
    Route::match(['get','post'],'land/land_index_update',[App\Http\Controllers\LandController::class, 'land_index_update'])->name('land.land_index_update');//
    Route::delete('land/land_destroy/{id}',[App\Http\Controllers\LandController::class, 'land_destroy'])->name('land.land_destroy');//

                    //****** อาคารสถานที่ *****
    Route::match(['get','post'],'building/building_index',[App\Http\Controllers\BuildingController::class, 'building_index'])->name('bu.building_index');//
    Route::match(['get','post'],'building/building_index_add',[App\Http\Controllers\BuildingController::class, 'building_index_add'])->name('bu.building_index_add');//
    Route::match(['get','post'],'building/building_index_save',[App\Http\Controllers\BuildingController::class, 'building_index_save'])->name('bu.building_index_save');//
    Route::get('building/building_index_edit/{id}',[App\Http\Controllers\BuildingController::class, 'building_index_edit'])->name('bu.building_index_edit');//
    Route::match(['get','post'],'building/building_index_update',[App\Http\Controllers\BuildingController::class, 'building_index_update'])->name('bu.building_index_update');//
    Route::delete('building/building_destroy/{id}',[App\Http\Controllers\BuildingController::class, 'building_destroy'])->name('bu.building_destroy');//

    Route::match(['get','post'],'building/building_addlevel/{id}',[App\Http\Controllers\BuildingController::class, 'building_addlevel'])->name('bu.building_addlevel');// ชั้น
    Route::match(['get','post'],'building/building_addlevel_save',[App\Http\Controllers\BuildingController::class, 'building_addlevel_save'])->name('bu.building_addlevel_save');//ชั้น
    Route::match(['get','post'],'building/building_addlevelone_save',[App\Http\Controllers\BuildingController::class, 'building_addlevelone_save'])->name('bu.building_addlevelone_save');//ชั้น
    Route::delete('building/building_leveldestroy/{id}',[App\Http\Controllers\BuildingController::class, 'building_leveldestroy'])->name('bu.building_leveldestroy');//ชั้น


    Route::match(['get','post'],'building/building_addlevel_room/{idbu}/{id}',[App\Http\Controllers\BuildingController::class, 'building_addlevel_room'])->name('bu.building_addlevel_room');// ห้อง
    Route::match(['get','post'],'building/building_addlevel_room_save',[App\Http\Controllers\BuildingController::class, 'building_addlevel_room_save'])->name('bu.building_addlevel_room_save');//ห้อง
    Route::delete('building/building_levelroomdestroy/{id}',[App\Http\Controllers\BuildingController::class, 'building_levelroomdestroy'])->name('bu.building_levelroomdestroy');//ห้อง
    Route::get('/building/addroomtype',[App\Http\Controllers\BuildingController::class, 'addroomtype'])->name('building_levelroomdestroy.addroomtype');//  เพิ่มประเภทห้อง

    // ******************** ข้อมูลบริการ ***********************
    Route::match(['get','post'],'serve/serve_index',[App\Http\Controllers\ServeController::class, 'serve_index'])->name('serve.serve_index');//
    Route::match(['get','post'],'serve/serve_index_add',[App\Http\Controllers\ServeController::class, 'serve_index_add'])->name('serve.serve_index_add');//
    Route::match(['get','post'],'serve/serve_index_save',[App\Http\Controllers\ServeController::class, 'serve_index_save'])->name('serve.serve_index_save');//
    Route::get('serve/serve_index_edit/{id}',[App\Http\Controllers\ServeController::class, 'serve_index_edit'])->name('serve.serve_index_edit');//
    Route::match(['get','post'],'serve/serve_index_update',[App\Http\Controllers\ServeController::class, 'serve_index_update'])->name('serve.serve_index_update');//
    Route::delete('/serve/serve_destroy/{id}',[App\Http\Controllers\ServeController::class, 'serve_destroy'])->name('serve.serve_destroy');//


      // ******************** คลังวัสดุ ***********************
      Route::match(['get','post'],'warehouse/warehouse_dashboard',[App\Http\Controllers\WarehouseController::class, 'warehouse_dashboard'])->name('ware.warehouse_dashboard');//
      Route::match(['get','post'],'warehouse/warehouse_index',[App\Http\Controllers\WarehouseController::class, 'warehouse_index'])->name('ware.warehouse_index');//
      Route::match(['get','post'],'warehouse/warehouse_add',[App\Http\Controllers\WarehouseController::class, 'warehouse_add'])->name('ware.warehouse_add');//
      Route::match(['get','post'],'warehouse/warehouse_addsub/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_addsub'])->name('ware.warehouse_addsub');//
      Route::match(['get','post'],'warehouse_add_product/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_add_product'])->name('ware.warehouse_add_product');//
      Route::match(['get','post'],'warehouse_edit_product/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_edit_product'])->name('ware.warehouse_edit_product');//
      Route::match(['get','post'],'warehouse_update_product',[App\Http\Controllers\WarehouseController::class,'warehouse_update_product'])->name('ware.warehouse_update_product');//
      Route::match(['get','post'],'warehouse_addsave',[App\Http\Controllers\WarehouseController::class, 'warehouse_addsave'])->name('ware.warehouse_addsave');//

      Route::match(['get','post'],'warehouse_billsave',[App\Http\Controllers\WarehouseController::class, 'warehouse_billsave'])->name('ware.warehouse_billsave');//
      Route::match(['get','post'],'warehouse_billupdate',[App\Http\Controllers\WarehouseController::class, 'warehouse_billupdate'])->name('ware.warehouse_billupdate');//
      Route::match(['get','post'],'warehouse/warehouse_save',[App\Http\Controllers\WarehouseController::class, 'warehouse_save'])->name('ware.warehouse_save');//

      Route::get('warehouse/warehouse_edit/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_edit'])->name('ware.warehouse_edit');//
      Route::match(['get','post'],'warehouse/warehouse_detail/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_detail'])->name('ware.warehouse_detail');//
      Route::match(['get','post'],'warehouse/warehouse_update',[App\Http\Controllers\WarehouseController::class, 'warehouse_update'])->name('ware.warehouse_update');//
      Route::match(['get','post'],'warehouse/warehouse_update_addsub',[App\Http\Controllers\WarehouseController::class, 'warehouse_update_addsub'])->name('ware.warehouse_update_addsub');//
      Route::match(['get','post'],'warehouse/warehouse_confirmbefor/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_confirmbefor'])->name('ware.warehouse_confirmbefor');//
      Route::match(['get','post'],'warehouse/warehouse_confirm/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_confirm'])->name('ware.warehouse_confirm');//
      Route::delete('warehouse/warehouse_destroy/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_destroy'])->name('ware.warehouse_destroy');//

      Route::match(['get','post'],'warehouse_confirm_recieve/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_confirm_recieve'])->name('ware.warehouse_confirm_recieve');//

      Route::match(['get','post'],'warehouse/warehouse_inven',[App\Http\Controllers\WarehouseController::class,'warehouse_inven'])->name('ware.warehouse_inven');//
      Route::match(['get','post'],'warehouse/warehouse_inven_add',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_add'])->name('ware.warehouse_inven_add');//
      Route::match(['get','post'],'warehouse/warehouse_invensave',[App\Http\Controllers\WarehouseController::class,'warehouse_invensave'])->name('ware.warehouse_invensave');//
      Route::match(['get','post'],'warehouse/warehouse_invenupdate',[App\Http\Controllers\WarehouseController::class,'warehouse_invenupdate'])->name('ware.warehouse_invenupdate');//
      Route::delete('warehouse_inven_destroy/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_destroy'])->name('ware.warehouse_inven_destroy');//

      Route::match(['get','post'],'warehouse/warehouse_inven_addper/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_addper'])->name('ware.warehouse_inven_addper');//
      Route::match(['get','post'],'warehouse/warehouse_inven_addpersave',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_addpersave'])->name('ware.warehouse_inven_addpersave');//
      Route::get('warehouse/warehouse_inven_edit/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_edit'])->name('ware.warehouse_inven_edit');//
      Route::put('warehouse/warehouse_inven_update',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_update'])->name('ware.warehouse_inven_update');//
      Route::delete('warehouse/warehouse_inven_addper_destroy/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_inven_addper_destroy'])->name('ware.warehouse_inven_addper_destroy');//
      Route::match(['get','post'],'warehouse/warehouse_editplus',[App\Http\Controllers\WarehouseController::class,'warehouse_editplus'])->name('ware.warehouse_editplus');//

      // Route::get('warehouse/warehouse_addsub/{id}',[App\Http\Controllers\WarehouseController::class,'warehouse_addsub']);

      Route::match(['get','post'],'warehouse/warehouse_vendor',[App\Http\Controllers\WarehouseController::class, 'warehouse_vendor'])->name('ware.warehouse_vendor');//
      Route::match(['get','post'],'warehouse/warehouse_vendorsave',[App\Http\Controllers\WarehouseController::class, 'warehouse_vendorsave'])->name('ware.warehouse_vendorsave');//
      Route::match(['get','post'],'warehouse/warehouse_vendor_edit/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_vendor_edit'])->name('ware.warehouse_vendor_edit');//
      Route::match(['get','post'],'warehouse/warehouse_vendorupdte',[App\Http\Controllers\WarehouseController::class, 'warehouse_vendorupdte'])->name('ware.warehouse_vendorupdte');//
      Route::delete('warehouse/warehouse_vendor_destroy/{id}',[App\Http\Controllers\WarehouseController::class, 'warehouse_vendor_destroy'])->name('ware.warehouse_vendor_destroy');//

      Route::get('warehouse/checksummoney',[App\Http\Controllers\WarehouseController::class, 'checksummoney'])->name('ware.checksummoney');//
      Route::get('warehouse/checkunitref',[App\Http\Controllers\WarehouseController::class, 'checkunitref'])->name('ware.checkunitref');//

      Route::get('warehouse/checksummoney_pay',[App\Http\Controllers\WarehouseController::class, 'checksummoney_pay'])->name('ware.checksummoney_pay');//
      Route::get('warehouse/checkunitref_pay',[App\Http\Controllers\WarehouseController::class, 'checkunitref_pay'])->name('ware.checkunitref_pay');//
      // Route::match(['get','post'],'warehouse/warehouse_save',[App\Http\Controllers\WarehouseController::class, 'warehouse_save'])->name('ware.warehouse_save');//
      Route::match(['get','post'],'warehouse/warehouse_main',[WarehouseController::class,'warehouse_main'])->name('ware.warehouse_main');
      Route::match(['get','post'],'warehouse/warehouse_main_detail/{id}',[WarehouseController::class,'warehouse_main_detail'])->name('ware.warehouse_main_detail');
      Route::match(['get','post'],'warehouse/warehouse_main_detail_sub/{idpro}',[WarehouseController::class,'warehouse_main_detail_sub'])->name('ware.warehouse_main_detail_sub');

      // Route::get('warehouse/warehouse_pay', function () {
      //   return view('welcome');
      // });
    // Route::match(['get','post'],'warehouse/warehouse_pay',[App\Http\Controllers\WarehousePayController::class,'warehouse_pay'])->name('pay.warehouse_pay');//

    // Route::match(['get','post'],'warehouse/warehouse_pay','WarehousePayController@warehouse_pay')->name('pay.warehouse_pay');//warehouse_payedit

    Route::match(['get','post'],'warehouse/warehouse_pay',[WarehousePayController::class,'warehouse_pay'])->name('pay.warehouse_pay');
    Route::match(['get','post'],'warehouse/warehouse_pay_edit/{id}',[WarehousePayController::class,'warehouse_pay_edit'])->name('pay.warehouse_pay_edit');
    Route::match(['get','post'],'warehouse_payedit/{id}',[WarehousePayController::class,'warehouse_payedit'])->name('pay.warehouse_payedit');
    Route::match(['get','post'],'warehouse_paymodal_edit/{id}',[WarehousePayController::class,'warehouse_paymodal_edit'])->name('pay.warehouse_paymodal_edit');

    Route::match(['get','post'],'get_year/{id}',[WarehousePayController::class,'get_year'])->name('pay.get_year');

    Route::match(['get','post'],'warehouse/warehouse_paysave',[WarehousePayController::class,'warehouse_paysave'])->name('pay.warehouse_paysave');
    Route::match(['get','post'],'warehouse/warehouse_payupdate',[WarehousePayController::class,'warehouse_payupdate'])->name('pay.warehouse_payupdate');

    Route::match(['get','post'],'warehouse_payadd/{id}',[WarehousePayController::class,'warehouse_payadd'])->name('pay.warehouse_payadd');
    Route::match(['get','post'],'warehouse_payadd_save',[WarehousePayController::class,'warehouse_payadd_save'])->name('pay.warehouse_payadd_save');
    Route::match(['get','post'],'warehouse_payadd_savesub',[WarehousePayController::class,'warehouse_payadd_savesub'])->name('pay.warehouse_payadd_savesub');
    Route::match(['get','post'],'warehouse/warehouse_pay_sub/{id}',[WarehousePayController::class,'warehouse_pay_sub'])->name('pay.warehouse_pay_sub');

    Route::get('warehouse/warehouse_plus/{id}',[WarehouseController::class,'warehouse_plus'])->name('pay.warehouse_plus');











    // ******************** ตั้งค่า  กลุ่มงาน ***********************
    Route::match(['get','post'],'setting/setting_index',[App\Http\Controllers\SettingController::class,'setting_index'])->name('setting.setting_index');//
    Route::match(['get','post'],'setting/setting_depsave',[App\Http\Controllers\SettingController::class, 'setting_depsave'])->name('setting.setting_depsave');//
    Route::get('setting/setting_index_edit/{id}',[App\Http\Controllers\SettingController::class, 'setting_index_edit'])->name('setting.setting_index_edit');//
    Route::match(['get','post'],'setting/setting_depupdate',[App\Http\Controllers\SettingController::class, 'setting_depupdate'])->name('setting.setting_depupdate');//
    Route::delete('setting_index_destroy/{id}',[App\Http\Controllers\SettingController::class, 'setting_index_destroy'])->name('setting.setting_index_destroy');//

    // ******************** ตั้งค่า  ฝ่าย/แผนก ***********************
    Route::match(['get','post'],'setting/depsub_index',[App\Http\Controllers\SettingController::class, 'depsub_index'])->name('setting.depsub_index');//
    Route::match(['get','post'],'setting/depsub_save',[App\Http\Controllers\SettingController::class, 'depsub_save'])->name('setting.depsub_save');//
    Route::get('setting/depsub_edit/{id}',[App\Http\Controllers\SettingController::class, 'depsub_edit'])->name('setting.depsub_edit');//
    Route::match(['get','post'],'setting/depsub_update',[App\Http\Controllers\SettingController::class, 'depsub_update'])->name('setting.depsub_update');//
    Route::delete('depsub_destroy/{id}',[App\Http\Controllers\SettingController::class, 'depsub_destroy'])->name('setting.depsub_destroy');//

    // ******************** ตั้งค่า  หน่วยงาน ***********************
    Route::match(['get','post'],'setting/depsubsub_index',[App\Http\Controllers\SettingController::class, 'depsubsub_index'])->name('setting.depsubsub_index');//
    Route::match(['get','post'],'setting/depsubsub_add_color',[App\Http\Controllers\SettingController::class, 'depsubsub_add_color'])->name('setting.depsubsub_add_color');//
    Route::match(['get','post'],'setting/depsubsub_updatecolor',[App\Http\Controllers\SettingController::class, 'depsubsub_updatecolor'])->name('setting.depsubsub_updatecolor');//

    Route::match(['get','post'],'setting/depsubsub_save',[App\Http\Controllers\SettingController::class, 'depsubsub_save'])->name('setting.depsubsub_save');//
    Route::get('setting/depsubsub_edit/{id}',[App\Http\Controllers\SettingController::class, 'depsubsub_edit'])->name('setting.depsubsub_edit');//
    Route::match(['get','post'],'setting/depsubsub_update',[App\Http\Controllers\SettingController::class, 'depsubsub_update'])->name('setting.depsubsub_update');//
    Route::delete('depsubsub_destroy/{id}',[App\Http\Controllers\SettingController::class, 'depsubsub_destroy'])->name('setting.depsubsub_destroy');//

    // ******************** ตั้งค่า  กำหนดสิทธิ์การเห็นชอบ ***********************
    Route::match(['get','post'],'setting/leader',[App\Http\Controllers\SettingController::class, 'leader'])->name('setting.leader');//
    Route::match(['get','post'],'setting/leader_save',[App\Http\Controllers\SettingController::class, 'leader_save'])->name('setting.leader_save');//
    Route::delete('leader_destroy/{id}',[App\Http\Controllers\SettingController::class, 'leader_destroy'])->name('setting.leader_destroy');//
    Route::match(['get','post'],'setting/leader_addsub/{id}',[App\Http\Controllers\SettingController::class, 'leader_addsub'])->name('setting.leader_addsub');//
    Route::match(['get','post'],'setting/leader_addsub_save',[App\Http\Controllers\SettingController::class, 'leader_addsub_save'])->name('setting.leader_addsub_save');//
    Route::delete('leadersub_destroy/{id}',[App\Http\Controllers\SettingController::class, 'leadersub_destroy'])->name('setting.leadersub_destroy');//

     // ******************** ตั้งค่า  กำหนดสิทธิ์การใช้งาน ***********************
     Route::match(['get','post'],'setting/permiss',[App\Http\Controllers\PermissController::class, 'permiss'])->name('setting.permiss');//
     Route::match(['get','post'],'setting/permiss_liss/{id}',[App\Http\Controllers\PermissController::class, 'permiss_liss'])->name('setting.permiss_liss');//
     Route::match(['get','post'],'setting/permiss_save',[App\Http\Controllers\PermissController::class, 'permiss_save'])->name('setting.permiss_save');//
     Route::get('setting/permiss_edit/{id}',[App\Http\Controllers\PermissController::class, 'permiss_edit'])->name('setting.permiss_edit');//
     Route::match(['get','post'],'setting/permiss_update',[App\Http\Controllers\PermissController::class, 'permiss_update'])->name('setting.permiss_update');//
     Route::delete('permiss_destroy/{id}',[App\Http\Controllers\PermissController::class, 'permiss_destroy'])->name('setting.permiss_destroy');//

     Route::get('setting/switchpermiss_person',[App\Http\Controllers\PermissController::class, 'switchpermiss_person'])->name('setting.switchpermiss_person');//
     Route::get('setting/switchpermiss_book',[App\Http\Controllers\PermissController::class, 'switchpermiss_book'])->name('setting.switchpermiss_book');//
     Route::get('setting/switchpermiss_car',[App\Http\Controllers\PermissController::class, 'switchpermiss_car'])->name('setting.switchpermiss_car');//
     Route::get('setting/switchpermiss_meetting',[App\Http\Controllers\PermissController::class, 'switchpermiss_meetting'])->name('setting.switchpermiss_meetting');//
     Route::get('setting/switchpermiss_repair',[App\Http\Controllers\PermissController::class, 'switchpermiss_repair'])->name('setting.switchpermiss_repair');//


 // ******************** ตั้งค่า องค์กร ***********************
 Route::match(['get','post'],'setting/orginfo',[App\Http\Controllers\SettingController::class, 'orginfo'])->name('setting.orginfo');//
 Route::match(['get','post'],'setting/orginfo_update',[App\Http\Controllers\SettingController::class, 'orginfo_update'])->name('setting.orginfo_update');//

    // ******************** ตั้งค่า  Line Token ***********************
    Route::match(['get','post'],'setting/line_token',[App\Http\Controllers\SettingController::class, 'line_token'])->name('setting.line_token');//
    Route::match(['get','post'],'setting/line_token_save',[App\Http\Controllers\SettingController::class, 'line_token_save'])->name('setting.line_token_save');//
    Route::get('setting/line_token_edit/{id}',[App\Http\Controllers\SettingController::class, 'line_token_edit'])->name('setting.line_token_edit');//
    Route::put('setting/line_token_update',[App\Http\Controllers\SettingController::class, 'line_token_update'])->name('setting.line_token_update');//



    // ******************** User **************************
    Route::match(['get','post'],'user/user_data',[App\Http\Controllers\UserController::class, 'user_data'])->name('user.user_data');//
    Route::match(['get','post'],'user/profile_edit/{id}',[App\Http\Controllers\UserController::class, 'profile_edit'])->name('user.profile_edit');//
    Route::match(['get','post'],'user/profile_update',[App\Http\Controllers\UserController::class, 'profile_update'])->name('user.profile_update');//
    Route::match(['get','post'],'password_update',[App\Http\Controllers\UserController::class, 'password_update'])->name('user.password_update');//

    Route::match(['get','post'],'user/gleave_data/{iduser}',[App\Http\Controllers\UserController::class, 'gleave_data'])->name('user.gleave_data');//
    Route::match(['get','post'],'user/gleave_data_add/{iduser}',[App\Http\Controllers\UserController::class, 'gleave_data_add'])->name('user.gleave_data_add');//
    Route::match(['get','post'],'user/gleave_data_dashboard/{iduser}',[App\Http\Controllers\UserController::class, 'gleave_data_dashboard'])->name('user.gleave_data_dashboard');//

    Route::match(['get','post'],'user/gleave_data_sick',[App\Http\Controllers\UserController::class, 'gleave_data_sick'])->name('user.gleave_data_sick');//ป่วย
    Route::match(['get','post'],'user/gleave_data_leave',[App\Http\Controllers\UserController::class, 'gleave_data_leave'])->name('user.gleave_data_leave');//กิจ
    Route::match(['get','post'],'user/gleave_data_maternity',[App\Http\Controllers\UserController::class, 'gleave_data_maternity'])->name('user.gleave_data_maternity');//ลาคลอดบุตร
    Route::match(['get','post'],'user/gleave_data_vacation',[App\Http\Controllers\UserController::class, 'gleave_data_vacation'])->name('user.gleave_data_vacation');//พักผ่อน
    Route::match(['get','post'],'user/gleave_data_study',[App\Http\Controllers\UserController::class, 'gleave_data_study'])->name('user.gleave_data_study');//ลาศึกษา ฝึกอบรม
    Route::match(['get','post'],'user/gleave_data_work',[App\Http\Controllers\UserController::class, 'gleave_data_work'])->name('user.gleave_data_work');//ทำงานต่างประเทศ
    Route::match(['get','post'],'user/gleave_data_occupation',[App\Http\Controllers\UserController::class, 'gleave_data_occupation'])->name('user.gleave_data_occupation');//ฟิ้นฟูอาชีพ
    Route::match(['get','post'],'user/gleave_data_soldier',[App\Http\Controllers\UserController::class, 'gleave_data_soldier'])->name('user.gleave_data_soldier');//ลาเกณฑ์ทหาร
    Route::match(['get','post'],'user/gleave_data_helpmaternity',[App\Http\Controllers\UserController::class, 'gleave_data_helpmaternity'])->name('user.gleave_data_helpmaternity');//ลาช่วยภริยาคลอด
    Route::match(['get','post'],'user/gleave_data_spouse',[App\Http\Controllers\UserController::class, 'gleave_data_spouse'])->name('user.gleave_data_spouse');//ติดตามคู่สมรส
    Route::match(['get','post'],'user/gleave_data_out',[App\Http\Controllers\UserController::class, 'gleave_data_out'])->name('user.gleave_data_out');//ลาออก
    Route::match(['get','post'],'user/gleave_data_law',[App\Http\Controllers\UserController::class, 'gleave_data_law'])->name('user.gleave_data_law');//ลาป่วยตามกฎหมาย
    Route::match(['get','post'],'user/gleave_data_ordination',[App\Http\Controllers\UserController::class, 'gleave_data_ordination'])->name('user.gleave_data_ordination');//ลาอุปสมบท

    // ***************** ยานพาหนะ ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user_car/car_calenda/{iduser}',[App\Http\Controllers\UsercarController::class, 'car_calenda'])->name('user_car.car_calenda');//
    Route::match(['get','post'],'user_car/car_narmal/{iduser}',[App\Http\Controllers\UsercarController::class, 'car_narmal'])->name('user_car.car_narmal');//
    Route::match(['get','post'],'user_car/car_narmal_show',[App\Http\Controllers\UsercarController::class, 'car_narmal_show'])->name('user_car.car_narmal_show');//
    Route::match(['get','post'],'user_car/car_narmal_showdetail/{id}',[App\Http\Controllers\UsercarController::class, 'car_narmal_showdetail'])->name('user_car.car_narmal_showdetail');//
    Route::match(['get','post'],'user_car/car_narmal_cancel/{id}',[App\Http\Controllers\UsercarController::class, 'car_narmal_cancel'])->name('user_car.car_narmal_cancel');//
    Route::match(['get','post'],'user_car/car_ambulance_cancel/{id}',[App\Http\Controllers\UsercarController::class, 'car_ambulance_cancel'])->name('user_car.car_ambulance_cancel');//
    Route::match(['get','post'],'user_car/car_ambulance_print/{id}',[App\Http\Controllers\UsercarController::class, 'car_ambulance_print'])->name('user_car.car_ambulance_print');//
    Route::match(['get','post'],'user_car/car_narmal_print/{id}',[App\Http\Controllers\UsercarController::class, 'car_narmal_print'])->name('user_car.car_narmal_print');//

    Route::match(['get','post'],'user_car/car_calenda_add/{id}',[App\Http\Controllers\UsercarController::class, 'car_calenda_add'])->name('user_car.car_calenda_add');//
    Route::match(['get','post'],'user_car/car_calenda_save',[App\Http\Controllers\UsercarController::class, 'car_calenda_save'])->name('user_car.car_calenda_save');//
    Route::match(['get','post'],'user_car/car_calenda_addsave',[App\Http\Controllers\UsercarController::class, 'car_calenda_addsave'])->name('user_car.car_calenda_addsave');//
    Route::match(['get','post'],'user_car/car_narmal_chose/{id}',[App\Http\Controllers\UsercarController::class, 'car_narmal_chose'])->name('user_car.car_narmal_chose');//
    Route::match(['get','post'],'user_car/car_calenda_savesign',[App\Http\Controllers\UsercarController::class, 'car_calenda_savesign'])->name('user_car.car_calenda_savesign');//
    Route::match(['get','post'],'user_car/car_calenda_edit/{id}',[App\Http\Controllers\UsercarController::class, 'car_calenda_edit'])->name('user_car.car_calenda_edit');//
    Route::match(['get','post'],'user_car/car_calenda_update',[App\Http\Controllers\UsercarController::class, 'car_calenda_update'])->name('user_car.car_calenda_update');//
    Route::match(['get','post'],'user_car/car_ambulance/{iduser}',[App\Http\Controllers\UsercarController::class, 'car_ambulance'])->name('user_car.car_ambulance');//
    Route::post('/user_car/addlocation',[App\Http\Controllers\UsercarController::class, 'addlocation'])->name('user_car.addlocation');//  เพิ่มสถานที่

    Route::match(['get','post'],'user_car/car_narmal_editshow/{id}',[App\Http\Controllers\UsercarController::class, 'car_narmal_editshow'])->name('user_car.car_narmal_editshow');//จัดสรร

    // ***************** สารบรรณ ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user/book_inside/{iduser}',[App\Http\Controllers\UserbookController::class, 'book_inside'])->name('user.book_inside');//
    Route::match(['get','post'],'user/book_send/{iduser}',[App\Http\Controllers\UserbookController::class, 'book_send'])->name('user.book_send');//
    Route::match(['get','post'],'user/book_advertise/{iduser}',[App\Http\Controllers\UserbookController::class, 'book_advertise'])->name('user.book_advertise');//

    Route::match(['get','post'],'user_book/user_bookdetail/{id}',[App\Http\Controllers\UserbookController::class, 'user_bookdetail'])->name('user.user_bookdetail');//
    Route::match(['get','post'],'user_book/user_book_send_file/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_file'])->name('user.user_book_send_file');//
    Route::match(['get','post'],'user_book/user_book_send_deb/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_deb'])->name('user.user_book_send_deb');//
    Route::match(['get','post'],'user_book/user_book_send_debsub/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_debsub'])->name('user.user_book_send_debsub');//
    Route::match(['get','post'],'user_book/user_book_send_debsubsub/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_debsubsub'])->name('user.user_book_send_debsubsub');//
    Route::match(['get','post'],'user_book/user_book_send_person/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_person'])->name('user.user_book_send_person');//
    Route::match(['get','post'],'user_book/user_book_send_team/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_team'])->name('user.user_book_send_team');//
    Route::match(['get','post'],'user_book/user_book_send_fileplus/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_fileplus'])->name('user.user_book_send_fileplus');//
    Route::match(['get','post'],'user_book/user_book_send_fileopen/{id}',[App\Http\Controllers\UserbookController::class, 'user_book_send_fileopen'])->name('user.user_book_send_fileopen');//

     // ***************** ประชุม/อบรม/ดูงาน ผู้ใช้งานทั่วไป***************************
     Route::match(['get','post'],'user/persondev_dashboard/{iduser}',[App\Http\Controllers\UserpersondevController::class, 'persondev_dashboard'])->name('user.persondev_dashboard');//
     Route::match(['get','post'],'user/persondev_index/{iduser}',[App\Http\Controllers\UserpersondevController::class, 'persondev_index'])->name('user.persondev_index');//
     Route::match(['get','post'],'user/persondev_inside/{iduser}',[App\Http\Controllers\UserpersondevController::class, 'persondev_inside'])->name('user.persondev_inside');//

    // ***************** ห้องประชุม ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user_meetting/meetting_dashboard ',[App\Http\Controllers\UsermeettingController::class, 'meetting_dashboard'])->name('meetting.meetting_dashboard');//
    Route::match(['get','post'],'user_meetting/meetting_index',[App\Http\Controllers\UsermeettingController::class, 'meetting_index'])->name('meetting.meetting_index');//
    Route::match(['get','post'],'user_meetting/meetting_add/{iduser}',[App\Http\Controllers\UsermeettingController::class, 'meetting_add'])->name('meetting.meetting_add');//
    Route::match(['get','post'],'user_meetting/meetting_save',[App\Http\Controllers\UsermeettingController::class, 'meetting_save'])->name('meetting.meetting_save');//
    Route::match(['get','post'],'user_meetting/meetting_choose/{id}',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose'])->name('meetting.meetting_choose');//
    Route::match(['get','post'],'user_meetting/meetting_choose_add/{id}',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose_add'])->name('meetting.meetting_choose_add');//
    Route::match(['get','post'],'user_meetting/meetting_choose_save',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose_save'])->name('meetting.meetting_choose_save');//
    Route::match(['get','post'],'user_meetting/meetting_choose_linesave',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose_linesave'])->name('meetting.meetting_choose_linesave');//
    Route::match(['get','post'],'user_meetting/meetting_choose_edit/{id}',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose_edit'])->name('meetting.meetting_choose_edit');//
    Route::match(['get','post'],'user_meetting/meetting_detail/{id}',[App\Http\Controllers\UsermeettingController::class, 'meetting_detail'])->name('meetting.meetting_detail');//
    Route::match(['get','post'],'meetting_choose_cancel/{id}',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose_cancel'])->name('meetting.meetting_choose_cancel');//

    Route::match(['get','post'],'user_meetting/meetting_calenda',[App\Http\Controllers\UsermeettingController::class, 'meetting_calenda'])->name('meetting.meetting_calenda');//ปฎิทิน
    Route::match(['get','post'],'user_meetting/calendar_save',[App\Http\Controllers\UsermeettingController::class, 'calendar_save'])->name('meetting.calendar_save');//
    Route::patch('user_meetting/calendar_update/{id}',[App\Http\Controllers\UsermeettingController::class, 'calendar_update'])->name('meetting.calendar_update');//
    // Route::match(['get','post'],'user_meetting/calendar_save',[App\Http\Controllers\UsermeettingController::class, 'calendar_save'])->name('meetting.calendar_save');//
    Route::delete('user_meetting/calendar_destroy/{id}',[App\Http\Controllers\UsermeettingController::class, 'calendar_destroy'])->name('meetting.calendar_destroy');//
    Route::match(['get','post'],'user_meetting/meetting_choose_lineupdate',[App\Http\Controllers\UsermeettingController::class, 'meetting_choose_lineupdate'])->name('meetting.meetting_choose_lineupdate');//

    Route::match(['get','post'],'user_meetting/meetting_calenda_add/{id}',[App\Http\Controllers\UsermeettingController::class, 'meetting_calenda_add'])->name('meetting.meetting_calenda_add');//ปฎิทิน


    // Route::resource('todo', CrudController::class);

    Route::match(['get','post'],'user_meetting/checkroom',[App\Http\Controllers\UsermeettingController::class, 'checkroom'])->name('meetting.checkroom');//

    // ***************** แจ้งซ่อม ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user/repair_dashboard/{iduser}',[App\Http\Controllers\UserrepairController::class, 'repair_dashboard'])->name('user.repair_dashboard');//
    Route::match(['get','post'],'user/repair_narmal/{iduser}',[App\Http\Controllers\UserrepairController::class, 'repair_narmal'])->name('user.repair_narmal');//

    Route::match(['get','post'],'user/repair_med/{iduser}',[App\Http\Controllers\UserrepairController::class, 'repair_med'])->name('user.repair_med');//

  // ***************** งานซ่อมคอม ผู้ใช้งานทั่วไป***************************


  Route::match(['get','post'],'user_com/repair_com_calenda',[App\Http\Controllers\UsercomController::class, 'repair_com_calenda'])->name('user.repair_com_calenda');//
  Route::match(['get','post'],'user_com/repair_com',[App\Http\Controllers\UsercomController::class, 'repair_com'])->name('user.repair_com');//
  Route::match(['get','post'],'user_com/repair_com_add',[App\Http\Controllers\UsercomController::class, 'repair_com_add'])->name('user.repair_com_add');//
  Route::match(['get','post'],'user_com/repair_com_save',[App\Http\Controllers\UsercomController::class, 'repair_com_save'])->name('user.repair_com_save');//
  Route::match(['get','post'],'user_com/repair_com_edit/{id}',[App\Http\Controllers\UsercomController::class, 'repair_com_edit'])->name('user.repair_com_edit');//
  Route::match(['get','post'],'user_com/repair_com_update',[App\Http\Controllers\UsercomController::class, 'repair_com_update'])->name('user.repair_com_update');//
  Route::match(['get','post'],'user_com/repair_com_cancel/{id}',[App\Http\Controllers\UsercomController::class, 'repair_com_cancel'])->name('user.repair_com_cancel');//
  Route::match(['get','post'],'user_com/repair_com_print/{id}',[App\Http\Controllers\UsercomController::class, 'repair_com_print'])->name('user.repair_com_print');//

  Route::match(['get','post'],'user_com/com_calenda',[App\Http\Controllers\UserComController::class,'com_calenda'])->name('user.com_calenda');//

  // Route::get('user_com/com_calendanew',[App\Http\Controllers\UserComController::class,'com_calendanew']);//

  Route::get('/com_calendanew', [UserComController::class, 'com_calendanew']);


  Route::match(['get','post'],'user_com/com_index',[App\Http\Controllers\UserComController::class, 'com_index'])->name('user.com_index');//
  Route::match(['get','post'],'user_com/com_index_save',[App\Http\Controllers\UserComController::class, 'com_index_save'])->name('user.com_index_save');//
  Route::match(['get','post'],'user_com/com_index_edit/{id}',[App\Http\Controllers\UserComController::class, 'com_index_edit'])->name('user.com_index_edit');//


    // ***************** บ้านพัก ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user/house_detail/{iduser}',[App\Http\Controllers\UserhouseController::class, 'house_detail'])->name('house.house_detail');//
    Route::match(['get','post'],'user/house_petition/{iduser}',[App\Http\Controllers\UserhouseController::class, 'house_petition'])->name('house.house_petition');//
    Route::match(['get','post'],'user/house_problem/{iduser}',[App\Http\Controllers\UserhouseController::class, 'house_problem'])->name('house.house_problem');//


    // ***************** ทะเบียนทรัพย์สิน ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user_article',[App\Http\Controllers\UserarticleController::class, 'user_article'])->name('article.user_article');//
    Route::match(['get','post'],'user_article_borrow',[App\Http\Controllers\UserarticleController::class, 'user_article_borrow'])->name('article.user_article_borrow');//
    Route::match(['get','post'],'user_article_borrowsave',[App\Http\Controllers\UserarticleController::class, 'user_article_borrowsave'])->name('article.user_article_borrowsave');//
    Route::match(['get','post'],'user_article_borrowupdate',[App\Http\Controllers\UserarticleController::class, 'user_article_borrowupdate'])->name('article.user_article_borrowupdate');//
    Route::match(['get','post'],'user_article_return',[App\Http\Controllers\UserarticleController::class, 'user_article_return'])->name('article.user_article_return');//

   // ***************** พัสดุ ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user/supplies_dashboard',[App\Http\Controllers\UsersuppliesController::class, 'supplies_dashboard'])->name('user.supplies_dashboard');//
    Route::match(['get','post'],'user/supplies_data/{iduser}',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data'])->name('user.supplies_data');//
    Route::match(['get','post'],'user/supplies_data_add/{iduser}',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_add'])->name('user.supplies_data_add');//
    Route::match(['get','post'],'user/supplies_data_save',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_save'])->name('user.supplies_data_save');//
    Route::get('user/supplies_data_edit/{iduser}/{id}',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_edit'])->name('user.supplies_data_edit');//

    // Route::get('staff/staff_member_edit/{id}',[App\Http\Controllers\UsersuppliesController::class, 'staff_member_edit'])->name('staff.staff_member_edit');//

    Route::match(['get','post'],'user/supplies_data_update',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_update'])->name('user.supplies_data_update');//
    Route::match(['get','post'],'user/supplies_data_add_sub/{iduser}/{idrep}',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_add_sub'])->name('user.supplies_data_add_sub');//
    Route::match(['get','post'],'user/supplies_data_add_subsave',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_add_subsave'])->name('user.supplies_data_add_subsave');//
    Route::match(['get','post'],'user/supplies_data_add_subupdate',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_add_subupdate'])->name('user.supplies_data_add_subupdate');//

    Route::delete('/user/supplies_data_add_destroy/{id}',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_add_destroy'])->name('user.supplies_data_add_destroy');//
    Route::delete('/user/supplies_data_add_subdestroy/{id}',[App\Http\Controllers\UsersuppliesController::class, 'supplies_data_add_subdestroy'])->name('user.supplies_data_add_subdestroy');//

    // ***************** คลังวัสดุ ผู้ใช้งานทั่วไป***************************
    Route::match(['get','post'],'user/warehouse_dashboard/{iduser}',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_dashboard'])->name('user.warehouse_dashboard');//
    Route::match(['get','post'],'user/warehouse_deb_sub_sub/{iduser}',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_deb_sub_sub'])->name('user.warehouse_deb_sub_sub');//
    Route::match(['get','post'],'user/warehouse_main_request/{iduser}',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_main_request'])->name('user.warehouse_main_request');//

    Route::match(['get','post'],'user_ware/warehouse_stock_sub',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_stock_sub'])->name('user_ware.warehouse_stock_sub');//
    Route::match(['get','post'],'user_ware/warehouse_stock_main',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_stock_main'])->name('user_ware.warehouse_stock_main');//
    Route::match(['get','post'],'user_ware/warehouse_stock_sub_add/{id}',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_stock_sub_add'])->name('user_ware.warehouse_stock_sub_add');//
    Route::match(['get','post'],'user_ware/warehouse_stock_subbillsave',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_stock_subbillsave'])->name('user_ware.warehouse_stock_subbillsave');//

    Route::match(['get','post'],'user_ware/warehouse_stock_subsave',[App\Http\Controllers\UserwarehouseController::class, 'warehouse_stock_subsave'])->name('user_ware.warehouse_stock_subsave');//
    Route::get('user_ware/checkunituser',[App\Http\Controllers\UserwarehouseController::class, 'checkunituser'])->name('user_ware.checkunituser');//
    Route::get('user_ware/getdetailselect',[App\Http\Controllers\UserwarehouseController::class, 'getdetailselect'])->name('user_ware.getdetailselect');//
    Route::get('user_ware/selectsupreq',[App\Http\Controllers\UserwarehouseController::class, 'selectsupreq'])->name('user_ware.selectsupreq');//
    Route::get('user_ware/selectsupunitname',[App\Http\Controllers\UserwarehouseController::class, 'selectsupunitname'])->name('user_ware.selectsupunitname');//







 //***************** ยานพาหนะ รถทั่วไป ผู้ดูแล**************************
    Route::match(['get','post'],'car/car_narmal_calenda',[App\Http\Controllers\CarController::class, 'car_narmal_calenda'])->name('car.car_narmal_calenda');//รถทั่วไป Calenda


    Route::match(['get','post'],'car/car_narmal_calenda_add/{id}',[App\Http\Controllers\CarController::class, 'car_narmal_calenda_add'])->name('car.car_narmal_calenda_add');//รถทั่วไป Calenda
    Route::match(['get','post'],'car/car_narmal_index',[App\Http\Controllers\CarController::class, 'car_narmal_index'])->name('car.car_narmal_index');//รถทั่วไป
    Route::match(['get','post'],'car/car_narmal_updatecancel/{id}',[App\Http\Controllers\CarController::class, 'car_narmal_updatecancel'])->name('car.car_narmal_updatecancel');//
    Route::match(['get','post'],'car/car_narmal_editallocate/{id}',[App\Http\Controllers\CarController::class, 'car_narmal_editallocate'])->name('car.car_narmal_editallocate');//จัดสรร
    Route::match(['get','post'],'car/car_narmal_report',[App\Http\Controllers\CarController::class, 'car_narmal_report'])->name('car.car_narmal_report');//รถทั่วไป report
    Route::match(['get','post'],'car/car_narmal_allocate',[App\Http\Controllers\CarController::class, 'car_narmal_allocate'])->name('car.car_narmal_allocate');//

 // ***************** ข้อมูลยานพาหนะ ***************************
    Route::match(['get','post'],'car/car_data_index',[App\Http\Controllers\CarController::class, 'car_data_index'])->name('car.car_data_index');//ข้อมูลยานพาหนะ
    Route::match(['get','post'],'car/car_data_indexsearch',[App\Http\Controllers\CarController::class, 'car_data_indexsearch'])->name('car.car_data_indexsearch');//ข้อมูลยานพาหนะ
    Route::match(['get','post'],'car/car_data_index_add',[App\Http\Controllers\CarController::class, 'car_data_index_add'])->name('car.car_data_index_add');//เพิ่มข้อมูลยานพาหนะ
    Route::match(['get','post'],'car/car_data_index_save',[App\Http\Controllers\CarController::class, 'car_data_index_save'])->name('car.car_data_index_save');//บันทึกข้อมูลยานพาหนะ
    Route::match(['get','post'],'car/car_data_index_edit/{id}',[App\Http\Controllers\CarController::class, 'car_data_index_edit'])->name('car.car_data_index_edit');//แก้ไขข้อมูลยานพาหนะ
    Route::match(['get','post'],'car/car_data_index_update',[App\Http\Controllers\CarController::class, 'car_data_index_update'])->name('car.car_data_index_update');//อัพเดทข้อมูลยานพาหนะ
    Route::delete('car/car_destroy/{id}',[App\Http\Controllers\CarController::class, 'car_destroy'])->name('car.car_destroy');//ลบข้อมูลยานพาหนะ

    Route::get('car/add_cartype',[App\Http\Controllers\CarController::class, 'add_cartype'])->name('car.add_cartype');//  เพิ่มประเภทยานพาหนะ
    Route::get('car/add_carbrand',[App\Http\Controllers\CarController::class, 'add_carbrand'])->name('car.add_carbrand');//  เพิ่มยี่ห้อยานพาหนะ
    Route::get('car/add_carcolor',[App\Http\Controllers\CarController::class, 'add_carcolor'])->name('car.add_carcolor');//  เพิ่มสียานพาหนะ
    Route::post('car/adddrive',[App\Http\Controllers\CarController::class, 'adddrive'])->name('car.adddrive');//  เพิ่มคนขับ

    // ***************** ยานพาหนะ พยาบาล***************************
    Route::match(['get','post'],'car/car_ambulance',[App\Http\Controllers\CarController::class, 'car_ambulance'])->name('car.car_ambulance');//พยาบาล
    Route::match(['get','post'],'car/car_ambulancesearch',[App\Http\Controllers\CarController::class, 'car_ambulancesearch'])->name('car.car_ambulancesearch');//พยาบาล
    // ***************** ยานพาหนะ Report***************************
    Route::match(['get','post'],'car/car_report',[App\Http\Controllers\CarController::class, 'car_report'])->name('car.car_report');//Report

    // ***************** ห้องประชุม ผู้ดูแล***************************
    Route::match(['get','post'],'meetting/meettingroom_dashboard',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_dashboard'])->name('meetting.meettingroom_dashboard');//ห้องประชุม
    Route::match(['get','post'],'meetting/meettingroom_index',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_index'])->name('meetting.meettingroom_index');//ห้องประชุม
    Route::match(['get','post'],'meetting/meettingroom_index_save',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_index_save'])->name('meetting.meettingroom_index_save');//ห้องประชุม
    Route::match(['get','post'],'meetting/meettingroom_index_edit/{id}',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_index_edit'])->name('meetting.meettingroom_index_edit');//แก้ไข
    Route::match(['get','post'],'meetting/meettingroom_index_tool/{id}',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_index_tool'])->name('meetting.meettingroom_index_tool');//เพิ่มอุปกรณ์
    Route::match(['get','post'],'meetting/meettingroom_index_toolsave',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_index_toolsave'])->name('meetting.meettingroom_index_toolsave');//เพิ่มอุปกรณ์
    Route::delete('/meetting/room_listdestroy/{id}',[App\Http\Controllers\MeettingroomController::class, 'room_listdestroy'])->name('meetting.room_listdestroy');//ลบข้อมูล

    Route::match(['get','post'],'meetting/meettingroom_add',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_add'])->name('meetting.meettingroom_add');//ห้องประชุม

    Route::match(['get','post'],'meetting/meettingroom_check',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_check'])->name('meetting.meettingroom_check');//ห้องประชุม
    Route::match(['get','post'],'meetting/meettingroom_check_search',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_check_search'])->name('meetting.meettingroom_check_search');//ห้องประชุม
    Route::match(['get','post'],'meetting/meettingroom_check_allow/{id}',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_check_allow'])->name('meetting.meettingroom_check_allow');//ตรวจสอบ
    Route::match(['get','post'],'meetting/meettingroom_check_allow_update',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_check_allow_update'])->name('meetting.meettingroom_check_allow_update');//ตรวจสอบ
    Route::match(['get','post'],'meetting/meettingroom_check_searce',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_check_searce'])->name('meetting.meettingroom_check_searce');//ตรวจสอบ

    Route::match(['get','post'],'meetting/meettingroom_report',[App\Http\Controllers\MeettingroomController::class, 'meettingroom_report'])->name('meetting.meettingroom_report');//ห้องประชุม

 // ***************** บ้านพัก ผู้ดูแล***************************
 Route::match(['get','post'],'housing/housing_dashboard',[App\Http\Controllers\HousingController::class, 'housing_dashboard'])->name('housing.housing_dashboard');//บ้านพัก
 Route::match(['get','post'],'housing/housing_index',[App\Http\Controllers\HousingController::class, 'housing_index'])->name('housing.housing_index');//บ้านพัก รายการบ้านพัก
 Route::match(['get','post'],'housing/housing_request',[App\Http\Controllers\HousingController::class, 'housing_request'])->name('housing.housing_request');//บ้านพัก รายการขอเข้าพัก
 Route::match(['get','post'],'housing/housing_appeal',[App\Http\Controllers\HousingController::class, 'housing_appeal'])->name('housing.housing_appeal');//บ้านพัก  ร้องเรียนปัญหา
 Route::match(['get','post'],'housing/housing_report',[App\Http\Controllers\HousingController::class, 'housing_report'])->name('housing.housing_report');//บ้านพัก  รายงาน


 // ***************** คอมพิวเตอร์ ผู้ดูแล***************************
 Route::match(['get','post'],'computer/com_staff_dashboard',[App\Http\Controllers\ComputerController::class, 'com_staff_dashboard'])->name('com.com_staff_dashboard');//คอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_calenda',[App\Http\Controllers\ComputerController::class, 'com_staff_calenda'])->name('com.com_staff_calenda');//ปฎิทินคอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_index',[App\Http\Controllers\ComputerController::class, 'com_staff_index'])->name('com.com_staff_index');//  คอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_index_add/{id}',[App\Http\Controllers\ComputerController::class, 'com_staff_index_add'])->name('com.com_staff_index_add');//  บันทึกคอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_index_update',[App\Http\Controllers\ComputerController::class, 'com_staff_index_update'])->name('com.com_staff_index_update');//  บันทึกคอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_repair',[App\Http\Controllers\ComputerController::class, 'com_staff_repair'])->name('com.com_staff_repair');// ทะเบียนซ่อมคอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_report',[App\Http\Controllers\ComputerController::class, 'com_staff_report'])->name('com.com_staff_report');//  คอมพิวเตอร์
 Route::match(['get','post'],'computer/com_staff_cancel/{id}',[App\Http\Controllers\ComputerController::class, 'com_staff_cancel'])->name('com.com_staff_cancel');//

 Route::match(['get','post'],'computer/com_staff_print/{id}',[App\Http\Controllers\ComputerController::class, 'com_staff_print'])->name('com.com_staff_print');//
 Route::get('employee/pdf', [App\Http\Controllers\ComputerController::class, 'createPDF'])->name('bk.createPDF'); // Dompdf
 Route::get('employee/fpdi', [App\Http\Controllers\ComputerController::class, 'createFPDI'])->name('bk.createFPDI');  //Fpdi

 Route::match(['get','post'],'computer/com_index',[App\Http\Controllers\ComputerController::class, 'com_index'])->name('com.com_index');// ทะเบียนครุภัณฑ์คอมพิวเตอร์
 Route::match(['get','post'],'computer/com_tech',[App\Http\Controllers\ComputerController::class, 'com_tech'])->name('com.com_tech');// ช่างซ่อมคอมพิวเตอร์
 Route::match(['get','post'],'computer/com_tech_save',[App\Http\Controllers\ComputerController::class, 'com_tech_save'])->name('com.com_tech_save');// ช่างซ่อมคอมพิวเตอร์
 Route::delete('computer/com_techdestroy/{id}',[App\Http\Controllers\ComputerController::class, 'com_techdestroy'])->name('com.com_techdestroy');//ลบข้อมูล

 Route::match(['get','post'],'computer/com_maintenance/{id}',[App\Http\Controllers\ComputerController::class, 'com_maintenance'])->name('com.com_maintenance');// ทะเบียนครุภัณฑ์คอมพิวเตอร์
 Route::match(['get','post'],'computer/com_qrcode/{id}',[App\Http\Controllers\ComputerController::class, 'com_qrcode'])->name('com.com_qrcode');// ทะเบียนครุภัณฑ์คอมพิวเตอร์




 // ***************** แจ้งซ่อมทั่วไป ผู้ดูแล***************************
 Route::match(['get','post'],'repaire_narmal',[App\Http\Controllers\RepairnarmalController::class, 'repaire_narmal'])->name('narmal.repaire_narmal');//แจ้งซ่อมทั่วไป
 Route::match(['get','post'],'repaire_calenda',[App\Http\Controllers\RepairnarmalController::class, 'repaire_calenda'])->name('narmal.repaire_calenda');//

 Route::match(['get','post'],'repaire_tech',[App\Http\Controllers\RepairnarmalController::class, 'repaire_tech'])->name('narmal.repaire_tech');//
 Route::match(['get','post'],'repaire_techsave',[App\Http\Controllers\RepairnarmalController::class, 'repaire_techsave'])->name('narmal.repaire_techsave');//
 Route::match(['get','post'],'repaire_techedit/{id}',[App\Http\Controllers\RepairnarmalController::class, 'repaire_techedit'])->name('narmal.repaire_techedit');//
 Route::match(['get','post'],'repaire_techupdate',[App\Http\Controllers\RepairnarmalController::class, 'repaire_techupdate'])->name('narmal.repaire_techupdate');//
 Route::delete('repaire_tech_destroy/{id}',[App\Http\Controllers\RepairnarmalController::class, 'repaire_tech_destroy'])->name('narmal.repaire_tech_destroy');//

 Route::match(['get','post'],'repaire_req',[App\Http\Controllers\RepairnarmalController::class, 'repaire_req'])->name('narmal.repaire_req');//

 // ***************** เครื่องมือแพทย์ ผู้ดูแล***************************
 Route::match(['get','post'],'medical/med_dashboard',[App\Http\Controllers\MedicalController::class, 'med_dashboard'])->name('med.med_dashboard');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_dashboard_detail/{id}',[App\Http\Controllers\MedicalController::class, 'med_dashboard_detail'])->name('med.med_dashboard_detail');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_dashboard_night/{id}',[App\Http\Controllers\MedicalController::class, 'med_dashboard_night'])->name('med.med_dashboard_night');//คืนคลังเครื่องมือแพทย์
 Route::match(['get','post'],'med_dashboard_repaire/{id}',[App\Http\Controllers\MedicalController::class, 'med_dashboard_repaire'])->name('med.med_dashboard_repaire');//คืนคลังเครื่องมือแพทย์
 Route::match(['get','post'],'med_dashboard_deal/{id}',[App\Http\Controllers\MedicalController::class, 'med_dashboard_deal'])->name('med.med_dashboard_deal');//คืนคลังเครื่องมือแพทย์

 Route::match(['get','post'],'medical/med_con',[App\Http\Controllers\MedicalController::class, 'med_con'])->name('med.med_con');//เครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_consave',[App\Http\Controllers\MedicalController::class, 'med_consave'])->name('med.med_consave');//เครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_con_edit/{id}',[App\Http\Controllers\MedicalController::class, 'med_con_edit'])->name('med.med_con_edit');//เครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_con_update',[App\Http\Controllers\MedicalController::class, 'med_con_update'])->name('med.med_con_update');//เครื่องมือแพทย์
 Route::delete('med_condestroy/{id}',[App\Http\Controllers\MedicalController::class, 'med_condestroy'])->name('med.med_condestroy');//

 Route::match(['get','post'],'medical/med_calenda',[App\Http\Controllers\MedicalController::class, 'med_calenda'])->name('med.med_calenda');//
 Route::match(['get','post'],'med_calenda_detail/{id}',[App\Http\Controllers\MedicalController::class, 'med_calenda_detail'])->name('car.med_calenda_detail');//รถทั่วไป Calenda

 Route::match(['get','post'],'med_store',[App\Http\Controllers\MedicalController::class, 'med_store'])->name('med.med_store');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_add/{id}',[App\Http\Controllers\MedicalController::class, 'med_store_add'])->name('med.med_store_add');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_save',[App\Http\Controllers\MedicalController::class, 'med_store_save'])->name('med.med_store_save');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_update',[App\Http\Controllers\MedicalController::class, 'med_store_update'])->name('med.med_store_update');//เครื่องมือแพทย์

 Route::match(['get','post'],'med_store_rep/{id}',[App\Http\Controllers\MedicalController::class, 'med_store_rep'])->name('med.med_store_rep');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_repsave',[App\Http\Controllers\MedicalController::class, 'med_store_repsave'])->name('med.med_store_repsave');//เครื่องมือแพทย์

 Route::match(['get','post'],'med_store_subsave',[App\Http\Controllers\MedicalController::class, 'med_store_subsave'])->name('med.med_store_subsave');//เครื่องมือแพทย์
//  ********************************* คลัง เครื่องมือแพทย์ **********************************
 Route::match(['get','post'],'medical_stock/{id}',[App\Http\Controllers\MedicalController::class, 'medical_stock'])->name('med.medical_stock');//คลังเครื่องมือแพทย์


 //  ********************************* ยืม เครื่องมือแพทย์ **********************************
 Route::match(['get','post'],'medical_store_borrow/{id}',[App\Http\Controllers\MedicalController::class, 'medical_store_borrow'])->name('med.medical_store_borrow');//ยืมคลังเครื่องมือแพทย์



 //  ********************************* คืน เครื่องมือแพทย์ **********************************
 Route::match(['get','post'],'medical_store_night/{id}',[App\Http\Controllers\MedicalController::class, 'medical_store_night'])->name('med.medical_store_night');//คืนคลังเครื่องมือแพทย์


 Route::match(['get','post'],'med_store_subadd',[App\Http\Controllers\MedicalController::class, 'med_store_subadd'])->name('med.med_store_subadd');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_subsave',[App\Http\Controllers\MedicalController::class, 'med_store_subsave'])->name('med.med_store_subsave');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_subedit/{id}',[App\Http\Controllers\MedicalController::class, 'med_store_subedit'])->name('med.med_store_subedit');//เครื่องมือแพทย์
 Route::match(['get','post'],'med_store_subupdate',[App\Http\Controllers\MedicalController::class, 'med_store_subupdate'])->name('med.med_store_subupdate');//เครื่องมือแพทย์

 Route::match(['get','post'],'medical/med_index',[App\Http\Controllers\MedicalController::class, 'med_index'])->name('med.med_index');// ทะเบียนครุภัณฑ์เครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_add',[App\Http\Controllers\MedicalController::class, 'med_add'])->name('med.med_add');//
 Route::match(['get','post'],'medical/med_save',[App\Http\Controllers\MedicalController::class, 'med_save'])->name('med.med_save');//
 Route::match(['get','post'],'medical/med_edit/{id}',[App\Http\Controllers\MedicalController::class, 'med_edit'])->name('med.med_edit');//
 Route::match(['get','post'],'medical/med_update',[App\Http\Controllers\MedicalController::class, 'med_update'])->name('med.med_update');//

 Route::match(['get','post'],'medical/med_maintenance/{id}',[App\Http\Controllers\MedicalController::class, 'med_maintenance'])->name('med.med_maintenance');//การบำรุงรักษา

 Route::match(['get','post'],'medical/med_repair',[App\Http\Controllers\MedicalController::class, 'med_repair'])->name('med.med_repair');// ทะเบียนซ่อมเครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_report',[App\Http\Controllers\MedicalController::class, 'med_report'])->name('med.med_report');// ทะเบียนซ่อมเครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_borrow',[App\Http\Controllers\MedicalController::class, 'med_borrow'])->name('med.med_borrow');// ทะเบียนซ่อมเครื่องมือแพทย์

 Route::match(['get','post'],'medical/med_borroweditpage/{id}',[App\Http\Controllers\MedicalController::class, 'med_borroweditpage'])->name('med.med_borroweditpage');//

 Route::match(['get','post'],'medical/med_borrow_search',[App\Http\Controllers\MedicalController::class, 'med_borrow_search'])->name('med.med_borrow_search');//
 Route::match(['get','post'],'medical/med_borrowsave',[App\Http\Controllers\MedicalController::class, 'med_borrowsave'])->name('med.med_borrowsave');// ทะเบียนซ่อมเครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_borrowedit/{id}',[App\Http\Controllers\MedicalController::class, 'med_borrowedit'])->name('med.med_borrowedit');//
 Route::match(['get','post'],'medical/med_borrowedit2/{id}',[App\Http\Controllers\MedicalController::class, 'med_borrowedit2'])->name('med.med_borrowedit2');//
 Route::match(['get','post'],'medical/med_borrowupdate',[App\Http\Controllers\MedicalController::class, 'med_borrowupdate'])->name('med.med_borrowupdate');//
 Route::match(['get','post'],'medical/med_borrowDataupdate',[App\Http\Controllers\MedicalController::class, 'med_borrowDataupdate'])->name('med.med_borrowDataupdate');//
 Route::match(['get','post'],'medical/med_borrowupdate_Noalert',[App\Http\Controllers\MedicalController::class, 'med_borrowupdate_Noalert'])->name('med.med_borrowupdate_Noalert');// Update แบบไม่มี Alert
 Route::match(['get','post'],'medical/med_borrowupdate_status/{id}',[App\Http\Controllers\MedicalController::class, 'med_borrowupdate_status'])->name('med.med_borrowupdate_status');// จัดสรร
 Route::delete('med_borrowdestroy/{id}',[App\Http\Controllers\MedicalController::class, 'med_borrowdestroy'])->name('med.med_borrowdestroy');//

 Route::match(['get','post'],'medical/med_repaire/{id}',[App\Http\Controllers\MedicalController::class, 'med_repaire'])->name('med.med_repaire');// ส่งซ่อม
 Route::match(['get','post'],'medical/med_repaire_save',[App\Http\Controllers\MedicalController::class, 'med_repaire_save'])->name('med.med_repaire_save');// ส่งซ่อม

 Route::match(['get','post'],'medical/med_rep1',[App\Http\Controllers\MedicalController::class, 'med_rep1'])->name('med.med_rep1');//รายงานการยืม/การใช้เครื่องมือแพทย์ ครุภัณฑ์เครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_rep1_search',[App\Http\Controllers\MedicalController::class, 'med_rep1_search'])->name('med.med_rep1_search');//


 Route::match(['get','post'],'medical/med_rep2',[App\Http\Controllers\MedicalController::class, 'med_rep2'])->name('med.med_rep2');//รายงานการยืม/การใช้เครื่องมือแพทย์ ครุภัณฑ์เครื่องมือแพทย์
 Route::match(['get','post'],'medical/med_rep2_search',[App\Http\Controllers\MedicalController::class, 'med_rep2_search'])->name('med.med_rep2_search');//รายงานการยืม/การใช้เครื่องมือแพทย์ ครุภัณฑ์เครื่องมือแพทย์


 Route::match(['get','post'],'medical/med_rep3',[App\Http\Controllers\MedicalController::class, 'med_rep3'])->name('med.med_rep3');//รายงานการยืม/การใช้เครื่องมือแพทย์ ครุภัณฑ์เครื่องมือแพทย์


 Route::match(['get','post'],'medical/med_rep1_excel',[App\Http\Controllers\MedicalController::class, 'med_rep1_excel'])->name('med.med_rep1_excel');
 Route::match(['get','post'],'medical/med_rep2_excel',[App\Http\Controllers\MedicalController::class, 'med_rep2_excel'])->name('med.med_rep2_excel');
 Route::match(['get','post'],'medical/med_rep3_excel/{startdate}/{enddate}',[App\Http\Controllers\MedicalController::class, 'med_rep3_excel'])->name('med.med_rep3_excel');



    // ***************** หัวหน้า ***************************
    Route::match(['get','post'],'hn/hn_dashboard/{iduser}',[App\Http\Controllers\HnController::class, 'hn_dashboard'])->name('hn.hn_dashboard');//

    Route::match(['get','post'],'hn/hn_bookindex/{iduser}',[App\Http\Controllers\HnController::class, 'hn_bookindex'])->name('hn.hn_bookindex');//
    Route::match(['get','post'],'hn/hn_bookdetail/{id}',[App\Http\Controllers\HnController::class, 'hn_bookdetail'])->name('hn.hn_bookdetail');//
    Route::match(['get','post'],'hn/hn_book_send_file/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_file'])->name('hn.hn_book_send_file');//
    Route::match(['get','post'],'hn/hn_book_send_deb/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_deb'])->name('hn.hn_book_send_deb');//
    Route::match(['get','post'],'hn/hn_book_send_debsub/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_debsub'])->name('hn.hn_book_send_debsub');//
    Route::match(['get','post'],'hn/hn_book_send_debsubsub/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_debsubsub'])->name('hn.hn_book_send_debsubsub');//
    Route::match(['get','post'],'hn/hn_book_send_person/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_person'])->name('hn.hn_book_send_person');//
    Route::match(['get','post'],'hn/hn_book_send_team/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_team'])->name('hn.hn_book_send_team');//
    Route::match(['get','post'],'hn/hn_book_send_fileplus/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_fileplus'])->name('hn.hn_book_send_fileplus');//
    Route::match(['get','post'],'hn/hn_book_send_fileopen/{id}',[App\Http\Controllers\HnController::class, 'hn_book_send_fileopen'])->name('hn.hn_book_send_fileopen');//


    Route::match(['get','post'],'hn/hn_bookindex_comment/{id}/{iduser}',[App\Http\Controllers\HnController::class, 'hn_bookindex_comment'])->name('hn.hn_bookindex_comment');//
    Route::get('hn/hn_bookindex_comment_edit/{id}',[App\Http\Controllers\HnController::class, 'hn_bookindex_comment_edit'])->name('hn.hn_bookindex_comment_edit');//
    Route::match(['get','post'],'hn/hn_bookindex_comment_update',[App\Http\Controllers\HnController::class, 'hn_bookindex_comment_update'])->name('hn.hn_bookindex_comment_update');//

    Route::match(['get','post'],'hn/hn_leaveindex/{iduser}',[App\Http\Controllers\HnController::class, 'hn_leaveindex'])->name('hn.hn_leaveindex');//
    Route::match(['get','post'],'hn/hn_trainindex/{iduser}',[App\Http\Controllers\HnController::class, 'hn_trainindex'])->name('hn.hn_trainindex');//

    Route::match(['get','post'],'hn/hn_purchaseindex/{iduser}',[App\Http\Controllers\HnController::class, 'hn_purchaseindex'])->name('hn.hn_purchaseindex');//
    Route::get('/hn/hn_purchaseindex_detail/{id}',[App\Http\Controllers\HnController::class, 'hn_purchaseindex_detail'])->name('hn.hn_purchaseindex_detail');//
    Route::get('/suphn_detail/{id}',[App\Http\Controllers\HnController::class, 'suphn_detail'])->name('suphn_detail');//

    Route::get('/hn/detailappall',[App\Http\Controllers\HnController::class, 'detailappall'])->name('hn.detailappall');//
    // Route::get('general_warehouse/detailappall','WarehouseController@detailappall')->name('warehouse.detailappall');

    Route::match(['get','post'],'hn/hn_storeindex/{iduser}',[App\Http\Controllers\HnController::class, 'hn_storeindex'])->name('hn.hn_storeindex');//


    // ***************** หัวหน้ากลุ่ม ***************************

    Route::match(['get','post'],'group/group_bookindex/{iduser}',[App\Http\Controllers\GroupController::class, 'group_bookindex'])->name('group.rong_bookindex');//
    Route::match(['get','post'],'group/group_bookindex_detail/{id}/{iduser}',[App\Http\Controllers\GroupController::class, 'group_bookindex_detail'])->name('group.group_bookindex_detail');//
    Route::match(['get','post'],'group/group_bookindex_retire/{id}',[App\Http\Controllers\GroupController::class, 'group_bookindex_retire'])->name('group.group_bookindex_retire');//
    Route::match(['get','post'],'group/group_bookindex_printdetail/{id}',[App\Http\Controllers\GroupController::class, 'group_bookindex_printdetail'])->name('group.group_bookindex_printdetail');//
    Route::match(['get','post'],'group/group_leaveindex/{iduser}',[App\Http\Controllers\GroupController::class, 'group_leaveindex'])->name('group.group_leaveindex');//
    Route::match(['get','post'],'group/group_trainindex/{iduser}',[App\Http\Controllers\GroupController::class, 'group_trainindex'])->name('group.group_trainindex');//
    Route::match(['get','post'],'group/group_storeindex/{iduser}',[App\Http\Controllers\GroupController::class, 'group_storeindex'])->name('group.group_storeindex');//
    Route::match(['get','post'],'group/group_purchaseindex/{iduser}',[App\Http\Controllers\GroupController::class, 'group_purchaseindex'])->name('group.group_purchaseindex');//
    Route::post('group/bookmake_allowgroup',[App\Http\Controllers\GroupController::class, 'bookmake_allowgroup'])->name('group.bookmake_allowgroup');// หัวหน้ากลุ่ม.อนุมัติ

    // ***************** หัวหน้าบริหาร ***************************

    Route::match(['get','post'],'rong/rong_bookindex/{iduser}',[App\Http\Controllers\RongController::class, 'rong_bookindex'])->name('rong.rong_bookindex');//
    Route::match(['get','post'],'rong/rong_bookindex_detail/{id}/{iduser}',[App\Http\Controllers\RongController::class, 'rong_bookindex_detail'])->name('rong.rong_bookindex_detail');//
    Route::match(['get','post'],'rong/rong_bookindex_retire/{id}',[App\Http\Controllers\RongController::class, 'rong_bookindex_retire'])->name('rong.rong_bookindex_retire');//
    Route::match(['get','post'],'rong/rong_bookindex_retire_get/{id}',[App\Http\Controllers\RongController::class, 'rong_bookindex_retire_get'])->name('rong.rong_bookindex_retire_get');//
    Route::match(['get','post'],'rong/rong_bookindex_retire_getdom/{id}',[App\Http\Controllers\RongController::class, 'rong_bookindex_retire_getdom'])->name('rong.rong_bookindex_retire_getdom');//

    Route::match(['get','post'],'rong/rong_bookindex_printdetail/{id}',[App\Http\Controllers\RongController::class, 'rong_bookindex_printdetail'])->name('rong.rong_bookindex_printdetail');//

    Route::match(['get','post'],'rong/rong_leaveindex/{iduser}',[App\Http\Controllers\RongController::class, 'rong_leaveindex'])->name('rong.rong_leaveindex');//
    Route::match(['get','post'],'rong/rong_trainindex/{iduser}',[App\Http\Controllers\RongController::class, 'rong_trainindex'])->name('rong.rong_trainindex');//
    Route::match(['get','post'],'rong/rong_storeindex/{iduser}',[App\Http\Controllers\RongController::class, 'rong_storeindex'])->name('rong.rong_storeindex');//
    Route::match(['get','post'],'rong/rong_purchaseindex/{iduser}',[App\Http\Controllers\RongController::class, 'rong_purchaseindex'])->name('rong.rong_purchaseindex');//

    Route::post('rong/bookmake_retirerong',[App\Http\Controllers\RongController::class, 'bookmake_retirerong'])->name('rong.bookmake_retirerong');// หัวหน้าบริหาร.อนุมัติ อันเดียว
    Route::post('rong/bookmake_allowrong',[App\Http\Controllers\RongController::class, 'bookmake_allowrong'])->name('rong.bookmake_allowrong');// หัวหน้าบริหาร.อนุมัติ ทั้งหมด

       // ***************** ผู้อำนวยการ ***************************

       Route::match(['get','post'],'po/po_bookindex/{iduser}',[App\Http\Controllers\PoController::class, 'po_bookindex'])->name('po.po_bookindex');//

       Route::match(['get','post'],'po/po_bookindex_detail/{id}/{iduser}',[App\Http\Controllers\PoController::class, 'po_bookindex_detail'])->name('po.po_bookindex_detail');//
       Route::match(['get','post'],'po/po_bookindex_retire/{id}',[App\Http\Controllers\PoController::class, 'po_bookindex_retire'])->name('po.po_bookindex_retire');//
       Route::match(['get','post'],'po/po_bookindex_printdetail/{id}',[App\Http\Controllers\PoController::class, 'po_bookindex_printdetail'])->name('po.po_bookindex_printdetail');//
      //  Route::post('po/bookmake_allowpo/{iduser}',[App\Http\Controllers\PoController::class, 'bookmake_allowpo'])->name('po.bookmake_allowpo');// ผอ.อนุมัติ

      Route::post('po/bookmake_retirepo',[App\Http\Controllers\PoController::class, 'bookmake_retirepo'])->name('po.bookmake_retirepo');// ผอ.อนุมัติ อันเดียว
      Route::post('po/bookmake_allowpo',[App\Http\Controllers\PoController::class, 'bookmake_allowpo'])->name('po.bookmake_allowpo');// ผอ.อนุมัติ ทั้งหมด


      Route::match(['get','post'],'po/po_carcalenda',[App\Http\Controllers\PoController::class, 'po_carcalenda'])->name('po.po_carcalenda');//
      Route::match(['get','post'],'po/po_carcalenda_add/{id}',[App\Http\Controllers\PoController::class, 'po_carcalenda_add'])->name('po.po_carcalenda_add');//
      Route::match(['get','post'],'po/po_carcalenda_allowpo',[App\Http\Controllers\PoController::class, 'po_carcalenda_allowpo'])->name('po.po_carcalenda_allowpo');//ผอ.อนุมัติ อันเดียวหน้าปฎิทิน
      Route::match(['get','post'],'po/po_carcalenda_update_allallowpo',[App\Http\Controllers\PoController::class, 'po_carcalenda_update_allallowpo'])->name('po.po_carcalenda_update_allallowpo');//ผอ.อนุมัติ

      Route::match(['get','post'],'po/allow_all',[App\Http\Controllers\PoController::class, 'allow_all'])->name('po.allow_all');//ผอ.อนุมัติ ทั้งหมด
      Route::match(['get','post'],'po/allow_all_add/{id}',[App\Http\Controllers\PoController::class, 'allow_all_add'])->name('po.allow_all_add');//จัดการ ผอ.อนุมัติ อันเดียว 2
      Route::match(['get','post'],'po/po_carcalenda_update_allowonepo',[App\Http\Controllers\PoController::class, 'po_carcalenda_update_allowonepo'])->name('po.po_carcalenda_update_allowonepo');//ผอ.อนุมัติ อันเดียว

      Route::match(['get','post'],'po/po_meetting_calenda/{iduser}',[App\Http\Controllers\PoController::class, 'po_meetting_calenda'])->name('po.po_meetting_calenda');//


       Route::match(['get','post'],'po/po_leaveindex/{iduser}',[App\Http\Controllers\PoController::class, 'po_leaveindex'])->name('po.po_leaveindex');//
       Route::match(['get','post'],'po/po_trainindex/{iduser}',[App\Http\Controllers\PoController::class, 'po_trainindex'])->name('po.po_trainindex');//
       Route::match(['get','post'],'po/po_storeindex/{iduser}',[App\Http\Controllers\PoController::class, 'po_storeindex'])->name('po.po_storeindex');//
       Route::match(['get','post'],'po/po_purchaseindex/{iduser}',[App\Http\Controllers\PoController::class, 'po_purchaseindex'])->name('po.po_purchaseindex');//

     // ******************** ร้านค้า ***********************
    Route::match(['get','post'],'market/market_dashboard',[App\Http\Controllers\MarketController::class, 'market_dashboard'])->name('mar.market_dashboard');//
    Route::match(['get','post'],'market/market_index',[App\Http\Controllers\MarketController::class, 'market_index'])->name('mar.market_index');//
    Route::match(['get','post'],'market/market_add',[App\Http\Controllers\MarketController::class, 'market_add'])->name('mar.market_add');//
    Route::match(['get','post'],'market/market_save',[App\Http\Controllers\MarketController::class, 'market_save'])->name('mar.market_save');//
    Route::get('market/market_edit/{id}',[App\Http\Controllers\MarketController::class, 'market_edit'])->name('mar.market_edit');//
    Route::match(['get','post'],'market/market_update',[App\Http\Controllers\MarketController::class, 'market_update'])->name('mar.market_update');//
    Route::delete('market/market_destroy/{id}',[App\Http\Controllers\MarketController::class, 'market_destroy'])->name('mar.market_destroy');//

    Route::match(['get','post'],'market/product_index',[App\Http\Controllers\MarketController::class, 'product_index'])->name('mar.product_index');//
    Route::match(['get','post'],'market/product_add',[App\Http\Controllers\MarketController::class, 'product_add'])->name('mar.product_add');//
    Route::match(['get','post'],'market/product_save',[App\Http\Controllers\MarketController::class, 'product_save'])->name('mar.product_save');//
    Route::get('market/product_edit/{id}',[App\Http\Controllers\MarketController::class, 'product_edit'])->name('mar.product_edit');//
    Route::match(['get','post'],'market/product_update',[App\Http\Controllers\MarketController::class, 'product_update'])->name('mar.product_update');//
    Route::delete('market/product_destroy/{id}',[App\Http\Controllers\MarketController::class, 'product_destroy'])->name('mar.product_destroy');//
    Route::get('market/addcategory',[App\Http\Controllers\MarketController::class, 'addcategory'])->name('mar.addcategory');//  เพิ่มหมวด
    Route::get('market/addvendor',[App\Http\Controllers\MarketController::class, 'addvendor'])->name('mar.addvendor');//  เพิ่มตัวแทน

    Route::match(['get','post'],'market/rep_product',[App\Http\Controllers\MarketController::class, 'rep_product'])->name('mar.rep_product');//
    Route::match(['get','post'],'market/rep_product_add',[App\Http\Controllers\MarketController::class, 'rep_product_add'])->name('mar.rep_product_add');//
    Route::match(['get','post'],'market/rep_product_save',[App\Http\Controllers\MarketController::class, 'rep_product_save'])->name('mar.rep_product_save');//
    Route::delete('market/rep_product_destroy/{id}',[App\Http\Controllers\MarketController::class, 'rep_product_destroy'])->name('mar.rep_product_destroy');//

    Route::match(['get','post'],'market/rep_product_addsub/{id}',[App\Http\Controllers\MarketController::class, 'rep_product_addsub'])->name('mar.rep_product_addsub');//
    Route::match(['get','post'],'market/rep_product_addsub_save',[App\Http\Controllers\MarketController::class, 'rep_product_addsub_save'])->name('mar.rep_product_addsub_save');//
    Route::delete('market/rep_product_addsub_destroy/{id}',[App\Http\Controllers\MarketController::class, 'rep_product_addsub_destroy'])->name('mar.rep_product_addsub_destroy');//

    Route::match(['get','post'],'market/rep_product_detail/{id}',[App\Http\Controllers\MarketController::class, 'rep_product_detail'])->name('mar.rep_product_detail');//
    Route::match(['get','post'],'market/rep_product_edit/{id}',[App\Http\Controllers\MarketController::class, 'rep_product_edit'])->name('mar.rep_product_edit');//
    Route::match(['get','post'],'market/rep_product_update',[App\Http\Controllers\MarketController::class, 'rep_product_update'])->name('mar.rep_product_update');//

     // ******************** ร้านค้า รายชื่อลูกค้า ***********************
     Route::match(['get','post'],'customer/customer',[App\Http\Controllers\MarketController::class, 'customer'])->name('cus.customer');//
     Route::match(['get','post'],'customer/customer_add',[App\Http\Controllers\MarketController::class, 'customer_add'])->name('cus.customer_add');//
     Route::match(['get','post'],'customer/customer_save',[App\Http\Controllers\MarketController::class, 'customer_save'])->name('cus.customer_save');//
     Route::get('customer/customer_edit/{id}',[App\Http\Controllers\MarketController::class, 'customer_edit'])->name('cus.customer_edit');//
     Route::match(['get','post'],'customer/customer_update',[App\Http\Controllers\MarketController::class, 'customer_update'])->name('cus.customer_update');//
     Route::delete('customer/customer_destroy/{id}',[App\Http\Controllers\MarketController::class, 'customer_destroy'])->name('cus.customer_destroy');//

       // ******************** ร้านค้า ขายสินค้า ***********************
     Route::match(['get','post'],'market/sale',[App\Http\Controllers\MarketController::class, 'sale'])->name('mar.sale');//
     Route::match(['get','post'],'market/sale_index',[App\Http\Controllers\MarketController::class, 'sale_index'])->name('mar.sale_index');//
     Route::match(['get','post'],'market/sale_add',[App\Http\Controllers\MarketController::class, 'rep_product_add'])->name('mar.sale_add');//
     Route::match(['get','post'],'market/sale_save',[App\Http\Controllers\MarketController::class, 'sale_save'])->name('mar.sale_save');//
     Route::match(['get','post'],'market/sale_savebill',[App\Http\Controllers\MarketController::class, 'sale_savebill'])->name('mar.sale_savebill');//
     Route::match(['get','post'],'market/sale_update',[App\Http\Controllers\MarketController::class, 'sale_update'])->name('mar.sale_update');//
     Route::match(['get','post'],'market/editsale_save',[App\Http\Controllers\MarketController::class, 'editsale_save'])->name('mar.editsale_save');//
     Route::match(['get','post'],'market/sale_updatebill',[App\Http\Controllers\MarketController::class, 'sale_updatebill'])->name('mar.sale_updatebill');//
     Route::match(['get','post'],'market/sale_edit/{id}',[App\Http\Controllers\MarketController::class, 'sale_edit'])->name('mar.sale_edit');//
     Route::delete('market/sale_destroy/{id}',[App\Http\Controllers\MarketController::class, 'sale_destroy'])->name('mar.sale_destroy');//
     Route::delete('market/bill_destroy/{id}',[App\Http\Controllers\MarketController::class, 'bill_destroy'])->name('mar.bill_destroy');//


    // ******************** PKClaim ***********************
    Route::match(['get','post'],'uprep_eclaim',[App\Http\Controllers\UprepController::class, 'uprep_eclaim'])->name('claim.uprep_eclaim');// PKClaim
    Route::match(['get','post'],'uprep_eclaim_save',[App\Http\Controllers\UprepController::class, 'uprep_eclaim_save'])->name('claim.uprep_eclaim_save');// 
    Route::match(['get','post'],'uprep_eclaim_send',[App\Http\Controllers\UprepController::class, 'uprep_eclaim_send'])->name('claim.uprep_eclaim_send');// 

    Route::match(['get','post'],'rep_crrt',[App\Http\Controllers\ReportCRRTController::class, 'rep_crrt'])->name('claim.rep_crrt');// 

    Route::match(['get','post'],'pkclaim_info',[App\Http\Controllers\PkclaimController::class, 'pkclaim_info'])->name('claim.pkclaim_info');// PKClaim
    Route::match(['get','post'],'bk_getbar',[App\Http\Controllers\PkclaimController::class, 'bk_getbar'])->name('claim.bk_getbar');// get ค่า ajax bar
    Route::match(['get','post'],'bk_getline',[App\Http\Controllers\PkclaimController::class, 'bk_getline'])->name('claim.bk_getline');// get ค่า ajax line
    Route::match(['get','post'],'sss_in',[App\Http\Controllers\SssController::class, 'sss_in'])->name('claim.sss_in');//
    Route::match(['get','post'],'pkclaim/pkclaim_sss',[App\Http\Controllers\PkclaimController::class, 'pkclaim_sss'])->name('claim.pkclaim_sss');//

    Route::match(['get','post'],'fs_eclaim',[App\Http\Controllers\PkclaimController::class, 'fs_eclaim'])->name('claim.fs_eclaim');// PKClaim
    Route::match(['get','post'],'fs_eclaim_inhos/{income}',[App\Http\Controllers\PkclaimController::class, 'fs_eclaim_inhos'])->name('claim.fs_eclaim_inhos');// PKClaim
    Route::match(['get','post'],'fs_eclaim_instu/{income}',[App\Http\Controllers\PkclaimController::class, 'fs_eclaim_instu'])->name('claim.fs_eclaim_instu');// PKClaim
    Route::match(['get','post'],'fs_eclaim_instu_eclaim/{income}',[App\Http\Controllers\PkclaimController::class, 'fs_eclaim_instu_eclaim'])->name('claim.fs_eclaim_instu_eclaim');// PKClaim
    Route::match(['get','post'],'fs_eclaim_editable',[App\Http\Controllers\PkclaimController::class, 'fs_eclaim_editable'])->name('claim.fs_eclaim_editable');// PKClaim

    Route::match(['get','post'],'doc_eclaim',[App\Http\Controllers\DocclaimController::class, 'doc_eclaim'])->name('claim.doc_eclaim');// 

    // ******************** PKClaim Report ***********************
    Route::match(['get','post'],'report_op',[App\Http\Controllers\ReportController::class, 'report_op'])->name('report.report_op');//
    Route::match(['get','post'],'report_op_getline',[App\Http\Controllers\ReportController::class, 'report_op_getline'])->name('rep.report_op_getline');// get ค่า ajax line
    Route::match(['get','post'],'report_op_getbar',[App\Http\Controllers\ReportController::class, 'report_op_getbar'])->name('rep.report_op_getbar');// get ค่า ajax
    Route::match(['get','post'],'report_ods_hsoft',[App\Http\Controllers\ReportController::class, 'report_ods_hsoft'])->name('report.report_ods_hsoft');//
    Route::match(['get','post'],'report_ipd',[App\Http\Controllers\ReportController::class, 'report_ipd'])->name('report.report_ipd');//
    Route::match(['get','post'],'report_ipd_getbar',[App\Http\Controllers\ReportController::class, 'report_ipd_getbar'])->name('rep.report_ipd_getbar');// get ค่า ajax
    Route::match(['get','post'],'report_opd_ofc',[App\Http\Controllers\ReportController::class, 'report_opd_ofc'])->name('report.report_opd_ofc');//
    Route::match(['get','post'],'report_opd_ofc_getbar',[App\Http\Controllers\ReportController::class, 'report_opd_ofc_getbar'])->name('rep.report_opd_ofc_getbar');// get ค่า ajax
    Route::match(['get','post'],'report_ipd_ofc',[App\Http\Controllers\ReportController::class, 'report_ipd_ofc'])->name('report.report_ipd_ofc');//
    Route::match(['get','post'],'report_ipd_ofc_getbar',[App\Http\Controllers\ReportController::class, 'report_ipd_ofc_getbar'])->name('rep.report_ipd_ofc_getbar');// get ค่า ajax



     // ******************** PKClaim Report REFER CAR***********************
     Route::match(['get','post'],'report_refer_main',[App\Http\Controllers\ReportController::class, 'report_refer_main'])->name('report.report_refer_main');//
     Route::match(['get','post'],'report_refer_main_repback',[App\Http\Controllers\ReportController::class, 'report_refer_main_repback'])->name('report.report_refer_main_repback');// การลงข้อมูลรับกลับ
     Route::match(['get','post'],'report_refer_main_rep',[App\Http\Controllers\ReportController::class, 'report_refer_main_rep'])->name('report.report_refer_main_rep');// การลงข้อมูลรับ
     Route::match(['get','post'],'report_refer_mainsub_opd/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_opd'])->name('report.report_refer_mainsub_opd');//
     Route::match(['get','post'],'report_refer_mainsub_ipd2/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_ipd2'])->name('report.report_refer_mainsub_ipd2');//
     Route::match(['get','post'],'report_refer_mainsub_ipd3/{day}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_ipd3'])->name('report.report_refer_mainsub_ipd3');//
     Route::match(['get','post'],'report_refer_mainsub_imcstork/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_imcstork'])->name('report.report_refer_mainsub_imcstork');//
     Route::match(['get','post'],'report_refer_mainsub_imcbrain/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_imcbrain'])->name('report.report_refer_mainsub_imcbrain');//
     Route::match(['get','post'],'report_refer_mainsub_imcinjury/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_imcinjury'])->name('report.report_refer_mainsub_imcinjury');//

     Route::match(['get','post'],'report_ipopd',[App\Http\Controllers\ReportController::class, 'report_ipopd'])->name('report.report_ipopd');//
     Route::match(['get','post'],'report_refer_main_ipopd_search ',[App\Http\Controllers\ReportController::class, 'report_refer_main_ipopd_search'])->name('report.report_refer_main_ipopd_search');//
     Route::match(['get','post'],'report_refer_out',[App\Http\Controllers\ReportController::class, 'report_refer_out'])->name('report.report_refer_out');//
     Route::match(['get','post'],'report_refer_outs',[App\Http\Controllers\ReportController::class, 'report_refer_outs'])->name('report.report_refer_outs');//
     Route::match(['get','post'],'report_refer_outipd',[App\Http\Controllers\ReportController::class, 'report_refer_outipd'])->name('report.report_refer_outipd');//
     Route::match(['get','post'],'report_refer_outopd',[App\Http\Controllers\ReportController::class, 'report_refer_outopd'])->name('report.report_refer_outopd');//
     Route::match(['get','post'],'report_refer_outmonth',[App\Http\Controllers\ReportController::class, 'report_refer_outmonth'])->name('report.report_refer_outmonth');//

     Route::match(['get','post'],'report_refer_opd/{years}',[App\Http\Controllers\ReportController::class, 'report_refer_opd'])->name('report.report_refer_opd');//
     Route::match(['get','post'],'report_refer_opdrep/{doc}',[App\Http\Controllers\ReportController::class, 'report_refer_opdrep'])->name('report.report_refer_opdrep');//
     Route::match(['get','post'],'report_refer_opdrep_sub/{hosname}/{doc}',[App\Http\Controllers\ReportController::class, 'report_refer_opdrep_sub'])->name('report.report_refer_opdrep_sub');//
     Route::match(['get','post'],'report_refer_opdrep_subsub/{vn}',[App\Http\Controllers\ReportController::class, 'report_refer_opdrep_subsub'])->name('report.report_refer_opdrep_subsub');//
     Route::match(['get','post'],'report_refer_opdrep_subsubtotal/{vn}',[App\Http\Controllers\ReportController::class, 'report_refer_opdrep_subsubtotal'])->name('report.report_refer_opdrep_subsubtotal');//
     Route::match(['get','post'],'report_refer_opdrep_subsubtran/{tran_id}',[App\Http\Controllers\ReportController::class, 'report_refer_opdrep_subsubtran'])->name('report.report_refer_opdrep_subsubtran');//

    //  รายงานการลงข้อมูลรับกลับ Refer IPD
     Route::match(['get','post'],'report_refer_mainsub_checkopd/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_checkopd'])->name('report.report_refer_mainsub_checkopd');// จำนวนผู้ป่วย OPD (ครั้ง)
     Route::match(['get','post'],'report_refer_mainsub_checkipd/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_checkipd'])->name('report.report_refer_mainsub_checkipd');// จำนวนผู้ป่วย IPD (ครั้ง)
     Route::match(['get','post'],'report_refer_mainsub_checkimcstork/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_checkimcstork'])->name('report.report_refer_mainsub_checkimcstork');// จำนวนผู้ป่วย IPD (ครั้ง)
     Route::match(['get','post'],'report_refer_mainsub_checkimcbrain/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_checkimcbrain'])->name('report.report_refer_mainsub_checkimcbrain');// จำนวนผู้ป่วย IPD (ครั้ง)
     Route::match(['get','post'],'report_refer_mainsub_checkinjury/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_checkinjury'])->name('report.report_refer_mainsub_checkinjury');// จำนวนผู้ป่วย IPD (ครั้ง)

     Route::match(['get','post'],'report_refer_mainsub_rep_opd/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_rep_opd'])->name('report.report_refer_mainsub_rep_opd');// จำนวนผู้ป่วย OPD (ครั้ง)
     Route::match(['get','post'],'report_refer_mainsub_rep_ipd/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_rep_ipd'])->name('report.report_refer_mainsub_rep_ipd');//
     Route::match(['get','post'],'report_refer_mainsub_rep_imcstork/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_rep_imcstork'])->name('report.report_refer_mainsub_rep_imcstork');//
     Route::match(['get','post'],'report_refer_mainsub_rep_imcbrain/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_rep_imcbrain'])->name('report.report_refer_mainsub_rep_imcbrain');//
     Route::match(['get','post'],'report_refer_mainsub_rep_imcinjury/{year}/{month}',[App\Http\Controllers\ReportController::class, 'report_refer_mainsub_rep_imcinjury'])->name('report.report_refer_mainsub_rep_imcinjury');//

     Route::match(['get','post'],'report_refer_main_search',[App\Http\Controllers\ReportController::class, 'report_refer_main_search'])->name('report.report_refer_main_search');//
     Route::match(['get','post'],'report_refer_2561',[App\Http\Controllers\ReportController::class, 'report_refer_2561'])->name('report.report_refer_2561');//
     Route::match(['get','post'],'report_refer_2562',[App\Http\Controllers\ReportController::class, 'report_refer_2562'])->name('report.report_refer_2562');//
     Route::match(['get','post'],'report_refer_2563',[App\Http\Controllers\ReportController::class, 'report_refer_2563'])->name('report.report_refer_2563');//
     Route::match(['get','post'],'report_refer_2564',[App\Http\Controllers\ReportController::class, 'report_refer_2564'])->name('report.report_refer_2564');//
     Route::match(['get','post'],'report_refer_2565',[App\Http\Controllers\ReportController::class, 'report_refer_2565'])->name('report.report_refer_2565');//
     Route::match(['get','post'],'report_report_refer_getline',[App\Http\Controllers\ReportController::class, 'report_report_refer_getline'])->name('rep.report_report_refer_getline');// get ค่า ajax line


 // ************************************************* งานประกัน   *****************************************************************
     // **************************** Karn ***********************
     Route::match(['get','post'],'karn_main',[App\Http\Controllers\karnController::class, 'karn_main'])->name('k.karn_main');//
     Route::match(['get','post'],'karn_main_sss',[App\Http\Controllers\karnController::class, 'karn_main_sss'])->name('k.karn_main_sss');//
     Route::match(['get','post'],'karn_main_sss_detail/{an}',[App\Http\Controllers\karnController::class, 'karn_main_sss_detail'])->name('k.karn_main_sss_detail');//
     Route::match(['get','post'],'karn_sss_309',[App\Http\Controllers\karnController::class, 'karn_sss_309'])->name('k.karn_sss_309');//

     Route::match(['get','post'],'inst_sss',[App\Http\Controllers\SssController::class, 'inst_sss'])->name('acc.inst_sss');//
     Route::match(['get','post'],'inst_sss_todtan',[App\Http\Controllers\SssController::class, 'inst_sss_todtan'])->name('acc.inst_sss_todtan');//


     Route::match(['get','post'],'opd_chai',[App\Http\Controllers\SssController::class, 'opd_chai'])->name('sss.opd_chai');//
     Route::match(['get','post'],'opd_chai_hn/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_hn'])->name('sss.opd_chai_hn');//
     Route::match(['get','post'],'opd_chai_vn/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_vn'])->name('sss.opd_chai_vn');//
     Route::match(['get','post'],'opd_chai_rep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_rep'])->name('sss.opd_chai_rep');//
     Route::match(['get','post'],'opd_chai_norep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_norep'])->name('sss.opd_chai_norep');//

     Route::match(['get','post'],'opd_chai_list',[App\Http\Controllers\SssController::class, 'opd_chai_list'])->name('sss.opd_chai_list');//
     Route::match(['get','post'],'opd_chai_listvn/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_listvn'])->name('sss.opd_chai_listvn');//
     Route::match(['get','post'],'opd_chai_listrep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_listrep'])->name('sss.opd_chai_listrep');//
     Route::match(['get','post'],'opd_chai_listnorep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_chai_listnorep'])->name('sss.opd_chai_listnorep');//

     Route::match(['get','post'],'ipd_chai',[App\Http\Controllers\SssController::class, 'ipd_chai'])->name('sss.ipd_chai');//
     Route::match(['get','post'],'ipd_chai_an/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'ipd_chai_an'])->name('sss.ipd_chai_an');//
     Route::match(['get','post'],'ipd_chai_rep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'ipd_chai_rep'])->name('sss.ipd_chai_rep');//
     Route::match(['get','post'],'ipd_chai_norep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'ipd_chai_norep'])->name('sss.ipd_chai_norep');//
     Route::match(['get','post'],'ipd_chaino/{months}/{year}',[App\Http\Controllers\SssController::class, 'ipd_chaino'])->name('sss.ipd_chaino');//
     Route::match(['get','post'],'ipd_chairep/{months}/{year}',[App\Http\Controllers\SssController::class, 'ipd_chairep'])->name('sss.ipd_chairep');//
     Route::match(['get','post'],'ipd_chai_vn/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'ipd_chai_vn'])->name('sss.ipd_chai_vn');//

     Route::match(['get','post'],'opd_outlocate',[App\Http\Controllers\SssController::class, 'opd_outlocate'])->name('sss.opd_outlocate');//
     Route::match(['get','post'],'opd_outlocate_sub/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'opd_outlocate_sub'])->name('sss.opd_outlocate_sub');//
     Route::match(['get','post'],'opd_outlocate_subrep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'opd_outlocate_subrep'])->name('sss.opd_outlocate_subrep');//
     Route::match(['get','post'],'opd_outlocate_subnorep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'opd_outlocate_subnorep'])->name('sss.opd_outlocate_subnorep');//
     Route::match(['get','post'],'opd_outlocate_keyrep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'opd_outlocate_keyrep'])->name('sss.opd_outlocate_keyrep');//
     Route::match(['get','post'],'opd_outlocate_tupol/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'opd_outlocate_tupol'])->name('sss.opd_outlocate_tupol');//
     Route::match(['get','post'],'opd_outlocate_tupolkey/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'opd_outlocate_tupolkey'])->name('sss.opd_outlocate_tupolkey');//
     Route::match(['get','post'],'opd_outlocate_total/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'opd_outlocate_total'])->name('sss.opd_outlocate_total');//




    Route::match(['get','post'],'ipd_outlocate',[App\Http\Controllers\SssController::class, 'ipd_outlocate'])->name('sss.ipd_outlocate');//
    Route::match(['get','post'],'ipd_outlocate_sub/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class, 'ipd_outlocate_sub'])->name('sss.ipd_outlocate_sub');//
    Route::match(['get','post'],'ipd_outlocate_pdx/{an}',[App\Http\Controllers\SssController::class, 'ipd_outlocate_pdx'])->name('sss.ipd_outlocate_pdx');//
    Route::match(['get','post'],'ipd_outlocate_income/{an}',[App\Http\Controllers\SssController::class, 'ipd_outlocate_income'])->name('sss.ipd_outlocate_income');//
    Route::match(['get','post'],'ipd_outlocate_subrep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'ipd_outlocate_subrep'])->name('sss.ipd_outlocate_subrep');//
    Route::match(['get','post'],'ipd_outlocate_subnorep/{months}/{startdate}/{enddate}',[App\Http\Controllers\SssController::class,'ipd_outlocate_subnorep'])->name('sss.ipd_outlocate_subnorep');//

     Route::match(['get','post'],'eclaim_check',[App\Http\Controllers\EclaimController::class,'eclaim_check'])->name('claim.eclaim_check');//
     Route::match(['get','post'],'eclaim_check_update',[App\Http\Controllers\EclaimController::class,'eclaim_check_update'])->name('claim.eclaim_check_update');//
     Route::match(['get','post'],'eclaim_check_edit/{id}',[App\Http\Controllers\EclaimController::class,'eclaim_check_edit'])->name('claim.eclaim_check_edit');//

     Route::match(['get','post'],'prb_opd',[App\Http\Controllers\PrbController::class,'prb_opd'])->name('prb.prb_opd');//
     Route::match(['get','post'],'prb_opd_sub/{vn}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_opd_sub'])->name('prb.prb_opd_sub');//
     Route::match(['get','post'],'prb_opd_subsub/{day}/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_opd_subsub'])->name('prb.prb_opd_subsub');//

     Route::match(['get','post'],'prb_ipd',[App\Http\Controllers\PrbController::class,'prb_ipd'])->name('prb.prb_ipd');//
     Route::match(['get','post'],'prb_ipd_sub/{an}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_ipd_sub'])->name('prb.prb_ipd_sub');//
     Route::match(['get','post'],'prb_ipd_subsub/{day}/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_ipd_subsub'])->name('prb.prb_ipd_subsub');//

     Route::match(['get','post'],'prb_cpo',[App\Http\Controllers\PrbController::class,'prb_cpo'])->name('prb.prb_cpo');//
     Route::match(['get','post'],'prb_repopd',[App\Http\Controllers\PrbController::class,'prb_repopd'])->name('prb.prb_repopd');//
     Route::match(['get','post'],'prb_repopd_subhn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repopd_subhn'])->name('prb.prb_repopd_subhn');//
     Route::match(['get','post'],'prb_repopd_subvn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repopd_subvn'])->name('prb.prb_repopd_subvn');//
     Route::match(['get','post'],'prb_repopd_subsubvn/{vn}',[App\Http\Controllers\PrbController::class,'prb_repopd_subsubvn'])->name('prb.prb_repopd_subsubvn');//
     Route::match(['get','post'],'prb_repopd_subreq/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repopd_subreq'])->name('prb.prb_repopd_subreq');//
     Route::match(['get','post'],'prb_repopd_subnoreq/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repopd_subnoreq'])->name('prb.prb_repopd_subnoreq');//

     Route::match(['get','post'],'prb_repipd',[App\Http\Controllers\PrbController::class,'prb_repipd'])->name('prb.prb_repipd');//
     Route::match(['get','post'],'prb_repipd_subhn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipd_subhn'])->name('prb.prb_repipd_subhn');//
     Route::match(['get','post'],'prb_repipd_subvn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipd_subvn'])->name('prb.prb_repipd_subvn');//
     Route::match(['get','post'],'prb_repipd_subsuban/{an}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipd_subsuban'])->name('prb.prb_repipd_subsuban');//
     Route::match(['get','post'],'prb_repipd_subreq/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipd_subreq'])->name('prb.prb_repipd_subreq');//
     Route::match(['get','post'],'prb_repipd_subnoreq/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipd_subnoreq'])->name('prb.prb_repipd_subnoreq');//

     Route::match(['get','post'],'prb_repipd_subsuban_print/{an}',[App\Http\Controllers\PrbController::class,'prb_repipd_subsuban_print'])->name('prb.prb_repipd_subsuban_print');//

     Route::match(['get','post'],'prb_repipdpay',[App\Http\Controllers\PrbController::class,'prb_repipdpay'])->name('prb.prb_repipdpay');//
     Route::match(['get','post'],'prb_repipdpay_subhn/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipdpay_subhn'])->name('prb.prb_repipdpay_subhn');//
     Route::match(['get','post'],'prb_repipdpay_suban/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipdpay_suban'])->name('prb.prb_repipdpay_suban');//
     Route::match(['get','post'],'prb_repipdpay_suban_amount/{an}',[App\Http\Controllers\PrbController::class,'prb_repipdpay_suban_amount'])->name('prb.prb_repipdpay_suban_amount');//

     Route::match(['get','post'],'prb_repipdpay_subreq/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipdpay_subreq'])->name('prb.prb_repipdpay_subreq');//
     Route::match(['get','post'],'prb_repipdpay_subnoreq/{months}/{startdate}/{enddate}',[App\Http\Controllers\PrbController::class,'prb_repipdpay_subnoreq'])->name('prb.prb_repipdpay_subnoreq');//


     Route::match(['get','post'],'prb_repipdover',[App\Http\Controllers\PrbController::class,'prb_repipdover'])->name('prb.prb_repipdover');//

     Route::match(['get','post'],'request_report',[App\Http\Controllers\PrbController::class,'request_report'])->name('rep.request_report');//
     Route::match(['get','post'],'request_report_save',[App\Http\Controllers\PrbController::class,'request_report_save'])->name('rep.request_report_save');//
     Route::match(['get','post'],'request_report_edit/{id}',[App\Http\Controllers\PrbController::class,'request_report_edit'])->name('rep.request_report_edit');//
     Route::match(['get','post'],'request_report_update',[App\Http\Controllers\PrbController::class,'request_report_update'])->name('rep.request_report_update');//

     Route::match(['get','post'],'recieve/{id}',[App\Http\Controllers\PrbController::class,'recieve'])->name('rep.recieve');// รับเรื่อง
     Route::match(['get','post'],'inprogress/{id}',[App\Http\Controllers\PrbController::class,'inprogress'])->name('rep.inprogress');//
     Route::match(['get','post'],'submitwork/{id}',[App\Http\Controllers\PrbController::class,'submitwork'])->name('rep.submitwork');//


    // **************************** บัญชี ***********************

    Route::match(['get','post'],'account_pk',[App\Http\Controllers\AccountPKController::class, 'account_pk'])->name('acc.account_pk');//
    Route::match(['get','post'],'account_pksave',[App\Http\Controllers\AccountPKController::class, 'account_pksave'])->name('acc.account_pksave');//
    Route::match(['get','post'],'account_pkCheck_sit',[App\Http\Controllers\AccountPKController::class, 'account_pkCheck_sit'])->name('acc.account_pkCheck_sit');//
    Route::match(['get','post'],'account_pkCheck_sitipd',[App\Http\Controllers\AccountPKController::class, 'account_pkCheck_sitipd'])->name('acc.account_pkCheck_sitipd');//

    Route::match(['get','post'],'account_pk_debtor',[App\Http\Controllers\AccountPKController::class, 'account_pk_debtor'])->name('acc.account_pk_debtor');//  stamp OPD
    Route::match(['get','post'],'acc_debtor_send',[App\Http\Controllers\AccountPKController::class, 'acc_debtor_send'])->name('acc.acc_debtor_send');//  Send

    Route::match(['get','post'],'account_pkucs',[App\Http\Controllers\AccountPKController::class, 'account_pkucs'])->name('acc.account_pkucs');//

    Route::match(['get','post'],'account_pkofc401_dash',[App\Http\Controllers\AccountPKController::class, 'account_pkofc401_dash'])->name('acc.account_pkofc401_dash');//
    Route::match(['get','post'],'account_pkofc401/{id}',[App\Http\Controllers\AccountPKController::class, 'account_pkofc401'])->name('acc.account_pkofc401');//

    Route::match(['get','post'],'account_pkofc402_dash',[App\Http\Controllers\AccountPKController::class, 'account_pkofc402_dash'])->name('acc.account_pkofc402_dash');//
    Route::match(['get','post'],'account_pkofc402',[App\Http\Controllers\AccountPKController::class, 'account_pkofc402'])->name('acc.account_pkofc402');//
    Route::match(['get','post'],'account_pksss',[App\Http\Controllers\AccountPKController::class, 'account_pksss'])->name('acc.account_pksss');//

    // Route::match(['get','post'],'account_pklgo801',[App\Http\Controllers\AccountPKController::class, 'account_pklgo801'])->name('acc.account_pklgo801');//
    Route::match(['get','post'],'account_pklgo801/{id}',[App\Http\Controllers\AccountPKController::class, 'account_pklgo801'])->name('acc.account_pklgo801');//
    Route::match(['get','post'],'account_pklgo801_dash',[App\Http\Controllers\AccountPKController::class, 'account_pklgo801_dash'])->name('acc.account_pklgo801_dash');//
    Route::match(['get','post'],'account_pk801/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_pk801'])->name('acc.account_pk801');//
    Route::match(['get','post'],'account_pk801_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_pk801_stm'])->name('acc.account_pk801_stm');//

    // Route::match(['get','post'],'account_pklgo802',[App\Http\Controllers\AccountPKController::class, 'account_pklgo802'])->name('acc.account_pklgo802');//
    // Route::match(['get','post'],'account_pklgo803',[App\Http\Controllers\AccountPKController::class, 'account_pklgo803'])->name('acc.account_pklgo803');//
    // Route::match(['get','post'],'account_pklgo804',[App\Http\Controllers\AccountPKController::class, 'account_pklgo804'])->name('acc.account_pklgo804');//

    Route::match(['get','post'],'account_pkti4011_dash',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_dash'])->name('acc.account_pkti4011_dash');//
    Route::match(['get','post'],'account_pkti4011_pull',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_pull'])->name('acc.account_pkti4011_pull');//
    Route::match(['get','post'],'account_pkti4011_pulldata',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_pulldata'])->name('acc.account_pkti4011_pulldata');//
    Route::match(['get','post'],'account_pkti4011/{months}/{year}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011'])->name('acc.account_pkti4011');//
    Route::match(['get','post'],'account_pkti4011_detail/{months}/{year}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_detail'])->name('acc.account_pkti4011_detail');//   
    Route::match(['get','post'],'account_pkti4011_stm/{months}/{year}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_stm'])->name('acc.account_pkti4011_stm');//
    Route::match(['get','post'],'account_pkti4011_stmnull/{months}/{year}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_stmnull'])->name('acc.account_pkti4011_stmnull');//
    Route::match(['get','post'],'account_pkti4011_stam',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_stam'])->name('acc.account_pkti4011_stam');//
    Route::match(['get','post'],'account_pkti4011_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_detail_date'])->name('acc.account_pkti4011_detail_date');//
    Route::match(['get','post'],'account_pkti4011_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_stm_date'])->name('acc.account_pkti4011_stm_date');//
    Route::match(['get','post'],'account_pkti4011_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account4011Controller::class, 'account_pkti4011_stmnull_date'])->name('acc.account_pkti4011_stmnull_date');//
    Route::match(['get','post'],'account_4011_destroy',[App\Http\Controllers\Account4011Controller::class, 'account_4011_destroy'])->name('acc.account_4011_destroy');//

    Route::match(['get','post'],'account_pkti4022_dash',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_dash'])->name('acc.account_pkti4022_dash');//
    Route::match(['get','post'],'account_pkti4022_pull',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_pull'])->name('acc.account_pkti4022_pull');//
    Route::match(['get','post'],'account_pkti4022_pulldata',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_pulldata'])->name('acc.account_pkti4022_pulldata');//
    Route::match(['get','post'],'account_pkti4022/{months}/{year}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022'])->name('acc.account_pkti4022');//
    Route::match(['get','post'],'account_pkti4022_detail/{months}/{year}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_detail'])->name('acc.account_pkti4022_detail');//
    Route::match(['get','post'],'account_pkti4022_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_detail_date'])->name('acc.account_pkti4022_detail_date');//
    Route::match(['get','post'],'account_pkti4022_stm/{months}/{year}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_stm'])->name('acc.account_pkti4022_stm');//
    Route::match(['get','post'],'account_pkti4022_stmnull/{months}/{year}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_stmnull'])->name('acc.account_pkti4022_stmnull');//
    Route::match(['get','post'],'account_pkti4022_stam',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_stam'])->name('acc.account_pkti4022_stam');//
    Route::match(['get','post'],'account_pkti4022_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_stm_date'])->name('acc.account_pkti4022_stm_date');//
    Route::match(['get','post'],'account_pkti4022_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_stmnull_date'])->name('acc.account_pkti4022_stmnull_date');//
    Route::match(['get','post'],'account_pkti4022_destroy_all',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_destroy_all'])->name('acc.account_pkti4022_destroy_all');//
    Route::match(['get','post'],'account_4022_destroy',[App\Http\Controllers\Account4022Controller::class, 'account_4022_destroy'])->name('acc.account_4022_destroy');//
    Route::match(['get','post'],'account_pkti4022_checksit',[App\Http\Controllers\Account4022Controller::class, 'account_pkti4022_checksit'])->name('acc.account_pkti4022_checksit');//

    Route::match(['get','post'],'account_pkti3099_dash',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_dash'])->name('acc.account_pkti3099_dash');//
    Route::match(['get','post'],'account_pkti3099_pull',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_pull'])->name('acc.account_pkti3099_pull');//
    Route::match(['get','post'],'account_pkti3099_pulldata',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_pulldata'])->name('acc.account_pkti3099_pulldata');//
    Route::match(['get','post'],'account_pkti3099/{months}/{year}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099'])->name('acc.account_pkti3099');//
    Route::match(['get','post'],'account_pkti3099_detail/{months}/{year}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_detail'])->name('acc.account_pkti3099_detail');//
    Route::match(['get','post'],'account_pkti3099_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_detail_date'])->name('acc.account_pkti3099_detail_date');//
    Route::match(['get','post'],'account_pkti3099_stm/{months}/{year}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_stm'])->name('acc.account_pkti3099_stm');//
    Route::match(['get','post'],'account_pkti3099_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_stm_date'])->name('acc.account_pkti3099_stm_date');//
    Route::match(['get','post'],'account_pkti3099_stmnull/{months}/{year}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_stmnull'])->name('acc.account_pkti3099_stmnull');//
    Route::match(['get','post'],'account_pkti3099_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_stmnull_date'])->name('acc.account_pkti3099_stmnull_date');//
    Route::match(['get','post'],'account_pkti3099_stam',[App\Http\Controllers\Account3099Controller::class, 'account_pkti3099_stam'])->name('acc.account_pkti3099_stam');//
    Route::match(['get','post'],'account_3099_destroy',[App\Http\Controllers\Account3099Controller::class, 'account_3099_destroy'])->name('acc.account_3099_destroy');//

    // Route::match(['get','post'],'account_pkti8011_dash',[App\Http\Controllers\AccountPKController::class, 'account_pkti8011_dash'])->name('acc.account_pkti8011_dash');//
    // Route::match(['get','post'],'account_pkti8011_pull',[App\Http\Controllers\AccountPKController::class, 'account_pkti8011_pull'])->name('acc.account_pkti8011_pull');//
    // Route::match(['get','post'],'account_pkti8011_pulldata',[App\Http\Controllers\AccountPKController::class, 'account_pkti8011_pulldata'])->name('acc.account_pkti8011_pulldata');//
    // Route::match(['get','post'],'account_pkti8011/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_pkti8011'])->name('acc.account_pkti8011');//
    // Route::match(['get','post'],'account_pkti8011_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_pkti8011_stm'])->name('acc.account_pkti8011_stm');//
    Route::match(['get','post'],'account_pkti8011_dash',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_dash'])->name('acc.account_pkti8011_dash');//
    Route::match(['get','post'],'account_pkti8011_pull',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_pull'])->name('acc.account_pkti8011_pull');//
    Route::match(['get','post'],'account_pkti8011_pulldata',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_pulldata'])->name('acc.account_pkti8011_pulldata');// 
    Route::match(['get','post'],'account_pkti8011_detail/{months}/{year}',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_detail'])->name('acc.account_pkti8011_detail');//
    Route::match(['get','post'],'account_pkti8011_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_detail_date'])->name('acc.account_pkti8011_detail_date');//
    Route::match(['get','post'],'account_pkti8011_stm/{months}/{year}',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_stm'])->name('acc.account_pkti8011_stm');//
    Route::match(['get','post'],'account_pkti8011_stmnull/{months}/{year}',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_stmnull'])->name('acc.account_pkti8011_stmnull');//
    Route::match(['get','post'],'account_pkti8011_stam',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_stam'])->name('acc.account_pkti8011_stam');//
    Route::match(['get','post'],'account_pkti8011_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_stm_date'])->name('acc.account_pkti8011_stm_date');//
    Route::match(['get','post'],'account_pkti8011_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account8011Controller::class, 'account_pkti8011_stmnull_date'])->name('acc.account_pkti8011_stmnull_date');//
    Route::match(['get','post'],'account_8011_destroy',[App\Http\Controllers\Account8011Controller::class, 'account_8011_destroy'])->name('acc.account_8011_destroy');//

    Route::match(['get','post'],'account_pkti2166_dash',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_dash'])->name('acc.account_pkti2166_dash');//
    Route::match(['get','post'],'account_pkti2166_pull',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_pull'])->name('acc.account_pkti2166_pull');//
    Route::match(['get','post'],'account_pkti2166_pulldata',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_pulldata'])->name('acc.account_pkti2166_pulldata');//
    Route::match(['get','post'],'account_pkti2166/{months}/{year}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166'])->name('acc.account_pkti2166');//
    Route::match(['get','post'],'account_pkti2166_stm/{months}/{year}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_stm'])->name('acc.account_pkti2166_stm');//
    Route::match(['get','post'],'account_pkti2166_stam',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_stam'])->name('acc.account_pkti2166_stam');//  stamp OPD
    Route::match(['get','post'],'account_pkti2166_stmtang/{months}/{year}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_stmtang'])->name('acc.account_pkti2166_stmtang');//
    Route::match(['get','post'],'account_pkti2166_detail/{months}/{year}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_detail'])->name('acc.account_pkti2166_detail');//
    Route::match(['get','post'],'account_pkti2166_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_detail_date'])->name('acc.account_pkti2166_detail_date');//
    Route::match(['get','post'],'account_pkti2166_stmnull/{months}/{year}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_stmnull'])->name('acc.account_pkti2166_stmnull');//
    Route::match(['get','post'],'account_pkti2166_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_stm_date'])->name('acc.account_pkti2166_stm_date');//
    Route::match(['get','post'],'account_pkti2166_stmnull_date/{months}/{year}',[App\Http\Controllers\Account2166Controller::class, 'account_pkti2166_stmnull_date'])->name('acc.account_pkti2166_stmnull_date');//
    Route::match(['get','post'],'account_2166_destroy',[App\Http\Controllers\Account2166Controller::class, 'account_2166_destroy'])->name('acc.account_2166_destroy');//

    Route::match(['get','post'],'ti2166_send/{id}',[App\Http\Controllers\AccountPKController::class, 'ti2166_send'])->name('acc.ti2166_send');//
    Route::match(['get','post'],'ti2166_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'ti2166_detail'])->name('acc.ti2166_detail');//

    Route::match(['get','post'],'upstm_ti',[App\Http\Controllers\AccountPKController::class, 'upstm_ti'])->name('acc.upstm_ti');// ไต
    Route::match(['get','post'],'upstm_ti_import',[App\Http\Controllers\AccountPKController::class, 'upstm_ti_import'])->name('acc.upstm_ti_import');// ไต
    Route::match(['get','post'],'upstm_ti_importtotal',[App\Http\Controllers\AccountPKController::class, 'upstm_ti_importtotal'])->name('acc.upstm_ti_importtotal');// ไต
    Route::match(['get','post'],'upstm_hn',[App\Http\Controllers\AccountPKController::class, 'upstm_hn'])->name('acc.upstm_hn');// ไต
    Route::match(['get','post'],'upstm_ti_importexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_ti_importexcel'])->name('acc.upstm_ti_importexcel');// ไต

    Route::match(['get','post'],'upstm_all',[App\Http\Controllers\AccountPKController::class, 'upstm_all'])->name('acc.upstm_all');//
     
    Route::match(['get','post'],'upstm_ucs_opd216',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_opd216'])->name('acc.upstm_ucs_opd216');//
    Route::match(['get','post'],'upstm_ucs_ipd217',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_ipd217'])->name('acc.upstm_ucs_ipd217');//
    Route::match(['get','post'],'upstm_ucs_ti',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_ti'])->name('acc.upstm_ucs_ti');//
    Route::match(['get','post'],'upstm_ucs_ti_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_ti_detail'])->name('acc.upstm_ucs_ti_detail');//

    Route::match(['get','post'],'upstm_sss_ti',[App\Http\Controllers\AccountPKController::class, 'upstm_sss_ti'])->name('acc.upstm_sss_ti');//
    Route::match(['get','post'],'upstm_sss_ti_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_sss_ti_detail'])->name('acc.upstm_sss_ti_detail');//

    Route::match(['get','post'],'upstm_ofc_ti',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_ti'])->name('acc.upstm_ofc_ti');//
    Route::match(['get','post'],'upstm_ofc_ti_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_ti_detail'])->name('acc.upstm_ofc_ti_detail');//
    Route::match(['get','post'],'upstm_ofc_ti_ipd',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_ti_ipd'])->name('acc.upstm_ofc_ti_ipd');//
    Route::match(['get','post'],'upstm_ofc_ti_ipd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_ti_ipd_detail'])->name('acc.upstm_ofc_ti_ipd_detail');//
    
    Route::match(['get','post'],'upstm_lgo_ti',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_ti'])->name('acc.upstm_lgo_ti');//
    Route::match(['get','post'],'upstm_lgo_ti_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_ti_detail'])->name('acc.upstm_lgo_ti_detail');//

    Route::match(['get','post'],'upstm_ofc_opd',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_opd'])->name('acc.upstm_ofc_opd');//
    Route::match(['get','post'],'upstm_ofc_opd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_opd_detail'])->name('acc.upstm_ofc_opd_detail');//
    Route::match(['get','post'],'upstm_ofc_ipd',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_ipd'])->name('acc.upstm_ofc_ipd');//
    Route::match(['get','post'],'upstm_ofc_ipd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_ipd_detail'])->name('acc.upstm_ofc_ipd_detail');//

    Route::match(['get','post'],'upstm_lgo_opd',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_opd'])->name('acc.upstm_lgo_opd');//
    Route::match(['get','post'],'upstm_lgo_opd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_opd_detail'])->name('acc.upstm_lgo_opd_detail');//
    Route::match(['get','post'],'upstm_lgo_ipd',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_ipd'])->name('acc.upstm_lgo_ipd');//
    Route::match(['get','post'],'upstm_lgo_ipd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_ipd_detail'])->name('acc.upstm_lgo_ipd_detail');//

    Route::match(['get','post'],'upstm_bkk_opd',[App\Http\Controllers\AccountPKController::class, 'upstm_bkk_opd'])->name('acc.upstm_bkk_opd');//
    Route::match(['get','post'],'upstm_bkk_opd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_bkk_opd_detail'])->name('acc.upstm_bkk_opd_detail');//
    Route::match(['get','post'],'upstm_bkk_ipd',[App\Http\Controllers\AccountPKController::class, 'upstm_bkk_ipd'])->name('acc.upstm_bkk_ipd');//
    Route::match(['get','post'],'upstm_bkk_ipd_detail/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_bkk_ipd_detail'])->name('acc.upstm_bkk_ipd_detail');//

    Route::match(['get','post'],'upstm_ucs',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs'])->name('acc.upstm_ucs');//
    Route::match(['get','post'],'upstm_ucs_excel',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_excel'])->name('acc.upstm_ucs_excel');//
    Route::match(['get','post'],'upstm_ucs_sendexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_sendexcel'])->name('acc.upstm_ucs_sendexcel');//

    Route::match(['get','post'],'upstm_ucsopd',[App\Http\Controllers\AccountSTMController::class, 'upstm_ucsopd'])->name('acc.upstm_ucsopd');//
    Route::match(['get','post'],'upstm_ucsopdsave',[App\Http\Controllers\AccountSTMController::class, 'upstm_ucsopdsave'])->name('acc.upstm_ucsopdsave');//
    Route::match(['get','post'],'upstm_ucsopdsend',[App\Http\Controllers\AccountSTMController::class, 'upstm_ucsopdsend'])->name('acc.upstm_ucsopdsend');//

    Route::match(['get','post'],'upstm_ucs_opd',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_opd'])->name('acc.upstm_ucs_opd');//
    Route::match(['get','post'],'upstm_ucs_detail_opd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_detail_opd'])->name('acc.upstm_ucs_detail_opd');//
    Route::match(['get','post'],'upstm_ucs_detail_opd_216/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_detail_opd_216'])->name('acc.upstm_ucs_detail_opd_216');//

    Route::match(['get','post'],'upstm_ucs_ipd',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_ipd'])->name('acc.upstm_ucs_ipd');//
    Route::match(['get','post'],'upstm_ucs_detail_ipd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_detail_ipd'])->name('acc.upstm_ucs_detail_ipd');//
    Route::match(['get','post'],'upstm_ucs_detail_ipd_217/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_detail_ipd_217'])->name('acc.upstm_ucs_detail_ipd_217');//
    Route::match(['get','post'],'upstm_lgo_detail_opd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_detail_opd'])->name('acc.upstm_lgo_detail_opd');//
    Route::match(['get','post'],'upstm_lgo_detail_ipd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_detail_ipd'])->name('acc.upstm_lgo_detail_ipd');//
    Route::match(['get','post'],'upstm_ofc_detail_opd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_detail_opd'])->name('acc.upstm_ofc_detail_opd');//
    Route::match(['get','post'],'upstm_ofc_detail_ipd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_detail_ipd'])->name('acc.upstm_ofc_detail_ipd');//

    Route::match(['get','post'],'upstm_ucs_detail_ti/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ucs_detail_ti'])->name('acc.upstm_ucs_detail_ti');//
    Route::match(['get','post'],'upstm_ofc_detail_ti/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_detail_ti'])->name('acc.upstm_ofc_detail_ti');//
    Route::match(['get','post'],'upstm_ofc_detail_ti_ipd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_ofc_detail_ti_ipd'])->name('acc.upstm_ofc_detail_ti_ipd');//
    Route::match(['get','post'],'upstm_sss_detail_ti/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_sss_detail_ti'])->name('acc.upstm_sss_detail_ti');//
    Route::match(['get','post'],'upstm_lgo_detail_ti/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_detail_ti'])->name('acc.upstm_lgo_detail_ti');//
    Route::match(['get','post'],'upstm_lgo_detail_ti_ipd/{id}',[App\Http\Controllers\AccountPKController::class, 'upstm_lgo_detail_ti_ipd'])->name('acc.upstm_lgo_detail_ti_ipd');//
    
     
    Route::match(['get','post'],'phthisis_opd',[App\Http\Controllers\ReportOrtherController::class, 'phthisis_opd'])->name('rep.phthisis_opd');//
    Route::match(['get','post'],'phthisis_ipd',[App\Http\Controllers\ReportOrtherController::class, 'phthisis_ipd'])->name('rep.phthisis_ipd');//

    Route::match(['get','post'],'upstm_tixml',[App\Http\Controllers\AccountPKController::class, 'upstm_tixml'])->name('acc.upstm_tixml');// ไต
    Route::match(['get','post'],'upstm_tixml_import',[App\Http\Controllers\AccountPKController::class, 'upstm_tixml_import'])->name('acc.upstm_tixml_import');// ไต
    Route::match(['get','post'],'upstm_tixml_sss',[App\Http\Controllers\AccountPKController::class, 'upstm_tixml_sss'])->name('acc.upstm_tixml_sss');// ไต
    Route::match(['get','post'],'upstm_tixml_sssimport',[App\Http\Controllers\AccountPKController::class, 'upstm_tixml_sssimport'])->name('acc.upstm_tixml_sssimport');// ไต

    Route::match(['get','post'],'upstm_sss_xml',[App\Http\Controllers\AccountPKController::class, 'upstm_sss_xml'])->name('acc.upstm_sss_xml');//  
    Route::match(['get','post'],'upstm_sss_xmlsave',[App\Http\Controllers\AccountPKController::class, 'upstm_sss_xmlsave'])->name('acc.upstm_sss_xmlsave');//  

    Route::match(['get','post'],'upstm_ofcexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_ofcexcel'])->name('acc.upstm_ofcexcel');//
    Route::match(['get','post'],'upstm_ofcexcel_save',[App\Http\Controllers\AccountPKController::class, 'upstm_ofcexcel_save'])->name('acc.upstm_ofcexcel_save');//
    Route::match(['get','post'],'upstm_ofcexcel_senddata',[App\Http\Controllers\AccountPKController::class, 'upstm_ofcexcel_senddata'])->name('acc.upstm_ofcexcel_senddata');//
    Route::match(['get','post'],'upstm_ofcexcel_sendstmdata',[App\Http\Controllers\AccountPKController::class, 'upstm_ofcexcel_sendstmdata'])->name('acc.upstm_ofcexcel_sendstmdata');//
    Route::match(['get','post'],'upstm_ofcexcel_sendstmipddata',[App\Http\Controllers\AccountPKController::class, 'upstm_ofcexcel_sendstmipddata'])->name('acc.upstm_ofcexcel_sendstmipddata');//

    Route::match(['get','post'],'upstm_bkkexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_bkkexcel'])->name('acc.upstm_bkkexcel');//
    Route::match(['get','post'],'upstm_bkkexcel_save',[App\Http\Controllers\AccountPKController::class, 'upstm_bkkexcel_save'])->name('acc.upstm_bkkexcel_save');//

    Route::match(['get','post'],'upstm_bkk803_senddata',[App\Http\Controllers\AccountPKController::class, 'upstm_bkk803_senddata'])->name('acc.upstm_bkk803_senddata');//
    Route::match(['get','post'],'upstm_bkk804_senddata',[App\Http\Controllers\AccountPKController::class, 'upstm_bkk804_senddata'])->name('acc.upstm_bkk804_senddata');//

    Route::match(['get','post'],'upstm_lgoexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_lgoexcel'])->name('acc.upstm_lgoexcel');//
    Route::match(['get','post'],'upstm_lgoexcel_save',[App\Http\Controllers\AccountPKController::class, 'upstm_lgoexcel_save'])->name('acc.upstm_lgoexcel_save');//
    Route::match(['get','post'],'upstm_lgoexcel_senddata',[App\Http\Controllers\AccountPKController::class, 'upstm_lgoexcel_senddata'])->name('acc.upstm_lgoexcel_senddata');//

    Route::match(['get','post'],'upstm_lgotiexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_lgotiexcel'])->name('acc.upstm_lgotiexcel');//
    Route::match(['get','post'],'upstm_lgotiexcel_save',[App\Http\Controllers\AccountPKController::class, 'upstm_lgotiexcel_save'])->name('acc.upstm_lgotiexcel_save');//
    Route::match(['get','post'],'upstm_lgotiexcel_senddata',[App\Http\Controllers\AccountPKController::class, 'upstm_lgotiexcel_senddata'])->name('acc.upstm_lgotiexcel_senddata');//

    Route::match(['get','post'],'upstm_lgoipexcel',[App\Http\Controllers\AccountPKController::class, 'upstm_lgoipexcel'])->name('acc.upstm_lgoipexcel');//
    Route::match(['get','post'],'upstm_lgoipexcel_save',[App\Http\Controllers\AccountPKController::class, 'upstm_lgoipexcel_save'])->name('acc.upstm_lgoipexcel_save');//
    Route::match(['get','post'],'upstm_lgoipexcel_senddata',[App\Http\Controllers\AccountPKController::class, 'upstm_lgoipexcel_senddata'])->name('acc.upstm_lgoipexcel_senddata');//

    Route::match(['get','post'],'upstm',[App\Http\Controllers\AccountPKController::class, 'upstm'])->name('acc.upstm');//
    Route::match(['get','post'],'upstm_save',[App\Http\Controllers\AccountPKController::class, 'upstm_save'])->name('acc.upstm_save');//
    Route::match(['get','post'],'upstm_import',[App\Http\Controllers\AccountPKController::class, 'upstm_import'])->name('acc.upstm_import');//


    Route::match(['get','post'],'account_pk_dash',[App\Http\Controllers\AccdashboardController::class, 'account_pk_dash'])->name('acc.account_pk_dash');//
    Route::match(['get','post'],'account_dash_save',[App\Http\Controllers\AccdashboardController::class, 'account_dash_save'])->name('acc.account_dash_save');//
    Route::match(['get','post'],'account_dashline',[App\Http\Controllers\AccdashboardController::class, 'account_dashline'])->name('acc.account_dashline');//
  
    Route::match(['get','post'],'chang_pttype_IPD',[App\Http\Controllers\MoveaccountController::class, 'chang_pttype_IPD'])->name('acc.chang_pttype_IPD');//ย้ายผัง
    Route::match(['get','post'],'chang_pttype_OPD',[App\Http\Controllers\MoveaccountController::class, 'chang_pttype_OPD'])->name('acc.chang_pttype_OPD');//ย้ายผัง
    Route::delete('pttypeopd_destroy/{id}',[App\Http\Controllers\MoveaccountController::class, 'pttypeopd_destroy'])->name('acc.pttypeopd_destroy');//ย้ายผัง
    Route::match(['get','post'],'chang_pttype_opdstamp',[App\Http\Controllers\MoveaccountController::class, 'chang_pttype_opdstamp'])->name('acc.chang_pttype_opdstamp');//ย้ายผัง
    Route::match(['get','post'],'move_pang/{id}',[App\Http\Controllers\MoveaccountController::class, 'move_pang'])->name('acc.move_pang');//ย้ายผัง
    Route::match(['get','post'],'move_pang_save',[App\Http\Controllers\MoveaccountController::class, 'move_pang_save'])->name('acc.move_pang_save');//ย้ายผัง
    // Route::match(['get','post'],'chang_pttype_OPD',[App\Http\Controllers\MoveaccountController::class, 'chang_pttype_OPD'])->name('acc.chang_pttype_OPD');//ย้ายผัง

    Route::match(['get','post'],'account_pk_ipd',[App\Http\Controllers\AccountPKController::class, 'account_pk_ipd'])->name('acc.account_pk_ipd');//
    Route::match(['get','post'],'account_pk_ipdsave',[App\Http\Controllers\AccountPKController::class, 'account_pk_ipdsave'])->name('acc.account_pk_ipdsave');//
    Route::match(['get','post'],'account_pk_debtor_ipd',[App\Http\Controllers\AccountPKController::class, 'account_pk_debtor_ipd'])->name('acc.account_pk_debtor_ipd');//  stamp IPD

    Route::match(['get','post'],'sit_acc_debtorauto',[App\Http\Controllers\AccountPKController::class, 'sit_acc_debtorauto'])->name('acc.sit_acc_debtorauto');//
    Route::match(['get','post'],'sit_accpull_auto',[App\Http\Controllers\AccountPKController::class, 'sit_accpull_auto'])->name('sit.sit_accpull_auto');//

    // ************106 OPD**********************

    Route::match(['get','post'],'acc_106_dashboard',[App\Http\Controllers\Account106Controller::class, 'acc_106_dashboard'])->name('acc.acc_106_dashboard');//
    Route::match(['get','post'],'acc_106_pull',[App\Http\Controllers\Account106Controller::class, 'acc_106_pull'])->name('acc.acc_106_pull');//
    Route::match(['get','post'],'acc_106_pulldata',[App\Http\Controllers\Account106Controller::class, 'acc_106_pulldata'])->name('acc.acc_106_pulldata');//
    Route::match(['get','post'],'acc_106_stam',[App\Http\Controllers\Account106Controller::class, 'acc_106_stam'])->name('acc.acc_106_stam');//
    Route::match(['get','post'],'acc_106_detail/{months}/{year}',[App\Http\Controllers\Account106Controller::class, 'acc_106_detail'])->name('acc.acc_106_detail');//
    Route::match(['get','post'],'acc_106_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account106Controller::class, 'acc_106_detail_date'])->name('acc.acc_106_detail_date');//
    Route::match(['get','post'],'acc_106_stm',[App\Http\Controllers\Account106Controller::class, 'acc_106_stm'])->name('acc.acc_106_stm');//
    Route::match(['get','post'],'acc_106_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account106Controller::class, 'acc_106_stm_date'])->name('acc.acc_106_stm_date');//
    Route::match(['get','post'],'acc_106_stmnull',[App\Http\Controllers\Account106Controller::class, 'acc_106_stmnull'])->name('acc.acc_106_stmnull');//
    Route::match(['get','post'],'acc_106_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account106Controller::class, 'acc_106_stmnull_date'])->name('acc.acc_106_stmnull_date');//
    Route::match(['get','post'],'acc_106_file',[App\Http\Controllers\Account106Controller::class, 'acc_106_file'])->name('acc.acc_106_file');//
    Route::match(['get','post'],'acc_106_file_updatefile',[App\Http\Controllers\Account106Controller::class, 'acc_106_file_updatefile'])->name('acc.acc_106_file_updatefile');//
    Route::match(['get','post'],'acc106destroy/{id}',[App\Http\Controllers\Account106Controller::class, 'acc106destroy'])->name('acc.acc106destroy');//

    Route::match(['get','post'],'acc_106_debt',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt'])->name('acc.acc_106_debt');//  ทวงหนี้
    Route::match(['get','post'],'acc_106_debt_outbook/{id}',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt_outbook'])->name('acc.acc_106_debt_outbook');// 
    Route::match(['get','post'],'acc_106_debt_print/{id}',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt_print'])->name('acc.acc_106_debt_print');//  ทวงหนี้
    Route::match(['get','post'],'acc_106_debt_pic',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt_pic'])->name('acc.acc_106_debt_pic');// 
    Route::match(['get','post'],'acc_106_debt_downloadbook/{id}',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt_downloadbook'])->name('acc.acc_106_debt_downloadbook');// 
    Route::match(['get','post'],'acc_106_debt_sync',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt_sync'])->name('acc.acc_106_debt_sync');//  ทวงหนี้
    Route::match(['get','post'],'acc_106_debt_checksit',[App\Http\Controllers\Account106Controller::class, 'acc_106_debt_checksit'])->name('acc.acc_106_debt_checksit');// 
    Route::match(['get','post'],'account_106_destroy',[App\Http\Controllers\Account106Controller::class, 'account_106_destroy'])->name('acc.account_106_destroy');//

    // ************107 IPD**********************

    Route::match(['get','post'],'acc_107_dashboard',[App\Http\Controllers\Account107Controller::class, 'acc_107_dashboard'])->name('acc.acc_107_dashboard');//
    Route::match(['get','post'],'acc_107_pull',[App\Http\Controllers\Account107Controller::class, 'acc_107_pull'])->name('acc.acc_107_pull');//
    Route::match(['get','post'],'acc_107_pulldata',[App\Http\Controllers\Account107Controller::class, 'acc_107_pulldata'])->name('acc.acc_107_pulldata');//
    Route::match(['get','post'],'acc_107_stam',[App\Http\Controllers\Account107Controller::class, 'acc_107_stam'])->name('acc.acc_107_stam');//
    Route::match(['get','post'],'acc_107_detail/{months}/{year}',[App\Http\Controllers\Account107Controller::class, 'acc_107_detail'])->name('acc.acc_107_detail');//
    Route::match(['get','post'],'acc_107_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account107Controller::class, 'acc_107_detail_date'])->name('acc.acc_107_detail_date');//
    Route::match(['get','post'],'acc_107_stm',[App\Http\Controllers\Account107Controller::class, 'acc_107_stm'])->name('acc.acc_107_stm');//
    Route::match(['get','post'],'acc_107_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account107Controller::class, 'acc_107_stm_date'])->name('acc.acc_107_stm_date');//
    Route::match(['get','post'],'acc_107_stmnull',[App\Http\Controllers\Account107Controller::class, 'acc_107_stmnull'])->name('acc.acc_107_stmnull');//
    Route::match(['get','post'],'acc_107_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account107Controller::class, 'acc_107_stmnull_date'])->name('acc.acc_107_stmnull_date');//
    Route::match(['get','post'],'acc_107_file',[App\Http\Controllers\Account107Controller::class, 'acc_107_file'])->name('acc.acc_107_file');//
    Route::match(['get','post'],'acc_107_file_updatefile',[App\Http\Controllers\Account107Controller::class, 'acc_107_file_updatefile'])->name('acc.acc_107_file_updatefile');//
    Route::match(['get','post'],'acc107destroy/{id}',[App\Http\Controllers\Account107Controller::class, 'acc107destroy'])->name('acc.acc107destroy');//
    Route::match(['get','post'],'account_107_destroy',[App\Http\Controllers\Account107Controller::class, 'account_107_destroy'])->name('acc.account_107_destroy');//

    Route::match(['get','post'],'acc_107_debt',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt'])->name('acc.acc_107_debt');//  ทวงหนี้
    Route::match(['get','post'],'acc_107_debt_outbook/{id}',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt_outbook'])->name('acc.acc_107_debt_outbook');// 
    Route::match(['get','post'],'acc_107_debt_print/{id}',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt_print'])->name('acc.acc_107_debt_print');//  ทวงหนี้
    Route::match(['get','post'],'acc_107_debt_sync',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt_sync'])->name('acc.acc_107_debt_sync');//  ทวงหนี้
    Route::match(['get','post'],'acc_107_debt_check_sit',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt_check_sit'])->name('acc.acc_107_debt_check_sit');// 
    Route::match(['get','post'],'acc_107_debt_months/{months}/{year}',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt_months'])->name('acc.acc_107_debt_months');//  ทวงหนี้
    Route::match(['get','post'],'acc_107_debt_syncmonths',[App\Http\Controllers\Account107Controller::class, 'acc_107_debt_syncmonths'])->name('acc.acc_107_debt_syncmonths');//  ทวงหนี้

    Route::match(['get','post'],'account_201_dash',[App\Http\Controllers\Account201Controller::class, 'account_201_dash'])->name('acc.account_201_dash');// 
    Route::match(['get','post'],'account_201_pull',[App\Http\Controllers\Account201Controller::class, 'account_201_pull'])->name('acc.account_201_pull');// OPD
    Route::match(['get','post'],'account_201_checksit',[App\Http\Controllers\Account201Controller::class, 'account_201_checksit'])->name('acc.account_201_checksit');//
    Route::match(['get','post'],'account_201_pulldata',[App\Http\Controllers\Account201Controller::class, 'account_201_pulldata'])->name('acc.account_201_pulldata');//   
    Route::match(['get','post'],'account_201_detail/{months}/{year}',[App\Http\Controllers\Account201Controller::class, 'account_201_detail'])->name('acc.account_201_detail');//
    Route::match(['get','post'],'account_201_stm/{months}/{year}',[App\Http\Controllers\Account201Controller::class, 'account_201_stm'])->name('acc.account_201_stm');//
    Route::match(['get','post'],'account_201_stmnull/{months}/{year}',[App\Http\Controllers\Account201Controller::class, 'account_201_stmnull'])->name('acc.account_201_stmnull');//
    Route::match(['get','post'],'account_201_stam',[App\Http\Controllers\Account201Controller::class, 'account_201_stam'])->name('acc.account_201_stam');//   
    Route::match(['get','post'],'account_201_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account201Controller::class, 'account_201_detail_date'])->name('acc.account_201_detail_date');//
    Route::match(['get','post'],'account_201_detaildate',[App\Http\Controllers\Account201Controller::class, 'account_201_detaildate'])->name('acc.account_201_detaildate');//
    Route::match(['get','post'],'account_201_stmdate',[App\Http\Controllers\Account201Controller::class, 'account_201_stmdate'])->name('acc.account_201_stmdate');//
    Route::match(['get','post'],'account_201_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account201Controller::class, 'account_201_stm_date'])->name('acc.account_201_stm_date');//
    Route::match(['get','post'],'account_201_stmnull_date/{months}/{year}',[App\Http\Controllers\Account201Controller::class, 'account_201_stmnull_date'])->name('acc.account_201_stmnull_date');//
    Route::match(['get','post'],'account_201_destroy',[App\Http\Controllers\Account201Controller::class, 'account_201_destroy'])->name('acc.account_201_destroy');//

    Route::match(['get','post'],'account_pkucs202_pull',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_pull'])->name('acc.account_pkucs202_pull');//
    Route::match(['get','post'],'account_pkucs202_checksit',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_checksit'])->name('acc.account_pkucs202_checksit');//
    Route::match(['get','post'],'account_pkucs202_search',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_search'])->name('acc.account_pkucs202_search');//
    Route::match(['get','post'],'account_pkucs202_processdata',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_processdata'])->name('acc.account_pkucs202_processdata');//
    Route::match(['get','post'],'account_pkucs202_pulldata',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_pulldata'])->name('acc.account_pkucs202_pulldata');//
    Route::match(['get','post'],'account_pkucs202_dash',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_dash'])->name('acc.account_pkucs202_dash');//
    Route::match(['get','post'],'account_pkucs202/{months}/{year}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202'])->name('acc.account_pkucs202');//
    Route::match(['get','post'],'account_pkucs202_detail/{months}/{year}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_detail'])->name('acc.account_pkucs202_detail');//
    Route::match(['get','post'],'account_pkucs202_stm/{months}/{year}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_stm'])->name('acc.account_pkucs202_stm');//
    Route::match(['get','post'],'account_pkucs202_stmnull/{months}/{year}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_stmnull'])->name('acc.account_pkucs202_stmnull');//
    Route::match(['get','post'],'account_pkucs202_stam',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_stam'])->name('acc.account_pkucs202_stam');//  stamp IPD
    Route::match(['get','post'],'account_pkucs202_stmnull_all/{months}/{year}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_stmnull_all'])->name('acc.account_pkucs202_stmnull_all');//
    Route::match(['get','post'],'account_pkucs202_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_detail_date'])->name('acc.account_pkucs202_detail_date');//
    Route::match(['get','post'],'account_pkucs202_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_stm_date'])->name('acc.account_pkucs202_stm_date');//
    Route::match(['get','post'],'account_pkucs202_stmnull_date/{months}/{year}',[App\Http\Controllers\Account202Controller::class, 'account_pkucs202_stmnull_date'])->name('acc.account_pkucs202_stmnull_date');//
    Route::match(['get','post'],'account_202_destroy',[App\Http\Controllers\Account202Controller::class, 'account_202_destroy'])->name('acc.account_202_destroy');//
 
    Route::match(['get','post'],'account_203_dash',[App\Http\Controllers\Account203Controller::class, 'account_203_dash'])->name('acc.account_203_dash');//
    Route::match(['get','post'],'account_203_hoscode/{months}/{year}',[App\Http\Controllers\Account203Controller::class, 'account_203_hoscode'])->name('acc.account_203_hoscode');//
    Route::match(['get','post'],'account_203_hoscode_date/{startdate}/{enddate}',[App\Http\Controllers\Account203Controller::class, 'account_203_hoscode_date'])->name('acc.account_203_hoscode_date');//
    Route::match(['get','post'],'account_203_hcode_group/{months}/{year}/{hcode}',[App\Http\Controllers\Account203Controller::class, 'account_203_hcode_group'])->name('acc.account_203_hcode_group');//
    Route::match(['get','post'],'account_203_hcode_group_date/{startdate}/{enddate}/{hcode}',[App\Http\Controllers\Account203Controller::class, 'account_203_hcode_group_date'])->name('acc.account_203_hcode_group_date');//
    Route::match(['get','post'],'account_203_hcode_detail/{months}/{year}/{hcode}',[App\Http\Controllers\Account203Controller::class, 'account_203_hcode_detail'])->name('acc.account_203_hcode_detail');//
    Route::match(['get','post'],'account_203_pull',[App\Http\Controllers\Account203Controller::class, 'account_203_pull'])->name('acc.account_203_pull');//
    Route::match(['get','post'],'account_203_checksit',[App\Http\Controllers\Account203Controller::class, 'account_203_checksit'])->name('acc.account_203_checksit');//
    Route::match(['get','post'],'account_203_pull_m/{months}/{year}',[App\Http\Controllers\Account203Controller::class, 'account_203_pull_m'])->name('acc.account_203_pull_m');//
    Route::match(['get','post'],'account_203_pulldata',[App\Http\Controllers\Account203Controller::class, 'account_203_pulldata'])->name('acc.account_203_pulldata');//    
    Route::match(['get','post'],'account_203/{months}/{year}',[App\Http\Controllers\Account203Controller::class, 'account_203'])->name('acc.account_203');//
    Route::match(['get','post'],'account_203_detail/{months}/{year}',[App\Http\Controllers\Account203Controller::class, 'account_203_detail'])->name('acc.account_203_detail');//
    Route::match(['get','post'],'account_203_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account203Controller::class, 'account_203_detail_date'])->name('acc.account_203_detail_date');//
    Route::match(['get','post'],'account_203_stm/{months}/{year}',[App\Http\Controllers\Account203Controller::class, 'account_203_stm'])->name('acc.account_203_stm');//
    Route::match(['get','post'],'account_203_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account203Controller::class, 'account_203_stm_date'])->name('acc.account_203_stm_date');//
    Route::match(['get','post'],'account_203_stmnull/{months}/{year}',[App\Http\Controllers\Account203Controller::class, 'account_203_stmnull'])->name('acc.account_203_stmnull');//
    Route::match(['get','post'],'account_203_stam',[App\Http\Controllers\Account203Controller::class, 'account_203_stam'])->name('acc.account_203_stam');// 
    Route::match(['get','post'],'account_203_sync',[App\Http\Controllers\Account203Controller::class, 'account_203_sync'])->name('acc.account_203_sync');//
    Route::match(['get','post'],'account_203_syncall',[App\Http\Controllers\Account203Controller::class, 'account_203_syncall'])->name('acc.account_203_syncall');//
    Route::match(['get','post'],'account_203_form',[App\Http\Controllers\Account203Controller::class, 'account_203_form'])->name('acc.account_203_form');//
    Route::match(['get','post'],'account_203_destroy',[App\Http\Controllers\Account203Controller::class, 'account_203_destroy'])->name('acc.account_203_destroy');//

    Route::match(['get','post'],'account_pkucs209_dash',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_dash'])->name('acc.account_pkucs209_dash');// 
    Route::match(['get','post'],'account_pkucs209_pull',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_pull'])->name('acc.account_pkucs209_pull');//
    Route::match(['get','post'],'account_pkucs209_checksit',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_checksit'])->name('acc.account_pkucs209_checksit');//
    Route::match(['get','post'],'account_pkucs209_pulldata',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_pulldata'])->name('acc.account_pkucs209_pulldata');//      
    Route::match(['get','post'],'account_pkucs209_detail/{months}/{year}',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_detail'])->name('acc.account_pkucs209_detail');//
    Route::match(['get','post'],'account_pkucs209_stm/{months}/{year}',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_stm'])->name('acc.account_pkucs209_stm');//
    Route::match(['get','post'],'account_pkucs209_stmnull/{months}/{year}',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_stmnull'])->name('acc.account_pkucs209_stmnull');//
    Route::match(['get','post'],'account_pkucs209_stam',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_stam'])->name('acc.account_pkucs209_stam');//  stamp IPD     
    Route::match(['get','post'],'account_pkucs209_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_detail_date'])->name('acc.account_pkucs209_detail_date');//
    Route::match(['get','post'],'account_pkucs209_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_stm_date'])->name('acc.account_pkucs209_stm_date');//
    Route::match(['get','post'],'account_pkucs209_stmnull_date/{months}/{year}',[App\Http\Controllers\Account209Controller::class, 'account_pkucs209_stmnull_date'])->name('acc.account_pkucs209_stmnull_date');//
    Route::match(['get','post'],'account_209_destroy',[App\Http\Controllers\Account209Controller::class, 'account_209_destroy'])->name('acc.account_209_destroy');//

    Route::match(['get','post'],'account_pkucs216_pull',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_pull'])->name('acc.account_pkucs216_pull');//
    Route::match(['get','post'],'account_pkucs216_search',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_search'])->name('acc.account_pkucs216_search');//
    Route::match(['get','post'],'account_pkucs216_checksit',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_checksit'])->name('acc.account_pkucs216_checksit');//
    Route::match(['get','post'],'account_pkucs216_pulldata',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_pulldata'])->name('acc.account_pkucs216_pulldata');//
    Route::match(['get','post'],'account_pkucs216_dash',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_dash'])->name('acc.account_pkucs216_dash');// 
    Route::match(['get','post'],'account_pkucs216_detail/{months}/{year}',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_detail'])->name('acc.account_pkucs216_detail');//
    Route::match(['get','post'],'account_pkucs216_stm/{months}/{year}',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_stm'])->name('acc.account_pkucs216_stm');//
    Route::match(['get','post'],'account_pkucs216_stmnull/{months}/{year}',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_stmnull'])->name('acc.account_pkucs216_stmnull');//
    Route::match(['get','post'],'account_pkucs216_stam',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_stam'])->name('acc.account_pkucs216_stam');//  stamp IPD 
    Route::match(['get','post'],'account_pkucs216_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_detail_date'])->name('acc.account_pkucs216_detail_date');//
    Route::match(['get','post'],'account_pkucs216_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_stm_date'])->name('acc.account_pkucs216_stm_date');//
    Route::match(['get','post'],'account_pkucs216_stmnull_date/{months}/{year}',[App\Http\Controllers\Account216Controller::class, 'account_pkucs216_stmnull_date'])->name('acc.account_pkucs216_stmnull_date');//
    Route::match(['get','post'],'account_216_destroy',[App\Http\Controllers\Account216Controller::class, 'account_216_destroy'])->name('acc.account_216_destroy');//

    Route::match(['get','post'],'account_pkucs217_pull',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_pull'])->name('acc.account_pkucs217_pull');//
    Route::match(['get','post'],'account_pkucs217_search',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_search'])->name('acc.account_pkucs217_search');//
    Route::match(['get','post'],'account_pkucs217_checksit',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_checksit'])->name('acc.account_pkucs217_checksit');//
    Route::match(['get','post'],'account_pkucs217_pulldata',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_pulldata'])->name('acc.account_pkucs217_pulldata');//
    Route::match(['get','post'],'account_pkucs217_dash',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_dash'])->name('acc.account_pkucs217_dash');//
    Route::match(['get','post'],'account_pkucs217/{months}/{year}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217'])->name('acc.account_pkucs217');//
    Route::match(['get','post'],'account_pkucs217_detail/{months}/{year}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_detail'])->name('acc.account_pkucs217_detail');//
    Route::match(['get','post'],'account_pkucs217_stm/{months}/{year}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_stm'])->name('acc.account_pkucs217_stm');//
    Route::match(['get','post'],'account_pkucs217_stmnull/{months}/{year}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_stmnull'])->name('acc.account_pkucs217_stmnull');//
    Route::match(['get','post'],'account_pkucs217_stam',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_stam'])->name('acc.account_pkucs217_stam');//  stamp IPD
    Route::match(['get','post'],'account_pkucs217_stmnull_all/{months}/{year}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_stmnull_all'])->name('acc.account_pkucs217_stmnull_all');//
    Route::match(['get','post'],'account_pkucs217_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_detail_date'])->name('acc.account_pkucs217_detail_date');//
    Route::match(['get','post'],'account_pkucs217_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_stm_date'])->name('acc.account_pkucs217_stm_date');//
    Route::match(['get','post'],'account_pkucs217_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account217Controller::class, 'account_pkucs217_stmnull_date'])->name('acc.account_pkucs217_stmnull_date');//
    Route::match(['get','post'],'account_217_destroy',[App\Http\Controllers\Account217Controller::class, 'account_217_destroy'])->name('acc.account_217_destroy');//

    Route::match(['get','post'],'account_301_dash',[App\Http\Controllers\Account301Controller::class, 'account_301_dash'])->name('acc.account_301_dash');//
    Route::match(['get','post'],'account_301_dashsub/{startdate}/{enddate}',[App\Http\Controllers\Account301Controller::class, 'account_301_dashsub'])->name('acc.account_301_dashsub');//
    Route::match(['get','post'],'account_301_dashsubdetail/{months}/{year}',[App\Http\Controllers\Account301Controller::class, 'account_301_dashsubdetail'])->name('acc.account_301_dashsubdetail');//
    Route::match(['get','post'],'account_301_pull',[App\Http\Controllers\Account301Controller::class, 'account_301_pull'])->name('acc.account_301_pull');//
    Route::match(['get','post'],'account_301_checksit',[App\Http\Controllers\Account301Controller::class, 'account_301_checksit'])->name('acc.account_301_checksit');//
    Route::match(['get','post'],'account_301_pulldata',[App\Http\Controllers\Account301Controller::class, 'account_301_pulldata'])->name('acc.account_301_pulldata');//
    Route::match(['get','post'],'account_301/{months}/{year}',[App\Http\Controllers\Account301Controller::class, 'account_301'])->name('acc.account_301');//
    Route::match(['get','post'],'account_301_detail/{startdate}/{enddate}',[App\Http\Controllers\Account301Controller::class, 'account_301_detail'])->name('acc.account_301_detail');//
    Route::match(['get','post'],'account_301_detail_date',[App\Http\Controllers\Account301Controller::class, 'account_301_detail_date'])->name('acc.account_301_detail_date');//
    Route::match(['get','post'],'account_301_detail_search',[App\Http\Controllers\Account301Controller::class, 'account_301_detail_search'])->name('acc.account_301_detail_search');//
    Route::match(['get','post'],'account_301_stm/{months}/{year}',[App\Http\Controllers\Account301Controller::class, 'account_301_stm'])->name('acc.account_301_stm');//
    Route::match(['get','post'],'account_301_stmnull/{months}/{year}',[App\Http\Controllers\Account301Controller::class, 'account_301_stmnull'])->name('acc.account_301_stmnull');//
    Route::match(['get','post'],'account_301_stam',[App\Http\Controllers\Account301Controller::class, 'account_301_stam'])->name('acc.account_301_stam');//  stamp OPD
    Route::match(['get','post'],'account_301_stmnull_all/{months}/{year}',[App\Http\Controllers\Account301Controller::class, 'account_301_stmnull_all'])->name('acc.account_301_stmnull_all');//
    Route::match(['get','post'],'account_301_destroy_all',[App\Http\Controllers\Account301Controller::class, 'account_301_destroy_all'])->name('acc.account_301_destroy_all');//

    Route::match(['get','post'],'account_301_income/{startdate}/{enddate}',[App\Http\Controllers\Account301Controller::class, 'account_301_income'])->name('acc.account_301_income');//
    Route::match(['get','post'],'account_301_ins/{startdate}/{enddate}',[App\Http\Controllers\Account301Controller::class, 'account_301_ins'])->name('acc.account_301_ins');//
    Route::match(['get','post'],'account_301_ct/{startdate}/{enddate}',[App\Http\Controllers\Account301Controller::class, 'account_301_ct'])->name('acc.account_301_ct');//

    Route::match(['get','post'],'account_3011_dash',[App\Http\Controllers\Account3011Controller::class, 'account_3011_dash'])->name('acc.account_3011_dash');//
    Route::match(['get','post'],'account_3011_pull',[App\Http\Controllers\Account3011Controller::class, 'account_3011_pull'])->name('acc.account_3011_pull');//
    Route::match(['get','post'],'account_3011_pulldata',[App\Http\Controllers\Account3011Controller::class, 'account_3011_pulldata'])->name('acc.account_3011_pulldata');//
    Route::match(['get','post'],'account_3011_stam',[App\Http\Controllers\Account3011Controller::class, 'account_3011_stam'])->name('acc.account_3011_stam');//
    Route::match(['get','post'],'account_3011_stm/{months}/{year}',[App\Http\Controllers\Account3011Controller::class, 'account_3011_stm'])->name('acc.account_3011_stm');//
    Route::match(['get','post'],'account_3011_detail/{startdate}/{enddate}',[App\Http\Controllers\Account3011Controller::class, 'account_3011_detail'])->name('acc.account_3011_detail');//
    Route::match(['get','post'],'account_3011_detail_date',[App\Http\Controllers\Account3011Controller::class, 'account_3011_detail_date'])->name('acc.account_3011_detail_date');//
    Route::match(['get','post'],'account_3011_search',[App\Http\Controllers\Account3011Controller::class, 'account_3011_search'])->name('acc.account_3011_search');// 
    Route::match(['get','post'],'account_3011_destroy',[App\Http\Controllers\Account3011Controller::class, 'account_3011_destroy'])->name('acc.account_3011_destroy');//
    



    Route::match(['get','post'],'account_3013_dash',[App\Http\Controllers\Account3013Controller::class, 'account_3013_dash'])->name('acc.account_3013_dash');// 
    Route::match(['get','post'],'account_3013_pull',[App\Http\Controllers\Account3013Controller::class, 'account_3013_pull'])->name('acc.account_3013_pull');//
    Route::match(['get','post'],'account_3013_stam',[App\Http\Controllers\Account3013Controller::class, 'account_3013_stam'])->name('acc.account_3013_stam');//
    Route::match(['get','post'],'account_3013_checksit',[App\Http\Controllers\Account3013Controller::class, 'account_3013_checksit'])->name('acc.account_3013_checksit');//
    Route::match(['get','post'],'account_3013_pulldata',[App\Http\Controllers\Account3013Controller::class, 'account_3013_pulldata'])->name('acc.account_3013_pulldata');// 
    Route::match(['get','post'],'account_3013_detail/{startdate}/{enddate}',[App\Http\Controllers\Account3013Controller::class, 'account_3013_detail'])->name('acc.account_3013_detail');//
    Route::match(['get','post'],'account_3013_detail_date',[App\Http\Controllers\Account3013Controller::class, 'account_3013_detail_date'])->name('acc.account_3013_detail_date');//
    Route::match(['get','post'],'account_3013_search',[App\Http\Controllers\Account3013Controller::class, 'account_3013_search'])->name('acc.account_3013_search');// 
    Route::match(['get','post'],'account_3013_destroy',[App\Http\Controllers\Account3013Controller::class, 'account_3013_destroy'])->name('acc.account_3013_destroy');//

    // Route::match(['get','post'],'account_3012_pull',[App\Http\Controllers\Account3011Controller::class, 'account_3012_pull'])->name('acc.account_3012_pull');// 

    Route::match(['get','post'],'account_302_dash',[App\Http\Controllers\Account302Controller::class, 'account_302_dash'])->name('acc.account_302_dash');//
    Route::match(['get','post'],'account_302_dashsub/{startdate}/{enddate}',[App\Http\Controllers\Account302Controller::class, 'account_302_dashsub'])->name('acc.account_302_dashsub');//
    Route::match(['get','post'],'account_302_dashsubdetail/{months}/{year}',[App\Http\Controllers\Account302Controller::class, 'account_302_dashsubdetail'])->name('acc.account_302_dashsubdetail');//
    Route::match(['get','post'],'account_302_pull',[App\Http\Controllers\Account302Controller::class, 'account_302_pull'])->name('acc.account_302_pull');//
    Route::match(['get','post'],'account_302_checksit',[App\Http\Controllers\Account302Controller::class, 'account_302_checksit'])->name('acc.account_302_checksit');//
    Route::match(['get','post'],'account_302_pulldata',[App\Http\Controllers\Account302Controller::class, 'account_302_pulldata'])->name('acc.account_302_pulldata');//
    Route::match(['get','post'],'account_302/{months}/{year}',[App\Http\Controllers\Account302Controller::class, 'account_302'])->name('acc.account_302');//
    Route::match(['get','post'],'account_302_detail/{startdate}/{enddate}',[App\Http\Controllers\Account302Controller::class, 'account_302_detail'])->name('acc.account_302_detail');//
    Route::match(['get','post'],'account_302_detail_date',[App\Http\Controllers\Account302Controller::class, 'account_302_detail_date'])->name('acc.account_302_detail_date');//
    Route::match(['get','post'],'account_302_stm/{months}/{year}',[App\Http\Controllers\Account302Controller::class, 'account_302_stm'])->name('acc.account_302_stm');//
    Route::match(['get','post'],'account_302_stmnull/{months}/{year}',[App\Http\Controllers\Account302Controller::class, 'account_302_stmnull'])->name('acc.account_302_stmnull');//
    Route::match(['get','post'],'account_302_stam',[App\Http\Controllers\Account302Controller::class, 'account_302_stam'])->name('acc.account_302_stam');//  stamp IPD
    Route::match(['get','post'],'account_302_destroy_all',[App\Http\Controllers\Account302Controller::class, 'account_302_destroy_all'])->name('acc.account_302_destroy_all');// 

    Route::match(['get','post'],'account_303_dash',[App\Http\Controllers\Account303Controller::class, 'account_303_dash'])->name('acc.account_303_dash');// 
    Route::match(['get','post'],'account_303_pull',[App\Http\Controllers\Account303Controller::class, 'account_303_pull'])->name('acc.account_303_pull');//
    Route::match(['get','post'],'account_303_checksit',[App\Http\Controllers\Account303Controller::class, 'account_303_checksit'])->name('acc.account_303_checksit');//
    Route::match(['get','post'],'account_303_pulldata',[App\Http\Controllers\Account303Controller::class, 'account_303_pulldata'])->name('acc.account_303_pulldata');// 
    Route::match(['get','post'],'account_303_detail/{startdate}/{enddate}',[App\Http\Controllers\Account303Controller::class, 'account_303_detail'])->name('acc.account_303_detail');//
    Route::match(['get','post'],'account_303_detail_date',[App\Http\Controllers\Account303Controller::class, 'account_303_detail_date'])->name('acc.account_303_detail_date');// 
    Route::match(['get','post'],'account_303_stam',[App\Http\Controllers\Account303Controller::class, 'account_303_stam'])->name('acc.account_303_stam');//  stamp IPD
    Route::match(['get','post'],'account_303_destroy_all',[App\Http\Controllers\Account303Controller::class, 'account_303_destroy_all'])->name('acc.account_303_destroy_all');// 
    Route::match(['get','post'],'account_303_search',[App\Http\Controllers\Account303Controller::class, 'account_303_search'])->name('acc.account_303_search');// 
    
    Route::match(['get','post'],'account_304_pull',[App\Http\Controllers\Account304Controller::class, 'account_304_pull'])->name('acc.account_304_pull');//
    Route::match(['get','post'],'account_304_checksit',[App\Http\Controllers\Account304Controller::class, 'account_304_checksit'])->name('acc.account_304_checksit');//
    Route::match(['get','post'],'account_304_pulldata',[App\Http\Controllers\Account304Controller::class, 'account_304_pulldata'])->name('acc.account_304_pulldata');//
    Route::match(['get','post'],'account_304_dash',[App\Http\Controllers\Account304Controller::class, 'account_304_dash'])->name('acc.account_304_dash');//
    Route::match(['get','post'],'account_304/{months}/{year}',[App\Http\Controllers\Account304Controller::class, 'account_304'])->name('acc.account_304');//
    Route::match(['get','post'],'account_304_detail/{months}/{year}',[App\Http\Controllers\Account304Controller::class, 'account_304_detail'])->name('acc.account_304_detail');//
    Route::match(['get','post'],'account_304_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account304Controller::class, 'account_304_detail_date'])->name('acc.account_304_detail_date');//
    Route::match(['get','post'],'account_304_stm/{months}/{year}',[App\Http\Controllers\Account304Controller::class, 'account_304_stm'])->name('acc.account_304_stm');//
    Route::match(['get','post'],'account_304_stmnull/{months}/{year}',[App\Http\Controllers\Account304Controller::class, 'account_304_stmnull'])->name('acc.account_304_stmnull');//
    Route::match(['get','post'],'account_304_stam',[App\Http\Controllers\Account304Controller::class, 'account_304_stam'])->name('acc.account_304_stam');//  stamp IPD
    Route::match(['get','post'],'account_304_sync',[App\Http\Controllers\Account304Controller::class, 'account_304_sync'])->name('acc.account_304_sync');//
    Route::match(['get','post'],'account_304_syncall',[App\Http\Controllers\Account304Controller::class, 'account_304_syncall'])->name('acc.account_304_syncall');//
    Route::match(['get','post'],'account_304_destroy_all',[App\Http\Controllers\Account304Controller::class, 'account_304_destroy_all'])->name('acc.account_304_destroy_all');// 
    Route::match(['get','post'],'account_304_yok/{months}/{year}',[App\Http\Controllers\Account304Controller::class, 'account_304_yok'])->name('acc.account_304_yok');//
    Route::match(['get','post'],'account_304_search',[App\Http\Controllers\Account304Controller::class, 'account_304_search'])->name('acc.account_304_search');// 

    Route::match(['get','post'],'account_307_pull',[App\Http\Controllers\Account307Controller::class, 'account_307_pull'])->name('acc.account_307_pull');//
    Route::match(['get','post'],'account_307_checksit',[App\Http\Controllers\Account307Controller::class, 'account_307_checksit'])->name('acc.account_307_checksit');//
    Route::match(['get','post'],'account_307_pull_m/{months}/{year}',[App\Http\Controllers\Account307Controller::class, 'account_307_pull_m'])->name('acc.account_307_pull_m');//
    Route::match(['get','post'],'account_307_pulldata',[App\Http\Controllers\Account307Controller::class, 'account_307_pulldata'])->name('acc.account_307_pulldata');//
    Route::match(['get','post'],'account_307_dash',[App\Http\Controllers\Account307Controller::class, 'account_307_dash'])->name('acc.account_307_dash');//
    Route::match(['get','post'],'account_307/{months}/{year}',[App\Http\Controllers\Account307Controller::class, 'account_307'])->name('acc.account_307');//
    Route::match(['get','post'],'account_307_detail/{months}/{year}',[App\Http\Controllers\Account307Controller::class, 'account_307_detail'])->name('acc.account_307_detail');//
    Route::match(['get','post'],'account_307_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account307Controller::class, 'account_307_detail_date'])->name('acc.account_307_detail_date');//
    Route::match(['get','post'],'account_307_stm/{months}/{year}',[App\Http\Controllers\Account307Controller::class, 'account_307_stm'])->name('acc.account_307_stm');//
    Route::match(['get','post'],'account_307_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account307Controller::class, 'account_307_stm_date'])->name('acc.account_307_stm_date');//
    Route::match(['get','post'],'account_307_stmnull/{months}/{year}',[App\Http\Controllers\Account307Controller::class, 'account_307_stmnull'])->name('acc.account_307_stmnull');//
    Route::match(['get','post'],'account_307_stam',[App\Http\Controllers\Account307Controller::class, 'account_307_stam'])->name('acc.account_307_stam');// 
    Route::match(['get','post'],'account_307_sync',[App\Http\Controllers\Account307Controller::class, 'account_307_sync'])->name('acc.account_307_sync');//
    Route::match(['get','post'],'account_307_syncall',[App\Http\Controllers\Account307Controller::class, 'account_307_syncall'])->name('acc.account_307_syncall');//
    Route::match(['get','post'],'account_307_destroy_all',[App\Http\Controllers\Account307Controller::class, 'account_307_destroy_all'])->name('acc.account_307_destroy_all');// 
    Route::match(['get','post'],'account_307_yok/{months}/{year}',[App\Http\Controllers\Account307Controller::class, 'account_307_yok'])->name('acc.account_307_yok');//
    Route::match(['get','post'],'account_307_search',[App\Http\Controllers\Account307Controller::class, 'account_307_search'])->name('acc.account_307_search');//

    Route::match(['get','post'],'account_308_pull',[App\Http\Controllers\Account308Controller::class, 'account_308_pull'])->name('acc.account_308_pull');//
    Route::match(['get','post'],'account_308_search',[App\Http\Controllers\Account308Controller::class, 'account_308_search'])->name('acc.account_308_search');//
    Route::match(['get','post'],'account_308_pulldata',[App\Http\Controllers\Account308Controller::class, 'account_308_pulldata'])->name('acc.account_308_pulldata');//
    Route::match(['get','post'],'account_308_dash',[App\Http\Controllers\Account308Controller::class, 'account_308_dash'])->name('acc.account_308_dash');//
    Route::match(['get','post'],'account_308/{months}/{year}',[App\Http\Controllers\Account308Controller::class, 'account_308'])->name('acc.account_308');//
    Route::match(['get','post'],'account_308_detail/{months}/{year}',[App\Http\Controllers\Account308Controller::class, 'account_308_detail'])->name('acc.account_308_detail');//
    Route::match(['get','post'],'account_308_stm/{months}/{year}',[App\Http\Controllers\Account308Controller::class, 'account_308_stm'])->name('acc.account_308_stm');//
    Route::match(['get','post'],'account_308_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account308Controller::class, 'account_308_detail_date'])->name('acc.account_308_detail_date');//
    Route::match(['get','post'],'account_308_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account308Controller::class, 'account_308_stm_date'])->name('acc.account_308_stm_date');//
    Route::match(['get','post'],'account_308_stmnull/{months}/{year}',[App\Http\Controllers\Account308Controller::class, 'account_308_stmnull'])->name('acc.account_308_stmnull');//
    Route::match(['get','post'],'account_308_stam',[App\Http\Controllers\Account308Controller::class, 'account_308_stam'])->name('acc.account_308_stam');//  stamp IPD
    Route::match(['get','post'],'account_308_syncall',[App\Http\Controllers\Account308Controller::class, 'account_308_syncall'])->name('acc.account_308_syncall');//
    Route::match(['get','post'],'account_308_destroy_all',[App\Http\Controllers\Account308Controller::class, 'account_308_destroy_all'])->name('acc.account_308_destroy_all');// 
    Route::match(['get','post'],'account_308_yok/{months}/{year}',[App\Http\Controllers\Account308Controller::class, 'account_308_yok'])->name('acc.account_308_yok');//
    Route::match(['get','post'],'account_308_checksit',[App\Http\Controllers\Account308Controller::class, 'account_308_checksit'])->name('acc.account_308_checksit');//

    Route::match(['get','post'],'account_309_pull',[App\Http\Controllers\Account309Controller::class, 'account_309_pull'])->name('acc.account_309_pull');//
    Route::match(['get','post'],'account_309_search',[App\Http\Controllers\Account309Controller::class, 'account_309_search'])->name('acc.account_309_search');//
    Route::match(['get','post'],'account_309_checksit',[App\Http\Controllers\Account309Controller::class, 'account_309_checksit'])->name('acc.account_309_checksit');//
    Route::match(['get','post'],'account_309_pulldata',[App\Http\Controllers\Account309Controller::class, 'account_309_pulldata'])->name('acc.account_309_pulldata');//
    Route::match(['get','post'],'account_309_dash',[App\Http\Controllers\Account309Controller::class, 'account_309_dash'])->name('acc.account_309_dash');//
    Route::match(['get','post'],'account_309/{months}/{year}',[App\Http\Controllers\Account309Controller::class, 'account_309'])->name('acc.account_309');//
    Route::match(['get','post'],'account_309_detail/{months}/{year}',[App\Http\Controllers\Account309Controller::class, 'account_309_detail'])->name('acc.account_309_detail');//
    Route::match(['get','post'],'account_309_stm/{months}/{year}',[App\Http\Controllers\Account309Controller::class, 'account_309_stm'])->name('acc.account_309_stm');//
    Route::match(['get','post'],'account_309_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account309Controller::class, 'account_309_detail_date'])->name('acc.account_309_detail_date');//
    Route::match(['get','post'],'account_309_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account309Controller::class, 'account_309_stm_date'])->name('acc.account_309_stm_date');//
    Route::match(['get','post'],'account_309_stmnull/{months}/{year}',[App\Http\Controllers\Account309Controller::class, 'account_309_stmnull'])->name('acc.account_309_stmnull');//
    Route::match(['get','post'],'account_309_stam',[App\Http\Controllers\Account309Controller::class, 'account_309_stam'])->name('acc.account_309_stam');//
    Route::match(['get','post'],'account_309_syncall',[App\Http\Controllers\Account309Controller::class, 'account_309_syncall'])->name('acc.account_309_syncall');//
    Route::match(['get','post'],'account_309_destroy_all',[App\Http\Controllers\Account309Controller::class, 'account_309_destroy_all'])->name('acc.account_309_destroy_all');// 

    Route::match(['get','post'],'account_310_dash',[App\Http\Controllers\Account310Controller::class, 'account_310_dash'])->name('acc.account_310_dash');//
    Route::match(['get','post'],'account_310_dashsub/{startdate}/{enddate}',[App\Http\Controllers\Account310Controller::class, 'account_310_dashsub'])->name('acc.account_310_dashsub');//
    Route::match(['get','post'],'account_310_dashsubdetail/{months}/{year}',[App\Http\Controllers\Account310Controller::class, 'account_310_dashsubdetail'])->name('acc.account_310_dashsubdetail');//
    Route::match(['get','post'],'account_310_detail_date',[App\Http\Controllers\Account310Controller::class, 'account_310_detail_date'])->name('acc.account_310_detail_date');//
    Route::match(['get','post'],'account_310_pull',[App\Http\Controllers\Account310Controller::class, 'account_310_pull'])->name('acc.account_310_pull');//
    Route::match(['get','post'],'account_310_checksit',[App\Http\Controllers\Account310Controller::class, 'account_310_checksit'])->name('acc.account_310_checksit');//
    Route::match(['get','post'],'account_310_pulldata',[App\Http\Controllers\Account310Controller::class, 'account_310_pulldata'])->name('acc.account_310_pulldata');//
    Route::match(['get','post'],'account_310/{months}/{year}',[App\Http\Controllers\Account310Controller::class, 'account_310'])->name('acc.account_310');//
    Route::match(['get','post'],'account_310_detail/{startdate}/{enddate}',[App\Http\Controllers\Account310Controller::class, 'account_310_detail'])->name('acc.account_310_detail');//
    Route::match(['get','post'],'account_310_stm/{months}/{year}',[App\Http\Controllers\Account310Controller::class, 'account_310_stm'])->name('acc.account_310_stm');//
    Route::match(['get','post'],'account_310_stmnull/{months}/{year}',[App\Http\Controllers\Account310Controller::class, 'account_310_stmnull'])->name('acc.account_310_stmnull');//
    Route::match(['get','post'],'account_310_stam',[App\Http\Controllers\Account310Controller::class, 'account_310_stam'])->name('acc.account_310_stam');//  
    Route::delete('acc_310_destroy',[App\Http\Controllers\Account310Controller::class, 'acc_310_destroy'])->name('acc.acc_310_destroy');//
    Route::match(['get','post'],'account_310_destroy_all',[App\Http\Controllers\Account310Controller::class, 'account_310_destroy_all'])->name('acc.account_310_destroy_all');//

    Route::match(['get','post'],'account_401_dash',[App\Http\Controllers\Account401Controller::class, 'account_401_dash'])->name('acc.account_401_dash');//
    Route::match(['get','post'],'account_401_pull',[App\Http\Controllers\Account401Controller::class, 'account_401_pull'])->name('acc.account_401_pull');//
    Route::match(['get','post'],'account_401_search',[App\Http\Controllers\Account401Controller::class, 'account_401_search'])->name('acc.account_401_search');//
    Route::match(['get','post'],'account_401_checksit',[App\Http\Controllers\Account401Controller::class, 'account_401_checksit'])->name('acc.account_401_checksit');//
    Route::match(['get','post'],'account_401_claim',[App\Http\Controllers\Account401Controller::class, 'account_401_claim'])->name('acc.account_401_claim');//
    Route::match(['get','post'],'account_401_claim_export',[App\Http\Controllers\Account401Controller::class, 'account_401_claim_export'])->name('acc.account_401_claim_export');//
    Route::match(['get','post'],'account_401_pulldata',[App\Http\Controllers\Account401Controller::class, 'account_401_pulldata'])->name('acc.account_401_pulldata');//
    Route::match(['get','post'],'account_401/{months}/{year}',[App\Http\Controllers\Account401Controller::class, 'account_401'])->name('acc.account_401');//
    Route::match(['get','post'],'account_401_detail/{months}/{year}',[App\Http\Controllers\Account401Controller::class, 'account_401_detail'])->name('acc.account_401_detail');//
    Route::match(['get','post'],'account_401_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account401Controller::class, 'account_401_detail_date'])->name('acc.account_401_detail_date');//
    Route::match(['get','post'],'account_401_stm/{months}/{year}',[App\Http\Controllers\Account401Controller::class, 'account_401_stm'])->name('acc.account_401_stm');//
    Route::match(['get','post'],'account_401_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account401Controller::class, 'account_401_stm_date'])->name('acc.account_401_stm_date');//
    Route::match(['get','post'],'account_401_stmnull/{months}/{year}',[App\Http\Controllers\Account401Controller::class, 'account_401_stmnull'])->name('acc.account_401_stmnull');//
    Route::match(['get','post'],'account_401_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account401Controller::class, 'account_401_stmnull_date'])->name('acc.account_401_stmnull_date');//
    Route::match(['get','post'],'account_401_stmnull_all/{months}/{year}',[App\Http\Controllers\Account401Controller::class, 'account_401_stmnull_all'])->name('acc.account_401_stmnull_all');//
    Route::match(['get','post'],'account_401_stam',[App\Http\Controllers\Account401Controller::class, 'account_401_stam'])->name('acc.account_401_stam');//  stamp OPD
    Route::match(['get','post'],'account_401_destroy_all',[App\Http\Controllers\Account401Controller::class, 'account_401_destroy_all'])->name('acc.account_401_destroy_all');//
    Route::match(['get','post'],'account_401_yok/{months}/{year}',[App\Http\Controllers\Account401Controller::class, 'account_401_yok'])->name('acc.account_401_yok');//

    Route::match(['get','post'],'account_402_dash',[App\Http\Controllers\Account402Controller::class, 'account_402_dash'])->name('acc.account_402_dash');//
    Route::match(['get','post'],'account_402_pull',[App\Http\Controllers\Account402Controller::class, 'account_402_pull'])->name('acc.account_402_pull');//
    Route::match(['get','post'],'account_402_search',[App\Http\Controllers\Account402Controller::class, 'account_402_search'])->name('acc.account_402_search');//
    Route::match(['get','post'],'account_402_pulldata',[App\Http\Controllers\Account402Controller::class, 'account_402_pulldata'])->name('acc.account_402_pulldata');//
    Route::match(['get','post'],'account_402/{months}/{year}',[App\Http\Controllers\Account402Controller::class, 'account_402'])->name('acc.account_402');//
    Route::match(['get','post'],'account_402_detail/{months}/{year}',[App\Http\Controllers\Account402Controller::class, 'account_402_detail'])->name('acc.account_402_detail');//
    Route::match(['get','post'],'account_402_stm/{months}/{year}',[App\Http\Controllers\Account402Controller::class, 'account_402_stm'])->name('acc.account_402_stm');//
    Route::match(['get','post'],'account_402_stmnull/{months}/{year}',[App\Http\Controllers\Account402Controller::class, 'account_402_stmnull'])->name('acc.account_402_stmnull');//
    Route::match(['get','post'],'account_402_stmnull_all/{months}/{year}',[App\Http\Controllers\Account402Controller::class, 'account_402_stmnull_all'])->name('acc.account_402_stmnull_all');//
    Route::match(['get','post'],'account_402_stam',[App\Http\Controllers\Account402Controller::class, 'account_402_stam'])->name('acc.account_402_stam');//
    Route::match(['get','post'],'account_402_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account402Controller::class, 'account_402_detail_date'])->name('acc.account_402_detail_date');//
    Route::match(['get','post'],'account_402_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account402Controller::class, 'account_402_stm_date'])->name('acc.account_402_stm_date');//
    Route::match(['get','post'],'account_402_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account402Controller::class, 'account_402_stmnull_date'])->name('acc.account_402_stmnull_date');//
    Route::match(['get','post'],'account_402_destroy_all',[App\Http\Controllers\Account402Controller::class, 'account_402_destroy_all'])->name('acc.account_402_destroy_all');//

    Route::match(['get','post'],'account_501_dash',[App\Http\Controllers\Account501Controller::class, 'account_501_dash'])->name('acc.account_501_dash');//  
    Route::match(['get','post'],'account_501_pull',[App\Http\Controllers\Account501Controller::class, 'account_501_pull'])->name('acc.account_501_pull');//
    Route::match(['get','post'],'account_501_search',[App\Http\Controllers\Account501Controller::class, 'account_501_search'])->name('acc.account_501_search');//
    Route::match(['get','post'],'account_501_pulldata',[App\Http\Controllers\Account501Controller::class, 'account_501_pulldata'])->name('acc.account_501_pulldata');// 
    Route::match(['get','post'],'account_501_stam',[App\Http\Controllers\Account501Controller::class, 'account_501_stam'])->name('acc.account_501_stam');// 
    Route::match(['get','post'],'account_501_detail/{months}/{year}',[App\Http\Controllers\Account501Controller::class, 'account_501_detail'])->name('acc.account_501_detail');//
    Route::match(['get','post'],'account_501_stm/{months}/{year}',[App\Http\Controllers\Account501Controller::class, 'account_501_stm'])->name('acc.account_501_stm');//
    Route::match(['get','post'],'account_501_stmnull/{months}/{year}',[App\Http\Controllers\Account501Controller::class, 'account_501_stmnull'])->name('acc.account_501_stmnull');//
    Route::match(['get','post'],'account_501_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account501Controller::class, 'account_501_detail_date'])->name('acc.account_501_detail_date');//
    Route::match(['get','post'],'account_501_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account501Controller::class, 'account_501_stm_date'])->name('acc.account_501_stm_date');//
    Route::match(['get','post'],'account_501_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account501Controller::class, 'account_501_stmnull_date'])->name('acc.account_501_stmnull_date');//
    Route::match(['get','post'],'account_501_destroy',[App\Http\Controllers\Account501Controller::class, 'account_501_destroy'])->name('acc.account_501_destroy');//
    Route::match(['get','post'],'account_501_yok/{months}/{year}',[App\Http\Controllers\Account501Controller::class, 'account_501_yok'])->name('acc.account_501_yok');//

    Route::match(['get','post'],'account_502_dash',[App\Http\Controllers\Account502Controller::class, 'account_502_dash'])->name('acc.account_502_dash');//  
    Route::match(['get','post'],'account_502_pull',[App\Http\Controllers\Account502Controller::class, 'account_502_pull'])->name('acc.account_502_pull');//
    Route::match(['get','post'],'account_502_search',[App\Http\Controllers\Account502Controller::class, 'account_502_search'])->name('acc.account_502_search');//
    Route::match(['get','post'],'account_502_pulldata',[App\Http\Controllers\Account502Controller::class, 'account_502_pulldata'])->name('acc.account_502_pulldata');// 
    Route::match(['get','post'],'account_502_stam',[App\Http\Controllers\Account502Controller::class, 'account_502_stam'])->name('acc.account_502_stam');// 
    Route::match(['get','post'],'account_502_detail/{months}/{year}',[App\Http\Controllers\Account502Controller::class, 'account_502_detail'])->name('acc.account_502_detail');//
    Route::match(['get','post'],'account_502_stm/{months}/{year}',[App\Http\Controllers\Account502Controller::class, 'account_502_stm'])->name('acc.account_502_stm');//
    Route::match(['get','post'],'account_502_stmnull/{months}/{year}',[App\Http\Controllers\Account502Controller::class, 'account_502_stmnull'])->name('acc.account_502_stmnull');//
    Route::match(['get','post'],'account_502_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account502Controller::class, 'account_502_detail_date'])->name('acc.account_502_detail_date');//
    Route::match(['get','post'],'account_502_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account502Controller::class, 'account_502_stm_date'])->name('acc.account_502_stm_date');//
    Route::match(['get','post'],'account_502_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account502Controller::class, 'account_502_stmnull_date'])->name('acc.account_502_stmnull_date');//
    Route::match(['get','post'],'account_502_destroy',[App\Http\Controllers\Account502Controller::class, 'account_502_destroy'])->name('acc.account_502_destroy');//

    Route::match(['get','post'],'account_503_dash',[App\Http\Controllers\Account503Controller::class, 'account_503_dash'])->name('acc.account_503_dash');//  
    Route::match(['get','post'],'account_503_pull',[App\Http\Controllers\Account503Controller::class, 'account_503_pull'])->name('acc.account_503_pull');//
    Route::match(['get','post'],'account_503_pulldata',[App\Http\Controllers\Account503Controller::class, 'account_503_pulldata'])->name('acc.account_503_pulldata');// 
    Route::match(['get','post'],'account_503_stam',[App\Http\Controllers\Account503Controller::class, 'account_503_stam'])->name('acc.account_503_stam');// 
    Route::match(['get','post'],'account_503_detail/{months}/{year}',[App\Http\Controllers\Account503Controller::class, 'account_503_detail'])->name('acc.account_503_detail');//
    Route::match(['get','post'],'account_503_stm/{months}/{year}',[App\Http\Controllers\Account503Controller::class, 'account_503_stm'])->name('acc.account_503_stm');//
    Route::match(['get','post'],'account_503_stmnull/{months}/{year}',[App\Http\Controllers\Account503Controller::class, 'account_503_stmnull'])->name('acc.account_503_stmnull');//
    Route::match(['get','post'],'account_503_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account503Controller::class, 'account_503_detail_date'])->name('acc.account_503_detail_date');//
    Route::match(['get','post'],'account_503_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account503Controller::class, 'account_503_stm_date'])->name('acc.account_503_stm_date');//
    Route::match(['get','post'],'account_503_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account503Controller::class, 'account_503_stmnull_date'])->name('acc.account_503_stmnull_date');//
    Route::match(['get','post'],'account_503_destroy',[App\Http\Controllers\Account503Controller::class, 'account_503_destroy'])->name('acc.account_503_destroy');//

    Route::match(['get','post'],'account_504_dash',[App\Http\Controllers\Account504Controller::class, 'account_504_dash'])->name('acc.account_504_dash');//  
    Route::match(['get','post'],'account_504_pull',[App\Http\Controllers\Account504Controller::class, 'account_504_pull'])->name('acc.account_504_pull');//
    Route::match(['get','post'],'account_504_pulldata',[App\Http\Controllers\Account504Controller::class, 'account_504_pulldata'])->name('acc.account_504_pulldata');// 
    Route::match(['get','post'],'account_504_stam',[App\Http\Controllers\Account504Controller::class, 'account_504_stam'])->name('acc.account_504_stam');// 
    Route::match(['get','post'],'account_504_detail/{months}/{year}',[App\Http\Controllers\Account504Controller::class, 'account_504_detail'])->name('acc.account_504_detail');//
    Route::match(['get','post'],'account_504_stm/{months}/{year}',[App\Http\Controllers\Account504Controller::class, 'account_504_stm'])->name('acc.account_504_stm');//
    Route::match(['get','post'],'account_504_stmnull/{months}/{year}',[App\Http\Controllers\Account504Controller::class, 'account_504_stmnull'])->name('acc.account_504_stmnull');//
    Route::match(['get','post'],'account_504_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account504Controller::class, 'account_504_detail_date'])->name('acc.account_504_detail_date');//
    Route::match(['get','post'],'account_504_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account504Controller::class, 'account_504_stm_date'])->name('acc.account_504_stm_date');//
    Route::match(['get','post'],'account_504_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account504Controller::class, 'account_504_stmnull_date'])->name('acc.account_504_stmnull_date');//
    Route::match(['get','post'],'account_504_destroy',[App\Http\Controllers\Account504Controller::class, 'account_504_destroy'])->name('acc.account_504_destroy');//

    Route::match(['get','post'],'account_602_dash',[App\Http\Controllers\Account602Controller::class, 'account_602_dash'])->name('acc.account_602_dash');//
    Route::match(['get','post'],'account_602_pull',[App\Http\Controllers\Account602Controller::class, 'account_602_pull'])->name('acc.account_602_pull');//
    Route::match(['get','post'],'account_602_pulldata',[App\Http\Controllers\Account602Controller::class, 'account_602_pulldata'])->name('acc.account_602_pulldata');//
    Route::match(['get','post'],'account_602/{months}/{year}',[App\Http\Controllers\Account602Controller::class, 'account_602'])->name('acc.account_602');//
    Route::match(['get','post'],'account_602_edit/{id}',[App\Http\Controllers\Account602Controller::class, 'account_602_edit'])->name('acc.account_602_edit');//
    Route::match(['get','post'],'account_602_update',[App\Http\Controllers\Account602Controller::class, 'account_602_update'])->name('acc.account_602_update');//
    Route::match(['get','post'],'account_602_detail/{months}/{year}',[App\Http\Controllers\Account602Controller::class, 'account_602_detail'])->name('acc.account_602_detail');//
    Route::match(['get','post'],'account_602_stm/{months}/{year}',[App\Http\Controllers\Account602Controller::class, 'account_602_stm'])->name('acc.account_602_stm');//
    Route::match(['get','post'],'account_602_stmnull/{months}/{year}',[App\Http\Controllers\Account602Controller::class, 'account_602_stmnull'])->name('acc.account_602_stmnull');//
    Route::match(['get','post'],'account_602_stmnull_all/{months}/{year}',[App\Http\Controllers\Account602Controller::class, 'account_602_stmnull_all'])->name('acc.account_602_stmnull_all');//
    Route::match(['get','post'],'account_602_stam',[App\Http\Controllers\Account602Controller::class, 'account_602_stam'])->name('acc.account_602_stam');//  stamp OPD
    Route::match(['get','post'],'account_602_syncall',[App\Http\Controllers\Account602Controller::class, 'account_602_syncall'])->name('acc.account_602_syncall');//
    Route::match(['get','post'],'account_602_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account602Controller::class, 'account_602_detail_date'])->name('acc.account_602_detail_date');//
    Route::match(['get','post'],'account_602_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account602Controller::class, 'account_602_stm_date'])->name('acc.account_602_stm_date');//
    Route::match(['get','post'],'account_602_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account602Controller::class, 'account_602_stmnull_date'])->name('acc.account_602_stmnull_date');//
    Route::match(['get','post'],'account_602_syncall_date',[App\Http\Controllers\Account602Controller::class, 'account_602_syncall_date'])->name('acc.account_602_syncall_date');//
    Route::match(['get','post'],'account_602_destroy',[App\Http\Controllers\Account602Controller::class, 'account_602_destroy'])->name('acc.account_602_destroy');//

    Route::match(['get','post'],'account_603_dash',[App\Http\Controllers\Account603Controller::class, 'account_603_dash'])->name('acc.account_603_dash');//
    Route::match(['get','post'],'account_603_pull',[App\Http\Controllers\Account603Controller::class, 'account_603_pull'])->name('acc.account_603_pull');//
    Route::match(['get','post'],'account_603_pulldata',[App\Http\Controllers\Account603Controller::class, 'account_603_pulldata'])->name('acc.account_603_pulldata');//
    Route::match(['get','post'],'account_603/{months}/{year}',[App\Http\Controllers\Account603Controller::class, 'account_603'])->name('acc.account_603');//
    Route::match(['get','post'],'account_603_edit/{id}',[App\Http\Controllers\Account603Controller::class, 'account_603_edit'])->name('acc.account_603_edit');//
    Route::match(['get','post'],'account_603_update',[App\Http\Controllers\Account603Controller::class, 'account_603_update'])->name('acc.account_603_update');//
    Route::match(['get','post'],'account_603_detail/{months}/{year}',[App\Http\Controllers\Account603Controller::class, 'account_603_detail'])->name('acc.account_603_detail');//
    Route::match(['get','post'],'account_603_stm/{months}/{year}',[App\Http\Controllers\Account603Controller::class, 'account_603_stm'])->name('acc.account_603_stm');//
    Route::match(['get','post'],'account_603_stmnull/{months}/{year}',[App\Http\Controllers\Account603Controller::class, 'account_603_stmnull'])->name('acc.account_603_stmnull');//
    Route::match(['get','post'],'account_603_stmnull_all/{months}/{year}',[App\Http\Controllers\Account603Controller::class, 'account_603_stmnull_all'])->name('acc.account_603_stmnull_all');//
    Route::match(['get','post'],'account_603_stam',[App\Http\Controllers\Account603Controller::class, 'account_603_stam'])->name('acc.account_603_stam');//  stamp PD
    Route::match(['get','post'],'account_603_syncall',[App\Http\Controllers\Account603Controller::class, 'account_603_syncall'])->name('acc.account_603_syncall');//
    Route::match(['get','post'],'account_603_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account603Controller::class, 'account_603_detail_date'])->name('acc.account_603_detail_date');//
    Route::match(['get','post'],'account_603_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account603Controller::class, 'account_603_stm_date'])->name('acc.account_603_stm_date');//
    Route::match(['get','post'],'account_603_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account603Controller::class, 'account_603_stmnull_date'])->name('acc.account_603_stmnull_date');//
    Route::match(['get','post'],'account_603_syncall_date',[App\Http\Controllers\Account603Controller::class, 'account_603_syncall_date'])->name('acc.account_603_syncall_date');//
    Route::match(['get','post'],'account_603_destroy',[App\Http\Controllers\Account603Controller::class, 'account_603_destroy'])->name('acc.account_603_destroy');//

    Route::match(['get','post'],'account_701_dash',[App\Http\Controllers\Account701Controller::class, 'account_701_dash'])->name('acc.account_701_dash');//  
    Route::match(['get','post'],'account_701_pull',[App\Http\Controllers\Account701Controller::class, 'account_701_pull'])->name('acc.account_701_pull');//
    Route::match(['get','post'],'account_701_pulldata',[App\Http\Controllers\Account701Controller::class, 'account_701_pulldata'])->name('acc.account_701_pulldata');// 
    Route::match(['get','post'],'account_701_stam',[App\Http\Controllers\Account701Controller::class, 'account_701_stam'])->name('acc.account_701_stam');// 
    Route::match(['get','post'],'account_701_detail/{months}/{year}',[App\Http\Controllers\Account701Controller::class, 'account_701_detail'])->name('acc.account_701_detail');//
    Route::match(['get','post'],'account_701_stm/{months}/{year}',[App\Http\Controllers\Account701Controller::class, 'account_701_stm'])->name('acc.account_701_stm');//
    Route::match(['get','post'],'account_701_stmnull/{months}/{year}',[App\Http\Controllers\Account701Controller::class, 'account_701_stmnull'])->name('acc.account_701_stmnull');//
    Route::match(['get','post'],'account_701_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account701Controller::class, 'account_701_detail_date'])->name('acc.account_701_detail_date');//
    Route::match(['get','post'],'account_701_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account701Controller::class, 'account_701_stm_date'])->name('acc.account_701_stm_date');//
    Route::match(['get','post'],'account_701_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account701Controller::class, 'account_701_stmnull_date'])->name('acc.account_701_stmnull_date');//

    Route::match(['get','post'],'account_702_dash',[App\Http\Controllers\Account702Controller::class, 'account_702_dash'])->name('acc.account_702_dash');//  
    Route::match(['get','post'],'account_702_pull',[App\Http\Controllers\Account702Controller::class, 'account_702_pull'])->name('acc.account_702_pull');//
    Route::match(['get','post'],'account_702_pulldata',[App\Http\Controllers\Account702Controller::class, 'account_702_pulldata'])->name('acc.account_702_pulldata');// 
    Route::match(['get','post'],'account_702_stam',[App\Http\Controllers\Account702Controller::class, 'account_702_stam'])->name('acc.account_702_stam');// 
    Route::match(['get','post'],'account_702_detail/{months}/{year}',[App\Http\Controllers\Account702Controller::class, 'account_702_detail'])->name('acc.account_702_detail');//
    Route::match(['get','post'],'account_702_stm/{months}/{year}',[App\Http\Controllers\Account702Controller::class, 'account_702_stm'])->name('acc.account_702_stm');//
    Route::match(['get','post'],'account_702_stmnull/{months}/{year}',[App\Http\Controllers\Account702Controller::class, 'account_702_stmnull'])->name('acc.account_702_stmnull');//
    Route::match(['get','post'],'account_702_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account702Controller::class, 'account_702_detail_date'])->name('acc.account_702_detail_date');//
    Route::match(['get','post'],'account_702_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account702Controller::class, 'account_702_stm_date'])->name('acc.account_702_stm_date');//
    Route::match(['get','post'],'account_702_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account702Controller::class, 'account_702_stmnull_date'])->name('acc.account_702_stmnull_date');//

    // Route::match(['get','post'],'account_703_dash',[App\Http\Controllers\Account703Controller::class, 'account_703_dash'])->name('acc.account_703_dash');//  
    // Route::match(['get','post'],'account_703_pull',[App\Http\Controllers\Account703Controller::class, 'account_703_pull'])->name('acc.account_703_pull');//
    // Route::match(['get','post'],'account_703_pulldata',[App\Http\Controllers\Account703Controller::class, 'account_703_pulldata'])->name('acc.account_703_pulldata');// 
    // Route::match(['get','post'],'account_703_stam',[App\Http\Controllers\Account703Controller::class, 'account_703_stam'])->name('acc.account_703_stam');// 
    // Route::match(['get','post'],'account_703_detail/{months}/{year}',[App\Http\Controllers\Account703Controller::class, 'account_703_detail'])->name('acc.account_703_detail');//
    // Route::match(['get','post'],'account_703_stm/{months}/{year}',[App\Http\Controllers\Account703Controller::class, 'account_703_stm'])->name('acc.account_703_stm');//
    // Route::match(['get','post'],'account_703_stmnull/{months}/{year}',[App\Http\Controllers\Account703Controller::class, 'account_703_stmnull'])->name('acc.account_703_stmnull');//
    // Route::match(['get','post'],'account_703_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account703Controller::class, 'account_703_detail_date'])->name('acc.account_703_detail_date');//
    // Route::match(['get','post'],'account_703_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account703Controller::class, 'account_703_stm_date'])->name('acc.account_703_stm_date');//
    // Route::match(['get','post'],'account_703_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account703Controller::class, 'account_703_stmnull_date'])->name('acc.account_703_stmnull_date');//

    Route::match(['get','post'],'account_704_dash',[App\Http\Controllers\Account704Controller::class, 'account_704_dash'])->name('acc.account_704_dash');//  
    Route::match(['get','post'],'account_704_pull',[App\Http\Controllers\Account704Controller::class, 'account_704_pull'])->name('acc.account_704_pull');//
    Route::match(['get','post'],'account_704_pulldata',[App\Http\Controllers\Account704Controller::class, 'account_704_pulldata'])->name('acc.account_704_pulldata');// 
    Route::match(['get','post'],'account_704_stam',[App\Http\Controllers\Account704Controller::class, 'account_704_stam'])->name('acc.account_704_stam');// 
    Route::match(['get','post'],'account_704_detail/{months}/{year}',[App\Http\Controllers\Account704Controller::class, 'account_704_detail'])->name('acc.account_704_detail');//
    Route::match(['get','post'],'account_704_stm/{months}/{year}',[App\Http\Controllers\Account704Controller::class, 'account_704_stm'])->name('acc.account_704_stm');//
    Route::match(['get','post'],'account_704_stmnull/{months}/{year}',[App\Http\Controllers\Account704Controller::class, 'account_704_stmnull'])->name('acc.account_704_stmnull');//
    Route::match(['get','post'],'account_704_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account704Controller::class, 'account_704_detail_date'])->name('acc.account_704_detail_date');//
    Route::match(['get','post'],'account_704_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account704Controller::class, 'account_704_stm_date'])->name('acc.account_704_stm_date');//
    Route::match(['get','post'],'account_704_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account704Controller::class, 'account_704_stmnull_date'])->name('acc.account_704_stmnull_date');//
    Route::match(['get','post'],'account_704_destroy',[App\Http\Controllers\Account704Controller::class, 'account_704_destroy'])->name('acc.account_704_destroy');//

    Route::match(['get','post'],'account_2166_pull',[App\Http\Controllers\AccountPKController::class, 'account_2166_pull'])->name('acc.account_2166_pull');//
    Route::match(['get','post'],'account_2166_pulldata',[App\Http\Controllers\AccountPKController::class, 'account_2166_pulldata'])->name('acc.account_2166_pulldata');//
    Route::match(['get','post'],'account_2166_dash',[App\Http\Controllers\AccountPKController::class, 'account_2166_dash'])->name('acc.account_2166_dash');//
    Route::match(['get','post'],'account_2166/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_2166'])->name('acc.account_2166');//
    Route::match(['get','post'],'account_2166_detail/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_2166_detail'])->name('acc.account_2166_detail');//
    Route::match(['get','post'],'account_2166_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_2166_stm'])->name('acc.account_2166_stm');//
    Route::match(['get','post'],'account_2166_stmnull/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_2166_stmnull'])->name('acc.account_2166_stmnull');//
    Route::match(['get','post'],'account_2166_stam',[App\Http\Controllers\AccountPKController::class, 'account_2166_stam'])->name('acc.account_2166_stam');//  stamp IPD

    Route::match(['get','post'],'account_3099_pull',[App\Http\Controllers\AccountPKController::class, 'account_3099_pull'])->name('acc.account_3099_pull');//
    Route::match(['get','post'],'account_3099_pulldata',[App\Http\Controllers\AccountPKController::class, 'account_3099_pulldata'])->name('acc.account_3099_pulldata');//
    Route::match(['get','post'],'account_3099_dash',[App\Http\Controllers\AccountPKController::class, 'account_3099_dash'])->name('acc.account_3099_dash');//
    Route::match(['get','post'],'account_3099/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_3099'])->name('acc.account_3099');//
    Route::match(['get','post'],'account_3099_detail/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_3099_detail'])->name('acc.account_3099_detail');//
    Route::match(['get','post'],'account_3099_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_3099_stm'])->name('acc.account_3099_stm');//
    Route::match(['get','post'],'account_3099_stmnull/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_3099_stmnull'])->name('acc.account_3099_stmnull');//
    Route::match(['get','post'],'account_3099_stam',[App\Http\Controllers\AccountPKController::class, 'account_3099_stam'])->name('acc.account_3099_stam');//  stamp IPD

    Route::match(['get','post'],'account_8011_pull',[App\Http\Controllers\AccountPKController::class, 'account_8011_pull'])->name('acc.account_8011_pull');//
    Route::match(['get','post'],'account_8011_pulldata',[App\Http\Controllers\AccountPKController::class, 'account_8011_pulldata'])->name('acc.account_8011_pulldata');//
    Route::match(['get','post'],'account_8011_dash',[App\Http\Controllers\AccountPKController::class, 'account_8011_dash'])->name('acc.account_8011_dash');//
    Route::match(['get','post'],'account_8011/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_8011'])->name('acc.account_8011');//
    Route::match(['get','post'],'account_8011_detail/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_8011_detail'])->name('acc.account_8011_detail');//
    Route::match(['get','post'],'account_8011_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_8011_stm'])->name('acc.account_8011_stm');//
    Route::match(['get','post'],'account_8011_stmnull/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_8011_stmnull'])->name('acc.account_8011_stmnull');//
    Route::match(['get','post'],'account_8011_stam',[App\Http\Controllers\AccountPKController::class, 'account_8011_stam'])->name('acc.account_8011_stam');//  stamp IPD

    // Route::match(['get','post'],'account_4011_pull',[App\Http\Controllers\AccountPKController::class, 'account_4011_pull'])->name('acc.account_4011_pull');//
    // Route::match(['get','post'],'account_4011_pulldata',[App\Http\Controllers\AccountPKController::class, 'account_4011_pulldata'])->name('acc.account_4011_pulldata');//
    // Route::match(['get','post'],'account_4011_dash',[App\Http\Controllers\AccountPKController::class, 'account_4011_dash'])->name('acc.account_4011_dash');//
    // Route::match(['get','post'],'account_4011/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_4011'])->name('acc.account_4011');//
    // Route::match(['get','post'],'account_4011_detail/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_4011_detail'])->name('acc.account_4011_detail');//
    // Route::match(['get','post'],'account_4011_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_4011_stm'])->name('acc.account_4011_stm');//
    // Route::match(['get','post'],'account_4011_stmnull/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_4011_stmnull'])->name('acc.account_4011_stmnull');//
    // Route::match(['get','post'],'account_4011_stam',[App\Http\Controllers\AccountPKController::class, 'account_4011_stam'])->name('acc.account_4011_stam');//  stamp OPD
    // Route::match(['get','post'],'account_4011_destroy',[App\Http\Controllers\AccountPKController::class, 'account_4011_destroy'])->name('acc.account_4011_destroy');//

    Route::match(['get','post'],'account_801_dash',[App\Http\Controllers\Account801Controller::class, 'account_801_dash'])->name('acc.account_801_dash');//
    Route::match(['get','post'],'account_801_pull',[App\Http\Controllers\Account801Controller::class, 'account_801_pull'])->name('acc.account_801_pull');//
    Route::match(['get','post'],'account_801_search',[App\Http\Controllers\Account801Controller::class, 'account_801_search'])->name('acc.account_801_search');//
    Route::match(['get','post'],'account_801_pulldata',[App\Http\Controllers\Account801Controller::class, 'account_801_pulldata'])->name('acc.account_801_pulldata');// 
    Route::match(['get','post'],'account_801_detail/{months}/{year}',[App\Http\Controllers\Account801Controller::class, 'account_801_detail'])->name('acc.account_801_detail');//
    Route::match(['get','post'],'account_801_stm/{months}/{year}',[App\Http\Controllers\Account801Controller::class, 'account_801_stm'])->name('acc.account_801_stm');//
    Route::match(['get','post'],'account_801_stmnull/{months}/{year}',[App\Http\Controllers\Account801Controller::class, 'account_801_stmnull'])->name('acc.account_801_stmnull');// 
    Route::match(['get','post'],'account_801_stam',[App\Http\Controllers\Account801Controller::class, 'account_801_stam'])->name('acc.account_801_stam');//  stamp OPD
    Route::match(['get','post'],'account_801_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account801Controller::class, 'account_801_detail_date'])->name('acc.account_801_detail_date');//
    Route::match(['get','post'],'account_801_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account801Controller::class, 'account_801_stm_date'])->name('acc.account_801_stm_date');//
    Route::match(['get','post'],'account_801_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account801Controller::class, 'account_801_stmnull_date'])->name('acc.account_801_stmnull_date');// 
    Route::match(['get','post'],'account_801_destroy',[App\Http\Controllers\Account801Controller::class, 'account_801_destroy'])->name('acc.account_801_destroy');//
    // Route::match(['get','post'],'account_801_dash',[App\Http\Controllers\AccountPKController::class, 'account_801_dash'])->name('acc.account_801_dash');//
    // Route::match(['get','post'],'account_801_pull',[App\Http\Controllers\AccountPKController::class, 'account_801_pull'])->name('acc.account_801_pull');//
    // Route::match(['get','post'],'account_801_pulldata',[App\Http\Controllers\AccountPKController::class, 'account_801_pulldata'])->name('acc.account_801_pulldata');//
    // Route::match(['get','post'],'account_801/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_801'])->name('acc.account_801');//
    // Route::match(['get','post'],'account_801_detail/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_801_detail'])->name('acc.account_801_detail');//
    // Route::match(['get','post'],'account_801_stm/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_801_stm'])->name('acc.account_801_stm');//
    // Route::match(['get','post'],'account_801_stmnull/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_801_stmnull'])->name('acc.account_801_stmnull');//
    // Route::match(['get','post'],'account_801_stmnull_all/{months}/{year}',[App\Http\Controllers\AccountPKController::class, 'account_801_stmnull_all'])->name('acc.account_801_stmnull_all');//
    // Route::match(['get','post'],'account_801_stam',[App\Http\Controllers\AccountPKController::class, 'account_801_stam'])->name('acc.account_801_stam');//  stamp OPD

    Route::match(['get','post'],'account_802_dash',[App\Http\Controllers\Account802Controller::class, 'account_802_dash'])->name('acc.account_802_dash');//
    Route::match(['get','post'],'account_802_pull',[App\Http\Controllers\Account802Controller::class, 'account_802_pull'])->name('acc.account_802_pull');//
    Route::match(['get','post'],'account_802_search',[App\Http\Controllers\Account802Controller::class, 'account_802_search'])->name('acc.account_802_search');//
    Route::match(['get','post'],'account_802_pulldata',[App\Http\Controllers\Account802Controller::class, 'account_802_pulldata'])->name('acc.account_802_pulldata');//
    Route::match(['get','post'],'account_802/{months}/{year}',[App\Http\Controllers\Account802Controller::class, 'account_802'])->name('acc.account_802');//
    Route::match(['get','post'],'account_802_detail/{months}/{year}',[App\Http\Controllers\Account802Controller::class, 'account_802_detail'])->name('acc.account_802_detail');//
    Route::match(['get','post'],'account_802_stm/{months}/{year}',[App\Http\Controllers\Account802Controller::class, 'account_802_stm'])->name('acc.account_802_stm');//
    Route::match(['get','post'],'account_802_stmnull/{months}/{year}',[App\Http\Controllers\Account802Controller::class, 'account_802_stmnull'])->name('acc.account_802_stmnull');//
    Route::match(['get','post'],'account_802_stmnull_all/{months}/{year}',[App\Http\Controllers\Account802Controller::class, 'account_802_stmnull_all'])->name('acc.account_802_stmnull_all');//
    Route::match(['get','post'],'account_802_stam',[App\Http\Controllers\Account802Controller::class, 'account_802_stam'])->name('acc.account_802_stam');//
    Route::match(['get','post'],'account_802_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account802Controller::class, 'account_802_detail_date'])->name('acc.account_802_detail_date');//
    Route::match(['get','post'],'account_802_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account802Controller::class, 'account_802_stm_date'])->name('acc.account_802_stm_date');//
    Route::match(['get','post'],'account_802_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account802Controller::class, 'account_802_stmnull_date'])->name('acc.account_802_stmnull_date');// 
    Route::match(['get','post'],'account_802_destroy',[App\Http\Controllers\Account802Controller::class, 'account_802_destroy'])->name('acc.account_802_destroy');//

    Route::match(['get','post'],'account_803_dash',[App\Http\Controllers\Account803Controller::class, 'account_803_dash'])->name('acc.account_803_dash');//
    Route::match(['get','post'],'account_803_pull',[App\Http\Controllers\Account803Controller::class, 'account_803_pull'])->name('acc.account_803_pull');//
    Route::match(['get','post'],'account_803_search',[App\Http\Controllers\Account803Controller::class, 'account_803_search'])->name('acc.account_803_search');//
    Route::match(['get','post'],'account_803_checksit',[App\Http\Controllers\Account803Controller::class, 'account_803_checksit'])->name('acc.account_803_checksit');//
    Route::match(['get','post'],'account_803_pulldata',[App\Http\Controllers\Account803Controller::class, 'account_803_pulldata'])->name('acc.account_803_pulldata');// 
    Route::match(['get','post'],'account_803_detail/{months}/{year}',[App\Http\Controllers\Account803Controller::class, 'account_803_detail'])->name('acc.account_803_detail');//
    Route::match(['get','post'],'account_803_stm/{months}/{year}',[App\Http\Controllers\Account803Controller::class, 'account_803_stm'])->name('acc.account_803_stm');//
    Route::match(['get','post'],'account_803_stmnull/{months}/{year}',[App\Http\Controllers\Account803Controller::class, 'account_803_stmnull'])->name('acc.account_803_stmnull');// 
    Route::match(['get','post'],'account_803_stam',[App\Http\Controllers\Account803Controller::class, 'account_803_stam'])->name('acc.account_803_stam');//
    Route::match(['get','post'],'account_803_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account803Controller::class, 'account_803_detail_date'])->name('acc.account_803_detail_date');//
    Route::match(['get','post'],'account_803_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account803Controller::class, 'account_803_stm_date'])->name('acc.account_803_stm_date');//
    Route::match(['get','post'],'account_803_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account803Controller::class, 'account_803_stmnull_date'])->name('acc.account_803_stmnull_date');// 
    Route::match(['get','post'],'account_803_destroy',[App\Http\Controllers\Account803Controller::class, 'account_803_destroy'])->name('acc.account_803_destroy');//

    Route::match(['get','post'],'account_804_dash',[App\Http\Controllers\Account804Controller::class, 'account_804_dash'])->name('acc.account_804_dash');//
    Route::match(['get','post'],'account_804_pull',[App\Http\Controllers\Account804Controller::class, 'account_804_pull'])->name('acc.account_804_pull');//
    Route::match(['get','post'],'account_804_search',[App\Http\Controllers\Account804Controller::class, 'account_804_search'])->name('acc.account_804_search');//
    Route::match(['get','post'],'account_804_checksit',[App\Http\Controllers\Account804Controller::class, 'account_804_checksit'])->name('acc.account_804_checksit');//
    Route::match(['get','post'],'account_804_pulldata',[App\Http\Controllers\Account804Controller::class, 'account_804_pulldata'])->name('acc.account_804_pulldata');// 
    Route::match(['get','post'],'account_804_detail/{months}/{year}',[App\Http\Controllers\Account804Controller::class, 'account_804_detail'])->name('acc.account_804_detail');//
    Route::match(['get','post'],'account_804_stm/{months}/{year}',[App\Http\Controllers\Account804Controller::class, 'account_804_stm'])->name('acc.account_804_stm');//
    Route::match(['get','post'],'account_804_stmnull/{months}/{year}',[App\Http\Controllers\Account804Controller::class, 'account_804_stmnull'])->name('acc.account_804_stmnull');// 
    Route::match(['get','post'],'account_804_stam',[App\Http\Controllers\Account804Controller::class, 'account_804_stam'])->name('acc.account_804_stam');//
    Route::match(['get','post'],'account_804_detail_date/{startdate}/{enddate}',[App\Http\Controllers\Account804Controller::class, 'account_804_detail_date'])->name('acc.account_804_detail_date');//
    Route::match(['get','post'],'account_804_stm_date/{startdate}/{enddate}',[App\Http\Controllers\Account804Controller::class, 'account_804_stm_date'])->name('acc.account_804_stm_date');//
    Route::match(['get','post'],'account_804_stmnull_date/{startdate}/{enddate}',[App\Http\Controllers\Account804Controller::class, 'account_804_stmnull_date'])->name('acc.account_804_stmnull_date');// 
    Route::match(['get','post'],'account_804_destroy',[App\Http\Controllers\Account804Controller::class, 'account_804_destroy'])->name('acc.account_804_destroy');//

    Route::match(['get','post'],'check_auth',[App\Http\Controllers\NeweclaimController::class, 'check_auth'])->name('api.check_auth');//
    Route::match(['get','post'],'check_authapi',[App\Http\Controllers\NeweclaimController::class, 'check_authapi'])->name('api.check_authapi');//

 

    Route::match(['get','post'],'acc_stm',[App\Http\Controllers\AccountPKController::class, 'acc_stm'])->name('acc.acc_stm');//
    Route::match(['get','post'],'acc_repstm',[App\Http\Controllers\AccountPKController::class, 'acc_repstm'])->name('acc.acc_repstm');//

    Route::match(['get','post'],'acc_setting',[App\Http\Controllers\AccountPKController::class, 'acc_setting'])->name('acc.acc_setting');//
    Route::match(['get','post'],'acc_setting_edit/{id}',[App\Http\Controllers\AccountPKController::class, 'acc_setting_edit'])->name('acc.acc_setting_edit');//
    Route::match(['get','post'],'acc_setting_save',[App\Http\Controllers\AccountPKController::class, 'acc_setting_save'])->name('acc.acc_setting_save');//
    Route::match(['get','post'],'acc_setting_update',[App\Http\Controllers\AccountPKController::class, 'acc_setting_update'])->name('acc.acc_setting_update');//


    Route::match(['get','post'],'acc_settingpang',[App\Http\Controllers\AccountsettingController::class, 'acc_settingpang'])->name('acc.acc_settingpang');//
    Route::match(['get','post'],'acc_settingpang_edit/{id}',[App\Http\Controllers\AccountsettingController::class, 'acc_settingpang_edit'])->name('acc.acc_settingpang_edit');//
    Route::match(['get','post'],'acc_settingpang_save',[App\Http\Controllers\AccountsettingController::class, 'acc_settingpang_save'])->name('acc.acc_settingpang_save');//
    Route::match(['get','post'],'acc_settingpang_update',[App\Http\Controllers\AccountsettingController::class, 'acc_settingpang_update'])->name('acc.acc_settingpang_update');//
    Route::match(['get','post'],'acc_settingpang_destroy/{id}',[App\Http\Controllers\AccountsettingController::class, 'acc_settingpang_destroy'])->name('acc.acc_settingpang_destroy');//

    Route::match(['get','post'],'acc_settingpang_detail/{id}',[App\Http\Controllers\AccountsettingController::class, 'acc_settingpang_detail'])->name('acc.acc_settingpang_detail');//    

    Route::match(['get','post'],'acc_pang_addtype/{id}',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addtype'])->name('acc.acc_pang_addtype');//
    Route::match(['get','post'],'acc_pang_addtypesave',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addtypesave'])->name('acc.acc_pang_addtypesave');//
    Route::match(['get','post'],'sub_destroy/{id}',[App\Http\Controllers\AccountsettingController::class, 'sub_destroy'])->name('acc.sub_destroy');//

    Route::match(['get','post'],'acc_pang_addicode/{id}',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addicode'])->name('acc.acc_pang_addicode');//
    Route::match(['get','post'],'acc_pang_addicodesave',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addicodesave'])->name('acc.acc_pang_addicodesave');//
    Route::match(['get','post'],'subicode_destroy/{id}',[App\Http\Controllers\AccountsettingController::class, 'subicode_destroy'])->name('acc.subicode_destroy');//
    Route::match(['get','post'],'acc_pang_addnoicodesave',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addnoicodesave'])->name('acc.acc_pang_addnoicodesave');//

    Route::match(['get','post'],'acc_pang_addhospmain/{id}',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addhospmain'])->name('acc.acc_pang_addhospmain');//
    Route::match(['get','post'],'acc_pang_addhospmainsave',[App\Http\Controllers\AccountsettingController::class, 'acc_pang_addhospmainsave'])->name('acc.acc_pang_addhospmainsave');//
    Route::match(['get','post'],'hospmain_destroy/{id}',[App\Http\Controllers\AccountsettingController::class, 'hospmain_destroy'])->name('acc.hospmain_destroy');//

    Route::match(['get','post'],'aset_trimart',[App\Http\Controllers\AccountPKController::class, 'aset_trimart'])->name('acc.aset_trimart');//
    Route::match(['get','post'],'aset_trimart_edit/{id}',[App\Http\Controllers\AccountPKController::class, 'aset_trimart_edit'])->name('acc.aset_trimart_edit');//
    Route::match(['get','post'],'aset_trimart_save',[App\Http\Controllers\AccountPKController::class, 'aset_trimart_save'])->name('acc.aset_trimart_save');//
    Route::match(['get','post'],'aset_trimart_update',[App\Http\Controllers\AccountPKController::class, 'aset_trimart_update'])->name('acc.aset_trimart_update');//

    Route::match(['get','post'],'book_inside_manage',[App\Http\Controllers\BooktrollController::class, 'book_inside_manage'])->name('pk.book_inside_manage');//
    Route::match(['get','post'],'book_inside_manage_save',[App\Http\Controllers\BooktrollController::class, 'book_inside_manage_save'])->name('pk.book_inside_manage_save');//
    Route::match(['get','post'],'book_inside_manage_edit/{id}',[App\Http\Controllers\BooktrollController::class, 'book_inside_manage_edit'])->name('pk.book_inside_manage_edit');//
    Route::match(['get','post'],'book_inside_manage_update',[App\Http\Controllers\BooktrollController::class, 'book_inside_manage_update'])->name('pk.book_inside_manage_update');//
    Route::match(['get','post'],'book_inside_manage_destroy/{id}',[App\Http\Controllers\BooktrollController::class, 'book_inside_manage_destroy'])->name('pk.book_inside_manage_destroy');//

     // **************************** PPFS 2566  ***********************
     Route::match(['get','post'],'anc_14001',[App\Http\Controllers\PPFSController::class, 'anc_14001'])->name('claim.anc_14001');//
     Route::match(['get','post'],'anc_14001_pull',[App\Http\Controllers\PPFSController::class, 'anc_14001_pull'])->name('claim.anc_14001_pull');//
     Route::match(['get','post'],'anc_14001_pull2',[App\Http\Controllers\PPFSController::class, 'anc_14001_pull2'])->name('claim.anc_14001_pull2');//

      // **************************** Anc  ***********************
      Route::match(['get','post'],'prenatal_care_db',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_db'])->name('anc.prenatal_care_db');//
      Route::match(['get','post'],'prenatal_care',[App\Http\Controllers\PediaricsController::class, 'prenatal_care'])->name('anc.prenatal_care');//
      Route::match(['get','post'],'prenatal_care_doctor/{doctor}/{year}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_doctor'])->name('anc.prenatal_care_doctor');//
      Route::match(['get','post'],'prenatal_care_pdx/{pdx}/{doctor}/{year}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_pdx'])->name('anc.prenatal_care_pdx');//
      Route::match(['get','post'],'prenatal_care_an/{pdx}/{doctor}/{year}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_an'])->name('anc.prenatal_care_an');//
      // Route::match(['get','post'],'prenatal_care_an/{an}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_an'])->name('anc.prenatal_care_an');//
      Route::match(['get','post'],'prenatal_care_sub/{ward}/{startdate}/{enddate}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_sub'])->name('anc.prenatal_care_sub');//
      Route::match(['get','post'],'prenatal_care_bar',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_bar'])->name('anc.prenatal_care_bar');//
      Route::match(['get','post'],'prenatal_care_andiag/{an}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_andiag'])->name('anc.prenatal_care_andiag');//
      Route::match(['get','post'],'prenatal_care_ankph/{an}',[App\Http\Controllers\PediaricsController::class, 'prenatal_care_ankph'])->name('anc.prenatal_care_ankph');//






     Route::match(['get','post'],'anc_dent',[App\Http\Controllers\AncController::class, 'anc_dent'])->name('claim.anc_dent');//
     Route::match(['get','post'],'anc_dent_search',[App\Http\Controllers\AncController::class, 'anc_dent_search'])->name('claim.anc_dent_search');//
     Route::match(['get','post'],'anc_dent_send16',[App\Http\Controllers\AncController::class, 'anc_dent_send16'])->name('claim.anc_dent_send16');//
     Route::match(['get','post'],'anc_dent_zip',[App\Http\Controllers\AncController::class, 'anc_dent_zip'])->name('claim.anc_dent_zip');//

     Route::match(['get','post'],'anc_dent_pull',[App\Http\Controllers\AncController::class, 'anc_dent_pull'])->name('claim.anc_dent_pull');//
     Route::match(['get','post'],'anc_dent_export',[App\Http\Controllers\AncController::class, 'anc_dent_export'])->name('claim.anc_dent_export');//


     Route::match(['get','post'],'anc_dent_insert',[App\Http\Controllers\AncController::class, 'anc_dent_insert'])->name('claim.anc_dent_insert');//

     Route::match(['get','post'],'anc_dent_searchvn',[App\Http\Controllers\AncController::class, 'anc_dent_searchvn'])->name('claim.anc_dent_searchvn');//
     Route::match(['get','post'],'anc_dent_sendvn',[App\Http\Controllers\AncController::class, 'anc_dent_sendvn'])->name('claim.anc_dent_sendvn');//
     Route::match(['get','post'],'anc_dent_zipvn',[App\Http\Controllers\AncController::class, 'anc_dent_zipvn'])->name('claim.anc_dent_zipvn');//

  // **************************** เงินเดือน ***********************
  Route::match(['get','post'],'account_money_hosrep',[App\Http\Controllers\AccountController::class, 'account_money_hosrep'])->name('acc.account_money_hosrep');//
  Route::match(['get','post'],'account_money_rep/{id}',[App\Http\Controllers\AccountController::class, 'account_money_rep'])->name('acc.account_money_rep');//
  Route::match(['get','post'],'account_money_personsave',[App\Http\Controllers\AccountController::class, 'account_money_personsave'])->name('acc.account_money_personsave');//
  Route::match(['get','post'],'account_money_copysave',[App\Http\Controllers\AccountController::class, 'account_money_copysave'])->name('acc.account_money_copysave');//
  Route::match(['get','post'],'account_money_personupdate',[App\Http\Controllers\AccountController::class, 'account_money_personupdate'])->name('acc.account_money_personupdate');//
  Route::match(['get','post'],'account_money_personcheckupdate',[App\Http\Controllers\AccountController::class, 'account_money_personcheckupdate'])->name('acc.account_money_personcheckupdate');//
  Route::match(['get','post'],'account_money_pay_onlyupdate',[App\Http\Controllers\AccountController::class, 'account_money_pay_onlyupdate'])->name('acc.account_money_pay_onlyupdate');//



  Route::match(['get','post'],'account_money_personedit/{id}',[App\Http\Controllers\AccountController::class, 'account_money_personedit'])->name('acc.account_money_personedit');//
  Route::match(['get','post'],'changstatus/{id}',[App\Http\Controllers\AccountController::class, 'changstatus'])->name('acc.changstatus');//
  Route::match(['get','post'],'account_money_repupdate',[App\Http\Controllers\AccountController::class, 'account_money_repupdate'])->name('acc.account_money_repupdate');//

  Route::match(['get','post'],'account_money_hospay',[App\Http\Controllers\AccountController::class, 'account_money_hospay'])->name('acc.account_money_hospay');//
  Route::match(['get','post'],'account_money_pay/{id}',[App\Http\Controllers\AccountController::class, 'account_money_pay'])->name('acc.account_money_pay');//
  Route::match(['get','post'],'account_money_payedit/{id}',[App\Http\Controllers\AccountController::class, 'account_money_payedit'])->name('acc.account_money_payedit');//
  Route::match(['get','post'],'account_money_payupdate',[App\Http\Controllers\AccountController::class, 'account_money_payupdate'])->name('acc.account_money_payupdate');//
  Route::match(['get','post'],'account_money_paycheckupdate',[App\Http\Controllers\AccountController::class, 'account_money_paycheckupdate'])->name('acc.account_money_paycheckupdate');//

  Route::match(['get','post'],'account_money_monthlydebthos',[App\Http\Controllers\AccountController::class, 'account_money_monthlydebthos'])->name('acc.account_money_monthlydebthos');//
  Route::match(['get','post'],'account_money_monthlydebt/{id}',[App\Http\Controllers\AccountController::class, 'account_money_monthlydebt'])->name('acc.account_money_monthlydebt');//
  Route::match(['get','post'],'account_money_monthlydebtedit/{id}',[App\Http\Controllers\AccountController::class, 'account_money_monthlydebtedit'])->name('acc.account_money_monthlydebtedit');//
  Route::match(['get','post'],'account_money_monthlydebtupdate',[App\Http\Controllers\AccountController::class, 'account_money_monthlydebtupdate'])->name('acc.account_money_monthlydebtupdate');//

  Route::match(['get','post'],'account_money_monthlydebt_personsave',[App\Http\Controllers\AccountController::class, 'account_money_monthlydebt_personsave'])->name('acc.account_money_monthlydebt_personsave');//
  Route::match(['get','post'],'account_money_monthlydebt_copypersonsave',[App\Http\Controllers\AccountController::class, 'account_money_monthlydebt_copypersonsave'])->name('acc.account_money_monthlydebt_copypersonsave');//








  Route::match(['get','post'],'account_money_setting',[App\Http\Controllers\AccountController::class, 'account_money_setting'])->name('acc.account_money_setting');//
  Route::match(['get','post'],'account_money_settingsave',[App\Http\Controllers\AccountController::class, 'account_money_settingsave'])->name('acc.account_money_settingsave');//
  Route::match(['get','post'],'account_money_settingedit/{id}',[App\Http\Controllers\AccountController::class, 'account_money_settingedit'])->name('acc.account_money_settingedit');//
  Route::match(['get','post'],'account_money_settingupdate',[App\Http\Controllers\AccountController::class, 'account_money_settingupdate'])->name('acc.account_money_settingupdate');//
  Route::delete('account_money_destroy/{id}',[App\Http\Controllers\AccountController::class, 'account_money_destroy'])->name('acc.account_money_destroy');//

  Route::match(['get','post'],'account_money_creditorsave',[App\Http\Controllers\AccountController::class, 'account_money_creditorsave'])->name('acc.account_money_creditorsave');//
  Route::match(['get','post'],'account_money_creditoredit/{id}',[App\Http\Controllers\AccountController::class, 'account_money_creditoredit'])->name('acc.account_money_creditoredit');//
  Route::match(['get','post'],'account_money_creditorupdate',[App\Http\Controllers\AccountController::class, 'account_money_creditorupdate'])->name('acc.account_money_creditorupdate');//

  Route::match(['get','post'],'account_money_report',[App\Http\Controllers\AccountController::class, 'account_money_report'])->name('acc.account_money_report');//




  // **************************** บัญชี ***********************
  Route::match(['get','post'],'account_plane',[App\Http\Controllers\AccountPlanController::class, 'account_plane'])->name('acc.account_plane');//
  Route::match(['get','post'],'account_plane_activity/{id}',[App\Http\Controllers\AccountPlanController::class, 'account_plane_activity'])->name('acc.account_plane_activity');//
  Route::match(['get','post'],'account_plane_pay',[App\Http\Controllers\AccountPlanController::class, 'account_plane_pay'])->name('acc.account_plane_pay');//
  Route::match(['get','post'],'account_plane_payedit/{id}',[App\Http\Controllers\AccountPlanController::class, 'account_plane_payedit'])->name('acc.account_plane_payedit');//
  Route::match(['get','post'],'account_plane_paysave',[App\Http\Controllers\AccountPlanController::class, 'account_plane_paysave'])->name('acc.account_plane_paysave');//

  Route::match(['get','post'],'account_info',[App\Http\Controllers\AccountController::class, 'account_info'])->name('acc.account_info');//
  Route::match(['get','post'],'account_info_vn/{startdate}/{enddate}',[App\Http\Controllers\AccountController::class, 'account_info_vn'])->name('acc.account_info_vn');//
  Route::match(['get','post'],'account_info_vnall/{year}/{months}/{startdate}/{enddate}',[App\Http\Controllers\AccountController::class, 'account_info_vnall'])->name('acc.account_info_vnall');//
  Route::match(['get','post'],'account_info_vnstmx/{cid}/{startdate}/{enddate}',[App\Http\Controllers\AccountController::class, 'account_info_vnstmx'])->name('acc.account_info_vnstmx');//

  Route::match(['get','post'],'account_info_vn_subofc_vn/{year}/{months}/{strdateadmit}/{enddateadmit}',[App\Http\Controllers\AccountController::class, 'account_info_vn_subofc_vn'])->name('acc.account_info_vn_subofc_vn');//
  Route::match(['get','post'],'account_info_vn_subofc_vndetail/{vn}',[App\Http\Controllers\AccountController::class, 'account_info_vn_subofc_vndetail'])->name('acc.account_info_vn_subofc_vndetail');//
  Route::match(['get','post'],'account_info_vn_subofc/{months}/{startdate}/{enddate}',[App\Http\Controllers\AccountController::class, 'account_info_vn_subofc'])->name('acc.account_info_vn_subofc');//

  Route::match(['get','post'],'account_info_noapproveofc/{months}/{startdate}/{enddate}',[App\Http\Controllers\AccountController::class, 'account_info_noapproveofc'])->name('acc.account_info_noapproveofc');//
  Route::match(['get','post'],'account_info_noapproveofc_vn/{vn}/{startdate}/{enddate}',[App\Http\Controllers\AccountController::class, 'account_info_noapproveofc_vn'])->name('acc.account_info_noapproveofc_vn');//
  Route::match(['get','post'],'account_info_vn_subofcdetail/{vn}',[App\Http\Controllers\AccountController::class, 'account_info_vn_subofcdetail'])->name('acc.account_info_vn_subofcdetail');//
  Route::match(['get','post'],'account_info_vn_subofcdetail_sub/{vn}/{income}',[App\Http\Controllers\AccountController::class, 'account_info_vn_subofcdetail_sub'])->name('acc.account_info_vn_subofcdetail_sub');//

  Route::match(['get','post'],'checksit_admit',[App\Http\Controllers\AccountController::class, 'checksit_admit'])->name('acc.checksit_admit');//
  Route::match(['get','post'],'checksit_admit_spsch',[App\Http\Controllers\AccountController::class, 'checksit_admit_spsch'])->name('acc.checksit_admit_spsch');//

  Route::match(['get','post'],'checksit_sendaccount',[App\Http\Controllers\AccountController::class, 'checksit_sendaccount'])->name('acc.checksit_sendaccount');//
  Route::match(['get','post'],'checksit_sendlist',[App\Http\Controllers\AccountController::class, 'checksit_sendlist'])->name('acc.checksit_sendlist');//
  Route::match(['get','post'],'checksit_ucs',[App\Http\Controllers\AccountController::class, 'checksit_ucs'])->name('acc.checksit_ucs');//
  Route::match(['get','post'],'checksit_sss',[App\Http\Controllers\AccountController::class, 'checksit_sss'])->name('acc.checksit_sss');//
  Route::match(['get','post'],'checksit_ofc',[App\Http\Controllers\AccountController::class, 'checksit_ofc'])->name('acc.checksit_ofc');//
  Route::match(['get','post'],'checksit_td',[App\Http\Controllers\AccountController::class, 'checksit_td'])->name('acc.checksit_td');//
  Route::match(['get','post'],'checksit_status',[App\Http\Controllers\AccountController::class, 'checksit_status'])->name('acc.checksit_status');//
  Route::match(['get','post'],'checksit_prb',[App\Http\Controllers\AccountController::class, 'checksit_prb'])->name('acc.checksit_prb');//
  Route::match(['get','post'],'checksit_ti',[App\Http\Controllers\AccountController::class, 'checksit_ti'])->name('acc.checksit_ti');//

  Route::match(['get','post'],'debtor_sss',[App\Http\Controllers\AccountController::class, 'debtor_sss'])->name('acc.debtor_sss');//


  Route::match(['get','post'],'account_nopaid',[App\Http\Controllers\AccountController::class, 'account_nopaid'])->name('acc.account_nopaid');//
  Route::match(['get','post'],'account_nopaid_sub/{months}/{year}',[App\Http\Controllers\AccountController::class, 'account_nopaid_sub'])->name('acc.account_nopaid_sub');//
  Route::match(['get','post'],'account_nopaid_subpay/{months}/{year}',[App\Http\Controllers\AccountController::class, 'account_nopaid_subpay'])->name('acc.account_nopaid_subpay');//
  // Route::match(['get','post'],'account_nopaid_moneysub/{months}/{year}',[App\Http\Controllers\AccountController::class, 'account_nopaid_moneysub'])->name('acc.account_nopaid_moneysub');//

  Route::match(['get','post'],'account_nopaid_ip',[App\Http\Controllers\AccountController::class, 'account_nopaid_ip'])->name('acc.account_nopaid_ip');//
  Route::match(['get','post'],'account_nopaid_sub_ip/{months}/{year}',[App\Http\Controllers\AccountController::class, 'account_nopaid_sub_ip'])->name('acc.account_nopaid_sub_ip');//
  // Route::match(['get','post'],'account_nopaid_moneysub_ip/{months}/{year}',[App\Http\Controllers\AccountController::class, 'account_nopaid_moneysub_ip'])->name('acc.account_nopaid_moneysub_ip');//
  
  // **************************** แผนโครงการ ***********************
  Route::match(['get','post'],'plan',[App\Http\Controllers\PlanController::class, 'plan'])->name('p.plan');//
  Route::match(['get','post'],'plan_save',[App\Http\Controllers\PlanController::class, 'plan_save'])->name('p.plan_save');//
  Route::get('plan_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_edit'])->name('p.plan_edit');//
  Route::match(['get','post'],'plan_update',[App\Http\Controllers\PlanController::class, 'plan_update'])->name('p.plan_update');//
  Route::delete('plan_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_destroy'])->name('p.plan_destroy');//

  Route::match(['get','post'],'plan_project',[App\Http\Controllers\PlanController::class, 'plan_project'])->name('p.plan_project');// แผนโครงการ
  Route::match(['get','post'],'plan_project_add',[App\Http\Controllers\PlanController::class, 'plan_project_add'])->name('p.plan_project_add');// แผนโครงการ

  Route::match(['get','post'],'plan_control',[App\Http\Controllers\PlanController::class, 'plan_control'])->name('p.plan_control');//
  Route::match(['get','post'],'plan_control_add/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_add'])->name('p.plan_control_add');//
  Route::match(['get','post'],'plan_control_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_edit'])->name('p.plan_control_edit');//
  Route::match(['get','post'],'plan_control_save',[App\Http\Controllers\PlanController::class, 'plan_control_save'])->name('p.plan_control_save');//
  Route::match(['get','post'],'plan_control_update',[App\Http\Controllers\PlanController::class, 'plan_control_update'])->name('p.plan_control_update');//
  Route::match(['get','post'],'plan_control_moneyedit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_moneyedit'])->name('p.plan_control_moneyedit');//
  Route::match(['get','post'],'plan_control_repmoney',[App\Http\Controllers\PlanController::class, 'plan_control_repmoney'])->name('p.plan_control_repmoney');//
  Route::delete('plan_control_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_destroy'])->name('p.plan_control_destroy');//
  Route::delete('subkpi_destroy/{id}',[App\Http\Controllers\PlanController::class, 'subkpi_destroy'])->name('p.subkpi_destroy');//
  Route::delete('subobj_destroy/{id}',[App\Http\Controllers\PlanController::class, 'subobj_destroy'])->name('p.subobj_destroy');//

  Route::match(['get','post'],'plan_control_subhos/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_subhos'])->name('p.plan_control_subhos');//
  Route::match(['get','post'],'plan_control_subhos_add/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_subhos_add'])->name('p.plan_control_subhos_add');//
  Route::match(['get','post'],'plan_control_subhos_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_subhos_edit'])->name('p.plan_control_subhos_edit');//
  Route::match(['get','post'],'plan_control_subedit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_subedit'])->name('p.plan_control_subedit');//
  Route::match(['get','post'],'plan_control_subhossave',[App\Http\Controllers\PlanController::class, 'plan_control_subhossave'])->name('p.plan_control_subhossave');//
  Route::match(['get','post'],'plan_control_subhosupdate',[App\Http\Controllers\PlanController::class, 'plan_control_subhosupdate'])->name('p.plan_control_subhosupdate');//
  Route::match(['get','post'],'plan_control_subhosactivity/{id}/{sid}',[App\Http\Controllers\PlanController::class, 'plan_control_subhosactivity'])->name('p.plan_control_subhosactivity');//
  Route::match(['get','post'],'plan_control_subhosactivity_edit/{id}/{sid}/{aid}',[App\Http\Controllers\PlanController::class, 'plan_control_subhosactivity_edit'])->name('p.plan_control_subhosactivity_edit');//

  Route::match(['get','post'],'plan_control_subhosactivity_sub/{sid}/{aid}',[App\Http\Controllers\PlanController::class, 'plan_control_subhosactivity_sub'])->name('p.plan_control_subhosactivity_sub');//
  Route::match(['get','post'],'plan_control_subhosactivity_subsave',[App\Http\Controllers\PlanController::class, 'plan_control_subhosactivity_subsave'])->name('p.plan_control_subhosactivity_subsave');//
  Route::match(['get','post'],'plan_control_subhosactivity_sub_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_subhosactivity_sub_edit'])->name('p.plan_control_subhosactivity_sub_edit');//
  Route::match(['get','post'],'plan_control_subhosactivity_subupdate',[App\Http\Controllers\PlanController::class, 'plan_control_subhosactivity_subupdate'])->name('p.plan_control_subhosactivity_subupdate');//

  Route::match(['get','post'],'plan_control_ssj/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_ssj'])->name('p.plan_control_ssj');//
  Route::match(['get','post'],'plan_control_po/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_po'])->name('p.plan_control_po');//

  Route::match(['get','post'],'plan_control_activ_ssj/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_activ_ssj'])->name('p.plan_control_activ_ssj');//
  Route::match(['get','post'],'plan_control_activ_po/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_activ_po'])->name('p.plan_control_activ_po');//
  Route::match(['get','post'],'plan_control_activ_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_activ_edit'])->name('p.plan_control_activ_edit');//
  Route::match(['get','post'],'plan_control_activobj_save',[App\Http\Controllers\PlanController::class, 'plan_control_activobj_save'])->name('p.plan_control_activobj_save');//
  Route::match(['get','post'],'plan_control_activobj_update',[App\Http\Controllers\PlanController::class, 'plan_control_activobj_update'])->name('p.plan_control_activobj_update');//

  Route::match(['get','post'],'plan_control_sub/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_sub'])->name('p.plan_control_sub');//
  Route::match(['get','post'],'plan_control_sub_pp',[App\Http\Controllers\PlanController::class, 'plan_control_sub_pp'])->name('p.plan_control_sub_pp');//
  Route::match(['get','post'],'plan_control_sub_uc',[App\Http\Controllers\PlanController::class, 'plan_control_sub_uc'])->name('p.plan_control_sub_uc');//
  Route::match(['get','post'],'plan_control_sub_lgo',[App\Http\Controllers\PlanController::class, 'plan_control_sub_lgo'])->name('p.plan_control_sub_lgo');//
  Route::match(['get','post'],'plan_control_sub_orther',[App\Http\Controllers\PlanController::class, 'plan_control_sub_orther'])->name('p.plan_control_sub_orther');//

 
  Route::match(['get','post'],'plan_control_subhos_pp',[App\Http\Controllers\PlanController::class, 'plan_control_subhos_pp'])->name('p.plan_control_subhos_pp');//
  Route::match(['get','post'],'plan_control_subhos_uc',[App\Http\Controllers\PlanController::class, 'plan_control_subhos_uc'])->name('p.plan_control_subhos_uc');//
  Route::match(['get','post'],'plan_control_subhos_lgo',[App\Http\Controllers\PlanController::class, 'plan_control_subhos_lgo'])->name('p.plan_control_subhos_lgo');//
  Route::match(['get','post'],'plan_control_subhos_orther',[App\Http\Controllers\PlanController::class, 'plan_control_subhos_orther'])->name('p.plan_control_subhos_orther');//

  Route::match(['get','post'],'plan_control_activity/{id}/{sid}',[App\Http\Controllers\PlanController::class, 'plan_control_activity'])->name('p.plan_control_activity');//
  Route::match(['get','post'],'plan_control_activity_save',[App\Http\Controllers\PlanController::class, 'plan_control_activity_save'])->name('p.plan_control_activity_save');//
  Route::match(['get','post'],'plan_control_activity_edit/{id}/{sid}/{aid}',[App\Http\Controllers\PlanController::class, 'plan_control_activity_edit'])->name('p.plan_control_activity_edit');//
  Route::match(['get','post'],'plan_control_activity_update',[App\Http\Controllers\PlanController::class, 'plan_control_activity_update'])->name('p.plan_control_activity_update');//
  Route::match(['get','post'],'plan_control_activity_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_activity_destroy'])->name('p.plan_control_activity_destroy');//

  Route::match(['get','post'],'plan_control_budget_save',[App\Http\Controllers\PlanController::class, 'plan_control_budget_save'])->name('p.plan_control_budget_save');//
  Route::match(['get','post'],'plan_control_budget_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_control_budget_edit'])->name('p.plan_control_budget_edit');//

  Route::get('detail_plan',[App\Http\Controllers\PlanController::class, 'detail_plan'])->name('p.detail_plan');//
  Route::match(['get','post'],'plan_control_obj_save',[App\Http\Controllers\PlanController::class, 'plan_control_obj_save'])->name('p.plan_control_obj_save');//
  Route::match(['get','post'],'plan_control_obj_update',[App\Http\Controllers\PlanController::class, 'plan_control_obj_update'])->name('p.plan_control_obj_update');//

  Route::match(['get','post'],'plan_control_kpi_save',[App\Http\Controllers\PlanController::class, 'plan_control_kpi_save'])->name('p.plan_control_kpi_save');//
  Route::match(['get','post'],'plan_control_kpi_update',[App\Http\Controllers\PlanController::class, 'plan_control_kpi_update'])->name('p.plan_control_kpi_update');//

  Route::match(['get','post'],'plan_control_indicators',[App\Http\Controllers\PlanController::class, 'plan_control_indicators'])->name('p.plan_control_indicators');// ตัวชี้วัด
  Route::match(['get','post'],'plan_control_indicators_save',[App\Http\Controllers\PlanController::class, 'plan_control_indicators_save'])->name('p.plan_control_indicators_save');// ตัวชี้วัด

  Route::match(['get','post'],'plan_development',[App\Http\Controllers\PlanController::class, 'plan_development'])->name('p.plan_development');// แผนพัฒนาบุคลากร


  Route::match(['get','post'],'plan_procurement',[App\Http\Controllers\PlanController::class, 'plan_procurement'])->name('p.plan_procurement');// แผนจัดซื้อครุภัณฑ์
  Route::match(['get','post'],'plan_procurement_save',[App\Http\Controllers\PlanController::class, 'plan_procurement_save'])->name('p.plan_procurement_save');// แผนจัดซื้อครุภัณฑ์


  Route::match(['get','post'],'plan_maintenance',[App\Http\Controllers\PlanController::class, 'plan_maintenance'])->name('p.plan_maintenance');// แผนบำรุงรักษา
  Route::match(['get','post'],'plan_type',[App\Http\Controllers\PlanController::class, 'plan_type'])->name('p.plan_type');// ประเภทแผนงาน

  Route::match(['get','post'],'plan_vision',[App\Http\Controllers\PlanController::class, 'plan_vision'])->name('p.plan_vision');// วิสัยทัศน์
  Route::match(['get','post'],'plan_vision_save',[App\Http\Controllers\PlanController::class, 'plan_vision_save'])->name('p.plan_vision_save');// วิสัยทัศน์
  Route::get('plan_vision_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_vision_edit'])->name('p.plan_vision_edit');//
  Route::match(['get','post'],'plan_vision_update',[App\Http\Controllers\PlanController::class, 'plan_vision_update'])->name('p.plan_vision_update');// วิสัยทัศน์
  Route::delete('plan_vision_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_vision_destroy'])->name('p.plan_vision_destroy');//


  Route::match(['get','post'],'plan_mission',[App\Http\Controllers\PlanController::class, 'plan_mission'])->name('p.plan_mission');// พันธกิจ
  Route::match(['get','post'],'plan_mission_save',[App\Http\Controllers\PlanController::class, 'plan_mission_save'])->name('p.plan_mission_save');// พันธกิจ
  Route::get('plan_mission_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_mission_edit'])->name('p.plan_mission_edit');//
  Route::match(['get','post'],'plan_mission_update',[App\Http\Controllers\PlanController::class, 'plan_mission_update'])->name('p.plan_mission_update');// พันธกิจ
  Route::delete('plan_mission_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_mission_destroy'])->name('p.plan_mission_destroy');//

  Route::match(['get','post'],'plan_strategic',[App\Http\Controllers\PlanController::class, 'plan_strategic'])->name('p.plan_strategic');// ยุทธศาสตร์
  Route::match(['get','post'],'plan_strategic_save',[App\Http\Controllers\PlanController::class, 'plan_strategic_save'])->name('p.plan_strategic_save');// ยุทธศาสตร์
  Route::get('plan_strategic_edit/{id}',[App\Http\Controllers\PlanController::class, 'plan_strategic_edit'])->name('p.plan_strategic_edit');// ยุทธศาสตร์
  Route::match(['get','post'],'plan_strategic_update',[App\Http\Controllers\PlanController::class, 'plan_strategic_update'])->name('p.plan_strategic_update');//  ยุทธศาสตร์
  Route::delete('plan_strategic_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_strategic_destroy'])->name('p.plan_strategic_destroy');//ยุทธศาสตร์

  Route::match(['get','post'],'plan_taget/{id}',[App\Http\Controllers\PlanController::class, 'plan_taget'])->name('p.plan_taget');// เป้าประสงค์
  Route::match(['get','post'],'plan_taget_save',[App\Http\Controllers\PlanController::class, 'plan_taget_save'])->name('p.plan_taget_save');//เป้าประสงค์
  Route::match(['get','post'],'plan_taget_update',[App\Http\Controllers\PlanController::class, 'plan_taget_update'])->name('p.plan_taget_update');//เป้าประสงค์
  Route::delete('plan_taget_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_taget_destroy'])->name('p.plan_taget_destroy');//เป้าประสงค์

  Route::match(['get','post'],'plan_kpi/{strategic_id}/{taget_id}',[App\Http\Controllers\PlanController::class, 'plan_kpi'])->name('p.plan_kpi');// KPI
  Route::match(['get','post'],'plan_kpi_save',[App\Http\Controllers\PlanController::class, 'plan_kpi_save'])->name('p.plan_kpi_save');//KPI
  Route::match(['get','post'],'plan_kpi_update',[App\Http\Controllers\PlanController::class, 'plan_kpi_update'])->name('p.plan_kpi_update');//KPI
  Route::delete('plan_kpi_destroy/{id}',[App\Http\Controllers\PlanController::class, 'plan_kpi_destroy'])->name('p.plan_kpi_destroy');//KPI

 // ****************************User ใบงาน ***********************
  Route::match(['get','post'],'userrequest_report',[App\Http\Controllers\SendreportController::class,'userrequest_report'])->name('rep.userrequest_report');//
  Route::match(['get','post'],'userrequest_report_save',[App\Http\Controllers\SendreportController::class,'userrequest_report_save'])->name('rep.userrequest_report_save');//
  Route::match(['get','post'],'userrequest_report_edit/{id}',[App\Http\Controllers\SendreportController::class,'userrequest_report_edit'])->name('rep.userrequest_report_edit');//
  Route::match(['get','post'],'userrequest_report_update',[App\Http\Controllers\SendreportController::class,'userrequest_report_update'])->name('rep.userrequest_report_update');//

 // ****************************User OT ***********************
 Route::match(['get','post'],'user_otone',[App\Http\Controllers\UserotController::class, 'user_otone'])->name('userot.user_otone');//
 Route::match(['get','post'],'user_otonesearch_',[App\Http\Controllers\UserotController::class, 'user_otonesearch_'])->name('userot.user_otonesearch_');//
 Route::match(['get','post'],'user_otone_add',[App\Http\Controllers\UserotController::class, 'user_otone_add'])->name('userot.user_otone_add');//
 Route::match(['get','post'],'user_otone_save',[App\Http\Controllers\UserotController::class, 'user_otone_save'])->name('userot.user_otone_save');//
 Route::match(['get','post'],'user_otone_edit/{id}',[App\Http\Controllers\UserotController::class, 'user_otone_edit'])->name('userot.user_otone_edit');//
 Route::match(['get','post'],'user_otone_update',[App\Http\Controllers\UserotController::class, 'user_otone_update'])->name('userot.user_otone_update');//
 Route::match(['get','post'],'user_otone_add_color/{id}',[App\Http\Controllers\UserotController::class, 'user_otone_add_color'])->name('userot.user_otone_add_color');//
 Route::match(['get','post'],'user_otone_updatecolor',[App\Http\Controllers\UserotController::class, 'user_otone_updatecolor'])->name('userot.user_otone_updatecolor');//
 Route::match(['get','post'],'user_otone_print',[App\Http\Controllers\UserotController::class, 'user_otone_print'])->name('userot.user_otone_print');//
 Route::match(['get','post'],'user_export',[App\Http\Controllers\UserotController::class, 'user_export'])->name('userot.user_export');//
 Route::delete('user_otone_destroy/{id}',[App\Http\Controllers\UserotController::class, 'user_otone_destroy'])->name('userot.user_otone_destroy');//


 // **************************** OT ***********************
  Route::match(['get','post'],'otone',[App\Http\Controllers\OtController::class, 'otone'])->name('ot.otone');//
  Route::match(['get','post'],'otonesearch',[App\Http\Controllers\OtController::class, 'otonesearch'])->name('ot.otonesearch');//
  Route::match(['get','post'],'otone_add',[App\Http\Controllers\OtController::class, 'otone_add'])->name('ot.otone_add');//
  Route::match(['get','post'],'otone_save',[App\Http\Controllers\OtController::class, 'otone_save'])->name('ot.otone_save');//
  Route::match(['get','post'],'otone_edit/{id}',[App\Http\Controllers\OtController::class, 'otone_edit'])->name('ot.otone_edit');//
  Route::match(['get','post'],'otone_update',[App\Http\Controllers\OtController::class, 'otone_update'])->name('ot.otone_update');//
  Route::match(['get','post'],'otone_add_color/{id}',[App\Http\Controllers\OtController::class, 'otone_add_color'])->name('ot.otone_add_color');//
  Route::match(['get','post'],'otone_updatecolor',[App\Http\Controllers\OtController::class, 'otone_updatecolor'])->name('ot.otone_updatecolor');//
  Route::match(['get','post'],'otone_print',[App\Http\Controllers\OtController::class, 'otone_print'])->name('ot.otone_print');//

  Route::match(['get','post'],'export',[App\Http\Controllers\OtController::class, 'export'])->name('ot.export');//

  Route::match(['get','post'],'profile_edit/{id}',[App\Http\Controllers\OtController::class, 'profile_edit'])->name('ot.profile_edit');//
  Route::match(['get','post'],'profile_update',[App\Http\Controllers\OtController::class, 'profile_update'])->name('ot.profile_update');//

  Route::match(['get','post'],'ottwo',[App\Http\Controllers\OtController::class, 'ottwo'])->name('ot.ottwo');//
  Route::delete('otone_destroy/{id}',[App\Http\Controllers\OtController::class, 'otone_destroy'])->name('ot.otone_destroy');//


//  *************************** Print OT form  *****
  Route::match(['get','post'],'otone_from1',[App\Http\Controllers\PrintController::class,'otone_from1'])->name('ot.otone_from1');//
  Route::match(['get','post'],'otone_from2',[App\Http\Controllers\PrintController::class,'otone_from2'])->name('ot.otone_from2');//
  Route::match(['get','post'],'otone_from3',[App\Http\Controllers\PrintController::class,'otone_from3'])->name('ot.otone_from3');//
  Route::match(['get','post'],'export_otform1/{start}/{end}/{reqsend}/{iddep}',[App\Http\Controllers\PrintController::class, 'export_otform1'])->name('export.export_otform1');//
  Route::match(['get','post'],'export_otform3/{start}/{end}/{reqsend}/{iddep}',[App\Http\Controllers\PrintController::class, 'export_otform3'])->name('export.export_otform3');//
  Route::match(['get','post'],'export_otform4/{start}/{end}/{reqsend}/{iddep}',[App\Http\Controllers\PrintController::class, 'export_otform4'])->name('export.export_otform4');//


//  *************************** Report รายงาน *******************************************************
Route::match(['get','post'],'report_type',[App\Http\Controllers\PersonController::class, 'report_type'])->name('re.report_type');//
Route::match(['get','post'],'report_dep',[App\Http\Controllers\PersonController::class, 'report_dep'])->name('re.report_dep');//

//  *************************** PT *******************************************************
 
Route::match(['get','post'],'ct_rep',[App\Http\Controllers\CtrepController::class, 'ct_rep'])->name('ct.ct_rep');//
Route::match(['get','post'],'ct_rep_pull',[App\Http\Controllers\CtrepController::class, 'ct_rep_pull'])->name('ct.ct_rep_pull');//
Route::match(['get','post'],'ct_rep_ipd',[App\Http\Controllers\CtrepController::class, 'ct_rep_ipd'])->name('ct.ct_rep_ipd');//
Route::match(['get','post'],'ct_rep_pay',[App\Http\Controllers\CtrepController::class, 'ct_rep_pay'])->name('ct.ct_rep_pay');//
Route::match(['get','post'],'ct_rep_edit/{id}',[App\Http\Controllers\CtrepController::class, 'ct_rep_edit'])->name('ct.ct_rep_edit');//
Route::match(['get','post'],'ct_rep_import',[App\Http\Controllers\CtrepController::class, 'ct_rep_import'])->name('ct.ct_rep_import');//
Route::match(['get','post'],'ct_rep_import_save',[App\Http\Controllers\CtrepController::class, 'ct_rep_import_save'])->name('ct.ct_rep_import_save');//
Route::match(['get','post'],'ct_rep_import_send',[App\Http\Controllers\CtrepController::class, 'ct_rep_import_send'])->name('ct.ct_rep_import_send');//
Route::match(['get','post'],'ct_rep_sync',[App\Http\Controllers\CtrepController::class, 'ct_rep_sync'])->name('ct.ct_rep_sync');//
Route::match(['get','post'],'ct_rep_confirm',[App\Http\Controllers\CtrepController::class, 'ct_rep_confirm'])->name('ct.ct_rep_confirm');//
Route::match(['get','post'],'ct_rep_checksit',[App\Http\Controllers\CtrepController::class, 'ct_rep_checksit'])->name('ct.ct_rep_checksit');//
Route::match(['get','post'],'ct_report',[App\Http\Controllers\CtrepController::class, 'ct_report'])->name('ct.ct_report');//
Route::match(['get','post'],'ct_report_hos',[App\Http\Controllers\CtrepController::class, 'ct_report_hos'])->name('ct.ct_report_hos');//

Route::match(['get','post'],'thalassemia_year',[App\Http\Controllers\PctController::class, 'thalassemia_year'])->name('pct.thalassemia_year');//
Route::match(['get','post'],'thalassemia_yearsearch',[App\Http\Controllers\PctController::class, 'thalassemia_yearsearch'])->name('pct.thalassemia_yearsearch');//

Route::match(['get','post'],'thalassemia_ipd/{months}',[App\Http\Controllers\PctController::class, 'thalassemia_ipd'])->name('pct.thalassemia_ipd');//
Route::match(['get','post'],'thalassemia_ipdsearch/{months}',[App\Http\Controllers\PctController::class, 'thalassemia_ipdsearch'])->name('pct.thalassemia_ipdsearch');//

Route::match(['get','post'],'thalassemia_opd/{months}/{startdate}/{enddate}',[App\Http\Controllers\PctController::class, 'thalassemia_opd'])->name('pct.thalassemia_opd');//
Route::match(['get','post'],'thalassemia_opdsub/{months}/{startdate}/{enddate}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub'])->name('pct.thalassemia_opdsub');//
Route::match(['get','post'],'thalassemia_opdsub_diag/{months}/{startdate}/{enddate}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_diag'])->name('pct.thalassemia_opdsub_diag');//
Route::match(['get','post'],'thalassemia_opdsub_diag_vn/{vn}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_diag_vn'])->name('pct.thalassemia_opdsub_diag_vn');//
Route::match(['get','post'],'thalassemia_opdsub_diag_labvn/{vn}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_diag_labvn'])->name('pct.thalassemia_opdsub_diag_labvn');//
Route::match(['get','post'],'thalassemia_opdsub_drugvn/{vn}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_drugvn'])->name('pct.thalassemia_opdsub_drugvn');//

Route::match(['get','post'],'thalassemia_opdsub_diag_an/{an}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_diag_an'])->name('pct.thalassemia_opdsub_diag_an');//
Route::match(['get','post'],'thalassemia_opdsub_diag_lab/{an}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_diag_lab'])->name('pct.thalassemia_opdsub_diag_lab');//
Route::match(['get','post'],'thalassemia_opdsub_diag_blood/{an}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_diag_blood'])->name('pct.thalassemia_opdsub_diag_blood');//

Route::match(['get','post'],'thalassemia_opdsub_drugdiag_hn/{an}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_drugdiag_hn'])->name('pct.thalassemia_opdsub_drugdiag_hn');//
Route::match(['get','post'],'thalassemia_opdsub_drugdiag_lab/{an}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsub_drugdiag_lab'])->name('pct.thalassemia_opdsub_drugdiag_lab');//

Route::match(['get','post'],'thalassemia_opdsubdrug/{months}/{startdate}/{enddate}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsubdrug'])->name('pct.thalassemia_opdsubdrug');//
Route::match(['get','post'],'thalassemia_opdsubdrug_hn/{hn}/{startdate}/{enddate}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsubdrug_hn'])->name('pct.thalassemia_opdsubdrug_hn');//

Route::match(['get','post'],'thalassemia_opdsubdrug_hos/{vn}/{startdate}/{enddate}',[App\Http\Controllers\PctController::class, 'thalassemia_opdsubdrug_hos'])->name('pct.thalassemia_opdsubdrug_hos');//

Route::match(['get','post'],'thalassemia',[App\Http\Controllers\PctController::class, 'thalassemia'])->name('pct.thalassemia');//
Route::match(['get','post'],'thalassemia',[App\Http\Controllers\PctController::class, 'thalassemia'])->name('pct.thalassemia');//

Route::match(['get','post'],'p4p_doctor',[App\Http\Controllers\P4pController::class, 'p4p_doctor'])->name('p4.p4p_doctor');//
Route::match(['get','post'],'p4p_doctor_detail/{doctor}/{startdate}/{enddate}',[App\Http\Controllers\P4pController::class, 'p4p_doctor_detail'])->name('p4.p4p_doctor_detail');//
Route::match(['get','post'],'p4p',[App\Http\Controllers\P4pController::class, 'p4p'])->name('p4.p4p');//
Route::match(['get','post'],'p4p_work',[App\Http\Controllers\P4pController::class, 'p4p_work'])->name('p4.p4p_work');//
Route::match(['get','post'],'p4p_work_save',[App\Http\Controllers\P4pController::class, 'p4p_work_save'])->name('p4.p4p_work_save');//
Route::match(['get','post'],'p4p_work_edit/{id}',[App\Http\Controllers\P4pController::class, 'p4p_work_edit'])->name('p4.p4p_work_edit');//
// Route::match(['get','post'],'p4p_work_choose/{year}/{month}',[App\Http\Controllers\P4pController::class, 'p4p_work_choose'])->name('p4.p4p_work_choose');//
Route::match(['get','post'],'p4p_work_update',[App\Http\Controllers\P4pController::class, 'p4p_work_update'])->name('p4.p4p_work_update');//
Route::match(['get','post'],'p4p_work_choose/{id}',[App\Http\Controllers\P4pController::class, 'p4p_work_choose'])->name('p4.p4p_work_choose');//
Route::match(['get','post'],'p4p_work_choose_save',[App\Http\Controllers\P4pController::class, 'p4p_work_choose_save'])->name('p4.p4p_work_choose_save');//
Route::match(['get','post'],'p4p_work_choose_worksetsave',[App\Http\Controllers\P4pController::class, 'p4p_work_choose_worksetsave'])->name('p4.p4p_work_choose_worksetsave');//

Route::match(['get','post'],'p4p_work_choose_detail/{id}',[App\Http\Controllers\P4pController::class, 'p4p_work_choose_detail'])->name('p4.p4p_work_choose_detail');//

Route::match(['get','post'],'p4p_work_load_save',[App\Http\Controllers\P4pController::class, 'p4p_work_load_save'])->name('p4.p4p_work_load_save');//
Route::match(['get','post'],'p4p_work_load_saveCopy',[App\Http\Controllers\P4pController::class, 'p4p_work_load_saveCopy'])->name('p4.p4p_work_load_saveCopy');//
Route::match(['get','post'],'p4p_work_load_update',[App\Http\Controllers\P4pController::class, 'p4p_work_load_update'])->name('p4.p4p_work_load_update');//
Route::DELETE('p4p_work_load_destroy/{id}',[App\Http\Controllers\P4pController::class, 'p4p_work_load_destroy'])->name('p4.p4p_work_load_destroy');//

Route::match(['get','post'],'p4p_work_scorenowsave',[App\Http\Controllers\P4pController::class, 'p4p_work_scorenowsave'])->name('p4.p4p_work_scorenowsave');//

Route::match(['get','post'],'p4p_work_position',[App\Http\Controllers\P4pController::class, 'p4p_work_position'])->name('p4.p4p_work_position');//
Route::match(['get','post'],'p4p_work_position_save',[App\Http\Controllers\P4pController::class, 'p4p_work_position_save'])->name('p4.p4p_work_position_save');//
Route::match(['get','post'],'p4p_work_position_edit/{id}',[App\Http\Controllers\P4pController::class, 'p4p_work_position_edit'])->name('p4.p4p_work_position_edit');//
Route::match(['get','post'],'p4p_work_position_update',[App\Http\Controllers\P4pController::class, 'p4p_work_position_update'])->name('p4.p4p_work_position_update');//
Route::match(['get','post'],'p4p_work_position_switchactive',[App\Http\Controllers\P4pController::class, 'p4p_work_position_switchactive'])->name('p4.p4p_work_position_switchactive');// switchactive

Route::match(['get','post'],'p4p_work_position_sub/{id}',[App\Http\Controllers\P4pController::class, 'p4p_work_position_sub'])->name('p4.p4p_work_position_sub');//

Route::match(['get','post'],'p4p_workset',[App\Http\Controllers\P4pController::class, 'p4p_workset'])->name('p4.p4p_workset');//
Route::match(['get','post'],'p4p_workset_save',[App\Http\Controllers\P4pController::class, 'p4p_workset_save'])->name('p4.p4p_workset_save');//
Route::match(['get','post'],'p4p_workset_edit/{id}',[App\Http\Controllers\P4pController::class, 'p4p_workset_edit'])->name('p4.p4p_workset_edit');//
Route::match(['get','post'],'p4p_workset_update',[App\Http\Controllers\P4pController::class, 'p4p_workset_update'])->name('p4.p4p_workset_update');//
Route::match(['get','post'],'p4p_workset_switchactive',[App\Http\Controllers\P4pController::class, 'p4p_workset_switchactive'])->name('p4.p4p_workset_switchactive');//

Route::match(['get','post'],'p4p_workgroupset',[App\Http\Controllers\P4pController::class, 'p4p_workgroupset'])->name('p4.p4p_workgroupset');//
Route::match(['get','post'],'p4p_workgroupset_save',[App\Http\Controllers\P4pController::class, 'p4p_workgroupset_save'])->name('p4.p4p_workgroupset_save');//
Route::match(['get','post'],'p4p_workgroupset_edit/{id}',[App\Http\Controllers\P4pController::class, 'p4p_workgroupset_edit'])->name('p4.p4p_workgroupset_edit');//
Route::match(['get','post'],'p4p_workgroupset_update',[App\Http\Controllers\P4pController::class, 'p4p_workgroupset_update'])->name('p4.p4p_workgroupset_update');//
Route::match(['get','post'],'p4p_workgroupset_switchactive',[App\Http\Controllers\P4pController::class, 'p4p_workgroupset_switchactive'])->name('p4.p4p_workgroupset_switchactive');//

Route::match(['get','post'],'addunitwork',[App\Http\Controllers\P4pController::class, 'addunitwork'])->name('p4.addunitwork');//

Route::match(['get','post'],'p4p_activity',[App\Http\Controllers\P4pController::class, 'p4p_activity'])->name('p4.p4p_activity');//


Route::match(['get','post'],'medicine',[App\Http\Controllers\MedicineController::class, 'medicine'])->name('me.medicine');//
Route::match(['get','post'],'medicine_salt',[App\Http\Controllers\MedicineController::class, 'medicine_salt'])->name('me.medicine_salt');//
Route::match(['get','post'],'medicine_saltsearch',[App\Http\Controllers\MedicineController::class, 'medicine_saltsearch'])->name('me.medicine_saltsearch');//
Route::match(['get','post'],'medicine_salt_sub/{months}/{startdate}/{enddate}',[App\Http\Controllers\MedicineController::class, 'medicine_salt_sub'])->name('me.medicine_salt_sub');//
Route::match(['get','post'],'medicine_salt_subhn/{hn}',[App\Http\Controllers\MedicineController::class, 'medicine_salt_subhn'])->name('me.medicine_salt_subhn');//

//********************* */ Claim 16 แฟ้ม ***********************************
// Route::match(['get','post'],'sixteendata',[App\Http\Controllers\ClaimreferController::class, 'sixteendata'])->name('data.sixteendata');//
// Route::match(['get','post'],'sixteendata_pull',[App\Http\Controllers\ClaimreferController::class, 'sixteendata_pull'])->name('data.sixteendata_pull');//

Route::match(['get','post'],'ucep24',[App\Http\Controllers\Ucep24Controller::class, 'ucep24'])->name('data.ucep24');//  UCEP24
Route::match(['get','post'],'ucep24_an/{an}',[App\Http\Controllers\Ucep24Controller::class, 'ucep24_an'])->name('data.ucep24_an');// UCEP24
Route::match(['get','post'],'ucep24_income/{an}/{income}',[App\Http\Controllers\Ucep24Controller::class, 'ucep24_income'])->name('data.ucep24_income');//  UCEP24
Route::match(['get','post'],'ucep24_claim',[App\Http\Controllers\Ucep24Controller::class, 'ucep24_claim'])->name('data.ucep24_claim');//  UCEP24
Route::match(['get','post'],'ucep24_claim_process',[App\Http\Controllers\Ucep24Controller::class, 'ucep24_claim_process'])->name('data.ucep24_claim_process');//  UCEP24
Route::match(['get','post'],'ucep24_claim_upucep',[App\Http\Controllers\Ucep24Controller::class, 'ucep24_claim_upucep'])->name('data.ucep24_claim_upucep');//  UCEP24
Route::match(['get','post'],'ucep24_claim_export',[App\Http\Controllers\Ucep24Controller::class, 'ucep24_claim_export'])->name('data.ucep24_claim_export');//  UCEP24

Route::match(['get','post'],'ucep24_claim_export_api',[App\Http\Controllers\Ucep24_APiController::class, 'ucep24_claim_export_api'])->name('data.ucep24_claim_export_api');//  UCEP24
Route::match(['get','post'],'UCEP24_sendapi',[App\Http\Controllers\Ucep24_APiController::class, 'UCEP24_sendapi'])->name('data.UCEP24_sendapi');//  UCEP24

Route::match(['get','post'],'imc',[App\Http\Controllers\ImcController::class, 'imc'])->name('data.imc');//  IMC

Route::match(['get','post'],'six',[App\Http\Controllers\SixteenController::class, 'six'])->name('data.six');//
Route::match(['get','post'],'six_pull_a',[App\Http\Controllers\SixteenController::class, 'six_pull_a'])->name('data.six_pull_a');//
Route::match(['get','post'],'six_pull_b',[App\Http\Controllers\SixteenController::class, 'six_pull_b'])->name('data.six_pull_b');//
Route::match(['get','post'],'six_pull_c',[App\Http\Controllers\SixteenController::class, 'six_pull_c'])->name('data.six_pull_c');//
Route::match(['get','post'],'six_pull_d',[App\Http\Controllers\SixteenController::class, 'six_pull_d'])->name('data.six_pull_d');//
Route::match(['get','post'],'six_send',[App\Http\Controllers\SixteenController::class, 'six_send'])->name('data.six_send');//

Route::match(['get','post'],'sixquery',[App\Http\Controllers\SixqueryController::class, 'sixquery'])->name('data.sixquery');//

Route::match(['get','post'],'ofc',[App\Http\Controllers\Ofcopd401Controller::class, 'ofc'])->name('data.ofc');//
Route::match(['get','post'],'ofc_pull_a',[App\Http\Controllers\Ofcopd401Controller::class, 'ofc_pull_a'])->name('data.ofc_pull_a');//
Route::match(['get','post'],'ofc_pull_b',[App\Http\Controllers\Ofcopd401Controller::class, 'ofc_pull_b'])->name('data.ofc_pull_b');//
Route::match(['get','post'],'ofc_pull_c',[App\Http\Controllers\Ofcopd401Controller::class, 'ofc_pull_c'])->name('data.ofc_pull_c');//
Route::match(['get','post'],'ofc_pull_d',[App\Http\Controllers\Ofcopd401Controller::class, 'ofc_pull_d'])->name('data.ofc_pull_d');//
Route::match(['get','post'],'ofc_send',[App\Http\Controllers\Ofcopd401Controller::class, 'ofc_send'])->name('data.ofc_send');//





//********************* */ Claim  AIPN ***********************************
Route::match(['get','post'],'aipn',[App\Http\Controllers\AipnController::class, 'aipn'])->name('claim.aipn');//
Route::match(['get','post'],'aipn_main',[App\Http\Controllers\AipnController::class, 'aipn_main'])->name('claim.aipn_main');//
Route::match(['get','post'],'aipn_process',[App\Http\Controllers\AipnController::class, 'aipn_process'])->name('claim.aipn_process');//
Route::match(['get','post'],'aipn_export',[App\Http\Controllers\AipnController::class, 'aipn_export'])->name('claim.aipn_export');//

Route::match(['get','post'],'aipn_ipop_edit/{id}',[App\Http\Controllers\AipnController::class, 'aipn_ipop_edit'])->name('claim.aipn_ipop_edit');//
Route::match(['get','post'],'aipn_ipop_update',[App\Http\Controllers\AipnController::class, 'aipn_ipop_update'])->name('claim.aipn_ipop_update');//

Route::match(['get','post'],'aipn_zip',[App\Http\Controllers\AipnController::class, 'aipn_zip'])->name('claim.aipn_zip');//

Route::match(['get','post'],'aipn_main_an',[App\Http\Controllers\AipnController::class, 'aipn_main_an'])->name('claim.aipn_main_an');//
Route::match(['get','post'],'aipn_process_an',[App\Http\Controllers\AipnController::class, 'aipn_process_an'])->name('claim.aipn_process_an');//
Route::match(['get','post'],'aipn_export_an',[App\Http\Controllers\AipnController::class, 'aipn_export_an'])->name('claim.aipn_export_an');//

Route::match(['get','post'],'aipnsearch',[App\Http\Controllers\AipnController::class, 'aipnsearch'])->name('claim.aipnsearch');//
Route::match(['get','post'],'aipn_plb',[App\Http\Controllers\AipnController::class, 'aipn_plb'])->name('claim.aipn_plb');//
Route::match(['get','post'],'aipn_plb_search',[App\Http\Controllers\AipnController::class, 'aipn_plb_search'])->name('claim.aipn_plb_search');//
Route::match(['get','post'],'aipn_plb_send_anplb',[App\Http\Controllers\AipnController::class, 'aipn_plb_send_anplb'])->name('claim.aipn_plb_send_anplb');//
Route::match(['get','post'],'checkdata',[App\Http\Controllers\AipnController::class, 'checkdata'])->name('claim.checkdata');//
Route::match(['get','post'],'aipn_disability',[App\Http\Controllers\AipnController::class, 'aipn_disability'])->name('claim.aipn_disability');// 06
Route::match(['get','post'],'aipn_disability_search',[App\Http\Controllers\AipnController::class, 'aipn_disability_search'])->name('claim.aipn_disability_search');// 06
Route::match(['get','post'],'aipn_disability_an',[App\Http\Controllers\AipnController::class, 'aipn_disability_an'])->name('claim.aipn_disability_an');// 06
Route::match(['get','post'],'aipn_equipdev',[App\Http\Controllers\AipnController::class, 'aipn_equipdev'])->name('claim.aipn_equipdev');//
Route::match(['get','post'],'aipn_equipdevsearch',[App\Http\Controllers\AipnController::class, 'aipn_equipdevsearch'])->name('claim.aipn_equipdevsearch');//
Route::match(['get','post'],'aipn_equipdev_send',[App\Http\Controllers\AipnController::class, 'aipn_equipdev_send'])->name('claim.aipn_equipdev_send');//
Route::match(['get','post'],'aipn_equipdev_zip',[App\Http\Controllers\AipnController::class, 'aipn_equipdev_zip'])->name('claim.aipn_equipdev_zip');//
Route::match(['get','post'],'aipn_billitems_destroy/{id}',[App\Http\Controllers\AipnController::class, 'aipn_billitems_destroy'])->name('claim.aipn_billitems_destroy');//
Route::match(['get','post'],'aipn_send',[App\Http\Controllers\AipnController::class, 'aipn_send'])->name('claim.aipn_send');//
Route::match(['get','post'],'aipn_send_an',[App\Http\Controllers\AipnController::class, 'aipn_send_an'])->name('claim.aipn_send_an');//
Route::match(['get','post'],'aipn_send_all',[App\Http\Controllers\AipnController::class, 'aipn_send_all'])->name('claim.aipn_send_all');//
Route::match(['get','post'],'aipn_send_chang',[App\Http\Controllers\AipnController::class, 'aipn_send_chang'])->name('claim.aipn_send_chang');//

//********************* */END  Claim  AIPN ***********************************

Route::match(['get','post'],'acc_checksit',[App\Http\Controllers\ClaimController::class, 'acc_checksit'])->name('claim.acc_checksit');//
Route::match(['get','post'],'acc_checksit_spsch',[App\Http\Controllers\ClaimController::class, 'acc_checksit_spsch'])->name('claim.acc_checksit_spsch');//
Route::match(['get','post'],'acc_checksit_spsch_pangstamp',[App\Http\Controllers\ClaimController::class, 'acc_checksit_spsch_pangstamp'])->name('claim.acc_checksit_spsch_pangstamp');//
Route::match(['get','post'],'acc_checksit_process',[App\Http\Controllers\ClaimController::class, 'acc_checksit_process'])->name('claim.acc_checksit_process');//

//********************* */Start  Claim  SSOP ***********************************
Route::match(['get','post'],'ssop',[App\Http\Controllers\SsopController::class, 'ssop'])->name('claim.ssop');//
Route::match(['get','post'],'ssop_process',[App\Http\Controllers\SsopController::class, 'ssop_process'])->name('claim.ssop_process');//
Route::match(['get','post'],'ssop_export',[App\Http\Controllers\SsopController::class, 'ssop_export'])->name('claim.ssop_export');//
 

Route::match(['get','post'],'ssop_zipfile',[App\Http\Controllers\SsopController::class, 'ssop_zipfile'])->name('claim.ssop_zipfile');//

Route::match(['get','post'],'ssop_data',[App\Http\Controllers\ClaimController::class, 'ssop_data'])->name('claim.ssop_data');//
Route::match(['get','post'],'ssop_check',[App\Http\Controllers\ClaimController::class, 'ssop_check'])->name('claim.ssop_check');//
Route::match(['get','post'],'ssop_send',[App\Http\Controllers\ClaimController::class, 'ssop_send'])->name('claim.ssop_send');//
Route::match(['get','post'],'ssop_zip',[App\Http\Controllers\ClaimController::class, 'ssop_zip'])->name('claim.ssop_zip');//

Route::match(['get','post'],'ssop_data_vn',[App\Http\Controllers\ClaimController::class, 'ssop_data_vn'])->name('claim.ssop_data_vn');//

Route::match(['get','post'],'ssop_edit_svpid/{id}',[App\Http\Controllers\ClaimController::class, 'ssop_edit_svpid'])->name('claim.ssop_edit_svpid');//
Route::match(['get','post'],'ssop_edit_prescb/{id}',[App\Http\Controllers\ClaimController::class, 'ssop_edit_prescb'])->name('claim.ssop_edit_prescb');//
 
Route::match(['get','post'],'ssop_search',[App\Http\Controllers\ClaimController::class, 'ssop_search'])->name('claim.ssop_search');//
Route::match(['get','post'],'ssop_save16',[App\Http\Controllers\ClaimController::class, 'ssop_save16'])->name('claim.ssop_save16');//
Route::match(['get','post'],'ssop_detail',[App\Http\Controllers\ClaimController::class, 'ssop_detail'])->name('claim.ssop_detail');//
Route::match(['get','post'],'ssop_claimsixteen',[App\Http\Controllers\ClaimController::class, 'ssop_claimsixteen'])->name('claim.ssop_claimsixteen');//
Route::match(['get','post'],'ssop_recheck',[App\Http\Controllers\ClaimController::class, 'ssop_recheck'])->name('claim.ssop_recheck');//
Route::match(['get','post'],'ssop_recheck_search',[App\Http\Controllers\ClaimController::class, 'ssop_recheck_search'])->name('claim.ssop_recheck_search');//
Route::match(['get','post'],'ssop_report',[App\Http\Controllers\ClaimController::class, 'ssop_report'])->name('claim.ssop_report');//

Route::match(['get','post'],'ssop_recheck_new',[App\Http\Controllers\ClaimController::class, 'ssop_recheck_new'])->name('claim.ssop_recheck_new');//

Route::match(['get','post'],'ssop_pull_delete',[App\Http\Controllers\ClaimController::class, 'ssop_pull_delete'])->name('claim.ssop_pull_delete');//ลบข้อมูล
Route::match(['get','post'],'ssop_pull_new/{start}/{end}',[App\Http\Controllers\ClaimController::class, 'ssop_pull_new'])->name('claim.ssop_pull_new');//ดึงข้อมูลใหม่
Route::match(['get','post'],'ssop_send_pull_new',[App\Http\Controllers\ClaimController::class, 'ssop_send_pull_new'])->name('claim.ssop_send_pull_new');//ส่งออก
Route::match(['get','post'],'ssop_zip_pull_new',[App\Http\Controllers\ClaimController::class, 'ssop_zip_pull_new'])->name('claim.ssop_zip_pull_new');//

Route::match(['get','post'],'Tranfer_stm',[App\Http\Controllers\ClaimController::class, 'Tranfer_stm'])->name('claim.Tranfer_stm');//
Route::match(['get','post'],'Tranfer_stmsearch',[App\Http\Controllers\ClaimController::class, 'Tranfer_stmsearch'])->name('claim.Tranfer_stmsearch');//
Route::match(['get','post'],'Tranfer_stm_save',[App\Http\Controllers\ClaimController::class, 'Tranfer_stm_save'])->name('claim.Tranfer_stm_save');//

Route::match(['get','post'],'opt',[App\Http\Controllers\ClaimController::class, 'opt'])->name('claim.opt');//

Route::match(['get','post'],'free_schedule',[App\Http\Controllers\FreescheduleController::class, 'free_schedule'])->name('claim.free_schedule');//


//********************* */ Ward  ***********************************

Route::match(['get','post'],'check_ward',[App\Http\Controllers\CheckwardController::class, 'check_ward'])->name('ward.check_ward');//
Route::match(['get','post'],'check_warddetail/{id}',[App\Http\Controllers\CheckwardController::class, 'check_warddetail'])->name('ward.check_warddetail');//
Route::match(['get','post'],'check_wardnonote/{id}',[App\Http\Controllers\CheckwardController::class, 'check_wardnonote'])->name('ward.check_wardnonote');//
Route::match(['get','post'],'check_wardnoclaim/{id}',[App\Http\Controllers\CheckwardController::class, 'check_wardnoclaim'])->name('ward.check_wardnoclaim');//
Route::match(['get','post'],'check_wardsss/{id}',[App\Http\Controllers\CheckwardController::class, 'check_wardsss'])->name('ward.check_wardsss');//


//********************* */ รพสต  ***********************************

Route::match(['get','post'],'home_rpst',[App\Http\Controllers\RpstController::class, 'home_rpst'])->name('rpst.home_rpst');//




//********************* */ KTB CLAIM  ***********************************
Route::match(['get','post'],'ktb',[App\Http\Controllers\KTBController::class, 'ktb'])->name('k.ktb');//
Route::match(['get','post'],'ktb_search',[App\Http\Controllers\KTBController::class, 'ktb_search'])->name('k.ktb_search');//
Route::match(['get','post'],'ktb_ancdental_search',[App\Http\Controllers\KTBController::class, 'ktb_ancdental_search'])->name('k.ktb_ancdental_search');//

Route::match(['get','post'],'ktb_ferrofolic',[App\Http\Controllers\KTBController::class, 'ktb_ferrofolic'])->name('k.ktb_ferrofolic');//
Route::match(['get','post'],'ktb_ferrofolic_search',[App\Http\Controllers\KTBController::class, 'ktb_ferrofolic_search'])->name('k.ktb_ferrofolic_search');//

Route::match(['get','post'],'ktb_kids_glasses',[App\Http\Controllers\KTBController::class, 'ktb_kids_glasses'])->name('k.ktb_kids_glasses');//
Route::match(['get','post'],'ktb_kids_glasses_search',[App\Http\Controllers\KTBController::class, 'ktb_kids_glasses_search'])->name('k.ktb_kids_glasses_search');//

Route::match(['get','post'],'anc_Pregnancy_test',[App\Http\Controllers\KTBController::class, 'anc_Pregnancy_test'])->name('k.anc_Pregnancy_test');//
Route::match(['get','post'],'anc_Pregnancy_testsearch',[App\Http\Controllers\KTBController::class, 'anc_Pregnancy_testsearch'])->name('k.anc_Pregnancy_testsearch');//
Route::match(['get','post'],'anc_Pregnancy_test_export',[App\Http\Controllers\KTBController::class, 'anc_Pregnancy_test_export'])->name('k.anc_Pregnancy_test_export');//

Route::match(['get','post'],'ktb_spawn',[App\Http\Controllers\KTBController::class, 'ktb_spawn'])->name('k.ktb_spawn');//การตรวจหลังคลอด ANC


Route::match(['get','post'],'timein',[App\Http\Controllers\TimeINController::class, 'timein'])->name('TT.timein');//ลงเวลา
Route::match(['get','post'],'timein_save',[App\Http\Controllers\TimeINController::class, 'timein_save'])->name('TT.timein_save');//ลงเวลา


//********************* */ DENTAL  ***********************************
Route::match(['get','post'],'dental',[App\Http\Controllers\DentalController::class, 'dental'])->name('den.dental');//
Route::match(['get','post'],'dental_detail/{id}',[App\Http\Controllers\DentalController::class, 'dental_detail'])->name('den.dental_detail');//
Route::match(['get','post'],'dental_save',[App\Http\Controllers\DentalController::class, 'dental_save'])->name('den.dental_save');//
Route::match(['get','post'],'dental_edit/{id}',[App\Http\Controllers\DentalController::class, 'dental_edit'])->name('den.dental_edit');//
Route::match(['get','post'],'dental_update',[App\Http\Controllers\DentalController::class, 'dental_update'])->name('den.dental_update');//
Route::match(['get','post'],'dental_switchactive',[App\Http\Controllers\DentalController::class, 'dental_switchactive'])->name('den.dental_switchactive');// switchactive


//********************* */ OPD IPD  ***********************************
Route::match(['get','post'],'opdtoipd',[App\Http\Controllers\OpipController::class, 'opdtoipd'])->name('op.opdtoipd');//
Route::match(['get','post'],'opdtoipd_sub/{vn}',[App\Http\Controllers\OpipController::class, 'opdtoipd_sub'])->name('op.opdtoipd_sub');//
Route::match(['get','post'],'opdtoipd_subsubclaim/{vn}/{income}',[App\Http\Controllers\OpipController::class, 'opdtoipd_subsubclaim'])->name('op.opdtoipd_subsubclaim');//
Route::match(['get','post'],'opdtoipd_subsub/{vn}/{income}',[App\Http\Controllers\OpipController::class, 'opdtoipd_subsub'])->name('op.opdtoipd_subsub');//
// Route::match(['get','post'],'opdtoipd_sub/{month}/{year}',[App\Http\Controllers\OpipController::class, 'opdtoipd_sub'])->name('op.opdtoipd_sub');//




//********************* */ ENV  ***********************************
Route::match(['get','post'],'env_dashboard',[App\Http\Controllers\EnvController::class, 'env_dashboard'])->name('env.env_dashboard');//
Route::match(['get','post'],'env_water_rep',[App\Http\Controllers\EnvController::class, 'env_water_rep'])->name('env.env_water_rep');//
Route::match(['get','post'],'env_trash_rep',[App\Http\Controllers\EnvController::class, 'env_trash_rep'])->name('env.env_trash_rep');//
//บ่อบำบัด//////////////////////////////////////////////////////////////
//ลงผลข้อมูลน้ำ บ่อบำบัด
Route::match(['get','post'],'env_water',[App\Http\Controllers\EnvController::class, 'env_water'])->name('env.env_water');//หน้าหลักแสดงข้อมูล
Route::match(['get','post'],'env_water_add',[App\Http\Controllers\EnvController::class, 'env_water_add'])->name('env.env_water_add');//เพิ่มข้อมูล
Route::match(['get','post'],'env_water_save',[App\Http\Controllers\EnvController::class, 'env_water_save'])->name('env.env_water_save');//บันทึก
Route::match(['get','post'],'env_water_edit/{id}',[App\Http\Controllers\EnvController::class, 'env_water_edit'])->name('env.env_water_edit');//แก้ไขข้อมูล
Route::match(['get','post'],'env_water_update',[App\Http\Controllers\EnvController::class, 'env_water_update'])->name('env.env_water_update');//อัพเดท
Route::match(['get','post'],'env_water_delete/{id}',[App\Http\Controllers\EnvController::class, 'env_water_delete'])->name('env.env_water_delete');//ลบข้อมูล
Route::match(['get','post'],'env_water_datetime',[App\Http\Controllers\EnvController::class, 'env_water_datetime'])->name('env.env_water_datetime');//ค้นตามช่วงวันที่


//ขยะ//////////////////////////////////////////////////////////////
//ลงผลข้อมูลขยะ
Route::match(['get','post'],'env_trash',[App\Http\Controllers\EnvController::class, 'env_trash'])->name('env.env_trash');//หน้าหลักแสดงข้อมูล
Route::match(['get','post'],'env_trash_add',[App\Http\Controllers\EnvController::class, 'env_trash_add'])->name('env.env_trash_add');//เพิ่มข้อมูล
Route::match(['get','post'],'env_trash_save',[App\Http\Controllers\EnvController::class, 'env_trash_save'])->name('env.env_trash_save');//บันทึก
Route::match(['get','post'],'env_trash_edit/{id}',[App\Http\Controllers\EnvController::class, 'env_trash_edit'])->name('env.env_trash_edit');//แก้ไข
Route::match(['get','post'],'env_trash_update',[App\Http\Controllers\EnvController::class, 'env_trash_update'])->name('env.env_trash_update');//อัพเดท
Route::match(['get','post'],'env_trash_delete/{id}',[App\Http\Controllers\EnvController::class, 'env_trash_delete'])->name('env.env_trash_delete');//ลบข้อมูล

//ตั้งค่า//////////////////////////////////////////////////////////////
//ตั้งค่า parameter น้ำ
Route::match(['get','post'],'env_water_parameter',[App\Http\Controllers\EnvController::class, 'env_water_parameter'])->name('env.env_water_parameter');//หน้าหลักแสดงข้อมูล
Route::match(['get','post'],'env_water_parameter_add',[App\Http\Controllers\EnvController::class, 'env_water_parameter_add'])->name('env.env_water_parameter_add');//เพิ่มข้อมูล
Route::match(['get','post'],'env_water_parameter_save',[App\Http\Controllers\EnvController::class, 'env_water_parameter_save'])->name('env.env_water_parameter_save');//บันทึก
Route::match(['get','post'],'env_water_parameter_edit/{id}',[App\Http\Controllers\EnvController::class, 'env_water_parameter_edit'])->name('env.env_water_parameter_edit');//แก้ไข
Route::match(['get','post'],'env_water_parameter_update',[App\Http\Controllers\EnvController::class, 'env_water_parameter_update'])->name('env.env_water_parameter_update');//อัพเดท
Route::match(['get','post'],'env_water_parameter_delete/{id}',[App\Http\Controllers\EnvController::class, 'env_water_parameter_delete'])->name('env.env_water_parameter_delete');//ลบข้อมูล
Route::match(['get','post'],'env_water_parameter_switchactive',[App\Http\Controllers\EnvController::class, 'env_water_parameter_switchactive'])->name('env.env_water_parameter_switchactive');//สถานะ
Route::match(['get','post'],'env_water_parameter_set',[App\Http\Controllers\EnvController::class, 'env_water_parameter_set'])->name('env.env_water_parameter_set');//ตั้งค่ากลุ่มบ่อบำบัด
Route::match(['get','post'],'env_water_parameter_para_id/{id}',[App\Http\Controllers\EnvController::class, 'env_water_parameter_para_id'])->name('env.env_water_parameter_para_id');//

Route::match(['get','post'],'env_parameter_save',[App\Http\Controllers\EnvController::class, 'env_parameter_save'])->name('env.env_parameter_save');//บันทึก
Route::match(['get','post'],'env_parameter_destroy/{id}',[App\Http\Controllers\EnvController::class, 'env_parameter_destroy'])->name('env.env_parameter_destroy');//

//ตั้งค่าประเภทขยะ
Route::match(['get','post'],'env_trash_parameter',[App\Http\Controllers\EnvController::class, 'env_trash_parameter'])->name('env.env_trash_parameter');//หน้าหลักแสดงข้อมูล
Route::match(['get','post'],'env_trash_parameter_add',[App\Http\Controllers\EnvController::class, 'env_trash_parameter_add'])->name('env.env_trash_parameter_add');//เพิ่ม
Route::match(['get','post'],'env_trash_parameter_save',[App\Http\Controllers\EnvController::class, 'env_trash_parameter_save'])->name('env.env_trash_parameter_save');//บันทึก
Route::match(['get','post'],'env_trash_parameter_edit/{id}',[App\Http\Controllers\EnvController::class, 'env_trash_parameter_edit'])->name('env.env_trash_parameter_edit');//แก้ไข
Route::match(['get','post'],'env_trash_parameter_update',[App\Http\Controllers\EnvController::class, 'env_trash_parameter_update'])->name('env.env_trash_parameter_update');//อัพเดท
Route::match(['get','post'],'env_trash_parameter_delete/{id}',[App\Http\Controllers\EnvController::class, 'env_trash_parameter_delete'])->name('env.env_trash_parameter_delete');//ลบข้อมูล
Route::match(['get','post'],'env_trash_parameter_switchactive',[App\Http\Controllers\EnvController::class, 'env_trash_parameter_switchactive'])->name('env.env_trash_parameter_switchactive');//สถานะ

//ตั่งค่าตัวแทนจำหน่าย
Route::match(['get','post'],'env_vendor',[App\Http\Controllers\EnvController::class, 'env_vendor'])->name('env.env_vendor');//หน้าหลักแสดงข้อมูล
Route::match(['get','post'],'env_vendor_add',[App\Http\Controllers\EnvController::class, 'env_env_vendor_add'])->name('env.env_vendor_add');//เพิ่ม
Route::match(['get','post'],'env_vendor_save',[App\Http\Controllers\EnvController::class, 'env_env_vendor_save'])->name('env.env_vendor_save');//บันทึก
Route::match(['get','post'],'env_vendor_edit/{id}',[App\Http\Controllers\EnvController::class, 'env_env_vendor_edit'])->name('env.env_vendor_edit');//แก้ไข
Route::match(['get','post'],'env_vendor_update',[App\Http\Controllers\EnvController::class, 'env_env_vendor_update'])->name('env.env_vendor_update');//อัพเดท
Route::match(['get','post'],'env_vendor_destroy/{id}',[App\Http\Controllers\EnvController::class, 'env_env_vendor_destroy'])->name('env.env_vendor_destroy');//ลบข้อมูล

// ************** Report ****************************
// Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportNewController::class, 'report_db'])->name('re.report_db');
// Route::match(['get','post'],'report_hos',[App\Http\Controllers\ReportNewController::class, 'report_hos'])->name('re.report_hos');
// Route::match(['get','post'],'report_hos_new/{id}',[App\Http\Controllers\ReportNewController::class, 'report_hos_new'])->name('re.report_hos_new');

// Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportMedController::class, 'report_db'])->name('re.report_db');
// Route::match(['get','post'],'report_med',[App\Http\Controllers\ReportMedController::class, 'report_med'])->name('re.report_med');
// Route::match(['get','post'],'report_hos_med/{id}',[App\Http\Controllers\ReportMedController::class, 'report_hos_med'])->name('re.report_hos_med');
 
// ************** TB ****************************
Route::match(['get','post'],'tb_main',[App\Http\Controllers\TbController::class, 'tb_main'])->name('re.tb_main');
Route::match(['get','post'],'tb_main_pull',[App\Http\Controllers\TbController::class, 'tb_main_pull'])->name('re.tb_main_pull');
Route::match(['get','post'],'tb_main_detail/{id}',[App\Http\Controllers\TbController::class, 'tb_main_detail'])->name('re.tb_main_detail');

// ************** Support-System ****************************
Route::match(['get','post'],'support_system_dashboard',[App\Http\Controllers\SupportPRSController::class, 'support_system_dashboard'])->name('prs.support_system_dashboard');//
Route::match(['get','post'],'support_system_excel',[App\Http\Controllers\SupportPRSController::class, 'support_system_excel'])->name('prs.support_system_excel');//
Route::match(['get','post'],'support_system_process',[App\Http\Controllers\SupportPRSController::class, 'support_system_process'])->name('prs.support_system_process');//
Route::match(['get','post'],'support_system_check/{monts}/{years}',[App\Http\Controllers\SupportPRSController::class, 'support_system_check'])->name('prs.support_system_check');//
Route::match(['get','post'],'support_system_nocheck/{monts}/{years}',[App\Http\Controllers\SupportPRSController::class, 'support_system_nocheck'])->name('prs.support_system_nocheck');//
Route::match(['get','post'],'support_system',[App\Http\Controllers\SupportPRSController::class, 'support_system'])->name('prs.support_system');//
Route::match(['get','post'],'support_dashboard_chart',[App\Http\Controllers\SupportPRSController::class, 'support_dashboard_chart'])->name('prs.support_dashboard_chart');//

Route::match(['get','post'],'techservice',[App\Http\Controllers\CCtvController::class, 'techservice'])->name('tec.techservice');//

// ************** CCTV-Service ****************************
Route::match(['get','post'],'cctv',[App\Http\Controllers\CCtvController::class, 'cctv'])->name('tec.cctv');//
Route::match(['get','post'],'cctv_list',[App\Http\Controllers\CCtvController::class, 'cctv_list'])->name('tec.cctv_list');//
Route::match(['get','post'],'cctvqrcode/{id}',[App\Http\Controllers\CCtvController::class, 'cctvqrcode'])->name('tec.cctvqrcode');//
Route::match(['get','post'],'cctv_add',[App\Http\Controllers\CCtvController::class, 'cctv_add'])->name('tec.cctv_add');//
Route::match(['get','post'],'cctv_edit/{id}',[App\Http\Controllers\CCtvController::class, 'cctv_edit'])->name('tec.cctv_edit');//
Route::match(['get','post'],'cctv_save',[App\Http\Controllers\CCtvController::class, 'cctv_save'])->name('tec.cctv_save');//
Route::match(['get','post'],'cctv_update',[App\Http\Controllers\CCtvController::class, 'cctv_update'])->name('tec.cctv_update');//
Route::delete('cctv_destroy/{id}',[App\Http\Controllers\CCtvController::class, 'cctv_destroy'])->name('tec.cctv_destroy');//

Route::match(['get','post'],'cctv_report',[App\Http\Controllers\CCtvController::class, 'cctv_report'])->name('tec.cctv_report');//
Route::match(['get','post'],'cctv_report_process',[App\Http\Controllers\CCtvController::class, 'cctv_report_process'])->name('tec.cctv_report_process');//

Route::match(['get','post'],'fire_dashboard',[App\Http\Controllers\FireController::class, 'fire_dashboard'])->name('prs.fire_dashboard');//
Route::match(['get','post'],'fire_main',[App\Http\Controllers\FireController::class, 'fire_main'])->name('prs.fire_main');//
Route::match(['get','post'],'fire_pramuan_admin',[App\Http\Controllers\FireController::class, 'fire_pramuan_admin'])->name('prs.fire_pramuan_admin');//
Route::match(['get','post'],'fire_add',[App\Http\Controllers\FireController::class, 'fire_add'])->name('prs.fire_add');//
Route::match(['get','post'],'fire_save',[App\Http\Controllers\FireController::class, 'fire_save'])->name('prs.fire_save');//
Route::match(['get','post'],'fire_edit/{id}',[App\Http\Controllers\FireController::class, 'fire_edit'])->name('prs.fire_edit');//
Route::match(['get','post'],'fire_update',[App\Http\Controllers\FireController::class, 'fire_update'])->name('prs.fire_update');//
// Route::delete('fire_destroy/{id}',[App\Http\Controllers\FireController::class, 'fire_destroy'])->name('prs.fire_destroy');//
Route::match(['get','post'],'fire_qrcode/{id}',[App\Http\Controllers\FireController::class, 'fire_qrcode'])->name('prs.fire_qrcode');//
Route::match(['get','post'],'fire_qrcode_all',[App\Http\Controllers\FireController::class, 'fire_qrcode_all'])->name('prs.fire_qrcode_all');//
Route::match(['get','post'],'fire_qrcode_detail/{id}',[App\Http\Controllers\FireController::class, 'fire_qrcode_detail'])->name('prs.fire_qrcode_detail');//
Route::match(['get','post'],'fire_qrcode_detail_all',[App\Http\Controllers\FireController::class, 'fire_qrcode_detail_all'])->name('prs.fire_qrcode_detail_all');//
Route::match(['get','post'],'fire_report_day',[App\Http\Controllers\FireController::class, 'fire_report_day'])->name('prs.fire_report_day');//
Route::match(['get','post'],'fire_destroy/{id}',[App\Http\Controllers\FireController::class, 'fire_destroy'])->name('prs.fire_destroy');//
// ************** FDH ****************************
Route::match(['get','post'],'fdh_dashboard',[App\Http\Controllers\FdhController::class, 'fdh_dashboard'])->name('fdh.fdh_dashboard');// 
Route::match(['get','post'],'fdh_main',[App\Http\Controllers\FdhController::class, 'fdh_main'])->name('fdh.fdh_main');// 
Route::match(['get','post'],'fdh_checksit',[App\Http\Controllers\FdhController::class, 'fdh_checksit'])->name('fdh.fdh_checksit');// 
Route::match(['get','post'],'fdh_data',[App\Http\Controllers\FdhController::class, 'fdh_data'])->name('claim.fdh_data');//
Route::match(['get','post'],'fdh_data_process',[App\Http\Controllers\FdhController::class, 'fdh_data_process'])->name('claim.fdh_data_process');//
Route::match(['get','post'],'fdh_data_export',[App\Http\Controllers\FdhController::class, 'fdh_data_export'])->name('claim.fdh_data_export');//

Route::match(['get','post'],'fdh_report_rep',[App\Http\Controllers\FdhController::class, 'fdh_report_rep'])->name('fdh.fdh_report_rep');// 

// *******************FDH UCS *******************
Route::match(['get','post'],'fdh_rep_reject',[App\Http\Controllers\Fdh_RepController::class, 'fdh_rep_reject'])->name('fdh.fdh_rep_reject');//
Route::match(['get','post'],'fdh_rep_reject_save',[App\Http\Controllers\Fdh_RepController::class, 'fdh_rep_reject_save'])->name('fdh.fdh_rep_reject_save');//
Route::match(['get','post'],'fdh_rep_reject_send',[App\Http\Controllers\Fdh_RepController::class, 'fdh_rep_reject_send'])->name('fdh.fdh_rep_reject_send');//

Route::match(['get','post'],'fdh_rep',[App\Http\Controllers\Fdh_RepController::class, 'fdh_rep'])->name('fdh.fdh_rep');//
Route::match(['get','post'],'fdh_rep_save',[App\Http\Controllers\Fdh_RepController::class, 'fdh_rep_save'])->name('fdh.fdh_rep_save');//
Route::match(['get','post'],'fdh_rep_send',[App\Http\Controllers\Fdh_RepController::class, 'fdh_rep_send'])->name('fdh.fdh_rep_send');//

Route::match(['get','post'],'ofc_rep',[App\Http\Controllers\Fdh_RepController::class, 'ofc_rep'])->name('fdh.ofc_rep');//
Route::match(['get','post'],'ofc_rep_save',[App\Http\Controllers\Fdh_RepController::class, 'ofc_rep_save'])->name('fdh.ofc_rep_save');//
Route::match(['get','post'],'ofc_rep_send',[App\Http\Controllers\Fdh_RepController::class, 'ofc_rep_send'])->name('fdh.ofc_rep_send');//

Route::match(['get','post'],'hpv',[App\Http\Controllers\Fdh_HpvController::class, 'hpv'])->name('fdh.hpv');//
Route::match(['get','post'],'hpv_process_vn',[App\Http\Controllers\Fdh_HpvController::class, 'hpv_process_vn'])->name('fdh.hpv_process_vn');//
Route::match(['get','post'],'hpv_process',[App\Http\Controllers\Fdh_HpvController::class, 'hpv_process'])->name('fdh.hpv_process');//
Route::match(['get','post'],'hpv_export',[App\Http\Controllers\Fdh_HpvController::class, 'hpv_export'])->name('fdh.hpv_export');//
Route::match(['get','post'],'hpv_zip',[App\Http\Controllers\Fdh_HpvController::class, 'hpv_zip'])->name('fdh.hpv_zip');//

Route::match(['get','post'],'liquid',[App\Http\Controllers\Fdh_LiquidController::class, 'liquid'])->name('fdh.liquid');//
Route::match(['get','post'],'liquid_process_vn',[App\Http\Controllers\Fdh_LiquidController::class, 'liquid_process_vn'])->name('fdh.liquid_process_vn');//
Route::match(['get','post'],'liquid_process',[App\Http\Controllers\Fdh_LiquidController::class, 'liquid_process'])->name('fdh.liquid_process');//
Route::match(['get','post'],'liquid_export',[App\Http\Controllers\Fdh_LiquidController::class, 'liquid_export'])->name('fdh.liquid_export');//
Route::match(['get','post'],'liquid_zip',[App\Http\Controllers\Fdh_LiquidController::class, 'liquid_zip'])->name('fdh.liquid_zip');//

Route::match(['get','post'],'walkin',[App\Http\Controllers\Fdh_walkinController::class, 'walkin'])->name('claim.walkin');//
Route::match(['get','post'],'walkin_process_vn',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_process_vn'])->name('claim.walkin_process_vn');//
Route::match(['get','post'],'walkin_process',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_process'])->name('claim.walkin_process');//
Route::match(['get','post'],'walkin_export',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_export'])->name('claim.walkin_export');//
Route::match(['get','post'],'walkin_exportapi',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_exportapi'])->name('claim.walkin_exportapi');//
Route::match(['get','post'],'walkin_sendapi',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_sendapi'])->name('claim.walkin_sendapi');//
Route::match(['get','post'],'walkin_report',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_report'])->name('claim.walkin_report');//
Route::match(['get','post'],'walkin_export_zip',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_export_zip'])->name('claim.walkin_export_zip');//
Route::match(['get','post'],'walkin_send_api',[App\Http\Controllers\Fdh_walkinController::class, 'walkin_send_api'])->name('claim.walkin_send_api');//

Route::match(['get','post'],'stp',[App\Http\Controllers\Fdh_StpController::class, 'stp'])->name('fdh.stp');//
Route::match(['get','post'],'stp_process_vn',[App\Http\Controllers\Fdh_StpController::class, 'stp_process_vn'])->name('fdh.stp_process_vn');//
Route::match(['get','post'],'stp_process',[App\Http\Controllers\Fdh_StpController::class, 'stp_process'])->name('fdh.stp_process');//
Route::match(['get','post'],'stp_export',[App\Http\Controllers\Fdh_StpController::class, 'stp_export'])->name('fdh.stp_export');//

Route::match(['get','post'],'fdh_ipd',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd'])->name('fdh.fdh_ipd');//
Route::match(['get','post'],'fdh_ipd_an',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_an'])->name('fdh.fdh_ipd_an');//
Route::match(['get','post'],'fdh_ipd_process',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_process'])->name('fdh.fdh_ipd_process');//
Route::match(['get','post'],'fdh_ipdods_process',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipdods_process'])->name('fdh.fdh_ipdods_process');//
Route::match(['get','post'],'fdh_ipd_updateprojectcode',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_updateprojectcode'])->name('fdh.fdh_ipd_updateprojectcode');//
Route::match(['get','post'],'fdh_ipd_export',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_export'])->name('fdh.fdh_ipd_export');//
Route::match(['get','post'],'fdh_ipd_zip',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_zip'])->name('fdh.fdh_ipd_zip');//
Route::match(['get','post'],'fdh_ipdprb_process',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipdprb_process'])->name('fdh.fdh_ipdprb_process');//
Route::match(['get','post'],'fdh_ipd_irfupdate',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_irfupdate'])->name('fdh.fdh_ipd_irfupdate');//
Route::match(['get','post'],'fdh_ipd_aerupdate',[App\Http\Controllers\Fdh_IpdController::class, 'fdh_ipd_aerupdate'])->name('fdh.fdh_ipd_aerupdate');//

Route::match(['get','post'],'ucep24_main',[App\Http\Controllers\Fdh_Ucep24Controller::class, 'ucep24_main'])->name('fdh.ucep24_main');//
Route::match(['get','post'],'ucep24_main_process',[App\Http\Controllers\Fdh_Ucep24Controller::class, 'ucep24_main_process'])->name('fdh.ucep24_main_process');//
Route::match(['get','post'],'ucep24_main_update',[App\Http\Controllers\Fdh_Ucep24Controller::class, 'ucep24_main_update'])->name('fdh.ucep24_main_update');//
Route::match(['get','post'],'ucep24_main_export',[App\Http\Controllers\Fdh_Ucep24Controller::class, 'ucep24_main_export'])->name('fdh.ucep24_main_export');//
Route::match(['get','post'],'ucep24_main_zip',[App\Http\Controllers\Fdh_Ucep24Controller::class, 'ucep24_main_zip'])->name('fdh.ucep24_main_zip');//

Route::match(['get','post'],'fdh_ppfs_12001',[App\Http\Controllers\Fdh_PPfs12001Controller::class, 'fdh_ppfs_12001'])->name('fdh.fdh_ppfs_12001');//
Route::match(['get','post'],'fdh_ppfs_12001_process',[App\Http\Controllers\Fdh_PPfs12001Controller::class, 'fdh_ppfs_12001_process'])->name('fdh.fdh_ppfs_12001_process');//
Route::match(['get','post'],'fdh_ppfs_12001_export',[App\Http\Controllers\Fdh_PPfs12001Controller::class, 'fdh_ppfs_12001_export'])->name('fdh.fdh_ppfs_12001_export');//

Route::match(['get','post'],'fdh_ppfs_12002',[App\Http\Controllers\Fdh_PPfs12002Controller::class, 'fdh_ppfs_12002'])->name('fdh.fdh_ppfs_12002');//
Route::match(['get','post'],'fdh_ppfs_12002_process',[App\Http\Controllers\Fdh_PPfs12002Controller::class, 'fdh_ppfs_12002_process'])->name('fdh.fdh_ppfs_12002_process');//
Route::match(['get','post'],'fdh_ppfs_12002_export',[App\Http\Controllers\Fdh_PPfs12002Controller::class, 'fdh_ppfs_12002_export'])->name('fdh.fdh_ppfs_12002_export');//

Route::match(['get','post'],'fdh_ppfs_12003',[App\Http\Controllers\Fdh_PPfs12003Controller::class, 'fdh_ppfs_12003'])->name('fdh.fdh_ppfs_12003');//
Route::match(['get','post'],'fdh_ppfs_12003_process',[App\Http\Controllers\Fdh_PPfs12003Controller::class, 'fdh_ppfs_12003_process'])->name('fdh.fdh_ppfs_12003_process');//
Route::match(['get','post'],'fdh_ppfs_12003_export',[App\Http\Controllers\Fdh_PPfs12003Controller::class, 'fdh_ppfs_12003_export'])->name('fdh.fdh_ppfs_12003_export');//

Route::match(['get','post'],'fdh_ppfs_12004',[App\Http\Controllers\Fdh_PPfs12004Controller::class, 'fdh_ppfs_12004'])->name('fdh.fdh_ppfs_12004');//
Route::match(['get','post'],'fdh_ppfs_12004_process',[App\Http\Controllers\Fdh_PPfs12004Controller::class, 'fdh_ppfs_12004_process'])->name('fdh.fdh_ppfs_12004_process');//
Route::match(['get','post'],'fdh_ppfs_12004_export',[App\Http\Controllers\Fdh_PPfs12004Controller::class, 'fdh_ppfs_12004_export'])->name('fdh.fdh_ppfs_12004_export');//

Route::match(['get','post'],'fdh_ppfs_2206',[App\Http\Controllers\Fdh_PPfs2206Controller::class, 'fdh_ppfs_2206'])->name('fdh.fdh_ppfs_2206');//
Route::match(['get','post'],'fdh_ppfs_2206_process',[App\Http\Controllers\Fdh_PPfs2206Controller::class, 'fdh_ppfs_2206_process'])->name('fdh.fdh_ppfs_2206_process');//
Route::match(['get','post'],'fdh_ppfs_2206_export',[App\Http\Controllers\Fdh_PPfs2206Controller::class, 'fdh_ppfs_2206_export'])->name('fdh.fdh_ppfs_2206_export');//

Route::match(['get','post'],'fdh_ppfs_30011',[App\Http\Controllers\Fdh_PPfs30011Controller::class, 'fdh_ppfs_30011'])->name('fdh.fdh_ppfs_30011');//
Route::match(['get','post'],'fdh_ppfs_30011_process',[App\Http\Controllers\Fdh_PPfs30011Controller::class, 'fdh_ppfs_30011_process'])->name('fdh.fdh_ppfs_30011_process');//
Route::match(['get','post'],'fdh_ppfs_30011_export',[App\Http\Controllers\Fdh_PPfs30011Controller::class, 'fdh_ppfs_30011_export'])->name('fdh.fdh_ppfs_30011_export');//

Route::match(['get','post'],'fdh_ppfs_30015',[App\Http\Controllers\Fdh_PPfs30015Controller::class, 'fdh_ppfs_30015'])->name('fdh.fdh_ppfs_30015');//
Route::match(['get','post'],'fdh_ppfs_30015_process',[App\Http\Controllers\Fdh_PPfs30015Controller::class, 'fdh_ppfs_30015_process'])->name('fdh.fdh_ppfs_30015_process');//
Route::match(['get','post'],'fdh_ppfs_30015_export',[App\Http\Controllers\Fdh_PPfs30015Controller::class, 'fdh_ppfs_30015_export'])->name('fdh.fdh_ppfs_30015_export');//

Route::match(['get','post'],'ipd',[App\Http\Controllers\Fdh_IpdController::class, 'ipd'])->name('fdh.ipd');//
// *******************FDH OFC *******************
Route::match(['get','post'],'ofc_main',[App\Http\Controllers\Fdh_OfcController::class, 'ofc_main'])->name('fdh.ofc_main');//
Route::match(['get','post'],'ofc_main_process',[App\Http\Controllers\Fdh_OfcController::class, 'ofc_main_process'])->name('fdh.ofc_main_process');//
Route::match(['get','post'],'ofc_main_active',[App\Http\Controllers\Fdh_OfcController::class, 'ofc_main_active'])->name('fdh.ofc_main_active');//
Route::match(['get','post'],'ofc_main_export',[App\Http\Controllers\Fdh_OfcController::class, 'ofc_main_export'])->name('fdh.ofc_main_export');//
Route::match(['get','post'],'ofc_main_zip',[App\Http\Controllers\Fdh_OfcController::class, 'ofc_main_zip'])->name('fdh.ofc_main_zip');//


Route::match(['get','post'],'ofc_ipd',[App\Http\Controllers\Fdh_OfcipdController::class, 'ofc_ipd'])->name('fdh.ofc_ipd');//
Route::match(['get','post'],'ofc_ipd_process',[App\Http\Controllers\Fdh_OfcipdController::class, 'ofc_ipd_process'])->name('fdh.ofc_ipd_process');//
Route::match(['get','post'],'ofc_ipd_active',[App\Http\Controllers\Fdh_OfcipdController::class, 'ofc_ipd_active'])->name('fdh.ofc_ipd_active');//
Route::match(['get','post'],'ofc_ipd_export',[App\Http\Controllers\Fdh_OfcipdController::class, 'ofc_ipd_export'])->name('fdh.ofc_ipd_export');//
Route::match(['get','post'],'ofc_ipd_zip',[App\Http\Controllers\Fdh_OfcipdController::class, 'ofc_ipd_zip'])->name('fdh.ofc_ipd_zip');//

// *******************FDH OPD-IPD LGO *******************
Route::match(['get','post'],'lgo_main',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main'])->name('fdh.lgo_main');//
Route::match(['get','post'],'lgo_main_process',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_process'])->name('fdh.lgo_main_process');//
Route::match(['get','post'],'lgo_main_export',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_export'])->name('fdh.lgo_main_export');//
Route::match(['get','post'],'lgo_main_zip',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_zip'])->name('fdh.lgo_main_zip');//
Route::match(['get','post'],'lgo_main_rep',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_rep'])->name('fdh.lgo_main_rep');//
Route::match(['get','post'],'lgo_main_repsave',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_repsave'])->name('fdh.lgo_main_repsave');//
Route::match(['get','post'],'lgo_main_repsenddata',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_repsenddata'])->name('fdh.lgo_main_repsenddata');//
Route::match(['get','post'],'lgo_main_report',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_report'])->name('fdh.lgo_main_report');//

Route::match(['get','post'],'lgo_ipdmain',[App\Http\Controllers\Fdh_LgoIpdController::class, 'lgo_ipdmain'])->name('fdh.lgo_ipdmain');//
Route::match(['get','post'],'lgo_ipdmain_process',[App\Http\Controllers\Fdh_LgoIpdController::class, 'lgo_ipdmain_process'])->name('fdh.lgo_ipdmain_process');//
Route::match(['get','post'],'lgo_ipdmain_export',[App\Http\Controllers\Fdh_LgoIpdController::class, 'lgo_ipdmain_export'])->name('fdh.lgo_ipdmain_export');//
Route::match(['get','post'],'lgo_ipdmain_zip',[App\Http\Controllers\Fdh_LgoIpdController::class, 'lgo_ipdmain_zip'])->name('fdh.lgo_ipdmain_zip');//
 

// *******************FDH LGO *******************
// Route::match(['get','post'],'lgo_main',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main'])->name('fdh.lgo_main');//
// Route::match(['get','post'],'lgo_main_process',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_process'])->name('fdh.lgo_main_process');//
// Route::match(['get','post'],'lgo_main_export',[App\Http\Controllers\Fdh_LgoController::class, 'lgo_main_export'])->name('fdh.lgo_main_export');//

Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportSxController::class, 'report_db'])->name('re.report_db');
Route::match(['get','post'],'report_sx',[App\Http\Controllers\ReportSxController::class, 'report_sx'])->name('re.report_sx');
Route::match(['get','post'],'report_hos_sx/{id}',[App\Http\Controllers\ReportSxController::class, 'report_hos_sx'])->name('re.report_hos_sx');
// Route::match(['get','post'],'report_hos_sx',[App\Http\Controllers\ReportSxController::class, 'report_hos_sx'])->name('re.report_hos_sx');



// ************** Report ****************************
Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportNewController::class, 'report_db'])->name('re.report_db');
Route::match(['get','post'],'report_hos',[App\Http\Controllers\ReportNewController::class, 'report_hos'])->name('re.report_hos');
Route::match(['get','post'],'report_hos_new/{id}',[App\Http\Controllers\ReportNewController::class, 'report_hos_new'])->name('re.report_hos_new');

Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportMedController::class, 'report_db'])->name('re.report_db');
Route::match(['get','post'],'report_med',[App\Http\Controllers\ReportMedController::class, 'report_med'])->name('re.report_med');
Route::match(['get','post'],'report_hos_med/{id}',[App\Http\Controllers\ReportMedController::class, 'report_hos_med'])->name('re.report_hos_med');
 
Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportOpdController::class, 'report_db'])->name('re.report_db');
Route::match(['get','post'],'report_opd',[App\Http\Controllers\ReportOpdController::class, 'report_opd'])->name('re.report_opd');
Route::match(['get','post'],'report_hos_opd/{id}',[App\Http\Controllers\ReportOpdController::class, 'report_hos_opd'])->name('re.report_hos_opd'); 

Route::match(['get','post'],'report_db',[App\Http\Controllers\ReportSxController::class, 'report_db'])->name('re.report_db');
Route::match(['get','post'],'report_sx',[App\Http\Controllers\ReportSxController::class, 'report_sx'])->name('re.report_sx');
Route::match(['get','post'],'report_hos_sx/{id}',[App\Http\Controllers\ReportSxController::class, 'report_hos_sx'])->name('re.report_hos_sx');

Route::match(['get','post'],'pre_audit',[App\Http\Controllers\PreauditController::class, 'pre_audit'])->name('audit.pre_audit');
Route::match(['get','post'],'pre_audit_process_a',[App\Http\Controllers\PreauditController::class, 'pre_audit_process_a'])->name('audit.pre_audit_process_a');
Route::match(['get','post'],'audit_approve_code',[App\Http\Controllers\PreauditController::class, 'audit_approve_code'])->name('audit.audit_approve_code');
Route::match(['get','post'],'audit_approve_detail/{month}/{year}',[App\Http\Controllers\PreauditController::class, 'audit_approve_detail'])->name('audit.audit_approve_detail');
Route::match(['get','post'],'pre_audit_chart',[App\Http\Controllers\PreauditController::class, 'pre_audit_chart'])->name('audit.pre_audit_chart');
Route::match(['get','post'],'audit_pdx',[App\Http\Controllers\PreauditController::class, 'audit_pdx'])->name('audit.audit_pdx');
Route::match(['get','post'],'audit_pdx_detail/{month}/{year}',[App\Http\Controllers\PreauditController::class, 'audit_pdx_detail'])->name('audit.audit_pdx_detail');

// **************************** ทาลัสซีเมีย **********************************************
Route::match(['get','post'],'talassemaie',[App\Http\Controllers\PreauditController::class, 'talassemaie'])->name('audit.talassemaie');
Route::match(['get','post'],'talassemaie_detail/{month}/{year}',[App\Http\Controllers\PreauditController::class, 'talassemaie_detail'])->name('audit.talassemaie_detail');

// **************************** FDH **********************************************
Route::match(['get','post'],'fdh_mini_dataset',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset'])->name('fdh.fdh_mini_dataset');
Route::match(['get','post'],'fdh_mini_dataset_api',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_api'])->name('fdh.fdh_mini_dataset_api');
Route::match(['get','post'],'fdh_mini_dataset_pull',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pull'])->name('fdh.fdh_mini_dataset_pull');
Route::match(['get','post'],'fdh_mini_dataset_pullnoinv',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pullnoinv'])->name('fdh.fdh_mini_dataset_pullnoinv');
Route::match(['get','post'],'fdh_mini_dataset_apicliam',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_apicliam'])->name('fdh.fdh_mini_dataset_apicliam');
Route::match(['get','post'],'fdh_mini_dataset_rep',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_rep'])->name('fdh.fdh_mini_dataset_rep');
Route::match(['get','post'],'fdh_mini_dataset_pulljong',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pulljong'])->name('fdh.fdh_mini_dataset_pulljong');
Route::match(['get','post'],'fdh_mini_dataset_line',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_line'])->name('fdh.fdh_mini_dataset_line');
Route::match(['get','post'],'fdh_mini_dataset_destroy',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_destroy'])->name('fdh.fdh_mini_dataset_destroy');

Route::match(['get','post'],'fdh_authen',[App\Http\Controllers\FdhController::class, 'fdh_authen'])->name('fdh.fdh_authen');
Route::match(['get','post'],'fdh_authen_pull',[App\Http\Controllers\FdhController::class, 'fdh_authen_pull'])->name('fdh.fdh_authen_pull');

// **************************** ประกันสังคม New ECLAIM **********************************************
                // ************** หมัน New ECLAIM ***********
Route::match(['get','post'],'sss_ipd310',[App\Http\Controllers\Fdh_sssController::class, 'sss_ipd310'])->name('fdh.sss_ipd310');
Route::match(['get','post'],'sss_ipd310_process',[App\Http\Controllers\Fdh_sssController::class, 'sss_ipd310_process'])->name('fdh.sss_ipd310_process');
Route::match(['get','post'],'sss_ipd310_export',[App\Http\Controllers\Fdh_sssController::class, 'sss_ipd310_export'])->name('fdh.sss_ipd310_export');
Route::match(['get','post'],'sss_ipd310_zip',[App\Http\Controllers\Fdh_sssController::class, 'sss_ipd310_zip'])->name('fdh.sss_ipd310_zip');
                                
                // ************** อุปกรณ์ New ECLAIM ***********
Route::match(['get','post'],'sss_insipd302',[App\Http\Controllers\Fdh_sss302Controller::class, 'sss_insipd302'])->name('fdh.sss_insipd302');
Route::match(['get','post'],'sss_insipd302_process',[App\Http\Controllers\Fdh_sss302Controller::class, 'sss_insipd302_process'])->name('fdh.sss_insipd302_process');
Route::match(['get','post'],'sss_insipd302_export',[App\Http\Controllers\Fdh_sss302Controller::class, 'sss_insipd302_export'])->name('fdh.sss_insipd302_export');
Route::match(['get','post'],'sss_insipd302_zip',[App\Http\Controllers\Fdh_sss302Controller::class, 'sss_insipd302_zip'])->name('fdh.sss_insipd302_zip');

// Route::match(['get','post'],'fdh_mini_dataset_apicliamauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_apicliamauto'])->name('fdh.fdh_mini_dataset_apicliamauto');
// Route::match(['get','post'],'fdh_mini_dataset_pulljongauto',[App\Http\Controllers\FdhController::class, 'fdh_mini_dataset_pulljongauto'])->name('fdh.fdh_mini_dataset_pulljongauto');
Route::match(['get','post'],'air_dashboard',[App\Http\Controllers\AirController::class, 'air_dashboard'])->name('prs.air_dashboard');//
Route::match(['get','post'],'air_main',[App\Http\Controllers\AirController::class, 'air_main'])->name('prs.air_main');//
Route::match(['get','post'],'air_pramuan_admin',[App\Http\Controllers\AirController::class, 'air_pramuan_admin'])->name('prs.air_pramuan_admin');//
Route::match(['get','post'],'air_add',[App\Http\Controllers\AirController::class, 'air_add'])->name('prs.air_add');//
Route::match(['get','post'],'air_save',[App\Http\Controllers\AirController::class, 'air_save'])->name('prs.air_save');//
Route::match(['get','post'],'air_edit/{id}',[App\Http\Controllers\AirController::class, 'air_edit'])->name('prs.air_edit');//
Route::match(['get','post'],'air_update',[App\Http\Controllers\AirController::class, 'air_update'])->name('prs.air_update');//
Route::match(['get','post'],'air_destroy/{id}',[App\Http\Controllers\AirController::class, 'air_destroy'])->name('prs.air_destroy');//
Route::match(['get','post'],'air_qrcode_all',[App\Http\Controllers\AirController::class, 'air_qrcode_all'])->name('prs.air_qrcode_all');//
Route::match(['get','post'],'air_qrcode_detail_all',[App\Http\Controllers\AirController::class, 'air_qrcode_detail_all'])->name('prs.air_qrcode_detail_all');//
Route::match(['get','post'],'air_qrcode/{id}',[App\Http\Controllers\AirController::class, 'air_qrcode'])->name('prs.air_qrcode');//

Route::match(['get','post'],'air_qrcode_repaire',[App\Http\Controllers\AirController::class, 'air_qrcode_repaire'])->name('prs.air_qrcode_repaire');//
Route::match(['get','post'],'air_main_repaire',[App\Http\Controllers\AirController::class, 'air_main_repaire'])->name('prs.air_main_repaire');//
Route::match(['get','post'],'air_main_repaire_destroy/{id}',[App\Http\Controllers\AirController::class, 'air_main_repaire_destroy'])->name('prs.air_main_repaire_destroy');//
Route::match(['get','post'],'air_repaire_edit/{id}',[App\Http\Controllers\AirController::class, 'air_repaire_edit'])->name('prs.air_repaire_edit');//
Route::match(['get','post'],'air_repiare_update',[App\Http\Controllers\AirController::class, 'air_repiare_update'])->name('prs.air_repiare_update');//
Route::match(['get','post'],'air_report_type',[App\Http\Controllers\AirController::class, 'air_report_type'])->name('prs.air_report_type');//
Route::match(['get','post'],'air_report_typesub/{id}/{air_repaire_type}/{startdate}/{enddate}',[App\Http\Controllers\AirController::class, 'air_report_typesub'])->name('prs.air_report_typesub');//
Route::match(['get','post'],'air_report_building',[App\Http\Controllers\AirController::class, 'air_report_building'])->name('prs.air_report_building');//
Route::match(['get','post'],'air_report_building_sub/{id}',[App\Http\Controllers\AirController::class, 'air_report_building_sub'])->name('prs.air_report_building_sub');//
Route::match(['get','post'],'air_report_building_excel',[App\Http\Controllers\AirController::class, 'air_report_building_excel'])->name('prs.air_report_building_excel');//
Route::match(['get','post'],'air_report_problems',[App\Http\Controllers\AirController::class, 'air_report_problems'])->name('prs.air_report_problems');//
Route::match(['get','post'],'air_report_problemsub/{id}',[App\Http\Controllers\AirController::class, 'air_report_problemsub'])->name('prs.air_report_problemsub');//
Route::match(['get','post'],'air_report_problem_detail/{id}',[App\Http\Controllers\AirController::class, 'air_report_problem_detail'])->name('prs.air_report_problem_detail');//
Route::match(['get','post'],'air_report_problems_excel',[App\Http\Controllers\AirController::class, 'air_report_problems_excel'])->name('prs.air_report_problems_excel');//

Route::match(['get','post'],'document',[App\Http\Controllers\DocumentController::class, 'document'])->name('d.document');//
Route::match(['get','post'],'document_save',[App\Http\Controllers\DocumentController::class, 'document_save'])->name('d.document_save');//
Route::match(['get','post'],'documentsub/{id}',[App\Http\Controllers\DocumentController::class, 'documentsub'])->name('d.documentsub');//
Route::match(['get','post'],'document_edit/{id}',[App\Http\Controllers\DocumentController::class, 'document_edit'])->name('d.document_edit');//
Route::match(['get','post'],'document_update',[App\Http\Controllers\DocumentController::class, 'document_update'])->name('d.document_update');//
Route::match(['get','post'],'document_destroy/{id}',[App\Http\Controllers\DocumentController::class, 'document_destroy'])->name('d.document_destroy');//

Route::match(['get','post'],'tree_document',[App\Http\Controllers\TreeDocumentController::class, 'tree_document'])->name('d.tree_document');//
Route::match(['get','post'],'tree_document_save',[App\Http\Controllers\TreeDocumentController::class, 'tree_document_save'])->name('d.tree_document_save');//
Route::match(['get','post'],'tree_documentsub/{id}',[App\Http\Controllers\TreeDocumentController::class, 'tree_documentsub'])->name('d.tree_documentsub');//
Route::match(['get','post'],'tree_document_edit/{id}',[App\Http\Controllers\TreeDocumentController::class, 'tree_document_edit'])->name('d.tree_document_edit');//
Route::match(['get','post'],'tree_document_update',[App\Http\Controllers\TreeDocumentController::class, 'tree_document_update'])->name('d.tree_document_update');//
Route::match(['get','post'],'tree_document_destroy/{id}',[App\Http\Controllers\TreeDocumentController::class, 'tree_document_destroy'])->name('d.tree_document_destroy');//

Route::match(['get','post'],'nurse_dashboard',[App\Http\Controllers\NurseController::class, 'nurse_dashboard'])->name('d.nurse_dashboard');//
Route::match(['get','post'],'nurse_index',[App\Http\Controllers\NurseController::class, 'nurse_index'])->name('d.nurse_index');//



});
