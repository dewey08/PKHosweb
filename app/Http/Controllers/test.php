close data
if tonum(getsqldata([select sum(ifnull(drg_chrgitem_id,0)=0) cc from income ]))>0
	=writeerror('¡ÃØ³Ò Map ËÁÇ´ Chrgitem(Ê»Êª.) ãËé¤Ãº¶éÇ¹',oerror)
	retu .F.
endif

<!-- text to _sql noshow textmerge
create table if not exists person (person_id int(11) not null,house_id int(11) ,cid varchar(13) ,pname varchar(25) ,fname varchar(50) ,lname varchar(50) ,pcode char(2) ,sex char(1) ,nationality varchar(3) 
,citizenship varchar(3) ,education char(1) ,occupation varchar(4) ,religion char(2) ,marrystatus char(1) ,house_regist_type_id int(11) ,birthdate date ,has_house_regist char(1) ,chronic_disease_list varchar(250) 
,club_list varchar(250) ,village_id int(11) ,blood_group varchar(20) ,current_age int(11) ,death_date date ,hos_guid varchar(38) ,income_per_year int(11) ,home_position_id int(11) ,family_position_id int(11) 
,drug_allergy varchar(150) ,last_update datetime ,death char(1) ,pttype char(2) ,pttype_begin_date date ,pttype_expire_date date ,pttype_hospmain char(5) ,pttype_hospsub char(5) ,father_person_id int(11) 
,mother_person_id int(11) ,pttype_no varchar(50) ,sps_person_id int(11) ,birthtime time ,age_y int(11) ,age_m int(11) ,age_d int(11) ,family_id int(11) ,person_house_position_id int(11) ,couple_person_id int(11) 
,person_guid varchar(38) ,house_guid varchar(38) ,last_update_pttype datetime ,patient_link char(1) ,patient_hn varchar(9) ,found_dw_emr char(1) ,person_discharge_id int(11) ,movein_date date 
,discharge_date date ,person_labor_type_id int(11) ,father_name varchar(100) ,mother_name varchar(100) ,sps_name varchar(100) ,father_cid varchar(13) ,mother_cid varchar(13) ,sps_cid varchar(13) 
,bloodgroup_rh varchar(5) ,home_phone varchar(30) ,old_code varchar(50) ,deformed_status char(1) ,ncd_dm_history_type_id int(11) ,ncd_ht_history_type_id int(11) ,agriculture_member_type_id int(11) 
,senile char(1) ,in_region char(1) ,body_weight_kg double(15,3) ,height_cm double(15,3) ,nutrition_level int(11) ,height_nutrition_level int(11) ,bw_ht_nutrition_level int(11) ,hometel varchar(20) 
,worktel varchar(20) ,register_conflict char(1) ,care_person_name varchar(50) ,work_addr varchar(100) ,person_dm_screen_status_id int(11) ,person_ht_screen_status_id int(11) 
,person_stroke_screen_status_id int(11) ,person_obesity_screen_status_id int(11) ,person_dmht_manage_type_id int(11) ,last_screen_dmht_bdg_year int(11) ,dw_chronic_register char(1) 
,mobile_phone varchar(20) ,vid varchar(8) ,pttype_nhso_valid char(1) ,pttype_nhso_valid_datetime datetime 
,primary key (person_id)
,key ix_cid (cid)
,key ix_hos_guid (hos_guid)
,key ix_house_id (house_id)
,key ix_couple_person_id (couple_person_id)
,key ix_father_person_id (father_person_id)
,key ix_mother_person_id (mother_person_id)
,key ix_death (death)
,key ix_hn (patient_hn)
,key ix_oldcode (old_code)
,key ix_inregion (in_region)
,key ix_village_id (village_id)
,key ix_father_cid (father_cid)
,key ix_mother_cid (mother_cid)
,key ix_last_update (last_update)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists person_anc (person_anc_id int(11) not null,person_id int(11) ,person_anc_no int(11) ,anc_register_date date ,anc_register_staff varchar(25) ,vaccine_tt1_date date 
,vaccine_tt2_date date ,vaccine_tt3_date date ,vaccine_tt4_date date ,vaccine_tt_complete char(1) ,blood_check1_date date ,blood_check2_date date ,blood_vdrl1_result varchar(25) 
,blood_vdrl2_result varchar(25) ,blood_hiv1_result varchar(25) ,blood_hiv2_result varchar(25) ,blood_of_result varchar(10) ,blood_hct_result varchar(10) ,blood_hct_grade int(11) 
,pre_labor_service1_date date ,pre_labor_service2_date date ,pre_labor_service3_date date ,pre_labor_service4_date date ,first_doctor_date date ,risk_list varchar(250) ,risk_refer_date date 
,psycho_eval_score int(11) ,anc_vc_result_id int(11) ,post_labor_service1_date date ,post_labor_service2_date date ,preg_no int(11) ,preg_begin_date date ,labor_date date ,labor_place_id int(11) 
,labor_doctor_type_id int(11) ,alive_child_count int(11) ,dead_child_count int(11) ,current_preg_age int(11) ,anc_finish char(1) ,labor_status_id int(11) ,edc date ,lmp date ,post_labor_service3_date date 
,labour_type_id int(11) ,labour_hospcode char(5) ,labor_icd10 varchar(7) ,ga int(11) ,discharge char(1) ,discharge_date date ,risk_level int(11) ,out_region char(1) ,thalassaemia_result_id int(11) 
,hos_guid varchar(38) ,last_update datetime ,new_book char(1) ,pre_labor_service_percent double(15,3) ,post_labor_service_percent double(15,3) ,thalasseima_preg_age int(11) 
,thalasseima_wife_of_result char(1) ,thalasseima_husband_of_result char(1) ,thalasseima_wife_dcip_result char(1) ,thalasseima_husband_dcip_result char(1) ,thalasseima_wife_hbtyping_result char(1) 
,thalasseima_husband_hbtyping_result char(1) ,thalasseima_wife_alpha1_result char(1) ,thalasseima_husband_alpha1_result char(1) ,thalasseima_wife_dx_icd10 varchar(9) 
,thalasseima_husband_dx_icd10 varchar(9) ,husband_pname varchar(30) ,husband_fname varchar(60) ,husband_lname varchar(60) ,husband_person_id int(11) ,dental_tx_date date 
,husban_thalassaemia_result_id int(11) ,pre_labor_service5_date date ,thalassemia_screen_date date ,thalassemia_confirm_date date ,thalassemia_prenatal_date date 
,thalassemia_prenatal_confirm char(1) ,thalassemia_prenatal_confirm_date date ,lmp_from_us char(1) ,vaccine_dtanc1_date date ,vaccine_dtanc2_date date ,vaccine_dtanc3_date date 
,vaccine_dtanc4_date date ,vaccine_dtanc5_date date ,ultrasound_text text,force_complete_export char(1) ,force_complete_date date ,send_nhso char(1) ,nhso_send_date date ,nhso_send_time time 
,nhso_send_staff varchar(20) ,nhso_data_ok char(1) ,nhso_reply_error char(1) ,nhso_error_code varchar(50) ,nhso_reply_update_datetime datetime ,thalassaemia_wife_location_type_id int(11) 
,service_count int(11) ,wife_thalassaemia_risk_type_id int(11) ,husband_thalassaemia_risk_type_id int(11) ,has_risk char(1) ,force_labor_complete_export char(1) ,force_labor_complete_date date 
,primary key (person_anc_id)
,key ix_anc_finish (anc_finish)
,key ix_discharge (discharge)
,key ix_out_region (out_region)
,key ix_person_id (person_id)
,key ix_last_update (last_update)
,key ix_post_labor_service3_date (post_labor_service3_date)
,key ix_hos_guid (hos_guid)
,key ix_force_complete_export (force_complete_export)
,key ix_force_labor_complete_date (force_labor_complete_date)
,key ix_force_labor_complete_date2 (force_labor_complete_export,force_labor_complete_date)
,key person_id (person_id,preg_no)
,key ix_force_labor_complete_date2_index (force_labor_complete_export,force_labor_complete_date)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists person_anc_service (person_anc_service_id int(11) not null,person_anc_id int(11) ,anc_service_date date ,anc_service_note varchar(250) ,pa_week int(11) ,service_result char(1) 
,provider_type int(11) ,vn varchar(13) ,provider_hospcode char(5) ,old_visitno int(11) ,anc_service_type_id int(11) ,anc_service_number int(11) ,service_text varchar(250) ,hos_guid varchar(38) 
,anc_service_time time ,anc_location_type_id int(11) ,old_visitcode varchar(25) ,real_anc_service char(1) ,home_visit char(1) ,ga int(11) ,pass_quality char(1) ,service_note_text text
,primary key (person_anc_service_id)
,key ix_old_visitno (old_visitno)
,key ix_person_anc_id (person_anc_id)
,key ix_pa_week (pa_week)
,key ix_old_visitcode (old_visitcode)
,key ix_hos_guid (hos_guid)
,key vn (vn)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists dtmain (dtmain_id int(11) not null,dn varchar(7) ,doctor varchar(7) ,fee double(15,3) ,hn varchar(9) ,icd varchar(250) ,note text,scount int(11) ,tcount int(11) ,tmcode varchar(10) 
,ttcode varchar(250) ,vn varchar(13) ,vstage int(11) ,vstdate date ,vsttime time ,tm_no int(11) ,doctor_helper varchar(6) ,rcount int(11) ,icd9 varchar(9) ,qty_count int(11) ,opi_guid varchar(38) 
,begin_time datetime ,end_time datetime ,dtmain_guid varchar(38) ,staff varchar(25) ,pregnancy char(1) ,post_labour char(1) ,report_update char(1) ,pregnancy_caries_count int(11) 
,pregnancy_gingivitis char(1) ,pregnancy_calculus char(1) ,pregnancy_checkup char(1) ,hos_guid varchar(38) ,update_datetime datetime ,dx_guid varchar(38) ,dental_plan_detail_id int(11) 
,department char(3) ,an varchar(9) ,depcode char(3) ,rc_count int(11) 
,primary key (dtmain_id)
,key ix_dn (dn)
,key ix_hn (hn)
,key ix_vn (vn)
,key ix_vstdate (vstdate)
,key ix_opi_guid (opi_guid)
,key ix_tmcode (tmcode)
,key ix_dtmain_guid (dtmain_guid)
,key ix_dental_plan_detail_id (dental_plan_detail_id)
,key ix_an (an)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists dttm (code varchar(10) not null,name varchar(250) ,requiredtc char(1) ,vorder int(11) ,treatment char(1) ,icd10 varchar(9) ,icd9cm varchar(9) ,icode varchar(7) ,opd_price1 double(15,3) 
,opd_price2 double(15,3) ,opd_price3 double(15,3) ,ipd_price1 double(15,3) ,ipd_price2 double(15,3) ,ipd_price3 double(15,3) ,dttm_group_id int(11) ,unit varchar(20) ,charge_per_qty char(1) 
,active_status char(1) ,dttm_guid varchar(38) ,thai_name varchar(250) ,charge_area_qty char(1) ,dttm_subgroup_id int(11) ,icd10tm_operation_code varchar(15) ,dttm_dw_report_group_id int(11) 
,export_proced char(1) ,dent2006_item_code varchar(50) ,hos_guid varchar(38) ,hoi varchar(6) 
,primary key (code)
,key name (name)
,key treatment (treatment)
,key ix_dttm_guid (dttm_guid)
,key ix_hos_guid (hos_guid)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists pp_special (pp_special_id int(11) not null,vn varchar(12) ,pp_special_type_id int(11) ,doctor varchar(25) ,pp_special_service_place_type_id int(11) ,entry_datetime datetime 
,dest_hospcode char(5) ,hos_guid char(38) ,pp_special_text text,hn varchar(9) 
,primary key (pp_special_id)
,key ix_hos_guid (hos_guid)
,key ix_vn (vn)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists pp_special_type (pp_special_type_id int(11) not null,pp_special_type_name varchar(200) ,hos_guid char(38) ,pp_special_code varchar(6) 
,primary key (pp_special_type_id)
,unique key ix_pp_special_type_name (pp_special_type_name)
,key ix_hos_guid (hos_guid)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists er_nursing_detail (vn varchar(13) not null,arrive_time datetime ,referin_person varchar(50) ,trauma char(1) ,bba char(1) ,dba char(1) ,psychic char(1) ,revisit48hr char(1) 
,gcs_e double(15,3) ,gcs_v double(15,3) ,gcs_m double(15,3) ,pupil_l double(15,3) ,pupil_r double(15,3) ,inform_person varchar(50) ,interview_person varchar(50) ,report_doctor_time datetime 
,doctor_finish_time datetime ,support_information varchar(250) ,visit_type char(1) ,transporter varchar(50) ,er_accident_type_id int(11) ,er_emergency_type int(11) ,er_refer_hosptype_id int(11) 
,er_refer_sender_id int(11) ,discharge_date date ,discharge_time time ,admit_2hr char(1) ,er_transfer_hosptype_id int(11) ,accident_in_province char(1) ,accident_admit char(1) 
,accident_dead_before_arrive char(1) ,accident_dead_in_hospital char(1) ,accident_transport_type_id int(11) ,accident_type_1 int(11) ,accident_type_2 int(11) ,accident_type_3 int(11) ,hos_guid varchar(38) 
,accident_type_4 int(11) ,accident_type_5 int(11) ,accident_type_6 int(11) ,o2sat double(15,3) ,accident_place_type_id int(11) ,accident_person_type_id int(11) ,accident_alcohol_type_id int(11) 
,accident_drug_type_id int(11) ,accident_airway_type_id int(11) ,accident_bleed_type_id int(11) ,accident_belt_type_id int(11) ,accident_helmet_type_id int(11) ,accident_splint_type_id int(11) 
,accident_fluid_type_id int(11) ,accident_note_text text,accident_gis_lat varchar(50) ,accident_gis_long varchar(50) ,accident_datetime datetime ,accident_place varchar(200) ,pupil_l_text varchar(200) 
,pupil_r_text varchar(200) ,accident_immo_cs_type_id int(11) ,accident_vehicle_regno varchar(100) ,coma_score int(11) ,br1 int(11) ,br2 int(11) ,br3 int(11) ,br4 int(11) ,br5 int(11) ,br6 int(11) ,ais1 int(11) 
,ais2 int(11) ,ais3 int(11) ,ais4 int(11) ,ais5 int(11) ,ais6 int(11) ,gcs int(11) ,rts double(22,6) ,ps double(22,3) ,iss double(22,6) ,is_blunt char(1) 
,primary key (vn)
,key ix_hos_guid (hos_guid)) engine=MyISAM default charset=tis620; -->

<!-- create table if not exists clinic_visit (hn varchar(9) ,clinic char(3) not null,vn varchar(13) not null,visit_type int(11) ,hos_guid varchar(38) ,afb_check char(1) ,afb_month_number int(11) ,hos_guid_ext varchar(64) ,pcu_code varchar(5) ,pcu_vn varchar(13) 
,primary key (clinic,vn)
,key clinic (clinic)
,key hn (hn)
,key ix_hos_guid (hos_guid)
,key ix_hos_guid_ext (hos_guid_ext)) ENGINE=MyISAM default CHARSET=tis620 engine=MyISAM default charset=tis620; -->
      
select o.vn,o.hn,pt.cid,concat(pt.pname,pt.fname,' ',pt.lname) ptname
,seekname(pt.sex,'sex') sex
,seekname(pt.marrystatus,'marry') marry
,seekname(pt.nationality,'nation') nation
,seekname(pt.occupation,'occupation') occupationname
,setdate(o.vstdate) date,settime(o.vsttime) time
,seekname(o.main_dep,'kskdepartment') ward
,seekname(o.spclty,'spclty') department
,o.pttype,seekhipdatas(o.pttype,0) maininscl
,seeknames(o.pttype,'pttype') pttypename
,seeknames(pt.pttype,'pttype') pttypename_patient
,hospmain(o.vn) hospmain
,doctorlicense(o.doctor) doctor
,v.income money_hosxp
,v.rcpt_money
,(select sum(qty*unitprice) from opitemrece where vn=o.vn) money_total
,(select sum(sum_price) from opitemrece where vn=o.vn and paidst in ('03')) paid_money
,diagnosis('opd',o.vn,1) pdx
,diagnosis('opd',o.vn,3) sdx
,operation('opd',o.vn) oper
,if(d.vn is not null,'Y',null) accident
,cc.claimcode,seekname(cc.claimcode,'servicetype') servicetype 
,seekname(o.ovstist,'ovstist') comein
,seekname(o.ovstost,'ovstost') discharge
#,o.rfrilct referin
#,o.rfrolct referout
,(select refer_hospcode from referin where vn=o.vn limit 1) referin
,(select refer_hospcode from referout where vn=o.vn limit 1) referout
from ovst o
left join patient pt on pt.hn=o.hn
left join vn_stat v on v.vn=o.vn
left join er_nursing_detail d on d.vn=o.vn and d.er_accident_type_id between 1 and 19
 
 

select i.an,i.hn,pt.cid,concat(pt.pname,pt.fname,' ',pt.lname) ptname
,seekname(pt.sex,'sex') sex
,seekname(pt.marrystatus,'marry') marry
,seekname(pt.nationality,'nation') nation
,seekname(pt.occupation,'occupation') occupationname
,setdate(i.dchdate) date,settime(i.dchtime) time
,seekname(i.ward,'ward') ward
,seekname(i.spclty,'spclty') department
,seekhipdatas(i.pttype,0) maininscl
,i.pttype,seeknames(i.pttype,'pttype') pttypename
,seeknames(pt.pttype,'pttype') pttypename_patient
,hospmain(i.an) hospmain
,doctorlicense(i.dch_doctor) doctor
,a.income money_hosxp
,(select sum(qty*unitprice) from opitemrece where an=i.an) money_total
,diagnosis('ipd',i.an,1) pdx
,diagnosis('ipd',i.an,3) sdx
,operation('ipd',i.an) oper
,cc.claimcode,seekname(cc.claimcode,'servicetype') servicetype
,seekname(i.ivstist,'ovstist') comein
,seekname(i.dchtype,'dchtype') discharge
#,i.rfrilct referin
#,i.rfrolct referout
,(select refer_hospcode from referin where vn=i.an limit 1) referin
,(select refer_hospcode from referout where vn=i.an limit 1) referout
from ipt i
left join patient pt on pt.hn=i.hn
left join an_stat a on a.an=i.an
 
  

text to _pat noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpdata (primary key (hn)) select * from patient limit 0;

replace into tmpData select pt.* from patient pt join ovst o on o.hn=pt.hn where o.vn in (select vn from tmpExport);
replace into tmpdata select pt.* from patient pt join ipt i on i.hn=pt.hn where i.an in (select vn from tmpExport);

select ifnull(occ.zip09_code,'13') occupa,nn.nhso_code nation,t.*
from tmpData t
left join occupation occ on occ.occupation=t.occupation
left join nationality nn on nn.nationality=t.nationality
endtext

text to _ins noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (seq varchar(30),cid varchar(13),hn varchar(9),an varchar(9),pname varchar(20),fname varchar(40),lname varchar(40),maininscl varchar(10),inscl varchar(2),subtype varchar(2),subinscl varchar(2),datein date,dateexp date,hospmain varchar(5),hospsub varchar(5),permitno varchar(30),htype varchar(1)
,primary key (seq)) engine=MyISAM default charset=tis620;

replace into tmpdata select o.vn seq,v.cid,o.hn,space(9) an,pt.pname,pt.fname,pt.lname
,seekhipdata(ptt.hipdata_code,1) maininscl
,ptt.pcode inscl
,if(ptt.pcode like 'U%','UC',ptt.pcode) subtype
,o.pttype subinscl
,v.pttype_begin datein ,v.pttype_expire dateexp 
,v.hospmain,v.hospsub
,cc.claimcode permitno
,if(ex.maininscl='SSS',
	case
		when ?myhospcode regexp ?myhospmain then '1'
#		when ex.hospmain regexp ?myhospmain then '2'
#		when ex.hospmain like 'X%' or hospitalchangwat(ex.hospmain)<>hospitalchangwat(?myhospcode) then '4'
		else '2'
	end
,'') htype
from tmpExport ex
join ovst o on o.vn=ex.vn
left join patient pt on pt.hn=o.hn
left join vn_stat v on v.vn=o.vn
left join pttype ptt on ptt.pttype=o.pttype
left join tmpclaimcode cc on cc.vn=o.vn;

replace into tmpData 
select i.an seq,v.cid,i.hn,i.an,pt.pname,pt.fname,pt.lname
,seekhipdata(ptt.hipdata_code,1) maininscl
,ptt.pcode inscl
,if(ptt.pcode like 'U%','UC',ptt.pcode) subtype
,i.pttype subinscl
,v.pttype_begin datein ,v.pttype_expire dateexp 
,v.hospmain,v.hospsub
,cc.claimcode permitno
,if(ex.maininscl='SSS',
	case
		when ?myhospcode regexp ?myhospmain then '1'
#		when ex.hospmain regexp ?myhospmain then '2'
#		when ex.hospmain like 'X%' or hospitalchangwat(ex.hospmain)<>hospitalchangwat(?myhospcode) then '4'
		else '2'
	end
,'') htype
from tmpExport ex 
join ipt i on i.an=ex.vn
left join patient pt on pt.hn=i.hn
left join vn_stat v on v.vn=i.vn
left join pttype ptt on ptt.pttype=i.pttype
left join tmpclaimcode cc on cc.vn=i.an;

select t.* from tmpData t
endtext

text to _opd noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (index (seq))
select o.vn seq,o.hn
,sp.nhso_code clinic 
,o.vstdate dateopd 
,date_format(o.vsttime,'%H%i') timeopd 
,'1' uuc
from tmpExport ex 
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty;

select t.* from tmpData t
endtext

text to _orf noshow textmerge
call modifycolumn('referin','refer_hospcode','varchar(5)',null);
call modifycolumn('referout','refer_hospcode','varchar(5)',null);

drop temporary table if exists tmpData;
create temporary table tmpData (primary key (seq,refer,refertype))
select o.vn seq,o.vn,o.hn
,r.refer_date dateopd
,sp.nhso_code clinic 
,ifnull(r.refer_hospcode,'') refer 
,'1' refertype
from tmpExport ex
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty
join referin r on r.vn=o.vn;

replace into tmpdata select o.vn seq,o.vn,o.hn
,ifnull(r.refer_date,o.vstdate) dateopd
,sp.nhso_code clinic 
,ifnull(r.refer_hospcode,'') refer 
,'2' refertype
from tmpExport ex 
join ovst o on o.vn=ex.vn
left join ovstost t on t.ovstost=o.ovstost
left join spclty sp on sp.spclty=o.spclty
left join referout r on r.vn=o.vn
where (t.export_code='3' or r.vn is not null);

select t.* from tmpData t
endtext

text to _odx noshow textmerge
update ovstdiag set diagtype='5' where vstdate between @ds1 and @ds2  and icd10 regexp '^[V-Y]';

drop temporary table if exists tmpData;
create temporary table tmpData (index (seq,dxtype,diag))
select o.vn seq,o.hn,seekcid(o.hn,null) cid
,o.vstdate datedx
,sp.nhso_code clinic
,dx.icd10 diag
,dx.diagtype dxtype
,doctorlicense(dx.doctor) drdx
from tmpExport ex 
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty
join ovstdiag dx on dx.vn=o.vn
where dx.icd10 not regexp '^[0-9]'
order by o.vn,dx.diagtype,dx.ovst_diag_id;

select t.* from tmpData t
endtext

text to _oop noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (index (seq,oper))
select o.vn seq,o.hn,seekcid(o.hn,null) cid
,o.vstdate dateopd
,sp.nhso_code clinic
,op.icd10 oper
,op.diagtype optype
,doctorlicense(op.doctor) dropid
from tmpExport ex
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty
join ovstdiag op on op.vn=o.vn
where op.icd10 regexp '^[0-9]'
order by o.vn,op.ovst_diag_id;

insert into tmpdata select o.vn seq,o.hn,seekcid(o.hn,null) cid
,o.vstdate dateopd
,sp.nhso_code clinic
,tm.icd10tm_operation_code oper
,'2' optype
,doctorlicense(dt.doctor) dropid
from tmpExport ex
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty
join dtmain dt on dt.vn=o.vn 
join dttm tm on tm.code=dt.tmcode
where ifnull(tm.icd10tm_operation_code,'')<>'';


replace into tmpdata select o.vn seq,o.hn,seekcid(o.hn,null) cid
,o.vstdate dateopd
,sp.nhso_code clinic
,dt.icd10tm oper
,'2' optype
,doctorlicense(op.doctor) dropid
from tmpExport ex
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty
JOIN doctor_operation op on op.vn=o.vn
join er_oper_code dt on dt.er_oper_code=op.er_oper_code
where dt.icd10tm in('9991810','9991811');

replace into tmpdata select o.vn seq,o.hn,seekcid(o.hn,null) cid
,o.vstdate dateopd
,sp.nhso_code clinic
,if(n.nhso_adp_code='58001','9991810','9991811') oper
,'2' optype
,doctorlicense(r.doctor) dropid
from tmpExport ex
join ovst o on o.vn=ex.vn
left join spclty sp on sp.spclty=o.spclty
join opitemrece r on r.vn=o.vn
JOIN nondrugitems n on n.icode=r.icode
where n.nhso_adp_code in('58001','58020');

select t.* from tmpData t <<icase(ltm,'','where length(oper)<=5')>>
endtext

text to _ipd noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (index (an))
select i.an,i.hn
,i.regdate dateadm,formattime(i.regtime) timeadm
,i.dchdate datedsc,formattime(i.dchtime) timedsc
,s.nhso_dchstts dischs 
,t.nhso_dchtype discht
,i.ward warddsc
,ifnull(st.nhso_code,'01') dept
,i.bw/1000 adm_w
,'1' UUC
,'I' svctype
from tmpExport ex 
join ipt i on i.an=ex.vn
left join dchstts s on s.dchstts=i.dchstts
left join dchtype t on t.dchtype=i.dchtype
left join spclty st on st.spclty=i.spclty;

select t.* from tmpData t
endtext

text to _irf noshow textmerge
call modifycolumn('referin','refer_hospcode','varchar(5)',null);
call modifycolumn('referout','refer_hospcode','varchar(5)',null);

drop temporary table if exists tmpData;
create temporary table tmpData (index (seq,refer,refertype))
select i.an seq,i.an,i.hn
,ifnull(r.refer_date,i.dchdate) dateopd
,sp.nhso_code clinic 
,r.refer_hospcode refer 
,'2' refertype
from tmpExport ex 
join ipt i on i.an=ex.vn
left join dchtype t on t.dchtype=i.dchtype
left join spclty sp on sp.spclty=i.spclty
left join referout r on r.vn=i.an
where (t.nhso_dchtype='4' or r.vn is not null);

select t.* from tmpData t
endtext

text to _idx noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (index (an,diag,dxtype))
select i.an
,i.dchdate datedx
,sp.nhso_code clinic
,dx.icd10 diag
,dx.diagtype dxtype
,doctorlicense(dx.doctor) drdx
from tmpExport ex 
join ipt i on i.an=ex.vn
left join spclty sp on sp.spclty=i.spclty
join iptdiag dx on dx.an=i.an
order by i.an,dx.diagtype,dx.ipt_diag_id;

select t.* from tmpData t
endtext

text to _iop noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (index (an,oper))
select i.an
,sp.nhso_code clinic
,op.icd9 oper
,op.oper_type optype
,op.opdate datein,date_format(op.optime,'%H%i') timein
,op.enddate dateout,date_format(op.endtime,'%H%i') timeout
,doctorlicense(op.doctor) dropid
from tmpExport ex 
join ipt i on i.an=ex.vn
left join spclty sp on sp.spclty=i.spclty
join iptoprt op on op.an=i.an
order by i.an,op.oper_type,op.iptoprt_id;

select t.* from tmpData t
endtext

text to _cht noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (seq varchar(30),cid varchar(13),hn varchar(9),an varchar(9),date date,pttype varchar(2),total double (15,2),paid double(15,2)
,primary key (seq)) engine=MyISAM default charset=tis620;

replace into tmpdata select o.vn seq,pt.cid,o.hn,null an,o.vstdate date,o.pttype,v.income total,v.rcpt_money paid
from tmpExport ex
join ovst o on o.vn=ex.vn
left join patient pt on pt.hn=o.hn
join vn_stat v on v.vn=o.vn;

replace into tmpdata select i.an seq,pt.cid,i.hn,i.an,i.dchdate date,i.pttype,a.income total,a.rcpt_money paid
from tmpExport ex 
join ipt i on i.an=ex.vn
left join patient pt on pt.hn=i.hn 
join an_stat a on a.an=i.an;

select t.* from tmpData t
endtext

text to _cha noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (seq varchar(30),cid varchar(13),hn varchar(9),an varchar(9),date date,billmaud varchar(2),chrgitem varchar(2),sum_price double(15,2),maininscl varchar(10));

insert into tmpdata select o.vn seq,pt.cid,o.hn,null an,o.vstdate date ,drg.drg_chrgitem_id billmaud,if(oo.paidst in ('03'),chrgitem_code2,chrgitem_code1) chrgitem,sum_price,ex.maininscl
from tmpExport ex
join ovst o on o.vn=ex.vn
left join patient pt on pt.hn=o.hn
join opitemrece oo on oo.vn=o.vn
left join s_drugitems d on d.icode=oo.icode
left join income inc on inc.income=oo.income 
left join drg_chrgitem drg on drg.drg_chrgitem_id=inc.drg_chrgitem_id;

insert into tmpdata select i.an seq,pt.cid,i.hn,i.an,i.dchdate date,drg.drg_chrgitem_id billmaud,if(oo.paidst in ('03'),chrgitem_code2,chrgitem_code1) chrgitem,sum_price,ex.maininscl
from tmpExport ex
join ipt i on i.an=ex.vn
left join patient pt on pt.hn=i.hn 
join opitemrece oo on oo.an=i.an 
left join s_drugitems d on d.icode=oo.icode
left join income inc on inc.income=oo.income 
left join drg_chrgitem drg on drg.drg_chrgitem_id=inc.drg_chrgitem_id;

select t.*,sum(sum_price) amount from tmpData t group by seq,chrgitem
endtext

*ÃËÑÊ ProjetCode ·ÕèÂÑ§à¢éÒ Web äÁèä´é HOSPIC|SCRCOV|SSSOBS|SSSSPC|INJDFO|KNEE17|KTLGOD|Z38000
text to _adp noshow textmerge
create table if not exists <<myeclaim>>.l_sev12 (CODE varchar(10) not null,NAME varchar(200) ,UNIT varchar(50) ,COST decimal(15,2) ,GYEAR decimal(4,0) not null,EXPDATE datetime ,STARTDATE datetime ,MAININSCL varchar(5) not null,FLAG varchar(1) 
,primary key (CODE,GYEAR,MAININSCL)) engine=MyISAM default charset=tis620;

drop temporary table if exists tmpNurse;
create temporary table tmpNurse (index (code)) select code,group_concat(distinct maininscl) maininscl
from <<myeclaim>>.l_sev12
where maininscl<>'UCS'
group by code
order by 1;

create table if not exists <<myeclaim>>.l_medical_supplies (MAININSCL varchar(5)  ,CODE varchar(7) not null,NAME varchar(250)  ,UNIT varchar(50) ,COST decimal(15,2) ,GYEAR varchar(4)  ,EDITABLE varchar(1)  ,STARTDATE datetime ,EXPDATE datetime 
,primary key (MAININSCL,CODE,GYEAR)) engine=MyISAM default charset=tis620;

drop temporary table if exists tmpSupply;
create temporary table tmpSupply (index (code)) select code,group_concat(distinct maininscl) maininscl
from <<myeclaim>>.l_medical_supplies
where maininscl<>'UCS'
group by code
order by 1;

drop temporary table if exists tmpIncome;
create temporary table tmpIncome select oo.vn seq,oo.an,oo.hn
,oo.rxdate dateopd
,oo.paidst
,inc.drg_chrgitem_id billmaud
,if(oo.paidst in ('03'),chrgitem_code2,chrgitem_code1) chrgitem
,oo.icode,concat_ws(' ',d.name,d.strength) drugname
,d.nhso_adp_type_id type 
,case
when d.nhso_adp_code in ('21301') then if(ex.maininscl regexp 'SSS','XXXX',d.nhso_adp_code)
when inc.drg_chrgitem_id=5 then if(ex.maininscl regexp 'UCS',d.nhso_adp_code,ifnull(ss.code,'XXXXXX'))
when inc.drg_chrgitem_id=12 then if(ex.maininscl regexp 'LGO|OFC' or ex.projectcode is not null,d.nhso_adp_code,ifnull(nn.code,'XXXX'))
when ifnull(d.nhso_adp_code,'')<>'' then d.nhso_adp_code
else 'XXXX' end code
,if(oo.paidst not in ('03'),oo.qty,0) qty 
,oo.unitprice rate
,oo.sum_price
,if(oo.paidst in ('03'),sum_price,0) totcopay
,ll.tmlt_code tmltcode
,if(d.nhso_adp_type_id=11,'2',null) use_status
,null status1,ex.pregno gravida,ex.ga ga_week,ex.lmp lmp
from tmpExport ex
join opitemrece oo on oo.vn=ex.vn
join s_drugitems d on d.icode=oo.icode
left join income inc on inc.income=oo.income
left join drg_chrgitem drg on drg.drg_chrgitem_id=inc.drg_chrgitem_id
left join nhso_adp_code adp on adp.nhso_adp_code=d.nhso_adp_code
left join <<myRCM>>.labitem ll on ll.lccode=oo.icode and (chi=1 or eclaim=1)
left join tmpnurse nn on nn.code=d.nhso_adp_code
left join tmpsupply ss on ss.code=d.nhso_adp_code
where drg.drg_chrgitem_id not in (3,4) and sum_price<>0;

insert into tmpIncome select oo.an seq,oo.an,oo.hn
,oo.rxdate dateopd
,oo.paidst
,inc.drg_chrgitem_id billmaud
,if(oo.paidst in ('03'),chrgitem_code2,chrgitem_code1) chrgitem
,oo.icode,concat_ws(' ',d.name,d.strength) drugname
,d.nhso_adp_type_id type 
,case
when d.nhso_adp_code in ('21301') then if(ex.maininscl regexp 'SSS','XXXX',d.nhso_adp_code)
when inc.drg_chrgitem_id=5 then if(ex.maininscl regexp 'UCS',d.nhso_adp_code,ifnull(ss.code,'XXXXXX'))
when inc.drg_chrgitem_id=12 then if(ex.maininscl regexp 'LGO|OFC' or ex.projectcode is not null,d.nhso_adp_code,ifnull(nn.code,'XXXX'))
when ifnull(d.nhso_adp_code,'')<>'' then d.nhso_adp_code
else 'XXXX' end code
,if(oo.paidst not in ('03'),oo.qty,0) qty 
,oo.unitprice rate
,oo.sum_price
,if(oo.paidst in ('03'),sum_price,0) totcopay
,ll.tmlt_code tmltcode
,if(d.nhso_adp_type_id=11,'2',null) use_status
,null status1,ex.pregno gravida,ex.ga ga_week,ex.lmp lmp
from tmpExport ex
join opitemrece oo on oo.an=ex.vn
join s_drugitems d on d.icode=oo.icode
left join income inc on inc.income=oo.income
left join drg_chrgitem drg on drg.drg_chrgitem_id=inc.drg_chrgitem_id
left join nhso_adp_code adp on adp.nhso_adp_code=d.nhso_adp_code
left join <<myRCM>>.labitem ll on ll.lccode=oo.icode and (chi=1 or eclaim=1)
left join tmpnurse nn on nn.code=d.nhso_adp_code
left join tmpsupply ss on ss.code=d.nhso_adp_code
where drg.drg_chrgitem_id not in (3,4) and sum_price<>0;

update tmpIncome set type='10' where billmaud=1;
update tmpIncome set type='11' where billmaud=5;
update tmpIncome set type='12' where billmaud=13;
update tmpIncome set type='14' where billmaud=6;
update tmpIncome set type='15' where billmaud=7;
update tmpIncome set type='16' where billmaud=8;
update tmpIncome set type='17' where billmaud=12;
update tmpIncome set type='18' where billmaud=10;
update tmpIncome set type='19' where billmaud=11;
update tmpIncome set type='20' where billmaud=14;

drop temporary table if exists tmpData;
create temporary table tmpData (seq varchar(30),an varchar(9),hn varchar(9),dateopd date,billmaud varchar(2),chrgitem varchar(2),type varchar(2),code varchar(15),DrugName varchar(100)
,qty int(11),rate double(15,2),totcopay double(15,2),tmltcode varchar(20),use_status varchar(1),status1 varchar(1),gravida varchar(2),ga_week varchar(2),lmp date
,primary key (seq,type,code,rate)) engine=MyISAM default charset=tis620;

replace into tmpdata 
select seq,an,hn,dateopd,billmaud,chrgitem,type,code,drugname
,sum(if(paidst not in ('03'),qty,0)) qty 
,rate
,sum(if(paidst not in ('03'),sum_price,0)) totcopay
,tmltcode,use_status,status1,gravida,ga_week,lmp
from tmpIncome
group by seq,type,code,rate;

replace into tmpdata (seq,hn,dateopd,type,code)
select o.vn seq,o.hn,o.vstdate dateopd 
,'5' type
,ex.projectcode code
from tmpexport ex
join ovst o on o.vn=ex.vn
where ifnull(ex.projectcode,'')<>'';

replace into tmpdata (seq,an,hn,dateopd,type,code)
select i.an seq,i.an,i.hn,i.dchdate dateopd 
,'5' type
,ex.projectcode code
from tmpExport ex
join ipt i  on i.an=ex.vn
where ifnull(ex.projectcode,'')<>'';

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,qty,rate)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,case
when icd10tm_operation_code='2377020' then '50001'
when icd10tm_operation_code='238703A' then '50002'
when icd10tm_operation_code='238703B' then '50003'
when icd10tm_operation_code='238703C' then '50004'
when icd10tm_operation_code='238703D' then '50005'
when icd10tm_operation_code='238703E' then '50006'
when icd10tm_operation_code='238703F' then '50007'
when icd10tm_operation_code='238703G' then '50008'
when icd10tm_operation_code='238703H' then '50009'
else '' end code
,1 qty
,if(icd10tm_operation_code='2377020',100,250) rate
from tmpExport ex 
join ovst o on o.vn=ex.vn
join dtmain dt on dt.vn=o.vn 
join dttm tm on tm.code=dt.tmcode
where tm.icd10tm_operation_code regexp '^2377020|^238703[A-H]';

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,drugname,qty,rate,gravida,ga_week,lmp)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
/*
,case 
when pa_week<13 then '30002'
when pa_week<21 then '30003'
when pa_week<27 then '30004'
when pa_week<33 then '30005'
when pa_week<41 then '30006'
else '30007' end code
*/
,'30011' code
,'ANC'
,1 qty
,360 rate
,ex.pregno,ex.ga,ex.lmp
from tmpExport ex
join ovst o on o.vn=ex.vn
join person_anc_service s on s.vn=o.vn 
left join person_anc anc on anc.person_anc_id=s.person_anc_id
where s.anc_service_type_id=1;

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,drugname,qty,rate,gravida,ga_week,lmp)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,'30012' code
,'LabANC1'
,1 qty
,600 rate
,ex.pregno,ex.ga,ex.lmp
from tmpExport ex
join ovst o on o.vn=ex.vn
join person_anc_service s on s.vn=o.vn 
left join person_anc anc on anc.person_anc_id=s.person_anc_id
where s.anc_service_type_id=1
and s.anc_service_number in (1,2)
and (pre_labor_service1_date=vstdate or pre_labor_service2_date=vstdate)
and (blood_vdrl1_result is not null and blood_hiv1_result is not null and blood_hct_result is not null);

replace into tmpdata (seq,hn,dateopd,type,code,drugname,qty,rate,gravida,ga_week,lmp)
select o.vn seq,o.hn,o.vstdate dateopd
,'4' type
,'30013' code
,'LabANC2'
,1 qty
,190 rate
,ex.pregno,ex.ga,ex.lmp
from tmpExport ex
join ovst o on o.vn=ex.vn
join person_anc_service s on s.vn=o.vn 
left join person_anc anc on anc.person_anc_id=s.person_anc_id
where s.anc_service_type_id=1
and s.anc_service_number not in  (1,2)
and (pre_labor_service4_date=vstdate or pre_labor_service5_date=vstdate)
and (blood_vdrl2_result is not null and blood_hiv2_result is not null );

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,drugname,qty,rate,gravida,ga_week,lmp)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,case
when icd10tm_operation_code='2330011' then '30008'
when icd10tm_operation_code='2277310' then '30009'
when icd10tm_operation_code='2287310' then '30009'
when icd10tm_operation_code='2287010' then '30009'
else '' end code
,if(icd10tm_operation_code='2330011','µÃÇ¨ªèÍ§»Ò¡','¢Ñ´¿Ñ¹')
,1 qty
,if( icd10tm_operation_code='2330011',0,500) rate
,ex.pregno,ex.ga,ex.lmp
from tmpExport ex
join ovst o on o.vn=ex.vn
join person_anc a on a.person_anc_id=ex.ancid
join dtmain dt on dt.vn=o.vn 
join dttm tm on tm.code=dt.tmcode
where tm.icd10tm_operation_code regexp '2287310|2277310|2330011';

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,drugname,qty,rate,gravida,ga_week,lmp)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,'30010' code
,'U/S'
,1 qty
,400 rate
,ex.pregno,ex.ga,ex.lmp
from tmpExport ex
join ovst o on o.vn=ex.vn
join person_anc a on a.person_anc_id=ex.ancid
join opitemrece oo on oo.vn=o.vn
where oo.icode in (<<us>>);

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,qty,rate)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,'30001' code
,1 qty
,0 rate
from tmpExport ex
join ovst o on o.vn=ex.vn
join ovstdiag dx on dx.vn=o.vn
where dx.icd10='Z515';

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,drugname,qty,rate,gravida,ga_week,lmp)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,'80008' code
,'¤èÒÊÍ¹/¤èÒ Strip/OGTT'
,1 qty
,4700 rate
,ex.pregno,ex.ga,ex.lmp
from tmpExport ex
join ovst o on o.vn=ex.vn
join person_anc a on a.person_anc_id=ex.ancid
join opitemrece oo on oo.vn=o.vn
join nondrugitems n on n.icode=oo.icode
where n.nhso_adp_code='80008';

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,qty,rate)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
,@code:=case
when t.pp_special_code in ('1B0060','1B0061') then '90005'
 end code
