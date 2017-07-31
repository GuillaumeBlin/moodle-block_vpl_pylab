<?php
class block_vpl_pylab_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        $mform->addElement('text', 'config_script_src', 'List of javascript src delimited by commas');
        $mform->setDefault('config_script_src', '');
        $mform->setType('config_editkeysc', PARAM_RAW);
    }
}
