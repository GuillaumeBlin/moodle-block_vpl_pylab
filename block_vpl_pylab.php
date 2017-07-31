<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


defined('MOODLE_INTERNAL') || die();
require_once(dirname(__FILE__) . '/../../config.php');
global $CFG, $DB;

/**
 * Block vpl_pylab class definition.
 *
 * This block can be added to a vpl page to support brython for feedback
 *
 * @package    block_vpl_pylab
 * @copyright  2016 Guillaume Blin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_vpl_pylab extends block_base {

  function init() {
    $this->title = get_string('pluginname', 'block_vpl_pylab');
  }

  function applicable_formats() {
    return array('all' => false,'mod-vpl' => true);
  }

  function instance_config_save($data, $nolongerused = false) {
    parent::instance_config_save($data);
  }


  function get_content() {
    global $CFG, $OUTPUT, $DB, $USER;
    $this->content = new stdClass();
    $this->content->items = array();
    $this->content->icons = array();
    $this->content->footer = '';
    $id=$this->page->course->id;
    $p=substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'],'mod/vpl')).'blocks/vpl_pylab';
    $this->content->text="";
    var script_sources = $this->config->config_script_src.split(",");
    for (var x = 0; x < script_sources.length; x++) {
  	    $this->content->text .="    <script type=\"text/javascript\" src=\"".script_sources[x]."\"></script>";
    }
    $this->content->text .= <<<EOT
<script type="text/javascript">
  function close_modal(){
    var node = document.getElementById('openModal');
    while (node.hasChildNodes()) {
      node.removeChild(node.firstChild);
    }
    node.style='';
  }
  function hide_output(){
    if(document.getElementById("modal_output").style.display=="none"){
        document.getElementById("modal_output").style.display="block";
    }else{
        document.getElementById("modal_output").style.display="none";
    }
  }
  function hide_error(){
    if(document.getElementById("modal_error").style.display=="none"){
        document.getElementById("modal_error").style.display="block";
    }else{
        document.getElementById("modal_error").style.display="none";
    }
  }
  function hide_fig(){
    if(document.getElementById("modal_content").style.display=="none"){
      document.getElementById("modal_content").style.display="block";
    }else{
      document.getElementById("modal_content").style.display="none";
    }
  }
</script>
<div id='openModal' class='modalDialogPylab'>
</div>
<script type="text/javascript">

  var target = document.getElementById('vpl_results');
  if(target){ 
	var observer = new MutationObserver(function(mutations) {
	var ct = document.getElementById('ui-accordion-vpl_results-panel-1').innerHTML;
ct=ct.replace(/<br\s*[\/]?>/gi, "\\n");
      	
	if(ct.indexOf('BINARY')>-1){
        	var truc = document.getElementById("openModal");
        	truc.style.opacity=1;
        	truc.style.pointerEvents="auto";
		var teacher="", output="", error="", display="";
		var lines = ct.split('\\n');
		var go_teacher=false, go_binary=false, go_output = false, go_error = false, go_display = false;
		for(var i = 0;i < lines.length;i++){
			var foo=lines[i];
			if(go_binary){
				try{
                                	foo=atob(foo);
				}catch(e){
				}
                        }
			if(foo.match(/BINARY/)){
				go_binary=true;
			}
			if(foo.match(/TEACHER-E/)){
                                go_teacher=false;
                        }
			if(foo.match(/OUTPUT-E/)){
                        	go_output=false;
                	}
			if(foo.match(/ERROR-E/)){
                        	go_error=false;
                	}
			if(foo.match(/DISPLAY-E/)){
                        	go_display=false;
                	}
			if(go_teacher){
                                teacher = teacher + foo;
                        }
			if(go_output){
				output = output + foo + '\\n';
			}
			if(go_error){
				error = error + foo + '\\n';
                	}
			if(go_display){
                        	display = display + foo;
                	}
			if(foo.match(/TEACHER-S/)){
                                go_teacher=true;
                        }
			if(foo.match(/OUTPUT-S/)){
                        	go_output=true;
                	}
			if(foo.match(/ERROR-S/)){
                        	go_error=true;
                	}
			if(foo.match(/DISPLAY-S/)){
                        	go_display=true;
                	}
		}
	        document.getElementById('openModal').innerHTML=teacher;	
		document.getElementById('modal_output').innerText=output;
		document.getElementById('modal_error').innerText=error;
		document.getElementById('modal_content').innerHTML=display;
		var arr = document.getElementById('openModal').getElementsByTagName('script');
                for (var n = 0; n < arr.length; n++){
                        eval(arr[n].innerHTML);
                }
	}
    });
    var config = { childList: true, characterData: true };
    observer.observe(target, config);
}
</script>
EOT;
    return $this->content;
    }


    function instance_allow_multiple() {
        return true;
    }
}