#,'90005' code
,1 qty
,60 rate
from tmpExport ex
join ovst o on o.vn=ex.vn
left join pp_special pp on o.vn=pp.vn
left join pp_special_type t on t.pp_special_type_id=pp.pp_special_type_id
where t.pp_special_code in ('1B0060','1B0061');

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,qty,rate)
select o.vn seq,o.hn,o.vstdate dateopd
,'19'
,'3' type
,@code:=case
when t.pp_special_code in ('1B0044','1B30','1B004N') then '1B004N'
when t.pp_special_code in ('1B40','1B004P') then '1B004P'
when t.pp_special_code in ('1B0040','1B0043','1B004_0N') then '1B004_0N'
when t.pp_special_code in ('1B0041','1B0042','1B0043','1B0045','1B004_0P') then '1B004_0P' end code
#,'1B004' code
,1 qty
,250 rate
from tmpExport ex
join ovst o on o.vn=ex.vn
left join pp_special pp on o.vn=pp.vn
left join pp_special_type t on t.pp_special_type_id=pp.pp_special_type_id
where t.pp_special_code in ('1B0044','1B30','1B40','1B004N','1B004P','1B0040','1B0041','1B0042','1B0043','1B0045','1B004_0N','1B004_0P');

replace into tmpdata (seq,hn,dateopd,billmaud,type,code,qty,rate)
select o.vn seq,o.hn,o.vstdate dateopd
,'18'
,'4' type
/*
,@code:=case
when t.pp_special_code in ('1B0046','1B0046_0') then '1B0046_0'
when t.pp_special_code in ('1B0048','1B0049') then '0320277_0'
else t.pp_special_code end code
*/
,@code:=case
when t.pp_special_code in ('1B0046','1B0046_0') then '1B0046'
when t.pp_special_code in ('1B0048','1B0049') then '1B005'
else t.pp_special_code end code
,1 qty
,if(@code like '1B0046%',420,250) rate
from tmpExport ex 
join ovst o on o.vn=ex.vn
left join pp_special pp on o.vn=pp.vn
left join pp_special_type t on t.pp_special_type_id=pp.pp_special_type_id
where t.pp_special_code regexp '^1B0046|^1B0048|^1B0049|^0320277_0|^0320277_1';

