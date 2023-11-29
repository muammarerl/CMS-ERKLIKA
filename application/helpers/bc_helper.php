<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
function getBCID(){
    
	$CI =& get_instance();
    $getsetup=$CI->db->query("SELECT account_id,client_id,client_secret FROM sv_setup_brightcove WHERE id=1")->row_array();
    return $getsetup;
}

function getAuth(){
    
	$CI =& get_instance();
    if(!$CI->session->userdata('bc_session') || strtotime(date('Y-m-d H:i:s'))>$CI->session->userdata('bc_session_exp')){
    $getsetup=getBCID();

    $data = array("username" => "erlangga"); // data u want to post                                                                   
    $data_string = json_encode($data);                                                                                   
    $api_key = $getsetup['client_id'];   
    $password = $getsetup['client_secret'];                                                                                                                  
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://oauth.brightcove.com/v4/access_token?grant_type=client_credentials");    
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
    curl_setopt($ch, CURLOPT_POST, true);                                                                   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
    'Accept: application/json',
    'Content-Type: application/json')                                                           
    );             

    //if(curl_exec($ch) === false)
    //{
    //    echo 'Curl error: ' . curl_error($ch);
    //}                                                                                                      
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'response'=>json_decode($result)
        );
        $CI->session->set_userdata('bc_session',$resp['response']->access_token);
        $CI->session->set_userdata('bc_session_exp',strtotime("+4 min"));
        return $resp['response']->access_token;
    }else{
        return $CI->session->userdata('bc_session');
    }
}
//labels
function getLabel(){
    
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    //echo $auth;
    //echo $bc['client_id'];
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/labels"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
    //curl_setopt($ch, CURLOPT_POST, true);                                                                   
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 

    //if(curl_exec($ch) === false)
    //{
      //  echo 'Curl error: ' . curl_error($ch);
    //}                                                                                                      
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>json_decode($result)
        );
        return $resp;
}

function delLabel($label){
    
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    //echo $auth;
    //echo $bc['client_id'];
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/labels/by_path/$label"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");  
    //curl_setopt($ch, CURLOPT_POST, true);                                                                   
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                                        
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>json_decode($result)
        );
        return $resp;
}

function insertLabel($label){
    
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    $a=new stdClass();
    $a->path=$label;
    $data_string=json_encode($a);
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/labels"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
    curl_setopt($ch, CURLOPT_POST, true);                                                                   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                               
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>array(json_decode($result))
        );
        return $resp;
}

function updLabel($old,$label){
    
	$CI =& get_instance();
    $labelclean=explode('/',substr($label,0,-1));
    $bc=getBCID();
    $auth=getAuth();
    $a=new stdClass();
    $a->new_label=end($labelclean);
    $data_string=json_encode($a);
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/labels/by_path/$old"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");  
    curl_setopt($ch, CURLOPT_POST, true);                                                                   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                               
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>array(json_decode($result))
        );
        return $resp;
}
//videos
function insertVideo($method,$name,$desc,$label,$vid=null,$tags){
    
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    $a=new stdClass();
    $a->name=$name;
    $a->description=$desc;
    $a->tags=$tags;
    $a->labels=$label;
    $data_string=json_encode($a);
    //print_mz($data_string);
    $url='';
    if(!empty($vid))$url="/$vid";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/videos$url"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);  
    curl_setopt($ch, CURLOPT_POST, true);                                                                   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                               
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        $head=$sent['request_header'];
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            //'data'=>$data_string,
            //'head'=>$head,
            'response'=>array(json_decode($result))
        );
        return $resp;
}

//videos
function ingestVideo($vid,$video=null,$poster=null,$thumbnail=null,$caption=null,$lang=null,$autocaption=null){
    ///v1/accounts/{account_id}/videos/{video_id}/ingest-requests
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    $a=new stdClass();
        if(!empty($video)){
            $a->master= new stdClass();
            $a->master->url=$video;
        }
        if(!empty($poster)){
            $a->poster= new stdClass();
            $a->poster->url=$poster;
            $a->poster->width=1488;
            $a->poster->height=536;
        }
        if(!empty($thumbnail)){
            $a->thumbnail= new stdClass();
            $a->thumbnail->url=$thumbnail;
            $a->thumbnail->width=364;
            $a->thumbnail->height=165;
        }
        if(!empty($caption)){
            $a->text_tracks[0]= new stdClass();
            $a->text_tracks[0]->url=$caption;
            $a->text_tracks[0]->srclang=$lang;
            $a->text_tracks[0]->kind="captions";
            $a->text_tracks[0]->label=strtoupper($lang);
            $a->text_tracks[0]->default=($lang=='id')?true:false;
            $a->text_tracks[0]->status="published";
            $a->text_tracks[0]->embed_closed_caption=false;
        }
        if(!empty($autocaption)){
            $a->transcriptions[0]= new stdClass();
            $a->transcriptions[0]->srclang='id';
            $a->transcriptions[0]->kind="captions";
            $a->transcriptions[0]->label='ID';
            $a->transcriptions[0]->default=true;
            $a->transcriptions[0]->status="published";
        }

        
    $a->callbacks = array(base_url()."load/callback_ingest");
    $data_string=json_encode($a);
    $url='';
    // print_mz($a);
    if(!empty($vid))$url="/$vid";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/videos/$vid/ingest-requests"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');  
    curl_setopt($ch, CURLOPT_POST, true);                                                                   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                               
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>array(json_decode($result))
        );
        return $resp;
}

function delVideo($vid){
    
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    //$data_string=json_encode($a);
    $url='';
    if(!empty($vid))$url="/$vid";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/videos$url"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');  
    //curl_setopt($ch, CURLOPT_POST, true);                                                                   
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                               
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>array(json_decode($result))
        );
        return $resp;
}
function getIngestJob($vid,$jid){
    ///v1/accounts/{account_id}/videos/{video_id}/ingest_jobs/{job_id}
	$CI =& get_instance();
    $bc=getBCID();
    $auth=getAuth();
    //$data_string=json_encode($a);
    $url='';
    if(!empty($vid))$url="/$vid";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://cms.api.brightcove.com/v1/accounts/".$bc['account_id']."/videos$url/ingest_jobs/$jid"); 
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        'Authorization: Bearer '.$auth, 
        'Accept: application/json',
        'Content-Type: application/json')                                                      
        );                
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');  
    //curl_setopt($ch, CURLOPT_POST, true);                                                                   
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    //curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$password);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                                                               
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $sent = curl_getinfo($ch);
        curl_close($ch);  
        $resp=array(
            'httpcode'=>$returnCode,
            'error'=>$errors,
            'sent'=>$sent,
            'response'=>json_decode($result)
        );
        return $resp;

}