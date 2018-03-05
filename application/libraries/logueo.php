<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class logueo {
        
    public function log() { 
        $this->load->library('session');
        if (!empty($this->session->logueado)) {
            return false;
        } else {
            return true;
        }
    }
}