drop temporary table if exists tmpLab;
create temporary table tmpLab (index (vn))
select lh.vn,lh.order_date,d.icode,d.name
,d.nhso_adp_code cscode
,case 
when lab_order_result regexp 'äÁè¾º|Neg|Not' then '2'
when lab_order_result regexp '¾º|Pos|Detect' then '1' 
else '2' end result
from tmpExport ex
join lab_head lh on lh.vn=ex.vn
join lab_order lo on lo.lab_order_number=lh.lab_order_number
join lab_items l on l.lab_items_code=lo.lab_items_code
join nondrugitems d on d.icode=l.icode 
where d.nhso_adp_code in (select code from covid_items_detail where id in (4,5));

update tmpData a
join tmpLab b on b.vn=a.seq and b.cscode=a.code
set a.status1=b.result;

drop temporary table if exists tmpHCT;
create temporary table tmpHCT
select lab_items_code id
from sys_lab_link
where sys_lab_code_id=(select sys_lab_code_id from sys_lab_code where sys_lab_name='HCT');

drop temporary table if exists tmpLab;
create temporary table tmpLab (index (vn))
select lh.vn,lh.order_date,d.icode,d.name
,d.nhso_adp_code cscode
,lo.lab_order_result result
from tmpExport ex
join lab_head lh on lh.vn=ex.vn
join lab_order lo on lo.lab_order_number=lh.lab_order_number
join lab_items l on l.lab_items_code=lo.lab_items_code
join nondrugitems d on d.icode=l.icode 
where l.provis_labcode='0621201';

