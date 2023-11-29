<style>
/*    table th,td{
        padding:10px;
    }
    */
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600);
table {
  background: #012B39;
  border-radius: 0.25em;
  border-collapse: collapse;
  margin: 1em;
}
th {
  border-bottom: 1px solid #364043;
  color: #E2B842;
  font-size: 0.85em;
  font-weight: 600;
  padding: 0.5em 1em;
  text-align: left;
}
td {
  color: #fff;
  font-weight: 400;
  padding: 0.65em 1em;
}
.disabled td {
  color: #4F5F64;
}
tbody tr {
  transition: background 0.25s ease;
}
tbody tr:hover {
  background: #014055;
}


</style>
<div class="container">
<?php if(count($query)>0){?>
<table width="100%" >
    <thead>
    <tr>
        <th>No</th>
        <th>Status</th>
        <th>ID Reg</th>
        <th>Tgl Reg</th>
        <th>Risk Desc</th>
        <th>Risk Owner</th>
        <th>Risk Identifier</th>
        <th>PIC User</th>
        <th>Department</th>
        <th>Create Date</th>
        <th>Approved By</th>
        <th>Approved Date</th>
    </tr>
    </thead>
    <tbody>
    <?php $a=1; foreach($query as $q){?>
    <tr>
        <td><?php echo $a?></td>
        <td><?php echo $q['status_risk']?></td>
        <td><?php echo $q['id_register']?></td>
        <td><?php echo $q['tgl_register_']?></td>
        <td><?php echo $q['risk_desc']?></td>
        <td><?php echo $q['risk_owner_']?></td>
        <td><?php echo $q['risk_identifier_']?></td>
        <td><?php echo $q['pic_']?></td>
        <td><?php echo $q['divisi_']?></td>
        <td><?php echo $q['created_on_']?></td>
        <td><?php echo $q['app_by_']?></td>
        <td><?php echo $q['app_date_']?></td>
    </tr>
    <?php $a++; }?>
    </tbody>
</table>
<?php }else{
    echo "No Data";
}
?>
</div>