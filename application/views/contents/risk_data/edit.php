<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<div class="row">
                    
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if(!diaojk()){?>
                                <form action="<?php echo base_url()?>risk_data/submit" method="post">
                                <?php }else{?>
                                    <form>
                                <?php }?>
                                    <?php echo form_hidden('id',$val['id']);?>
                                    <div class="col-md-6 my-2 pull-left">
                                        <div class="form-group row">
                                            <label for="idregister" class="col-sm-3 col-form-label">ID Register</label>
                                            <div class="col-sm-4">
                                                <input type="input" name="id_register" class="form-control" id="idregister" placeholder="ID Register" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="id_date" class="col-3 col-form-label">Tgl Register</label>
                                            <div class="col-4">
                                                <input type="input" id="datepicker" name="tgl_register" class="datepicker form-control" value="<?php echo ($val['tgl_register']?tglindo($val['tgl_register'],'/'):date('d/m/Y'))?>" readonly="readonly">
                                            </div>
                                          </div>
                                        <div class="form-group row">
                                            <label for="jenis_resiko" class="col-3 col-form-label">Jenis Resiko</label>
                                            <div class="col-4">
                                                <?php
                                                
                                                echo form_dropdown('jenis_risk',$opt_risk,($val['jenis_risk']?$val['jenis_risk']:''),'class="form-control" id="jenis_resiko"')?>
                                            </div>
                                            <!--<label for="divisi" class="col-2 col-form-label">Divisi</label>
                                            <div class="col-3">
                                                <?php echo form_dropdown('divisi_risk',$opt_divisi,($val['divisi']?$val['divisi']:''),'class="form-control" id="divisi"')?>
                                            </div>-->
                                          </div>
                                          <div class="form-group row">
                                            <label for="risk_desc" class="col-3 col-form-label">Risk Desc</label>
                                            <div class="col-7">
                                                <textarea class="form-control" rows="4"  name="risk_desc"><?php echo ($val['risk_desc']?$val['risk_desc']:'')?></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="id_date" class="col-3 col-form-label">Status Risk</label>
                                            <div class="col-4">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="status_risk_open" name="status_risk" class="custom-control-input" value="open" <?php echo ($val['status_risk'] && $val['status_risk']=='open'?'checked':'')?>>
                                                    <label class="custom-control-label" for="status_risk_open">Open</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="status_risk_close" name="status_risk" class="custom-control-input" value="close" <?php echo ($val['status_risk'] && $val['status_risk']=='close'?'checked':'')?>>
                                                    <label class="custom-control-label" for="status_risk_close">Closed</label>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="sebab" class="col-3 col-form-label">Sebab</label>
                                            <div class="col-9">
                                                <textarea class="form-control" rows="10"  name="sebab"><?php echo ($val['sebab']?$val['sebab']:'')?></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="akibat" class="col-3 col-form-label">Akibat</label>
                                            <div class="col-9">
                                                <textarea class="form-control" rows="10"  name="akibat"><?php echo ($val['akibat']?$val['akibat']:'')?></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="pengendalian_pencegahan" class="col-3 col-form-label">Pengendalian & Pencegahan</label>
                                            <div class="col-9">
                                                <textarea class="form-control" rows="10"  name="pengendalian_pencegahan"><?php echo ($val['pengendalian_pencegahan']?$val['pengendalian_pencegahan']:'')?></textarea>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-6">
                                                
                                            <?php if(!diaojk()){?>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            <?php }else{?>
                                                <a class="btn btn-primary" href="<?php echo base_url()?>risk_data">Close</a>
                                            <?php }?>
                                                <?php if(diaadmin()){?>
                                                <!--a href="#" class="btn btn-success">Approve</a-->
                                                <?php }?>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="col-md-6 my-2 pull-right">
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b>Inherit Risk:</b></label>
                                            <label for="dampak" class="col-2 col-form-label">Dampak</label>
                                            <div class="col-6"> 
                                            <?php 
                                            $nm_f='ir_impact';
                                            echo form_dropdown($nm_f,$opt_impact,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" onchange="ir_assess()" required="required"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b></b></label>
                                            <label for="probability" class="col-2 col-form-label">Probability</label>
                                            <div class="col-6">
                                                
                                            <?php
                                            $nm_f='ir_probability';
                                            echo form_dropdown($nm_f,$opt_probability,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" onchange="ir_assess()" required="required"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b></b></label>
                                            <label for="ir_assessment" class="col-2 col-form-label">Assessment</label>
                                            <div class="col-6">
                                                
                                            <?php
                                            $nm_f='ir_assessment';
                                            echo form_input($nm_f,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"');
                                            ?>
                                                <?php
                                            $nm_f='ir_x';
                                            echo form_input($nm_f,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"');
                                            ?>
                                                <label id="ir_assessment_text"></label>
                                                <!--input type="text" class="form-control" name="assessment" readonly="readonly"-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b>Impact Control :</b></label>
                                            <label for="dampak_impact" class="col-2 col-form-label">Dampak</label>
                                            <div class="col-6">
                                                <?php 
                                            $nm_f='ic_impact';
                                            echo form_dropdown($nm_f,$opt_impact,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" onchange="ic_assess()" required="required"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">(Pengendalian/Migitasi)</label>
                                            <label for="probability_impact" class="col-2 col-form-label">Probability</label>
                                            <div class="col-6">
                                            <?php
                                            $nm_f='ic_probability';
                                            echo form_dropdown($nm_f,$opt_probability,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" onchange="ic_assess()" required="required"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b></b></label>
                                            <label for="assessment_impact" class="col-2 col-form-label">Assessment</label>
                                            <div class="col-6">
                                            <?php
                                            $nm_f='ic_assessment';
                                            echo form_input($nm_f,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"')?><?php
                                            $nm_f='ic_x';
                                            echo form_input($nm_f,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"');
                                            ?>
                                                <label id="ic_assessment_text"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b>Residual Risk</b></label>
                                            <label for="residual_risk" class="col-2 col-form-label">Dampak</label>
                                            <div class="col-6">
                                                <?php 
                                            $nm_f='rr_impact';
                                            echo form_dropdown($nm_f,$opt_impact,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" onchange="rr_assess()" required="required" readonly="readonly"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"></label>
                                            <label for="probability_residual_risk" class="col-2 col-form-label">Probability</label>
                                            <div class="col-6">
                                            <?php
                                            $nm_f='rr_probability';
                                            echo form_dropdown($nm_f,$opt_probability,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" onchange="rr_assess()" required="required" readonly="readonly"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b></b></label>
                                            <label for="assessment_residual_risk" class="col-2 col-form-label">Assessment</label>
                                            <div class="col-6">
                                            <?php
                                            $nm_f='rr_assessment';
                                            echo form_input($nm_f,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"')?>
                                                <?php
                                            $nm_f='rr_x';
                                            echo form_input($nm_f,($val[$nm_f]?$val[$nm_f]:''),'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"');
                                            ?>
                                                <label id="rr_assessment_text"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b>Estimasi:</b></label>
                                            <div class="col-2"></div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="estimasi" id="estimasi" value="<?php echo ($val['estimasi']?$val['estimasi']:'')?>" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>Size</b></label>
                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" checked="" id="customRadio1" name="size" class="custom-control-input" value="1" <?php echo ($val['size'] && $val['size']=='1'?'checked':'')?>>
                                                    <label class="custom-control-label" for="customRadio1">Per Tahun</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio2" name="size" class="custom-control-input" value="2" <?php echo ($val['size'] && $val['size']=='2'?'checked':'')?> >
                                                    <label class="custom-control-label" for="customRadio2">Rp</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio3" name="size" class="custom-control-input" value="3" <?php echo ($val['size'] && $val['size']=='3'?'checked':'')?> >
                                                    <label class="custom-control-label" for="customRadio3">%</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio4" name="size" class="custom-control-input" value="4" <?php echo ($val['size'] && $val['size']=='4'?'checked':'')?> >
                                                    <label class="custom-control-label" for="customRadio4">Lainnya</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>R Appetite</b></label>
                                            <div class="col-6">
                                                <input type="number" class="form-control" name="r_appetite">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>R Tolerance</b></label>
                                            <div class="col-6">
                                                <input type="number" class="form-control" name="r_tolerance" id="r_tolerance" value="<?php echo ($val['r_tolerance']?$val['r_tolerance']:'')?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>Kejadian</b></label>
                                            <div class="col-6">
                                                <input type="number" class="form-control" name="kejadian" id="realisasi" value="<?php echo ($val['kejadian']?$val['kejadian']:'')?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>Divisi</b></label>
                                            <div class="col-9">
                                                <?php echo form_input('divisi',($val['divisi']?$val['divisi']:''),'class="form-control" id="divisi" readonly style="display:none"')?>
                                                <label id="divisi_text"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>Risk Owner</b></label>
                                            <div class="col-9">
                                                <?php
                                            $nm_f='risk_owner';
                                            echo form_dropdown($nm_f,$opt_user_owner,$val[$nm_f],'class="form-control" id="'.$nm_f.'" required="required" onchange="gantiowner()"')?>
                                                <!--input type="text" class="form-control" name="risk_owner"-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label"><b>Risk Identifier</b></label>
                                            <div class="col-9">
                                                <?php
                                            $nm_f='risk_identifier';
                                            echo form_dropdown($nm_f,$opt_user,($val[$nm_f]?$val[$nm_f]:webmasterid()),'class="form-control" id="'.$nm_f.'" required="required"')?>
                                                <!--input type="text" class="form-control" name="risk_identifier"-->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b>SKMR</b></label>
                                            <label for="skmr" class="col-2 col-form-label">Dampak</label>
                                            <div class="col-6">
                                                <?php 
                                            $nm_f='skmr_impact';
                                            echo form_dropdown($nm_f,$opt_impact,$val[$nm_f],'class="form-control" id="'.$nm_f.'" onchange="skmr_assess()" required="required"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"></label>
                                            <label for="probability_skmr" class="col-2 col-form-label">Probability</label>
                                            <div class="col-6">
                                                
                                            <?php
                                            $nm_f='skmr_probability';
                                            echo form_dropdown($nm_f,$opt_probability,$val[$nm_f],'class="form-control" id="'.$nm_f.'" onchange="skmr_assess()" required="required"')?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><b></b></label>
                                            <label for="assessment_skmr" class="col-2 col-form-label">Assessment</label>
                                            <div class="col-6">
                                            <?php
                                            $nm_f='skmr_assessment';
                                            echo form_input($nm_f,$val[$nm_f],'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"')?><?php
                                            $nm_f='skmr_x';
                                            echo form_input($nm_f,$val[$nm_f],'class="form-control" id="'.$nm_f.'" readonly="readonly" style="display:none"');
                                            ?>
                                                <label id="skmr_assessment_text"></label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
<script>
        $('#datepicker').datepicker({
            format:'dd/mm/yyyy',
            autoclose:true
        });
        $(document).ready(function(e){
            
            ir_assess();
            ic_assess();
            rr_assess();
            skmr_assess();
            estimasi();
            gantiowner();
        });
    function ir_assess(){
        $('#ir_assessment').val('');
        $('#ir_x').val('');
        $('#ir_assessment_text').empty();
        let ir_impact=$('#ir_impact').val();   
        let ir_probability=$('#ir_probability').val();
        if(ir_impact && ir_probability){
            $('#ir_assessment_text').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="25px" height="25px">');
            $.post('<?php echo base_url()?>risk_data/assessment',{impact:ir_impact,probability:ir_probability},function(e){
                let je=JSON.parse(e);
                $('#ir_assessment').val(je.val);
                $('#ir_x').show();
                $('#ir_x').val(ir_impact*ir_probability);
                $('#ir_assessment_text').html(je.text);
                rr_assess();
            
            
            });
        }
    }    
    function ic_assess(){
        $('#ic_assessment').val('');
        $('#ic_x').val('');
        $('#ic_assessment_text').empty();
        let ic_impact=$('#ic_impact').val();   
        let ic_probability=$('#ic_probability').val();
        if(ic_impact && ic_probability){
            $('#ic_assessment_text').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="25px" height="25px">');
            $.post('<?php echo base_url()?>risk_data/assessment',{impact:ic_impact,probability:ic_probability},function(e){
                let je=JSON.parse(e);
                $('#ic_assessment').val(je.val);
                $('#ic_x').show();
                $('#ic_x').val(ic_impact*ic_probability);
                $('#ic_assessment_text').html(je.text);
                rr_assess();
            });
        }
    }    
    function rr_assess(){
        $('#rr_assessment').val('');
        $('#rr_x').val('');
        $('#rr_assessment_text').empty();
        
        let ir_impact=$('#ir_impact').val();   
        let ir_probability=$('#ir_probability').val();
        let ic_impact=$('#ic_impact').val();   
        let ic_probability=$('#ic_probability').val();
        
        if(ir_impact && ic_impact){
            $('#rr_impact').val(ir_impact-ic_impact);
        }
        if(ic_impact && ic_probability){
            $('#rr_probability').val(ir_probability-ic_probability);
        }
        let rr_impact=$('#rr_impact').val();   
        let rr_probability=$('#rr_probability').val();
        if(rr_impact && rr_probability){
            $('#rr_assessment_text').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="25px" height="25px">');
            $.post('<?php echo base_url()?>risk_data/assessment',{impact:rr_impact,probability:rr_probability},function(e){
                let je=JSON.parse(e);
                $('#rr_assessment').val(je.val);
                $('#rr_x').show();
                $('#rr_x').val(rr_impact*rr_probability);
                $('#rr_assessment_text').html(je.text);
            });
        }
    }   
    function skmr_assess(){
        $('#skmr_assessment').val('');
        $('#skmr_x').val('');
        $('#skmr_assessment_text').empty();
        let skmr_impact=$('#skmr_impact').val();   
        let skmr_probability=$('#skmr_probability').val();
        if(skmr_impact && skmr_probability){
            $('#skmr_assessment_text').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="25px" height="25px">');
            $.post('<?php echo base_url()?>risk_data/assessment',{impact:skmr_impact,probability:skmr_probability},function(e){
                let je=JSON.parse(e);
                $('#skmr_assessment').val(je.val);
                $('#skmr_x').val(skmr_impact*skmr_probability);
                $('#skmr_x').show();
                $('#skmr_assessment_text').html(je.text);
            });
        }
    }   
    $("#r_tolerance").bind('keyup mouseup', function () {
        estimasi();            
    });
    $("#realisasi").bind('keyup mouseup', function () {
        estimasi();            
    });
    function estimasi(){
        let r_tolerance=$('#r_tolerance').val();   
        let realisasi=$('#realisasi').val();
        if(r_tolerance && realisasi){
            let hasil=Math.round((r_tolerance-realisasi)/r_tolerance*100)+"%";
            $('#estimasi').val(hasil);
        }
    
    }
    function gantiowner(){
        
        let risk_owner=$('#risk_owner').val();
        
        if(risk_owner){
            
        $('#divisi_text').html('<img src="<?php echo base_url()?>assets/img/spinner.gif" width="25px" height="25px">');
        $.post('<?php echo base_url()?>risk_data/gantidivisi',{ro:risk_owner},function(e){
                let je=JSON.parse(e);
                $('#divisi').val(je.val);
                $('#divisi_text').html(je.text);
            });
        }
    }
</script>