update tmpData a
join tmpLab b on b.vn=a.seq and b.cscode=a.code
set a.status1=b.result;

update tmpData set billmaud='' where billmaud is null;

select t.* from tmpData t where billmaud not in ('17') order by seq,an,cast(billmaud as signed)
endtext

text to _dru noshow textmerge
drop temporary table if exists tmpData;
create temporary table tmpData (seq varchar(30),cid varchar(13),an varchar(9),hn varchar(9),date_serv date,clinic varchar(5),did varchar(13),didname varchar(100),unit varchar(20),amount int(11),drugpric double(15,2),drugcode double(15,2),didstd varchar(24),use_status varchar(2),drugremark varchar(5),totcopay double(15,2));

drop temporary table if exists tmpdrug;
create temporary table tmpdrug
select o.vn seq,null an,o.hn,pt.cid
,zero(sp.nhso_code) clinic
,oo.rxdate
,oo.icode did
,concat_ws(' ',d.name,d.strength) didname,d.units unit
,oo.qty
,oo.sum_price
,oo.unitprice drugpric
,oo.cost drugcost
,oo.paidst
,d.did didstd
,if(oo.item_type='H' or oo.income in (<<income_homemed>>),'2','1') use_status
,if(oo.income in (<<income_drug_ned>>) or d.drugaccount='-' or ifnull(d.drugaccount,'')='','EC','') drugremark
from tmpExport ex
join ovst o on o.vn=ex.vn
left join patient pt on pt.hn=o.hn
left join spclty sp on sp.spclty=o.spclty
join opitemrece oo on oo.vn=o.vn
join drugitems d on d.icode=oo.icode;

