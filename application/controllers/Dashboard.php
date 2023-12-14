<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created :December 2014
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.2
*************************************/	

class dashboard extends CI_Controller {
	var $utama ='dashboard';
	function __construct()
	{
		parent::__construct();
                error_reporting(0);
		izin();
                $this->load->model('chart_model');
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
                $this->load->model('Chart_model');

                $resultCustomers = $this->Chart_model->getCustomerData();
                        $dataPointsCustomers = [];
                        foreach ($resultCustomers as $row) {
                                $dataPointsCustomers[] = [
                                'date' => $row->date,
                                'value' => $row->count
                                ];
                        }
                        $jsonChartDataUsers = json_encode($dataPointsCustomers);
                        $data['jsonChartDataUsers'] = $jsonChartDataUsers;

                $resultRedeem = $this->Chart_model->getRedeemData();
                        $dataPointsRedeem = [];
                        foreach ($resultRedeem as $row) {
                            $dataPointsRedeem[] = [
                                'date' => $row->date,
                                'value' => $row->count
                            ];
                        }
                        $jsonChartDataRedeem = json_encode($dataPointsRedeem);
                        $data['jsonChartDataRedeem'] = $jsonChartDataRedeem;

                $resultVideo = $this->Chart_model->getVideoData();
                        $dataPointsVideo = [];
                        foreach ($resultVideo as $row) {
                                $dataPointsVideo[] = [
                                        'date' => $row->date,
                                        'value' => $row->count
                                ];
                        }
                        $jsonChartDataVideo = json_encode($dataPointsVideo);
                        $data['jsonChartDataVideo'] = $jsonChartDataVideo;

                $resultPayment = $this->Chart_model->getPaymentData();
                        $dataPointsPayment = [];
                        foreach ($resultPayment as $row) {
                        $dataPointsPayment[] = [
                                'date' => $row->date,
                                'value' => $row->count
                        ];
                        }
                        $jsonChartDataPayment = json_encode($dataPointsPayment);
                        $data['jsonChartDataPayment'] = $jsonChartDataPayment;

                // pie chart 
		$count_consumer_1 = $this->Chart_model->getCountByConsumer('retail');
		$count_consumer_2 = $this->Chart_model->getCountByConsumer('school');
		$count_actv_1 = $this->Chart_model->getCountByActivation('sub');
		$count_actv_2 = $this->Chart_model->getCountByActivation('voc');
				$data['count_consumer_1'] = $count_consumer_1;
				$data['count_consumer_2'] = $count_consumer_2;
				$data['count_actv_1'] = $count_actv_1;
				$data['count_actv_2'] = $count_actv_2;

                // list admin 
                $limit = 4;
                $result = $this->Chart_model->getLimitedAdminsWithGroupTitle($limit);
                $data['admins'] = $result;

                // jumlah nilai transaksi
                $result = $this->Chart_model->getTotalPrice();
                $data['total_price'] = $result ? $result->total_price : 0;

                $totalVideosCount = $this->Chart_model->getTotalVideosCount();
                $data['totalVideosCount'] = $totalVideosCount;

                $usersCount = $this->Chart_model->getUsersCount();
                $data['usersCount'] = $usersCount;

                $packageCount = $this->Chart_model->getPackagesCount();
                $data['packageCount'] = $packageCount;

                $paymentCount = $this->Chart_model->getPaymentCount();
                $data['paymentCount'] = $paymentCount;

                $data['top_users'] = $this->Chart_model->getTopUsers();

                $this->load->helper('number');
                $data['top_users_total_price'] = $this->Chart_model->getTopUsersWithTotalPrice();

                $data['user_history'] = $this->Chart_model->getUserHistory();
        


		$data['content'] = 'contents/'.$this->utama.'/view';
		$this->load->view('layout/main',$data);

               
        
	}
        function visitors(){
            $charts='<chart caption="Temperature Monitoring (in degree C) on on 7/9/2013" xaxisname="Time" yaxismaxvalue="100" linecolor="008ee4" anchorsides="3" anchorradius="5" plotgradientcolor=" " bgcolor="FFFFFF" showalternatehgridcolor="0" showplotborder="0" showvalues="0" divlinecolor="666666" showcanvasborder="0" canvasborderalpha="0" >
            <set label="0" value="34" />
            <set label="3" value="27" />
            <set label="6" value="42" />
            <set label="9" value="50" />
            <set label="12" value="68" />
            <set label="15" value="56" />
            <set label="18" value="48" />
            <set label="21" value="34" />
            <set label="24" value="30" />
            <trendlines>
            <line startvalue="80" endvalue="100" displayvalue="Critical" color="008ee4" istrendzone="1" showontop="0" alpha="35" valueonright="1" />
            <line startvalue="60" endvalue="80" displayvalue="Warning" color="33bdda" istrendzone="1" showontop="0" alpha="35" valueonright="1" />
            </trendlines>
            </chart>';	
            echo $charts;
        }	
        
        function load_data(){
             $this->db->select("a.id idnya,a.*,DATE_FORMAT(a.tgl_register,'%d/%m/%Y') tgl_register_,DATE_FORMAT(a.created_on,'%d/%m/%Y') created_on_,b.title divisi_,c.name risk_owner_,d.name risk_identifier_,e.name pic_,f.name app_by_,DATE_FORMAT(a.app_date,'%d/%m/%Y') app_date_",false)->from("sv_risk_data a");
            $this->db->join("sv_ref_divisi b","b.id=a.divisi","left");
            $this->db->join("sv_admin c","c.id=a.risk_owner","left");
            $this->db->join("sv_admin d","d.id=a.risk_identifier","left");
            $this->db->join("sv_admin e","e.id=a.created_by","left");
            $this->db->join("sv_admin f","f.id=a.app_by","left");
            $this->db->join("sv_assessment_formula g","g.id=a.rr_assessment","left");
            
            if($this->input->post('y'))$this->db->where('YEAR(a.tgl_register)', $this->input->post('y'));
            if($this->input->post('s'))$this->db->where('g.assessment', $this->input->post('s'));
            if($this->input->post('d'))$this->db->where('a.tgl_register', tglsistem ($this->input->post('d')));
            $data['query']=$this->db->get()->result_array();
            //lastq();
            $this->load->view('contents/'.$this->utama.'/tbl_data',$data);
        }

        function chartcustomers() {
                $this->load->model('Chart_model'); // Load the model

                $resultCustomers = $this->Chart_model->getCustomerData();

                $dataPointsCustomers = [];
                foreach ($resultCustomers as $row) {
                        $dataPointsCustomers[] = [
                        'date' => $row->date,
                        'value' => $row->count
                        ];
                }
                $jsonChartDataUsers = json_encode($dataPointsCustomers);

                // Pass data to the view
                $data['jsonChartDataUsers'] = $jsonChartDataUsers;
                // $this->load->view('contents/'.$this->utama.'/view.php', $data);
                echo view('contents/'.$this->utama.'/view.php', $data);
        }
}
?>