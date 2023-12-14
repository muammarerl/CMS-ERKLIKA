<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_model extends CI_Model{
    
	function risk_yearly(){
                $y=date('Y');
		$q="SELECT count(*) as `all` FROM sv_risk_data WHERE YEAR(tgl_register)='$y' ";
		$a=$this->db->query($q)->row();
                return $a->all;
	}
        
	function risk_severity(){
                $y=date('Y');
		$q1="SELECT count(a.id) as `all` FROM sv_risk_data a LEFT JOIN sv_assessment_formula b ON a.rr_assessment=b.id WHERE YEAR(tgl_register)='$y' AND b.assessment=1 ";
		$q2="SELECT count(a.id) as `all` FROM sv_risk_data a LEFT JOIN sv_assessment_formula b ON a.rr_assessment=b.id WHERE YEAR(tgl_register)='$y' AND b.assessment=2 ";
		$q3="SELECT count(a.id) as `all` FROM sv_risk_data a LEFT JOIN sv_assessment_formula b ON a.rr_assessment=b.id WHERE YEAR(tgl_register)='$y' AND b.assessment=3 ";
		$a1=$this->db->query($q1)->row_array();
		$a2=$this->db->query($q2)->row_array();
		$a3=$this->db->query($q3)->row_array();
                $arr=array(
                    1=>$a1['all'],
                    2=>$a2['all'],
                    3=>$a3['all']
                        );
                return $arr;
	}
        function risk_weekly($datss){
                $y=date('Y');
		$q="SELECT count(*) as `all` FROM sv_risk_data WHERE tgl_register='$datss' ";
		$a=$this->db->query($q)->row();
                return $a->all;
	}

	function getCustomerData() {
        $queryCustomers = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_users WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)');
        return $queryCustomers->result();
    }

	function getRedeemData(){
		$queryRedeem = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_redeem_history WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data redeem
		return $queryRedeem->result();
	}

	function getVideoData(){
		$queryVideo = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_videos WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data video
		return $queryVideo->result();
	}

	function getPaymentData(){
		$queryPayment = $this->db->query('SELECT DATE(createdAt) AS date, COUNT(*) AS count FROM sv_payment_details WHERE createdAt IS NOT NULL GROUP BY DATE(createdAt)'); // Query untuk data video
		return $queryPayment->result();
	}

	// Payment
	public function getCountByConsumer($consumerType) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_payment WHERE consumer = ?", array($consumerType));
        $result = $query->row();
        return $result->count;
    }

	public function getCountByActivation($activationType) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_user_packages WHERE activation = ?", array($activationType));
        $result = $query->row();
        return $result->count;
    }

	public function getLimitedAdminsWithGroupTitle($limit = 4) {
        $query = $this->db->query('
            SELECT sv_admin.*, sv_admin_grup.title
            FROM sv_admin
            INNER JOIN sv_admin_grup ON sv_admin.id_admin_grup = sv_admin_grup.id
            LIMIT ?', array($limit)
        );
        return $query->result();
    }

	public function getTotalPrice() {
        $query = $this->db->query('SELECT SUM(price) AS total_price FROM sv_user_packages');
        return $query->row();
    }

	public function getTotalPriceTransaksi() {
        $query = $this->db->query('SELECT SUM(price) AS total_price FROM sv_user_packages');
        return $query->row();
    }

	public function getTotalVideosCount() {
        $query = $this->db->query('SELECT * FROM sv_videos');
        return $query->num_rows();
    }

    public function getUsersCount() {
        $query = $this->db->query('SELECT * FROM sv_users');
        return $query->num_rows();
    }

    public function getPackagesCount() {
        $query = $this->db->query('SELECT * FROM sv_packages');
        return $query->num_rows();
    }

    public function getPaymentCount() {
        $query = $this->db->query('SELECT * FROM sv_payment');
        return $query->num_rows();
    }

    public function getUsersWithPackageCount() {
        $query = $this->db->query('
            SELECT up.uid, COUNT(up.uid) AS total_uid, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid
            ORDER BY COUNT(up.uid) DESC
            LIMIT 9
        ');

        return $query->result();
    }

    public function getUsersWithTotalPrice() {
        $query = $this->db->query('
            SELECT up.uid, SUM(up.price) AS total_price, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid, u.full_name
            ORDER BY SUM(up.price) DESC
            LIMIT 9
        ');

        return $query->result();
    }

    public function getPackageWithTotalPrice() {
        $query = $this->db->query('
                SELECT up.package_id, COUNT(up.package_id) AS total_package_id, u.name
                FROM sv_user_packages up
                LEFT JOIN sv_packages u ON up.package_id = u.id
                GROUP BY up.package_id
                ORDER BY COUNT(up.package_id) DESC
                LIMIT 5
        ');

        return $query->result();
    }

    public function getPackageWithTotalPriceSchool() {
        $query = $this->db->query('
                SELECT up.package_id, COUNT(up.package_id) AS total_package_id, u.name, su.school
                FROM sv_user_packages up
                LEFT JOIN sv_packages u ON up.package_id = u.id
                LEFT JOIN sv_users su ON up.uid = su.id -- LEFT JOIN ke tabel sv_users berdasarkan uid
                GROUP BY up.package_id
                ORDER BY COUNT(up.package_id) DESC
                LIMIT 5
        ');

        return $query->result();
    }

    public function getUserPackages() {
        $this->db->select('UP.uid, U.full_name, UP.package_id, P.name');
        $this->db->from('SV_USER_PACKAGES AS UP');
        $this->db->join('SV_USERS AS U', 'U.full_name = UP.uid');
        $this->db->join('SV_PACKAGES AS P', 'P.name = UP.package_id');
        $this->db->order_by('UP.uid', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPackageDataTables() {
        return $this->db->get('sv_user_packages')->result();
    }

    public function getAllUserPackages() {
        $this->db->select('up.package_id, up.createdAt, up.expiredAt, u.name, u.price, su.school, su.full_name, su.email');
        $this->db->from('sv_user_packages up');
        $this->db->join('sv_packages u', 'up.package_id = u.id', 'left');
        $this->db->join('sv_users su', 'up.uid = su.id', 'left');
        $this->db->order_by('su.full_name', 'ASC');
        return $this->db->get()->result();
    }

    public function getTopUsers() {
        $query = $this->db->query('
            SELECT up.uid, COUNT(up.uid) AS total_uid, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid
            ORDER BY COUNT(up.uid) DESC
            LIMIT 7
        ');
        return $query->result();
    }

    public function getTopUsersWithTotalPrice() {
        $query = $this->db->query('
            SELECT up.uid, SUM(up.price) AS total_price, u.full_name
            FROM sv_user_packages up
            LEFT JOIN sv_users u ON up.uid = u.id
            GROUP BY up.uid, u.full_name
            ORDER BY SUM(up.price) DESC
            LIMIT 7
        ');
        return $query->result();
    }

    public function getTopRedeem() {
        $query = $this->db->query('
            SELECT rh.redeemBy, u.full_name, COUNT(*) AS jumlah_data
            FROM sv_redeem_history rh
            JOIN sv_users u ON rh.redeemBy = u.id
            GROUP BY rh.redeemBy, u.full_name
            ORDER BY jumlah_data DESC 
            LIMIT 5
        ');
        return $query->result();
    }

    public function getTopPackageRedeem() {
        $query = $this->db->query('
            SELECT rh.package_id, u.name, COUNT(*) AS jumlah_data
            FROM sv_redeem_history rh
            JOIN sv_packages u ON rh.package_id = u.id
            GROUP BY rh.package_id, u.name
            ORDER BY jumlah_data DESC
            LIMIT 5
        ');
        return $query->result();
    }

    public function getTopRedeemWithTotalPrice() {
        $query = $this->db->query('
            SELECT u.full_name, COUNT(rh.redeemBy) AS jumlah_data, SUM(rh.price) AS total_price
            FROM sv_redeem_history rh
            JOIN sv_users u ON rh.redeemBy = u.id
            GROUP BY u.full_name
            ORDER BY jumlah_data DESC
            LIMIT 5
        ');
        return $query->result();
    }

    public function getTopPackageRedeemWithTotalPrice() {
        $query = $this->db->query('
            SELECT u.name, COUNT(rh.redeemBy) AS jumlah_data, SUM(rh.price) AS total_price
            FROM sv_redeem_history rh
            JOIN sv_packages u ON rh.package_id = u.id
            GROUP BY u.name
            ORDER BY jumlah_data DESC
            LIMIT 5
        ');
        return $query->result();
    }

    public function getUserHistory() {
        $query = $this->db->query('
            SELECT sv_user_history.*, sv_users.full_name
            FROM sv_user_history
            INNER JOIN sv_users ON sv_user_history.uid = sv_users.id
            ORDER BY sv_user_history.updatedAt DESC 
            LIMIT 20
        ');
        return $query->result();
    }

    public function getLogUserHistory() {
        $this->db->select('sv_user_history.*, sv_users.full_name');
        $this->db->from('sv_user_history');
        $this->db->join('sv_users', 'sv_user_history.uid = sv_users.id', 'inner');
        $this->db->order_by('sv_user_history.id', 'ASC');
    
        return $this->db->get()->result();
    }

    public function getPaymentAll() {
        $this->db->select('spp.transaction_status, spp.settlement_time, spp.updatedAt, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        // $this->db->order_by('spp.updatedAt', 'ASC');
        
        return $this->db->get()->result();
    }
    public function getPaymentSettlement() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['settlement']);
        
        return $this->db->get()->result();
    }
    public function getPaymentRefound() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['refound']);
        
        return $this->db->get()->result();
    }
    public function getPaymentCancel() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['cancel']);
        
        return $this->db->get()->result();
    }
    public function getPaymentExpired() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['expired']);
        
        return $this->db->get()->result();
    }
    public function getPaymentPending() {
        $this->db->select('spp.transaction_status, spp.order_id, spp.qty, spp.total_amount, spp.payment_type, svu.email, svpd.name');
        $this->db->from('sv_payment spp');
        $this->db->join('sv_users svu', 'spp.uid = svu.id');
        $this->db->join('sv_payment_details svpd', 'spp.package_id = svpd.id');
        $this->db->where_in('spp.transaction_status', ['pending']);
        
        return $this->db->get()->result();
    }
    
    public function sdsdsd() {
        $this->db->select('transaction_status, COUNT(*) AS total_count');
            $this->db->from('sv_payment');
            $this->db->group_by('transaction_status');
            $this->db->get();

            return $this->db->get()->result();
    }

    public function countByTransactionStatus($transaction_status) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_payment WHERE transaction_status = ?", array($transaction_status));
        $result = $query->row();
        return $result->count;
    }

    public function countByPlatform($platform) {
        $query = $this->db->query("SELECT COUNT(*) AS count FROM sv_payment WHERE platform = ?", array($platform));
        $result = $query->row();
        return $result->count;
    }

    public function getCountPerId() {
        $this->db->select('transaction_status, COUNT(*) AS count_per_status');
        $this->db->from('sv_payment');
        $this->db->group_by('transaction_status');

        return $this->db->get()->result();
    }

    public function getTopPackages() {
        $this->db->select('sv_payment.package_id, sv_packages.name, COUNT(*) AS total_data');
        $this->db->from('sv_payment');
        $this->db->join('sv_packages', 'sv_payment.package_id = sv_packages.id', 'inner');
        $this->db->group_by('sv_payment.package_id, sv_packages.name');
        $this->db->order_by('total_data', 'DESC');
    
        return $this->db->get()->result();
    }

    public function getVisitsByDate($day, $month, $year){
        $start_date = "$year-$month-$day 00:00:00";
        $end_date = "$year-$month-$day 23:59:59";

        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('updatedAt >=', $start_date);
        $this->db->where('updatedAt <=', $end_date);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }
    public function getVisitsToday(){
        $today = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('DATE(updatedAt)', $today);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getVisitsThisMonth(){
        $thisMonth = date('Y-m');
        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('DATE_FORMAT(updatedAt, "%Y-%m")', $thisMonth);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getVisitsThisYear(){
        $thisYear = date('Y');
        $this->db->select('*');
        $this->db->from('sv_user_history');
        $this->db->where('YEAR(updatedAt)', $thisYear);
        $this->db->order_by('updatedAt', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function countDataThisToday() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('sv_user_history');
        $this->db->where('MONTH(updatedAt)', date('d'));
        $this->db->where('MONTH(updatedAt)', date('m'));
        $this->db->where('YEAR(updatedAt)', date('Y'));

        $query = $this->db->get();
        return $query->row()->total;
    }

    public function countDataThisMonth() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('sv_user_history');
        $this->db->where('MONTH(updatedAt)', date('m'));
        $this->db->where('YEAR(updatedAt)', date('Y'));

        $query = $this->db->get();
        return $query->row()->total;
    }
    public function countDataThisYears() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('sv_user_history');
        $this->db->where('YEAR(updatedAt)', date('Y'));

        $query = $this->db->get();
        return $query->row()->total;
    }
    

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