insert into tmpdata select seq,cid,an,hn,max(rxdate) date_serv,clinic,did,didname,unit,sum(qty) amount,drugpric,drugcost,didstd,use_status,drugremark,sum(if(paidst in ('03'),sum_price,0)) totcopay
from tmpdrug
group by seq,did,use_status
having sum(sum_price)<>0;

drop temporary table if exists tmpdrug;
create temporary table tmpdrug
select i.an seq,i.an,i.hn,pt.cid
,zero(sp.nhso_code) clinic
,oo.rxdate
,oo.icode did
,concat_ws(' ',d.name,d.strength) didname,d.units unit
,oo.qty
,oo.sum_price
,oo.unitprice drugpric
,oo.cost drugcost
,oo.paidst
,d.did didstd
,if(oo.item_type='H' or oo.income in (<<income_homemed>>),'2','1') use_status
,if(oo.income in (<<income_drug_ned>>) or d.drugaccount='-' or ifnull(d.drugaccount,'')='','EC','') drugremark
from tmpExport ex 
join ipt i on i.an=ex.vn
left join patient pt on pt.hn=i.hn
left join spclty sp on sp.spclty=i.spclty
join opitemrece oo on oo.an=i.an
join drugitems d on d.icode=oo.icode;

insert into tmpdata select seq,cid,an,hn,max(rxdate) date_serv,clinic,did,didname,unit,sum(qty) amount,drugpric,drugcost,didstd,use_status,drugremark,sum(if(paidst in ('03'),sum_price,0)) totcopay
from tmpdrug
group by seq,did,use_status
having sum(sum_price)<>0;

select t.* from tmpData t
endtext

text to _aer noshow textmerge
call modifycolumn('referin','refer_hospcode','varchar(5)',null);
call modifycolumn('referout','refer_hospcode','varchar(5)',null);

drop temporary table if exists tmpData;
create temporary table tmpData (seq varchar(30),an varchar(9),hn varchar(9),dateopd date,authae varchar(15),aedate date,aetime varchar(4),aetype varchar(1),ucae varchar(1),refer_no varchar(20),refmaini varchar(5),ireftype varchar(4),refmaino varchar(5),oreftype varchar(4));

#insert into tmpData (seq,hn,dateopd,aedate,aetime,aetype)
#select o.vn seq,o.hn,o.vstdate dateopd,date(d.arrive_time) aedate,date_format(d.arrive_time,'%H%i') aetime,'' aetype
#from tmpExport ex
#join ovst o on o.vn=ex.vn
#join er_nursing_detail d on d.vn=o.vn
#where d.er_accident_type_id between 1 and 19;

insert into tmpData (seq,hn,dateopd,ucae,refmaini,ireftype,refmaino,oreftype,refer_no) select o.vn seq,o.hn,o.vstdate dateopd
,case 
when demand='Normal' then 'N'
when demand='Accident' then 'A'
when demand='Emergency' then 'E'
when demand='OP Refer ¢éÒÁ¨Ñ§ËÇÑ´' then 'O'
when demand='OP Refer ã¹¨Ñ§ËÇÑ´' then 'I'
when demand='ÂéÒÂË¹èÇÂà¡Ô´ÊÔ·¸Ô·Ñ¹·Õ' then 'C'
when demand='ºÃÔ¡ÒÃàªÔ§ÃØ¡' then 'Z'
else '' end ucae
,if(ri.vn is not null,ri.refer_hospcode,'')
,if(ri.vn is not null,'1100','')
,if(ro.vn is not null,ro.refer_hospcode,'')
,if(ro.vn is not null,'1100','')
,if(ro.vn is not null,ro.refer_number,'')
from tmpExport ex
join ovst o on o.vn=ex.vn
left join referin ri on ri.vn=o.vn
left join referout ro on ro.vn=o.vn
where ifnull(ex.demand,'')<>'' or ri.vn is not null or ro.vn is not null;

insert into tmpData (seq,an,hn,dateopd,authae,aedate,aetime,aetype,refmaino,oreftype,refer_no)
select i.an seq,i.an,i.hn
,if(r.vn is not null,r.refer_date,i.regdate)
,ac.claim_code,ac.ac_date,ac.ac_time,ac.ac_type
,r.refer_hospcode
,if(r.vn is not null,'1100','')
,refer_number
from tmpExport ex
join ipt i on i.an=ex.vn
left join ipt_accident ac on ac.an=i.an
left join referout r on r.vn=i.an
where ac.an is not null or r.vn is not null;

insert into tmpData (seq,an,hn,dateopd,refmaini,ireftype,refer_no)
select i.an seq,i.an,i.hn
,r.refer_date dateopd
,r.refer_hospcode
,'1100'
,docno
from tmpExport ex
join ipt i on i.an=ex.vn
join referin r on r.vn=i.vn;

select t.* from tmpData t
endtext

text to _lab noshow textmerge
call modifycolumn('lab_items','labtest','varchar(2)',null);
call modifycolumn('lab_items','provis_labcode','varchar(7)',null);

drop temporary table if exists tmpData;
create temporary table tmpData (HCode varchar(5),HN varchar(9),Person_ID varchar(13),DateServ date,Seq varchar(15),LabTest varchar(7),LabResult double(7,2)
,primary key (seq,labtest)) engine=MyISAM default charset=tis620;

replace into tmpData 
select ?myhospcode,lh.hn,pt.cid,lh.order_date,lh.vn,l.labtest,lo.lab_order_result
from tmpExport ex
join lab_head lh on lh.vn=ex.vn
join clinic_visit cv on cv.vn=ex.vn
left join patient pt on pt.hn=lh.hn
join lab_order lo on lo.lab_order_number=lh.lab_order_number
join lab_items l on l.lab_items_code=lo.lab_items_code 
where ifnull(l.labtest,'')<>'';

select t.* from tmpData t where labresult>0
endtext

