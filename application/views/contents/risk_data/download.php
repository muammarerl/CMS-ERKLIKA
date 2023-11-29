<table cellspacing="0" cellpadding="0" >
  <col width="201">
  <col width="111">
  <col width="124">
  <col width="156">
  <col width="96">
  <col width="143">
  <col width="176">
  <col width="264">
  <col width="97">
  <col width="132">
  <col width="124">
  <col width="96">
  <col width="132">
  <col width="101">
  <col width="139">
  <col width="128">
  <col width="97">
  <col width="115">
  <col width="85">
  <col width="69">
  <col width="73">
  <col width="49">
  <col width="103">
  <col width="139">
  <col width="103">
  <col width="69">
  <col width="88">
  <col width="79">
  <col width="68">
  <col width="100">
  <col width="67">
  <col width="105">
  <col width="131">
  <col width="117">
  <col width="115">
  <col width="108">
  <tr>
    <td width="201">TABEL   DATA RISIKO</td>
    <td width="111"></td>
    <td width="124"></td>
    <td width="156"></td>
    <td width="96"></td>
    <td width="143"></td>
    <td width="176"></td>
    <td width="264"></td>
    <td colspan="3" width="353">Inherit Risk</td>
    <td colspan="2" width="228">Impact Control</td>
    <td colspan="3" width="368">Residual Risk</td>
    <td width="97">&nbsp;</td>
    <td width="115"></td>
    <td width="85">&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="73"></td>
    <td width="49"></td>
    <td width="103"></td>
    <td width="139"></td>
    <td width="103"></td>
    <td width="69"><a name="RANGE!Z1:AA7"></a></td>
    <td width="88"></td>
    <td width="79"></td>
    <td width="68"></td>
    <td width="100"></td>
    <td width="67"></td>
    <td width="105"><a name="RANGE!AF1:AG7"></a></td>
    <td width="131"></td>
    <td width="117"></td>
    <td width="115"></td>
    <td width="108"></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Impact Control</td>
    <td>a</td>
    <td>b</td>
    <td>c=axb</td>
    <td>d</td>
    <td>e</td>
    <td>f=a-d</td>
    <td>g=b-e</td>
    <td>h=fxg</td>
    <td>&nbsp;</td>
    <td>i</td>
    <td>j</td>
    <td>k=(i-j)/i</td>
    <td></td>
    <td></td>
    <td>User Approval</td>
    <td>User</td>
    <td></td>
    <td>User</td>
    <td></td>
    <td>User</td>
    <td></td>
    <td>User Approval</td>
    <td></td>
    <td>l</td>
    <td>m</td>
    <td>lxm</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>JENIS RISIKO</td>
    <td>ID_REGISTER</td>
    <td>TGL_REGISTER</td>
    <td>RISK DESC</td>
    <td>OPENCLOSE</td>
    <td>SEBAB</td>
    <td>AKIBAT</td>
    <td>PENGENDALIAN &amp; PENCEGAHAN</td>
    <td>IR_DAMPAK</td>
    <td>IR_PROBABILITY</td>
    <td>IR_ASSESMENT</td>
    <td>IC_DAMPAK</td>
    <td>IC_PROBABILITY</td>
    <td>RR_DAMPAK</td>
    <td>RR_PROBABILITY</td>
    <td>RR_ASSESMENT</td>
    <td>R APPETITE</td>
    <td>R TOLERANCE</td>
    <td>REALISASI</td>
    <td>DEVIASI</td>
    <td>UKURAN</td>
    <td>DEPT</td>
    <td>RISK OWNER</td>
    <td>RISK IDENTIFIER</td>
    <td>CREATE_date</td>
    <td>Create_by</td>
    <td>Change_date</td>
    <td>Change_by</td>
    <td>app_Date</td>
    <td>App_by</td>
    <td>STATUS</td>
    <td>SKMR_DAMPAK</td>
    <td>SKMR_PROBABILITY</td>
    <td>SK_ASSESMENT</td>
    <td>skChange_Date</td>
    <td>SKChange_BY</td>
  </tr>
  <?php foreach($isi as $is){?>
  <tr>
    <td><?php echo $is->jenis_risk?></td>
    <td><?php echo $is->id_register?></td>
    <td><?php echo $is->tgl_register_?></td>
    <td><?php echo $is->risk_desc?></td>
    <td><?php echo $is->status_risk?></td>
    <td><?php echo $is->sebab?></td>
    <td><?php echo $is->akibat?></td>
    <td><?php echo $is->pengendalian_pencegahan?></td>
    <td><?php echo $is->ir_impact?></td>
    <td><?php echo $is->ir_probability?></td>
    <td><?php echo $is->ir_x?></td>
    <td><?php echo $is->ic_impact?></td>
    <td><?php echo $is->ic_probability?></td>
    <td><?php echo $is->rr_impact?></td>
    <td><?php echo $is->rr_probability?></td>
    <td><?php echo $is->rr_x?></td>
    <td><?php echo $is->r_appetite?></td>
    <td><?php echo $is->r_tolerance?></td>
    <td><?php echo $is->kejadian?></td>
    <td><?php echo $is->estimasi?></td>
    <td><?php echo $is->size_?></td>
    <td><?php echo $is->divisi_?></td>
    <td><?php echo $is->risk_owner_?></td>
    <td><?php echo $is->risk_identifier_?></td>
    <td><?php echo $is->created_on_?></td>
    <td><?php echo $is->pic_?></td>
    <td><?php echo $is->modify_on_?></td>
    <td><?php echo $is->modify_by_?></td>
    <td><?php echo $is->app_date_?></td>
    <td><?php echo $is->app_by_?></td>
    <td></td>
    <td><?php echo $is->skmr_impact?></td>
    <td><?php echo $is->skmr_probability?></td>
    <td><?php echo $is->skmr_x?></td>
    <td><?php echo $is->skmr_date_?></td>
    <td><?php echo $is->skmr_by_?></td>
  </tr>
  <?php }?>
</table>