<?php 
    $titoptions=array('Mr'=>'Mr','Ms'=>'Ms','Mrs'=>'Mrs','Miss'=>'Miss','Dr'=>'Dr');
    echo $this->Form->input('title',['options'=>$titoptions]);
?>               