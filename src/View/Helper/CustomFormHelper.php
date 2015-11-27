<?php
namespace App\View\Helper;

use Cake\View\Helper;

/**
 * CustomForm helper
 * Requires jQuery
 */
class CustomFormHelper extends Helper {
	
	public $helpers = ['Form'];

	/*
	 * @params 
	 * 		string $name // name of input field matching database
	 * 		string $value // initial value of field containing the date
	 * 		string $label // label of field
	 * 
	 * @return text // returns html required for field
	 */
	public function date($name, $value = '', $label = '') {
		$value = ($value==''?date('d/m/Y'):date('d/m/Y',strtotime($value)));
		$date = explode('/',$value);
		$dateYear = $date[2];
		$dateMonth = $date[1];
		$dateDay = $date[0];
		$input = '';
		$input .= $this->Form->input($name.'_picker', [ 'label' => $label, 'type'=> 'text', 'id'=> 'datepicker', 'value'=> $value, 'onchange'=> 'updateDate(this.value)' ]);
		$input .= $this->Form->input($name.'[year]', [ 'type'=> 'hidden', 'id'=> 'dateYear', 'value'=> $dateYear ]);
		$input .= $this->Form->input($name.'[month]', [ 'type'=> 'hidden', 'id'=> 'dateMonth', 'value'=> $dateMonth ]);
		$input .= $this->Form->input($name.'[day]', [ 'type'=> 'hidden', 'id'=> 'dateDay', 'value'=> $dateDay ]);
		$input .= '
		<script>
		function updateDate(value) {
			var date_dat = value.split("/");
			$("#dateYear").val(date_dat[2]);
			$("#dateMonth").val(date_dat[1]);
			$("#dateDay").val(date_dat[0]);
		}
		</script>
		';
		
		return $input;
	}
	
	/*
	 * @params
	* 		string $name // name of input field matching database
	* 		string $value // initial value of field containing the date
	* 		string $label // label of field
	*
	* @return text // returns html required for field
	*/
	public function datetime($name, $value = '', $label = '') {
		$value = ($value==''?date('d/m/Y h:i'):date('d/m/Y h:i',strtotime($value)));
		$datetime = explode(' ',$value);
		$date = explode('/',$datetime[0]);
		$time = explode(':',$datetime[1]);
		$dateYear = $date[2];
		$dateMonth = $date[1];
		$dateDay = $date[0];
		$dateHour = $time[0];
		$dateMin = $time[1];
		$input = '';
		$input .= $this->Form->input($name.'_picker', [ 'label' => $label, 'type'=> 'text', 'id'=> 'datetimepicker', 'value'=> $value, 'onchange'=> 'updateDateTime(this.value)' ]);
		$input .= $this->Form->input($name.'[year]', [ 'type'=> 'hidden', 'id'=> 'dateYear', 'value'=> $dateYear ]);
		$input .= $this->Form->input($name.'[month]', [ 'type'=> 'hidden', 'id'=> 'dateMonth', 'value'=> $dateMonth ]);
		$input .= $this->Form->input($name.'[day]', [ 'type'=> 'hidden', 'id'=> 'dateDay', 'value'=> $dateDay ]);
		$input .= $this->Form->input($name.'[hour]', [ 'type'=> 'hidden', 'id'=> 'dateHour', 'value'=> $dateHour ]);
		$input .= $this->Form->input($name.'[minute]', [ 'type'=> 'hidden', 'id'=> 'dateMin', 'value'=> $dateMin ]);
		$input .= '
		<script>
		function updateDateTime(value) {
			var datetime_dat = value.split(" ");
			var date_dat = datetime_dat[0].split("/");
			var time_dat = datetime_dat[1].split(":");
			$("#dateYear").val(date_dat[2]);
			$("#dateMonth").val(date_dat[1]);
			$("#dateDay").val(date_dat[0]);
			$("#dateHour").val(time_dat[0]);
			$("#dateMin").val(time_dat[1]);
		}
		</script>
		';
	
		return $input;
	}
	
	/*
	 * @params
	* 		string $name // name of input field matching database
	* 		string $value // initial value of field containing the date
	* 		string $label // label of field
	*
	* @return text // returns html required for field
	*/
	public function time($name, $value = '', $label = '') {
		$value = ($value==''?date('h:i'):date('h:i',strtotime($value)));
		$time = explode(':',$value);
		$dateHour = $time[0];
		$dateMin = $time[1];
		$input = '';
		$input .= $this->Form->input($name.'_picker', [ 'label' => $label, 'type'=> 'text', 'id'=> 'timepicker', 'value'=> $value, 'onchange'=> 'updateTime(this.value)' ]);
		$input .= $this->Form->input($name.'[hour]', [ 'type'=> 'hidden', 'id'=> 'dateHour', 'value'=> $dateHour ]);
		$input .= $this->Form->input($name.'[minute]', [ 'type'=> 'hidden', 'id'=> 'dateMin', 'value'=> $dateMin ]);
		$input .= '
		<script>
		function updateTime(value) {
			var time_dat = value.split(":");
			$("#dateHour").val(time_dat[0]);
			$("#dateMin").val(time_dat[1]);
		}
		</script>
		';
	
		return $input;
	}


       public function fileUploadLimit() {
           $max_file_size = ini_get('upload_max_filesize');
           if(preg_match('|([0-9]+)([a-z]+?)|i',$max_file_size,$match))
           {
              $qty = $match[1];
              if($unit = $match[2])
                return $qty . ' ' . strtoupper($unit).'B';

              if($qty = round($qty / 1073741824)>=1)
              	return $qty . ' GB';
              elseif($qty = round($qty / 1048576)>=1)
              	return $qty . ' MB';
              elseif($qty = round($qty / 1024)>=1)
              	return $qty . ' KB';
              else
              	return $qty . ' Bytes';

           }
           return $max_file_size . 'Bytes';
       }
	
}
