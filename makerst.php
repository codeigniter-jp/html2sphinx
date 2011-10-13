<?php
mb_internal_encoding("UTF-8");

class Makerst {
    var $_textdata;
    var $_padded_textdata;
    var $_maxlengthdata;
    
    function __construct($textdata, $maxlengthdata) {
        if (is_array($textdata)) {
            $this->_textdata = $textdata;
        }
        if (is_array($maxlengthdata)) {
            $this->_maxlengthdata = $maxlengthdata;
        }
    }
    
    function _mb_str_pad($input, $length, $filltext=" ") {
        if (1 != strlen($filltext)) {
            $filltext = " ";
        }

        $filllen = $length - mb_strwidth($input);
        if ($filllen > 0) {
            for($j=0;$j<$filllen;$j++) {
                $input .= " ";
            }
        }
        return $input;
    }
    
    function lineout($separator=" ", $line="-") {
        //$lineout = $separator;
        $lineout = '';
        foreach($this->_maxlengthdata as $val) {
            for($i=0;$i<$val;$i++) {
                $lineout .= $line;
            }
            $lineout .= $separator;
        }
        $lineout .= "\n";
        return $lineout;
    }
    
    function _out($array, $separator=" ") {
        if (is_array($array)) {
            $len = count($this->_maxlengthdata);
            //$outdata = $separator;
            $outdata = '';
            for($i=0; $i<$len; $i++) {
                $outdata .= $this->_mb_str_pad($array[$i],$this->_maxlengthdata[$i]);
                $outdata .= $separator;
            }
            return $outdata;
        } else {
            return false;
        }
    }
    
    function outall($separator=" ") {
        foreach ($this->_textdata as $arr){
            $this->_padded_textdata .= $this->_out($arr,$separator);
            $this->_padded_textdata .= "\n";
        }
        return $this->_padded_textdata;
    }
}