_ret='_'+_file
_ret=icase(type(_ret)#'U',eval(_ret),'')
retu _ret

Proc CreateCursor
para _file
priv _ret
_ret=.T.
_cursor=ntoc(_file)
_cursor=juststem(_cursor)
do case
	case _cursor='ADP'
		create cursor (_cursor) (HN C (15) NULL,AN C (15) NULL,DATEOPD D  NULL,TYPE C (2) NULL,CODE C (20) NULL,QTY N (4,0) NULL,RATE N (12,2) NULL,SEQ C (25) NULL,CAGCODE C (10) NULL,DOSE C (10) NULL,CA_TYPE C (1) NULL,SERIALNO C (24) NULL,TOTCOPAY N (12,2) NULL,USE_STATUS C (1) NULL,TOTAL N (12,2) NULL,QTYDAY N (3,0) NULL,TMLTCODE C (20) NULL,STATUS1 C(20) NULL,GRAVIDA C(2) NULL,GA_WEEK C(2) NULL,LMP D NULL)
	case _cursor='AER'
		create cursor (_cursor) (HN C (15) NULL,AN C (15) NULL,DATEOPD D  NULL,AUTHAE C (12) NULL,AEDATE D  NULL,AETIME C (4) NULL,AETYPE C (1) NULL,REFER_NO C (20) NULL,REFMAINI C (5) NULL,IREFTYPE C (4) NULL,REFMAINO C (5) NULL,OREFTYPE C (4) NULL,UCAE C (1) NULL,EMTYPE C (1) NULL,SEQ C (25) NULL,AESTATUS C (1) NULL,DALERT D  NULL,TALERT C (4) NULL)
	case _cursor='CHA'
		create cursor (_cursor) (HN C (15) NULL,AN C (15) NULL,DATE D  NULL,CHRGITEM C (2) NULL,AMOUNT N (12,2) NULL,PERSON_ID C (13) NULL,SEQ C (25) NULL)
	case _cursor='CHT'
		create cursor (_cursor) (HN C (15) NULL,AN C (9) NULL,DATE D  NULL,TOTAL N (12,2) NULL,PAID N (12,2) NULL,PTTYPE C (2) NULL,PERSON_ID C (13) NULL,SEQ C (25) NULL)
	case _cursor='DRU'
		create cursor (_cursor) (HCODE C (5) NULL,HN C (15) NULL,AN C (9) NULL,CLINIC C (5) NULL,PERSON_ID C (13) NULL,DATE_SERV D  NULL,DID C (30) NULL,DIDNAME C (250) NULL,AMOUNT C (12) NULL,DRUGPRIC C (14) NULL,DRUGCOST C (14) NULL,DIDSTD C (24) NULL,UNIT C (20) NULL,UNIT_PACK C (20) NULL,SEQ C (25) NULL,DRUGTYPE C (2) NULL,DRUGREMARK C (2) NULL,PA_NO C (9) NULL,TOTCOPAY N (12,2) NULL,USE_STATUS C (1) NULL,TOTAL N (12,2) NULL)
	case _cursor='IDX'
		create cursor (_cursor) (AN C (15) NULL,DIAG C (7) NULL,DXTYPE C (1) NULL,DRDX C (20) NULL)
	case _cursor='INS'
		create cursor (_cursor) (HN C (15) NULL,INSCL C (3) NULL,SUBTYPE C (2) NULL,CID C (16) NULL,DATEIN D  NULL,DATEEXP D  NULL,HOSPMAIN C (5) NULL,HOSPSUB C (5) NULL,GOVCODE C (6) NULL,GOVNAME C (250) NULL,PERMITNO C (30) NULL,DOCNO C (30) NULL,OWNRPID C (13) NULL,OWNNAME C (250) NULL,AN C (15) NULL,SEQ C (25) NULL,SUBINSCL C (2) NULL,RELINSCL C (2) NULL,HTYPE C (1) NULL)
	case _cursor='IOP'
		create cursor (_cursor) (AN C (15) NULL,OPER C (7) NULL,OPTYPE C (1) NULL,DROPID C (20) NULL,DATEIN D  NULL,TIMEIN C (4) NULL,DATEOUT D  NULL,TIMEOUT C (4) NULL)
	case _cursor='IPD'
		create cursor (_cursor) (HN C (15) NULL,AN C (15) NULL,DATEADM D  NULL,TIMEADM C (4) NULL,DATEDSC D  NULL,TIMEDSC C (4) NULL,DISCHS C (1) NULL,DISCHT C (1) NULL,WARDDSC C (4) NULL,DEPT C (2) NULL,ADM_W N (7,3) NULL,UUC C (1) NULL,SVCTYPE C (1) NULL)
	case _cursor='IRF'
		create cursor (_cursor) (AN C (15) NULL,REFER C (5) NULL,REFERTYPE C (1) NULL)
	case _cursor='LAB'
		create cursor (_cursor) (HCODE C(5) NULL,HN C(15) NULL,PERSON_ID C(13) NULL,DATESERV D NULL,SEQ C(25) NULL,LABTEST C(7) NULL,LABRESULT N(12,5) NULL)
	case _cursor='LVD'
		create cursor (_cursor) (SEQLVD C (25) NULL,AN C (15) NULL,DATEOUT D  NULL,TIMEOUT C (4) NULL,DATEIN D  NULL,TIMEIN C (4) NULL,QTYDAY C (3) NULL)
	case _cursor='ODX'
		create cursor (_cursor) (HN C (15) NULL,DATEDX D  NULL,CLINIC C (5) NULL,DIAG C (7) NULL,DXTYPE C (1) NULL,DRDX C (20) NULL,PERSON_ID C (13) NULL,SEQ C (25) NULL)
	case _cursor='OOP'
		create cursor (_cursor) (HN C (15) NULL,DATEOPD D  NULL,CLINIC C (5) NULL,OPER C (7) NULL,DROPID C (20) NULL,PERSON_ID C (13) NULL,SEQ C (25) NULL)
	case _cursor='OPD'
		create cursor (_cursor) (HN C (15) NULL,CLINIC C (5) NULL,DATEOPD D  NULL,TIMEOPD C (4) NULL,SEQ C (25) NULL,UUC C (1) NULL)
	case _cursor='ORF'
		create cursor (_cursor) (HN C (15) NULL,DATEOPD D  NULL,CLINIC C (5) NULL,REFER C (5) NULL,REFERTYPE C (1) NULL,SEQ C (25) NULL)
	case _cursor='PAT'
		create cursor (_cursor) (HCODE C (5) NULL,HN C (15) NULL,CHANGWAT C (2) NULL,AMPHUR C (2) NULL,DOB D  NULL,SEX C (1) NULL,MARRIAGE C (1) NULL,OCCUPA C (3) NULL,NATION C (3) NULL,PERSON_ID C (13) NULL,NAMEPAT C (36) NULL,TITLE C (30) NULL,FNAME C (40) NULL,LNAME C (40) NULL,IDTYPE N (1) NULL)
	other
		_ret=.F.
endcase
retu _ret

Proc CreateTempFile
text to _sql noshow textmerge
drop temporary table if exists Export4ADP;
create temporary table Export4ADP (HN Char(15), AN Char(15), DATEOPD Date, BillMaud Char(2), TYPE Char(2), CODE Char(20), QTY Int(4), RATE Double(12,2), SEQ Char(25), CAGCODE Char(10), DOSE Char(10), CA_TYPE Char(1), SERIALNO Char(24), TOTCOPAY Double(12,2), USE_STATUS Char(1), TOTAL Double(12,2), QTYDAY Int(3), TMLTCODE Char(20), STATUS1 Char(20), GRAVIDA char(2), GA_WEEK char(2), LMP Date
,primary key (seq,type,code,rate)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4AER;
create temporary table Export4AER (HN Char(15), AN Char(15), DATEOPD Date, AUTHAE Char(12), AEDATE Date, AETIME Char(4), AETYPE Char(1), REFER_NO Char(20), REFMAINI Char(5), IREFTYPE Char(4), REFMAINO Char(5), OREFTYPE Char(4), UCAE Char(1), EMTYPE Char(1), SEQ Char(25), AESTATUS Char(1), DALERT Date, TALERT Char(4)
,primary key (seq)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4CHA;
create temporary table Export4CHA (HN Char(15), AN Char(15), DATE Date,CHRGITEM Char(2), AMOUNT Double(12,2), PERSON_ID Char(13), SEQ Char(25)
,primary key (seq,chrgitem)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4CHT;
create temporary table Export4CHT (HN Char(15), AN Char(9), DATE Date, TOTAL Double(12,2), PAID Double(12,2), PTTYPE Char(2), PERSON_ID Char(13), SEQ Char(25)
,primary key (seq)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4DRU;
create temporary table Export4DRU (HCODE Char(5), HN Char(15), AN Char(9), CLINIC Char(5), PERSON_ID Char(13), DATE_SERV Date, DID Char(30), DIDNAME Char(250), AMOUNT Char(12), DRUGPRIC Char(14), DRUGCOST Char(14), DIDSTD Char(24), UNIT Char(20), UNIT_PACK Char(20), SEQ Char(25), DRUGTYPE Char(2), DRUGREMARK Char(2), PA_NO Char(9), TOTCOPAY Double(12,2), USE_STATUS Char(1), TOTAL Double(12,2)
,primary key (seq,did,date_serv,use_status)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4IDX;
create temporary table Export4IDX (AN Char(15), DIAG Char(7), DXTYPE Char(1), DRDX Char(20)
,primary key (an,diag)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4INS;
create temporary table Export4INS (HN Char(15), INSCL Char(3), SUBTYPE Char(2), CID Char(16), DATEIN Date, DATEEXP Date, HOSPMAIN Char(5), HOSPSUB Char(5), GOVCODE Char(6), GOVNAME Char(250), PERMITNO Char(30), DOCNO Char(30), OWNRPID Char(13), OWNNAME Char(250), AN Char(15), SEQ Char(25), SUBINSCL Char(2), RELINSCL Char(2), HTYPE Char(1)
,primary key (seq)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4IOP;
create temporary table Export4IOP (AN Char(15), OPER Char(7), OPTYPE Char(1), DROPID Char(20), DATEIN Date, TIMEIN Char(4), DATEOUT Date, TIMEOUT Char(4)
,primary key (an,oper)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4IPD;
create temporary table Export4IPD (HN Char(15), AN Char(15), DATEADM Date, TIMEADM Char(4), DATEDSC Date, TIMEDSC Char(4), DISCHS Char(1), DISCHT Char(1), WARDDSC Char(4), DEPT Char(2), ADM_W Double(7,3), UUC Char(1), SVCTYPE Char(1)
,primary key (an)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4IRF;
create temporary table Export4IRF (AN Char(15), REFER Char(5), REFERTYPE Char(1)
,primary key (an,refer,refertype)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4LAB;
create temporary table Export4LAB (HCODE Char(5), HN Char(15), PERSON_ID Char(13), DATESERV Date, SEQ Char(25), LABTEST Char(7), LABRESULT Double(7,2)
,primary key (seq,labtest)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4LVD;
create temporary table Export4LVD (SEQLVD Char(3), AN Char(15), DATEOUT Date, TIMEOUT Char(4), DATEIN Date, TIMEIN Char(4), QTYDAY Char(3)
,primary key (seqlvd)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4ODX;
create temporary table Export4ODX (HN Char(15), DATEDX Date, CLINIC Char(5), DIAG Char(7), DXTYPE Char(1), DRDX Char(20), PERSON_ID Char(13), SEQ Char(25)
,primary key (seq,diag)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4OOP;
create temporary table Export4OOP (HN Char(15), DATEOPD Date, CLINIC Char(5), OPER Char(7), DROPID Char(20), PERSON_ID Char(13), SEQ Char(25)
,primary key (seq,oper)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4OPD;
create temporary table Export4OPD (HN Char(15), CLINIC Char(5), DATEOPD Date, TIMEOPD Char(4), SEQ Char(25), UUC Char(1)
,primary key (seq)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4ORF;
create temporary table Export4ORF (HN Char(15), DATEOPD Date, CLINIC Char(5), REFER Char(5), REFERTYPE Char(1), SEQ Char(25)
,primary key (seq,refer,refertype)) engine=MyISAM default charset=tis620;

drop temporary table if exists Export4PAT;
create temporary table Export4PAT (HCODE Char(5), HN Char(15), CHANGWAT Char(2), AMPHUR Char(2), DOB Date, SEX Char(1), MARRIAGE Char(1), OCCUPA Char(3), NATION Char(3), PERSON_ID Char(13), NAMEPAT Char(36), TITLE Char(30), FNAME Char(40), LNAME Char(40), IDTYPE int(1)
,primary key (hn)) engine=MyISAM default charset=tis620;
endtext
=runsql(_sql,.T.)

Proc CheckUpData
priv i,ii,_sql,_opd,_ipd,_caption,_title,_format,_width,_position,_color,_risk,reportname,reportfield,setcolumn,lockcolumns,maxform,formwidth,formheight,formtop,formleft,gridtop,gridleft,lsubheader,setcaption,lno
sele tmpreport
scatt memv memo
m.an=ntoc(m.an)
m.vn=ntoc(m.vn)
cfield=icase(empty(m.an),'vn','an')
m.maininscl=ntoc(m.maininscl)
if empty(m.an) and empty(m.vn)
	retu .F.
endif
store '' to _sql,_opd,_ipd
text to _sql noshow textmerge
drop temporary table if exists tmpIncome;
create temporary table tmpIncome
select oo.icode,concat_ws(' ',d.name,d.strength) drugname
,ifnull(d.tpu_code_list,space(10)) TMT_HOSxP
,ifnull(dd.tmtid,space(10)) TMT_EClaim
,if(oo.item_type='H','H','') item_type
,oo.paidst
,sum(oo.qty) qty
,oo.unitprice
,oo.cost unitcost
,sum(oo.sum_price) price
#,sum(oo.qty*oo.unitprice) total
,000000000000000.00 total
,inc.name income
,if(d.nhso_adp_code in (select code from covid_items_detail),'Y',' ') covid
,inc.drg_chrgitem_id billmaud
,drg_chrgitem_name billname
,d.nhso_adp_type_id id
,ifnull(d.nhso_adp_code,'') cscode
,adp.nhso_adp_code_name csname
,ifnull(ll.tmlt_code,'') tmlt
,if(dd.hospdrugcode is null,'','Y') drug
from opitemrece oo
left join s_drugitems d on d.icode=oo.icode 
left join income inc on inc.income=oo.income
left join drg_chrgitem g on g.drg_chrgitem_id=inc.drg_chrgitem_id
left join nhso_adp_code adp on adp.nhso_adp_code=d.nhso_adp_code
left join <<myrcm>>.labitem ll on ll.icode=oo.icode and (chi=1 or eclaim=1)
left join <<myrcm>>.eclaim_drugcatalog dd on dd.hospdrugcode=oo.icode and inc.drg_chrgitem_id in (3,4)
where oo.<<cfield>>=?m.<<cfield>>
group by oo.icode,billmaud,oo.paidst
#having price<>0
order by billmaud,icode,type,cscode;

update tmpincome  set total=qty*unitprice;

set @no=0;
select @no:=asnumber(@no)+1 no,t.* from tmpincome t
endtext 
_caption='ÃÒÂÅÐàÍÕÂ´ '+icase(empty(m.an),'VN:','AN:')+icase(empty(m.an),m.vn,m.an)
if !runsql(_sql,.T.)
	retu .F.
endif
store '' to _title,_format,_width,_position
for ii=1 to fcount()
	_field=field(ii)
	_title=_title+icase(ii=1,'','|')+icase(_field='TMT',programname(strtran(_field,'TMT_','')),_field='TOTAL','¨Ò¡¤Ó¹Ç³',_field='INCOME','ª×èÍ¡ÅØèÁ¤èÒãªé¨èÒÂ',_field='PRICE','¨Ó¹Ç¹à§Ô¹',_field$'BILLMAUD,ID','ÃËÑÊ',_field$'BILLNAME,CSNAME','ª×èÍ',_field='CSCODE','CSCode',_field='TMLT','TMLT',_field='ITEM_TYPE','»ÃÐàÀ·',_field='COVID','Covid','x')
	_format=_format+icase(ii=1,'','|')+icase(_field$'TOTAL,PRICE,UNITPRICE',formatmoney,'x')
	_width=_width+icase(ii=1,'','|')+icase(_field=='NO','40','DATE'$_field,'70',_field='PTNAME','200',_field='BILLMAUD','40',_field='BILLNAME','300',_field$'CSCODE,TMLT','80',_field$'INCOME,CSNAME','300',_field='TOTAL','80',_field=='DRUG','30',_field='TMT','50','x')
	_position=_position+icase(ii=1,'','|')+icase(_field='OK' or _field='ITEM_TYPE' or _field=='DRUG' or _field='COVID','2','x')
	if _field='PRICE' or _field='TOTAL'
		sum (&_field) to m.&_field
	endif
next
store .null. to m.no,m.qty,m.unitprice,m.unitcost,m.id,m.billmaud
m.drugname='ÃÇÁ'
if recco()>0
	insert into temp from memv
endif
go top
_risk='All|BillMaud:color1|Item_Type:color1|Drug:color3|TMT_HOSxP:color4|Total:color5'
_color=[icase(drugname='ÃÇÁ',rgb(128,255,0),inlist(billmaud,1,2,5,6,7,8,9,10,11,12,13,14,15,19) and empty(cscode),rgb(255,0,0),inlist(billmaud,6,7) and empty(tmlt),iif(m.maininscl='OCF',rgb(255,0,0),rgb(255,128,0)),rgb(255,255,255))]
color1=[icase(drugname='ÃÇÁ',rgb(128,255,0),(id=10 and billmaud#1) or (id=2 and billmaud#2) or (id=11 and billmaud#5) or (id=14 and billmaud#6) or (id=15 and billmaud#7) or (id=16 and billmaud#8)]
color1=color1+[ or (id=9 and billmaud#9) or (id=18 and billmaud#10)  or (id=19 and billmaud#11) or (id=17 and billmaud#12) or (id=12 and billmaud#13) or (id=20 and billmaud#14) or (id=13 and billmaud#15) or (id=3 and billmaud#19)]
color1=color1+[,rgb(255,0,255),inlist(billmaud,1,2,5,6,7,8,9,10,11,12,13,14,15,19) and empty(cscode),rgb(255,0,0),inlist(billmaud,6,7) and empty(tmlt),iif(m.maininscl='OCF',rgb(255,0,0),rgb(255,128,0)),rgb(255,255,255))]
color2=[icase(drugname='ÃÇÁ',rgb(128,255,0),item_type='H' and billmaud#4,rgb(255,0,255),inlist(billmaud,1,2,5,6,7,8,9,10,11,12,13,14,15,19) and empty(cscode),rgb(255,0,0),inlist(billmaud,6,7) and empty(tmlt),iif(m.maininscl='OCF',rgb(255,0,0),rgb(255,128,0))]
color2=color2+[,rgb(255,255,255))]
color3=[icase(drugname='ÃÇÁ',rgb(128,255,0),empty(drug) and inlist(billmaud,3,4),rgb(255,0,255),inlist(billmaud,1,2,5,6,7,8,9,10,11,12,13,14,15,19) and empty(cscode),rgb(255,0,0),inlist(billmaud,6,7) and empty(tmlt)]
color3=color3+[,iif(m.maininscl='OCF',rgb(255,0,0),rgb(255,128,0)),rgb(255,255,255))]
color4=[icase(drugname='ÃÇÁ',rgb(128,255,0),tmt_hosxp#tmt_eclaim,rgb(255,0,0),inlist(billmaud,1,2,5,6,7,8,9,10,11,12,13,14,15,19) and empty(cscode),rgb(255,0,0),inlist(billmaud,6,7) and empty(tmlt)]
color4=color4+[,iif(m.maininscl='OCF',rgb(255,0,0),rgb(255,128,0)),rgb(255,255,255))]
color5=[icase(drugname='ÃÇÁ',rgb(128,255,0),price#total,rgb(255,0,255),inlist(billmaud,1,2,5,6,7,8,9,10,11,12,13,14,15,19) and empty(cscode),rgb(255,0,0),inlist(billmaud,6,7) and empty(tmlt),iif(m.maininscl='OCF',rgb(255,0,0),rgb(255,128,0)),rgb(255,255,255))]
setcolumn=fieldpos('drugname')
lockcolumns=setcolumn
reportname='checkgroupdata'
clear class myGroup
oIncome=create('myGroup')
oIncome.show
defi class myGroup as myShows
	Proc SetMergeHeader
		.MergeHeader(fieldpos('UnitPrice'),fieldpos('UnitCost'),'ÃÒ¤Ò')
		.MergeHeader(fieldpos('Price'),fieldpos('Total'),'¤èÒãªé¨èÒÂ')
		.MergeHeader(fieldpos('REIMB_MONEY'),fieldpos('TOTAL_MONEY'),'¤èÒãªé¨èÒÂ HOSxP')
		.MergeHeader(fieldpos('REIMB_MONEYs'),fieldpos('TOTAL_MONEYs'),'¨Ò¡¡ÒÃ¤Ó¹Ç³')
		.MergeHeader(fieldpos('TMT_HOSxP'),fieldpos('TMT_EClaim'),'TMT')
		.MergeHeader(fieldpos('BillMaud'),fieldpos('BillName'),'ËÁÇ´¤èÒãªé¨èÒÂ')
		.MergeHeader(fieldpos('ID'),fieldpos('CSName'),'ADP Code')
enddefi

Proc CheckGroupData
priv _ret,i,ii,_sql,_opd,_ipd,_caption,_title,_format,_width,_position,_color,_risk,reportname,reportfield,setcolumn,lockcolumns,maxform,formwidth,formheight,formtop,formleft,gridtop,gridleft,lsubheader,setcaption,mypath
store '' to _sql,_opd,_ipd
text to _sql noshow textmerge
select if(item_type='H',4,billmaud) id
,billname name
,sum(if(paidst not in ('03'),price,0)) REIMB_MONEY
,sum(if(paidst in ('03'),price,0)) NREIMB_MONEY
,sum(price) Total_money
,sum(if(paidst not in ('03'),total,0)) REIMB_MONEYs
,sum(if(paidst in ('03'),total,0)) NREIMB_MONEYs
,sum(total) Total_moneys
from tmpincome
group by billmaud
endtext 
=runsql(_sql,.T.,'tmpdata')
store '' to _title,_format,_width,_position
for ii=1 to fcount()
	_field=field(ii)
	_title=_title+icase(ii=1,'','|')+icase(_field='ID','ÃËÑÊ',_field='NAME','ª×èÍËÁÇ´',_field='REIMB','àºÔ¡ä´é',_field='NREIMB','àºÔ¡äÁèä´é',_field='TOTAL','ÃÇÁ','x')
	_format=_format+icase(ii=1,'','|')+icase('MONEY'$_field,formatmoney,'x')
	_width=_width+icase(ii=1,'','|')+icase(_field=='NO','40','DATE'$_field,'70',_field='PTNAME','200','MONEY'$_field,'80','x')
	_position=_position+icase(ii=1,'','|')+icase(_field='OK','2','x')
	if type(_field)$'NIB' and _field#'NO'
		sum (&_field) to m.&_field
	endif
next
store .null. to m.id
m.name='ÃÇÁ'
if recco()>0
	insert into tmpdata from memv
endif
go top
_risk='All|Total_Money:color1|Total_Moneys:color2'
_color=[icase(name='ÃÇÁ',rgb(128,255,0),rgb(255,255,255))]
color1=[icase(name='ÃÇÁ',rgb(128,255,0),total_money#total_moneys,rgb(0,255,0),rgb(255,255,255))]
color2=[icase(name='ÃÇÁ',rgb(128,255,0),total_money#total_moneys,rgb(255,0,255),rgb(255,255,255))]
setcolumn=fieldpos('name')
lockcolumns=setcolumn
formwidth=800
clear class myGroupData
oGroup=create('myGroupData')
oGroup.show
defi class myGroupData as myShows
	Proc SetMergeHeader
		.MergeHeader(fieldpos('REIMB_MONEY'),fieldpos('TOTAL_MONEY'),'¤èÒãªé¨èÒÂ HOSxP')
		.MergeHeader(fieldpos('REIMB_MONEYs'),fieldpos('TOTAL_MONEYs'),'¨Ò¡¡ÒÃ¤Ó¹Ç³')
		.MergeHeader(fieldpos('TMT_HOSxP'),fieldpos('TMT_EClaim'),'TMT')
enddefi

Proc ImportStatus
priv cfolder
_table=textmerge([<<myrcm>>.NewEClaim])
if !checkfield(_table,'Channel',,,_handle)
	=sqlexec(_handle,textmerge([drop table if exists <<_table>>]))
endif
if checkfieldlength(_table,'seq',,_handle)<50
	=sqlexec(_handle,textmerge([drop table if exists <<_table>>]))
endif
text to _sql noshow textmerge
create table if not exists <<_table>> (Seq varchar(50),EClaimNo varchar(30),CID varchar(13),HN varchar(15),AN varchar(15),AdmDate datetime,DchDate datetime
,Department varchar(3),MainInscl varchar(5),Income double(15,2) default 0
,TranID varchar(50),Rep varchar(50),Status varchar(1),StatusName varchar(20),Channel varchar(100)
,primary key (Seq)
,key CID(CID)
,key HN(HN)
,key AN(AN)
) engine=MyISAM default charset=tis620;

select * from <<_table>> limit 0
endtext
=runsql(_sql,.T.,'mytable')
cfolder=calfolder(getvariable(inifile,'Folder','Status','C:\Temp\OnWeb'))
try
	xlsfile=locfile(cfolder+'Export*.XLS','XLS')
catch
	xlsfile=''
endtry
if !file(xlsfile)
	retu
endif
=writevariable(inifile,'Folder','Status',justpath(xlsfile))
=writeerror(xlsfile,oerr)
_temp='tmpNew'
=file2cursor(xlsfile,_temp)
if !used(_temp)
	retu
endif
sele (_temp)
rec=recco()
n=0
=writeerror(trans(n)+'/'+trans(rec),oerr)
scan
	n=n+1
	=writeas(trans(n)+'/'+trans(rec),oerr)
	store '' to m.seq,m.an,m.hn,m.admdate,m.type,m.status
	scatt memv memo
	m.seq=ntoc(m.seq)
	m.hn=ntoc(m.hn)
	m.an=ntoc(m.an)
	m.type=ntoc(m.type)
	m.department=icase(m.type='1','OP','IP')
	m.status=ntoc(m.status)
	m.statusname='OnWeb['+m.status+']'
	do case
		case !empty(m.an)
			m.seq=m.an
			m.department='IP'
		case empty(m.seq)
			m.seq=ntoc(getsqldata([select vn from ovst where hn=?m.hn and vstdate=?m.admdate]))
			m.department='OP'
	endcase
	if !empty(m.seq)
		=savemysqldata(_table)
	endif
ends
=sqlexec(_handle,textmerge([delete a.* from <<myrcm>>.neweclaim a join <<myrcm>>.repdata b on b.id=a.tranid where ifnull(errorcode,'')='']))
=sqlexec(_handle,textmerge([delete a.* from <<myrcm>>.neweclaim a join <<myrcm>>.repeclaim b on b.id=a.tranid where ifnull(errorcode,'')='']))
=writeerror('OK',oerr)

Proc File2Cursor
para _file,_temp
local _data,_header,_body,_value,_values
_temp=ntoc(_temp)
_temp=icase(empty(_temp),'temp',_temp)
if used(_temp)
	use in (_temp)
endif
_data=icase(file(_file),filetostr(_file),'')
_data=icase(isutf(_data),strconv(_data,11),_data)
_header=strextract(_data,'<thead>','</thead>')
_body=strextract(_data,'<tbody>','</tbody')
set textmerge to memv lcXML noshow
set textmerge on
\<?xml version="1.0" encoding="Windows-874" standalone="yes" ?>
\<VFPData>
\	<xsd:schema id="VFPData" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata">
\		<xsd:element name="VFPData" msdata:IsDataSet="true">
\			<xsd:complexType>
 \				<xsd:choice maxOccurs="unbounded">
\					<xsd:element name="row" minOccurs="0" maxOccurs="unbounded">
\						<xsd:complexType>
\							<xsd:sequence>
ncount=1
lwork=.T.
dime myHeader(1,3)
do while lwork
	_value=strextract(_header,'<th>','</th>',nCount)
	if empty(_value)
		exit
	endif
	_var=_value
	_type='string'
	_width='50'
	do case
		case upper(_value)='CHANNEL'
			_var='Channel'
		case upper(_value)='ROW'
			_var='Row'
			_type='int'
			_width='10'
		case upper(_value)='ECLAIM'
			_var='EClaimNo'
		case upper(_value)='TRAN'
			_var='TranID'
		case _value='àÅ¢ºÑµÃ»ÃÐ¨ÓµÑÇ¼Ùé»èÇÂ(HN)' 	&&'HN'$upper(_value)
			_var='HN'
			_width='15'
		case _value='ºÑµÃ»ÃÐ¨ÓµÑÇ¼Ùé»èÇÂã¹ (AN)' 	&&'AN'$upper(_value)
			_var='AN'
			_width='15'
		case _value='»ÃÐàÀ·¼Ùé»èÇÂ'
			_var='Type'
			_width='1'
		case _value='ÊÔ·¸Ô»ÃÐâÂª¹ì'
			_var='MainInscl'
			_width='3'
		case _value='ËÁÒÂàÅ¢ºÑµÃ'
			_var='CID'
			_width='13'
		case _value='ª×èÍ¼Ùé»èÇÂ'
			_var='PtName'
		case _value='ª×èÍ¼ÙéºÑ¹·Ö¡àºÔ¡ª´àªÂ'
			_var='Recorder'
		case _value='ÇÑ¹·Õèà¢éÒÃÑººÃÔ¡ÒÃ'
			_var='AdmDate'
			_type='date'
		case _value='¨ÓË¹èÒÂÇÑ¹·Õè'
			_var='DchDate'
			_type='date'
		case _value='Ê¶Ò¹Ð¢éÍÁÙÅ'
			_var='Status'
			_width='1'
*		case _value='ÃÒÂÅÐàÍÕÂ´¡ÒÃµÃÇ¨ÊÍº'
	endcase
	_var=icase(between(left(_var,1),'A','Z'),_var,'Field'+trans(nCount))
	if ascan(myheader,_var,1,-1,1,15)>0
		_var='Field'+trans(nCount)
	endif
	dime myHeader(nCount,3)
	myheader(ncount,1)=_var
	myheader(ncount,2)=_value
	myheader(ncount,3)=_type
	nCount=nCount+1
\								<xsd:element name="<<lower(_var)>>">
\									<xsd:simpleType>
\										<xsd:restriction base="xsd:<<_type>>">
\											<xsd:maxLength value="<<_width>>"></xsd:maxLength>
\										</xsd:restriction>
\									</xsd:simpleType>
\								</xsd:element>
enddo
\							</xsd:sequence>
\						</xsd:complexType>
\					</xsd:element>
\				</xsd:choice>
\				<xsd:anyAttribute namespace="http://www.w3.org/XML/1998/namespace" processContents="lax"></xsd:anyAttribute>
\			</xsd:complexType>
\		</xsd:element>
\	</xsd:schema>

ncount=1
lwork=.T.
do while lwork
	_value=strextract(_body,'<tr>','</tr>',nCount)
	if empty(_value)
		exit
	endif
	\<EClaimData>
	for nsub=1 to alen(myheader,1)
		_header=lower(myheader(nsub,1))
		_values=ntoc(strextract(_value,'<td>','</td>',nsub))
		do case
			case upper(_values)='NULL'
				_values=''
		endcase
		\	<
		\\<<_header>>><<_values>></<<_header>>>
	next
	\</EClaimData>
	ncount=ncount+1
enddo
\</VFPData>
set textmerge to 
set textmerge off
=strtofile(m.lcXML,'C:\Temp\Test.XML')
Xmltocursor(m.lcXML,_temp)

Proc SendAPI
=writeerror('´Óà¹Ô¹¡ÒÃÊè§ API',oerr,.T.)
lTestZone=.F.
cFolderExport=calfolder(cfolder)
cURLToken=icase(ltestzone,'https://tnhsoapi.nhso.go.th/ecimp/v1/auth','https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth')
cURLSend=icase(ltestzone,'https://tnhsoapi.nhso.go.th/ecimp/v1/send','https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send')
cUser=getvariable(inifile,'NHSO API','User','')
cPsw=getvariable(inifile,'NHSO API','Password','')
cType='txt'
cPttype=''
lOver=.F.
if empty(cuser) or empty(cpsw)
	=writeas('¡ÃØ³ÒµÃÇ¨ÊÍº User ËÃ×Í Password',oerr,.T.)
	retu .F.
endif
checkfile=sys(2000,textmerge([<<cfolderexport>>ins*.<<ctype>>]))
checkfile=icase(empty(checkfile),'',cfolderexport+checkfile)
if !file(checkfile)
	=writeas('äÁè¾ºä¿ÅìÊÓËÃÑºÊè§ API',oerr,.T.)
	retu .F.
endif
oHttp=SetXMLHttp()
=writeas('¤é¹ËÒ Token',oerr,.T.)
cURL=cURLToken
_data=''
with oHttp
	.Open("POST",cURL,.F.)
	.setRequestHeader("Content-Type","text/html; charset=windows-874")
	.setRequestHeader("Content-Type","application/json")
	lOK=.T.
	try
		.send(textmerge('{ "username": "<<cUser>>", "password": "<<cPsw>>"}'))
	catch
		lOK=.F.
	endtry
	if lok
		_data=.responsetext
	endif
endwith
_data=icase(["token"]$_data,_data,'')
publ oJson
Json=create('myjson')
oJson=json.parse(_data)
_token=returndata('oJson.token')
if empty(_token)
	=writeas('äÁèÊÒÁÒÃ¶ËÒ Token ä´é',oerr,.T.)
	retu .F.
endif
=writeas('´Óà¹Ô¹¡ÒÃÊè§ÍÍ¡...',oerr,.T.)
cURL=cURLSend
_data=''
_send=readdata()
=strtofile(_send,'C:\Temp\SendEClaim.JSON')
with oHttp
	.Open("POST",cURL,.F.)
	.setRequestHeader("Content-Type","text/html; charset=windows-874")
	.setRequestHeader("Authorization", "Bearer "+_token)
	.setRequestHeader("Content-Type","application/json")
	lOK=.T.
	try
		.send(_send)
	catch
		lOK=.F.
	endtry
	if lok
		_data=.responsetext
	endif
endwith
oJson=json.parse(_data)
_status=tonum(returndata('oJson.status'))
_message=returndata('oJson.message')
=writeas(icase(_status=200,'Êè§ New-EClaim àÃÕÂºÃéÍÂ',_message),oerr)

Proc ReadData
local _data
_data=''
set textmerge to memv _data noshow
set textmerge on
\{ 
\	"fileType": "<<ctype>>"
\	, "maininscl": <<icase(empty(cpttype),[null],["]+cpttype+["])>>
\	, "importDup": <<icase(lover,'true','false')>>
\	, "assignToMe": false
\	, "dataTypes": [ "IP", "OP" ]
\	, "opRefer": false
\	, "file": { 
_str='ins|pat|opd|orf|odx|oop|ipd|irf|idx|iop|cht|cha|aer|adp|lvd|dru'
for ii=1 to getwordcount(_str,'|')
		_name=getwordnum(_str,ii,'|')
		_file=textmerge([<<cFolderExport>><<upper(_name)>>*.<<ctype>>])
		_file=sys(2000,_file)
		_file=icase(empty(_file),'',cfolderexport+_file)
		_size=filesize(_file)
\		<<icase(ii=1,'',',')>>"<<_name>>":{
\			"blobName": "<<upper(_name)>>.<<ctype>>"
\			, "blobType": "text/plain"
\			, "blob": "<<strconv(icase(file(_file),filetostr(_file),''),13)>>"
\			, "size": <<_size>>
\			, "encoding": "MS874"
\		}
next
\		, "lab": null 
\	} 
\}
set textmerge off
set textmerge to
retu _data
