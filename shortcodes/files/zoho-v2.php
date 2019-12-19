<?php
aw2_library::add_shortcode('zoho','config', 'awesome2_zoho_v2_config','Runs Zoho.com CRM API Actions');

aw2_library::add_shortcode('zoho','crm', 'awesome2_zoho_v2_crm','Runs Zoho.com CRM API Actions');

 
function awesome2_zoho_v2_crm($atts,$content=null,$shortcode){
    
    /*
    if(\aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
    
    extract( shortcode_atts( array(
    'main'=>null,
    ), $atts) );
    unset($atts['main']);

    $return_value='';
    $pieces=explode('.',$main);
    
    $zoho=new aw2_zoho_v2_crm($pieces['0'],$pieces['1'],$atts,$content);
    $return_value=$zoho->run();

    $return_value=\aw2_library::post_actions('all',$return_value,$atts);
    unset($pieces);
    return $return_value;
    
    */
}

function awesome2_zoho_v2_config($atts,$content=null,$shortcode){
    
    if(\aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
    
    extract( shortcode_atts( array(
    'main'=>null,
    ), $atts) );
    unset($atts['main']);

    $return_value='';
    $pieces=explode('.',$main);

    $zoho_config = new awsZohoConfig();

    if (method_exists($zoho_config, $main)){
        $return_value = call_user_func(array($zoho_config, $main));
    }else{
        $return_value = "fun:awesome2_zoho_v2_config - invalid function call.";
    }

    $return_value=\aw2_library::post_actions('all',$return_value,$atts);
    unset($pieces);
    return $return_value;
}

class aw2_zoho_v2_crm{
    
    public $module=null;
    public $action=null;
    public $atts=null;
    public $content=null;
    public $zoho_crm=null;

    function __construct($module,$action,$atts,$content=null){

        $this->module=$module;
        $this->action=$action;
        $this->atts=$atts;
        $this->content=trim($content);

        $_SERVER['user_email_id'] = $GLOBALS['zoho_config']['zoho_userIdentifier_email'];		
        $this->zoho_crm = new \zohoMain();
    }

    public function run(){
        $return_value='';
	
        if (method_exists($this, $this->action)){
            return call_user_func(array($this, $this->action));
        }else {
            return "invalied function call...";
        }
        return $return_value;	
    }

    private function getRecord(){
        $response = array();
        if(!empty($this->module) && !empty($this->atts['id'])){
            $result =  $this->zoho_crm->getRecord($this->module,$this->atts['id']);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Please zoho module and id is required fields!');
        }
        return $response;
    }

    private function getRecords(){
        $field_api_name = $this->atts['field_api_name'];
        $sort_order = $this->atts['sort_order'];
        $start_index = $this->atts['start_index'];
        $end_index = $this->atts['end_index'];


        $response = array();
        if(!empty($this->module)){
            $result =  $this->zoho_crm->getRecords($this->module,null ,$field_api_name,$sort_order,$start_index,$end_index,null);
            if(isset($result['aws_status'])){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'zoho module name is required field!');
        }
        return $response;
    }

    private function getModuleFields(){
        $response = array();
        $result =  $this->zoho_crm->getModuleFieldsName($this->module);
        if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
        }else{
            $response = array('status'=>'error','response'=>$result);
        }

        return $response;
    }

    private function getAllCustomViews(){
        $response = array();
        $result =  $this->zoho_crm->getAllCustomViews($this->module);
        if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
        }else{
            $response = array('status'=>'error','response'=>$result);
        }

        return $response;
    }

    private function deleteRecords(){
        $response = array();
        if(!empty($this->module) && !empty($this->atts['ids'])){
            $result =  $this->zoho_crm->deleteRecords($this->module,$this->atts['ids']);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Comma separated ids is required fields.Example ids="1234567890,9876543210" or Invalid shortcode format.');
        }
        return $response;
    }

    private function createRecord(){
        $args = $this->args();
        $response = array();
        if(!empty($this->module) && !empty($args)){
            $result =  $this->zoho_crm->createRecords($this->module, $args);

            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'id is required fields.Example id="1234567890" or Invalid shortcode format.');
        }
        return $response;
    }

    private function updateRecord(){
        $args = $this->args();
        $response = array();

        if(!empty($this->module) && !empty($this->atts['ids'])){
            $result =  $this->zoho_crm->updateRecord($this->module,$this->atts['ids'],$args);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Comma separated ids is required fields.Example ids="1234567890,9876543210" or Invalid shortcode format.');
        }
        return $response;
    }

    private function createRecords(){
        $args = $this->args();
        $response = array();
        if(!empty($this->module) && !empty($args)){
            foreach ($args['rows'] as $value) {
			
                $result =  $this->zoho_crm->createRecords($this->module,$value);
                if($result['aws_status'] === 1){
                    unset($result['aws_status']);
                    $response[] = array('status'=>'success','response'=>$result);
                }else{
                    $response[] = array('status'=>'error','response'=>$result);
                }
            }
        }else{
            $response = array('status'=>'error','message'=>'Comma separated ids is required fields.Example ids="1234567890,9876543210" or Invalid shortcode format.');
        }
        return $response;
    }

    private function uploadPhoto() {
        $response = array();
        if(!empty($this->module) && !empty($this->atts['id']) && !empty($this->atts['path'])){
            $result =  $this->zoho_crm->uploadPhoto($this->module,$this->atts['id'],$this->atts['path']);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Lead id, absolute path required fields.Example id="1234567890" path="D:\laragon\IMG_20181106_111725-768x432.jpg" or Invalid shortcode format.');
        }
        return $response;
    }

    private function uploadAttachment() {
        $response = array();
        if(!empty($this->module) && !empty($this->atts['id']) && !empty($this->atts['path'])){
            $result =  $this->zoho_crm->uploadAttachment($this->module,$this->atts['id'],$this->atts['path']);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Lead id, absolute path required fields.Example id="1234567890" path="D:\laragon\IMG_20181106_111725-768x432.jpg" or Invalid shortcode format.');
        }
        return $response;
    }

    private function updateAccessToken() {
        $result =  $this->zoho_crm->updateAccessToken();
        return $result;
    }

    private function getZohoRefreshToken() {
        $result =  $this->zoho_crm->getZohoRefreshToken();
        return $result;
    }

    private function addNote() {
        $args = $this->args();
        $response = array();
        if(!empty($this->module) && !empty($this->atts['id']) && !empty($args)){
            $result =  $this->zoho_crm->addNote($this->module,$this->atts['id'],$args);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Lead id,Note title or Contect is required.or Invalid shortcode format.');
        }
        return $response;
    }

    private function updateNotes() {
        $args = $this->args();

        $response = array();
        if(!empty($this->module) && !empty($this->atts['id']) && !empty($args)){
            $result =  $this->zoho_crm->updateNotes($this->module,$this->atts['id'],$args);
            if($result['aws_status'] === 1){
                unset($result['aws_status']);
                $response = array('status'=>'success','response'=>$result);
            }else{
                $response = array('status'=>'error','response'=>$result);
            }
        }else{
            $response = array('status'=>'error','message'=>'Lead id,Note title or Contect is required.or Invalid shortcode format.');
        }
        return $response;
    }
    
    private function args(){
        if($this->content==null || $this->content==''){
            $return_value = array();	
        }
        else{
            $json=\aw2_library::clean_specialchars($this->content);
            $json=\aw2_library::parse_shortcode($json);		
            $return_value=json_decode($json, true);
            if(is_null($return_value)){
                \aw2_library::set_error('Invalid JSON' . $content); 
                $return_value=array();	
            }
        }
        //util::var_dump($return_value);
        /* $arg_list = func_get_args();
        foreach($arg_list as $arg){
                if(array_key_exists($arg,$this->atts))
                        $return_value[$arg]=$this->atts[$arg];
        } */
        return $return_value;
    }
}

