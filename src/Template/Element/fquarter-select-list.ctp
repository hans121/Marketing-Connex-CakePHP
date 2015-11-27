<?php 
$month_list =   ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December',];
if(isset($vendor->financial_quarter_start_month)){
    $fqtrid =   $vendor->financial_quarter_start_month;
}else{
    $fqtrid = '04';
}
echo $this->Form->input('financial_quarter_start_month', ['options' => $month_list,'value'=>$fqtrid,'data-live-search' => true, 'label' => 'Financial Year Start Month']);?>
