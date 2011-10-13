<?php
mb_internal_encoding("UTF-8");

class Max_length {
    var $_textdata;
    var $_lengthdata;
    var $_inversedata;
    var $_maxlengthdata;
    function __construct($array=array()) {
        $this->_textdata = $this->_data_input($array);
        $this->_lengthdata = $this->_get_lengths($this->_textdata);
        $this->_inversedata = $this->_get_array_inverse($this->_lengthdata);
        $this->_maxlengthdata = $this->_get_array_max_length($this->_inversedata);
    }
    function _data_input($array=array()) {
        if (is_array($array)) {
            return $array;
        } else {
            return false;
        }
    }
    function _get_lengths($array) {
        if (is_array($array)) {
            $out = array();
            foreach ($array as $arr){
                if (is_array($arr)){
                    $out[] = array_map('mb_strwidth',$arr);
                } else {
                    $out[] = mb_strwidth($arr);
                }
            }
        } else {
            $out = mb_strwidth($array);
        }
        return $out;
    }
    function _get_array_inverse($array) {
        $inverse_array = array();
        $len = count($array[0]);
        for ($i=0;$i<$len;$i++){
            foreach ($array as $arr){
                $inverse_array[$i][] = $arr[$i];
            }
        }
        return $inverse_array;
    }

    function _get_array_max_length($array) {
        $max_array = array();
        foreach ($array as $arr){
            $max_array[] = max($arr);
        }
        return $max_array;
    }
    function get_max_length_data() {
        return $this->_maxlengthdata;
    }
}
