<?php 
class Load extends CI_Controller {
		
		
		function __construct(){
				parent::__construct();
		}
		function renderdropdown($id=NULL){
				$side=GetAll('sv_menu',array('id_parents'=>'where/'.(int)$id,'sort'=>'order/ASC','is_active'=>"where/Active"));
				$data['menu']=$side->result();
				$this->load->view('layout/listside',$data);
		}
		function rendermessage(){
			error_reporting(0);
				$filter=array();
				$idwebmaster=$this->session->userdata('webmaster_grup');
				if($idwebmaster==4 || $idwebmaster==5 || $idwebmaster==6 ||  $idwebmaster==7 || webmastergrup()==8 || webmastergrup()==10){
				if($idwebmaster==4){$filter['to']='where/Export';}
				if($idwebmaster==5){$filter['to']='where/Import';}
				if($idwebmaster==7){$filter['to']='where/Finance';}
				if($idwebmaster==6 || webmastergrup()==8 || webmastergrup()==10){$filter['to']='where/Trucking';}
				
				}
				$filter['status']='where/N';
				$filter['create_date']='order/DESC';
				
				$data['badge']=GetAll('notif',$filter)->num_rows();
				
				//unset($filter['status']);
				$data['isi']=GetAll('notif',$filter)->result_array();
				
				$this->load->view('layout/message',$data);
		}
		function error404(){
				$this->load->view('layout/notfound');
		}
		function ambilakun(){
				$akun=GetAll('setup_account_mapping',array('id'=>'where/'.$_REQUEST['a']))->row_array();
				echo $akun['acno'].'/'.$akun['acno2'].'/'.$akun['name'].'/'.$akun['name'];
		}
		
		function exec_voucher(){
			$now=date('Y-m-d');
			error_reporting(0);
			ini_set("memory_limit", "10056M");
			set_time_limit(0);
			ini_set('mysql.connect_timeout', '0');
			ini_set('max_execution_time', '0');
			$myfile = fopen("./logs/voucherjob-$now.txt", "a") or die("Unable to open file!");
			$find_proc=$this->db->query("SELECT * FROM sv_voucher_job WHERE job_status='processing'")->num_rows();
			if($find_proc==0){
			$find_jobs=$this->db->query("SELECT * FROM sv_voucher_job WHERE job_status='waiting'")->result();
			foreach($find_jobs as $jobs){
				fwrite($myfile, "processing job id ".$jobs->id."\n");
				$this->db->query("UPDATE sv_voucher_job SET job_status='processing' WHERE id='".$jobs->id."'");
				$this->benchmark->mark('code_start');
				$loopend=false;
				$generated=0;
				//for($a=1;$a<=$jobs->jumlah;$a++){
					
					$this->db->trans_begin();
					while(!$loopend){
						$code=generateVoucher();
						
						//$find_generated=$this->db->query("SELECT code FROM sv_vouchers WHERE code='$code'")->num_rows();
						//if($find_generated==0){
							$data['job_id']=$jobs->id;
							$data['code']=$code;
							$data['package_id']=$jobs->package;
							$data['is_redeem']=0;
							$data['expiredAt']=$jobs->expiredAt;
							$data['createdAt']=date('Y-m-d H:i:s');
							//$data['updatedAt']=date('Y-m-d H:i:s');
							$ins=$this->db->insert_string('sv_vouchers',$data);
							$insert_query = preg_replace('/INSERT INTO/','INSERT IGNORE INTO',$ins,1);
							$insert=$this->db->query($insert_query);
							if($this->db->insert_id()>0){
								fwrite($myfile, "generated 1 voucher from ".$jobs->id."\n");
								$generated++;
							}

							//if($ins) $generated++;
						//}
						if($generated==$jobs->jumlah){
							
							if ($this->db->trans_status() === FALSE)
							{
        						$this->db->trans_rollback();
							}
							else
							{
        						$this->db->trans_commit();
							}
							$this->benchmark->mark('code_end');
							$times= $this->benchmark->elapsed_time('code_start', 'code_end');
							$loopend=true;
							fwrite($myfile, "generated all voucher from ".$jobs->id."\n");
							$updateproc=$this->db->query("UPDATE sv_voucher_job SET job_status='done',exec_time='$times' WHERE id='".$jobs->id."'");
						}
					}

				//}
			}
			}
			echo "done";
		}
		function callback_ingest(){
			$now=date('Y-m-d');
			$myfile = fopen("./logs/callback-$now.txt", "a") or die("Unable to open file!");
			// Takes raw data from the request
			$json = file_get_contents('php://input');


			//$txt = "John Doe\n";
			fwrite($myfile, $json."\n");
			
			// Converts it into a PHP object
			$data = json_decode($json);
			$cari=getIngestJob($data->videoId,$data->jobId);
			$cj=$cari['response'];
			if($cari['httpcode']==200){
				fwrite($myfile, json_decode($cj)."\n");
				if($cj->state=='finished'){
					$cariindo=$this->db->query("SELECT id FROM sv_videos WHERE video_id='".$cj->video_id."'")->num_rows();
					if($cariindo>0){
						$ingest='ingest_status_id';
						$vid='video_id';
						$fl='filename_id';
					}else{
						$ingest='ingest_status_en';
						$vid='video_en';
						$fl='filename_en';
					}
					$filebefore=explode('/',GetValue($fl,'sv_videos',array($vid=>'where/'.$cj->video_id)));
					unlink('./assets/upload_video/'.end($filebefore));
					if(!empty(GetValue($fl,'sv_videos',array($vid=>'where/'.$cj->video_id)))){
						$this->db->query("UPDATE sv_videos SET `$ingest`='finished' WHERE `$vid`='".$cj->video_id."'");
					}
				fwrite($myfile, $this->db->last_query()."\n");
				}
				
			}

			
			fclose($myfile);
		}
		function coba(){
			$code='YQVL-J5EI-4K6X-3OC0s';
			$insert_query = $this->db->insert_string('sv_vouchers',array('code'=>$code));
			$insert_query = preg_replace('/INSERT INTO/','INSERT IGNORE INTO',$insert_query,1);
			$ins=$this->db->query($insert_query);
			if($this->db->insert_id()>0){
				echo 'berhasil';
			}else{
				echo 'gagal';
			}
			//$ins=$this->db->insert('sv_vouchers',array('code'=>$code));
			//$this->db->query("INSERT INTO sv_vouchers SET code='$code'");
		}
}