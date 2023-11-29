<?php

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
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

