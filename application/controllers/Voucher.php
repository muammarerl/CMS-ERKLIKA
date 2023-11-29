<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*************************************
  * Created : January 2021
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class Voucher extends CI_Controller {
	
		var $utama ='voucher';
		var $title ='Voucher';
	function __construct()
	{
		parent::__construct();
                izin();
		$this->load->library('flexigrid');
                $this->load->helper('flexigrid');
	}
	
	function index()
	{
		$this->main();
	}
	function getconfig(){
		$a=getAuth();
		print_mz($a);
	}
	function getlabel(){
		$a=getLabel();
		print_mz($a);
	}
	function main()
	{
                $data['type']='View';
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['js_grid']=$this->get_column();
		
		$this->load->view('layout/main',$data);
	}
        function listcol(){
            
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['job_status'] = array('Job Status',180,TRUE,'left',2);
            $colModel['title'] = array('Job Name',180,TRUE,'left',2);
            //$colModel['type'] = array('Type',180,TRUE,'left',2);
            $colModel['package_name'] = array('Package',180,TRUE,'left',2);
            $colModel['package_ax'] = array('Kode Produk AX',180,TRUE,'left',2);
            $colModel['price_'] = array('Price',100,TRUE,'left',2);
            $colModel['periode'] = array('Periode',180,TRUE,'left',2);
            $colModel['jumlah_'] = array('Jumlah Voucher',120,TRUE,'left',2);
            $colModel['createdAt'] = array('Create Date',110,TRUE,'left',2);
            $colModel['expiredAt'] = array('Tgl Expired',120,TRUE,'left',2);
            $colModel['printed'] = array('Telah Dicetak?',120,TRUE,'left',2);
            $colModel['is_void_'] = array('Dibatalkan?',120,TRUE,'left',2);
            return $colModel;
        }
	
	function get_column(){
	$colModel=$this->listcol();
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
           	$buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
            $buttons[] = array('separator');
            $buttons[] = array('print','print','btn');
            $buttons[] = array('separator');
            $buttons[] = array('void','delete','btn');
            $buttons[] = array('separator');
            $buttons[] = array('unvoid','check','btn');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("a.id idnya,a.*,b.name package_,c.title periode_,FORMAT(a.price,0) price_,FORMAT(a.jumlah,0) jumlah_,case a.is_void
			when '0' then 'Tidak'
			when '1' then 'YA'
			end as is_void_",false)->from("sv_voucher_job a");
			$this->db->join("sv_packages b","b.id=a.package","left");
			$this->db->join("sv_setup_periode c","c.id=a.periode","left");
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from("sv_voucher_job");
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
		function gettagsparent(){
			$id=$this->input->post('parents');
			$a=GetValue('tags','tags',array('id'=>'where/'.$id));
			echo ($a!='0' ? $a : '');
		}
	
	function get_record(){
            $colModel=$this->listcol();
            $z=0;
            foreach($colModel as $key=>$cm){
				$valid_fields[$z]=$key;
				$z++;
            }

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();
            $a=0;
            $coloring='black';
            foreach ($records['records']->result() as $row)
            {
                $record_items[$a][]=$row->id;
				$record_items[$a][]=$row->id;
				$b=2;
				foreach($colModel as $key=>$cm){
                    if($key!='id'){
                        $record_items[$a][$b]="<span style='color:$coloring'>".$row->$key."</span>";
					$b++;
                    }
				}
                $a++;
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  
	function deletec()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			$cetak=GetValue('printed','sv_voucher_job',array('id'=>'where/'.$country_id));
			if($cetak=='yes'){
				$flag='printed';
			}
			else{
				$del1=$this->db->delete('sv_voucher_job',array('id'=>$country_id));
				$del=$this->db->delete('sv_vouchers',array('job_id'=>$country_id));
            		if($del1 && $del)$flag='ok';
                    else $flag='nook';
				}
			
		}
                echo $flag;
	}
	 
	function void()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
				$this->db->where('id',$country_id);
				$del1=$this->db->update('sv_voucher_job',array('is_void'=>1));
				$this->db->where(array('job_id'=>$country_id,'is_redeem'=>0));
				$del=$this->db->update('sv_vouchers',array('is_redeem'=>2));
            		if($del1 && $del)$flag='ok';
                    else $flag='nook';
			
		}
                echo $flag;
	}
	function unvoid()
	{		
		//return true;
		//if(izin('d')){
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
				$this->db->where('id',$country_id);
				$del1=$this->db->update('sv_voucher_job',array('is_void'=>0));
				$this->db->where(array('job_id'=>$country_id,'is_redeem'=>2));
				$del=$this->db->update('sv_vouchers',array('is_redeem'=>0));
            		if($del1 && $del)$flag='ok';
                    else $flag='nook';
			
		}
                echo $flag;
	}
	function form($id=null){
		izin();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
                        $data['list']=GetAll('sv_'.$this->utama.'_job',$filter);
		}
		else{
			$data['type']='New';
		}
                
		$data['opt']=GetOptAll('admin_grup');
		$data['opt_type']=array(''=>'-Type-','retail'=>'Retail','paket'=>'Paket');
		$data['opt_package']=GetOptAll('packages','-Paket-',array('method'=>'where/voc','deletedAt'=>'where_is_null/'),'name');
		$data['opt_periode']=GetOptAll('setup_periode','-Periode-');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		
		
		$this->load->view('layout/main',$data);
	}
	function submit(){
                $webmaster_id=$this->session->userdata('webmaster_id');
                $id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama.'_job');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");

			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		//if(!$this->input->post('is_active')){$data['is_active']='InActive';}
		//else{$data['is_active']='Active';}
		
		if($id != NULL && $id != '')
		{
				$data['modifyBy'] = $webmaster_id;
				$data['modifyAt']=date("Y-m-d");
				$this->db->where("id", $id);
				$this->db->update('sv_'.$this->utama.'_job', $data);

				$this->db->where(array("job_id"=>$id,'is_redeem'=>0));
				$this->db->update('sv_'.$this->utama.'s', array('package_id'=>$data['package'],'expiredAt'=>$data['expiredAt']));
				
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Sukses diupdate');
			
		}
		else
		{
				$data['createdBy'] = $webmaster_id;
				$data['createdAt'] = date("Y-m-d H:i:s");
				$this->db->insert('sv_'.$this->utama.'_job', $data);
				$id = $this->db->insert_id();
				$this->session->set_flashdata("err_code", '0');
				$this->session->set_flashdata("message", 'Sukses ditambahkan');
			
		}
                
		if($this->input->post('next')) redirect($this->utama.'/form/');
		else redirect($this->utama);
		
	}

	function delete($id){
            $this->db->where('id',$id);
            $this->db->delete('sv_'.$this->utama);	
            $this->session->set_flashdata("message", 'Sukses dihapus');
            redirect($this->utama);
		
	}
	function print($id){
		$getjob=$this->db->query("SELECT id,title,job_status,is_void FROM sv_voucher_job WHERE id='$id'")->row_array();
		if($getjob['job_status']=='waiting'){
			echo '<script type="text/javascript">'; 
			echo 'alert("Voucher Belum Selesai Di Generate");';  
			echo 'window.history.back();'; 
			echo '</script>';
				exit;
		}
		if($getjob['is_void']=='1'){
			echo '<script type="text/javascript">'; 
			echo 'alert("Voucher Sudah Di Void");';  
			echo 'window.history.back();'; 
			echo '</script>';
				exit;
		}
		$getvoucher=$this->db->query("SELECT b.package as package_id,a.code,a.expiredAt,b.package_ax,b.title,b.price,b.periode,b.package_name  FROM sv_vouchers a LEFT JOIN sv_voucher_job b ON a.job_id=b.id WHERE a.job_id='$id'")->result();
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'.$getjob['title'].'.csv"');
		$fp = fopen('php://output', 'wb');
		$val=array();
		$val[0] = 'ID_Paket;NamaJob;PackageName;Kode_AX;Price;Duration;Code;TglExpired';
		fputcsv($fp, $val);
		unset($val[0]);
		$i=1;
		foreach ( $getvoucher as $line ) {
    		$val[$i] = $line->package_id.';'.str_replace(' ', '_', $line->title).';'.str_replace(' ', '_',$line->package_name).';'.$line->package_ax.';'.$line->price.';'.$line->periode.';'.$line->code.';'.tglindo($line->expiredAt);
    		fputcsv($fp, $val);
			unset($val[$i]);
			$i++;
		}
		fclose($fp);
		$data['printed'] = 'yes';
		$data['printed_date']=date("Y-m-d H:i:s");
		$this->db->where("id", $id);
		$this->db->update('sv_'.$this->utama.'_job', $data);
	}
	
	function loadpackage(){
		$package=$this->input->post('p');
		 $a=GetAll('sv_packages',array('id'=>'where/'.$package))->row_array();
		 $return=array(
			'name'=>$a['name'],
			'kode_produk_ax'=>$a['kode_produk_ax'],
			'price'=>$a['price'],
			'periode'=>$a['periode']
		 );
		 echo json_encode($return);
	}
	
}
?>