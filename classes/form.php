<?php
/*
form.php
A simple form library for building a form.

Created: 10/31/2018
Author: Larry Elliott

Helpful Links:
    https://www.w3schools.com/bootstrap/bootstrap_forms.asp specifically Horizontal Forms
    https://www.w3schools.com/bootstrap/bootstrap_forms_inputs.asp
    https://getbootstrap.com/docs/3.3/components/
*/

class Form {
	private $id;
	private $content;
	
	function __construct ($id = "myform") {
		$this->id = $id;
		$this->content = "";
	}
	
	
	
	function addTextInput ($id, $required = true, $label = false) {
		if ($label == false)
			$label = $this->idToLabel($id);
		$value = "";
		if (isset($_POST[$id]))
			$value = 'value="'.htmlentities($_POST[$id]).'"';
		$this->content .= '
		<div class="form-group">
			<label class="control-label col-sm-2" for="'.$id.'">'.$label.':</label>
			<div class="col-sm-10"> 
				<input type="text" class="form-control" id="'.$id.'"  name="'.$id.'" '.$value.($required ? ' required' : '').'>
			</div>
		</div>
		';
	}
	
	function addPassword ($id, $required = true, $label = false) {
		if ($label == false)
			$label = $this->idToLabel($id);
		$value = "";
		if (isset($_POST[$id]))
			;//$value = 'value="'.htmlentities($_POST[$id]).'"';
		$this->content .= '
		<div class="form-group">
			<label class="control-label col-sm-2" for="'.$id.'">'.$label.':</label>
			<div class="col-sm-10"> 
				<input type="password" class="form-control" id="'.$id.'"  name="'.$id.'" '.$value.($required ? ' required' : '').'>
			</div>
		</div>
		';
	}
	
	function addHiddenField ($id) {
		$value = "";
		if (isset($_POST[$id]))
			$value = 'value="'.htmlentities($_POST[$id]).'"';
		$this->content .= '
			<input type="hidden" id="'.$id.'"  name="'.$id.'" '.$value.'>
		';
	}
	
	function addDisabledField ($id, $label = false) {
		if ($label == false)
			$label = $this->idToLabel($id);
		$value = "";
		if (isset($_POST[$id]))
			$value = $_POST[$id];
		$this->content .= '
		<div class="form-group">
			<label class="control-label col-sm-2" for="'.$id.'">'.$label.':</label>
			<div class="form-control-static col-sm-10"> 
				'.$value.'
				<input type="hidden" id="'.$id.'"  name="'.$id.'" value="'.htmlentities($value).'">
			</div>
		</div>
		';
	}
	
	
	function addFileInput ($id, $required = true, $label = false) {
		if ($label == false)
			$label = $this->idToLabel($id);
		$value = "";
		if (isset($_POST[$id]))
			$value = 'value="'.htmlentities($_POST[$id]).'"';
		$this->content .= '
		<div class="form-group">
			<label class="control-label col-sm-2" for="'.$id.'">'.$label.':</label>
			<div class="col-sm-10"> 
				<div id="'.$id.'-file-message"></div>
				<input type="file" class="form-control file-input" id="'.$id.'-file" '.($required ? ' required' : '').'>
				<div style="display:none">
					<input type="text" class="form-control" id="'.$id.'"  name="'.$id.'">
					<textarea class="form-control" id="'.$id.'Base64"  name="'.$id.'Base64"></textarea>
				</div>
			</div>
		</div>
		';
	}
	
	function addSelect ($id, $options, $required = true, $field_label = false) {
		if ($field_label == false)
			$field_label = $this->idToLabel($id);
		$options_html = "";
		$is_assoc = $this->is_assoc($options);
		
		foreach ($options as $key => $label) {
			$attributes = "";
			if ($is_assoc) {
				$attributes .= ' value="'.htmlentities($key).'"';
				if (isset($_POST[$id]) && $_POST[$id] == $key)
					$attributes .= ' selected="selected"';
			} else if (isset($_POST[$id]) && $_POST[$id] == $label) {
				$attributes .= ' selected="selected"';
			}
			$options_html .= "\t\t\t\t<option".$attributes.">".$label."</option>\n";
		}
		
		$this->content .= '
		<div class="form-group">
			<label class="control-label col-sm-2" for="'.$id.'">'.$field_label.':</label>
			<div class="col-sm-10">
				<select class="form-control" id="'.$id.'"  name="'.$id.'">
				'.$options_html.'</select>
			</div>
		</div>
		';
	}
	
	function is_assoc($arr) {
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	function addSubmit ($name = "Submit") {
		$this->content .= '
		<div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">'.$name.'</button>
			</div>
		</div>
		';
	}
	
	// Converts an ID to a human readable label
	function idToLabel ($id) {
		return ucwords(preg_replace('/(?<!^)(?<![A-Z0-9])([A-Z0-9])/', ' \\1', str_replace("_"," ",$id)));
	}
	
	
	
	function addField () {}
	
	function addContent ($new_content) {
		$this->content .= $new_content;
	}
	
	function getForm () {
		$output  = '<form class="form-horizontal" method="post" action="?">'."\n";
		$output .= $this->content;
		$output .= '</form>'."\n";
		return $output;
	}
}