<?php
    function display_format($number,$digit=8,$format=NULL){
        if($format ==""){
            $twocoin = sprintf('%.'.$digit.'f',$number);
        }elseif($format==0){
            $twocoin = number_format($number,$digit);
        }else{
            $twocoin = number_format($number,$digit,",",".");
        }
        return $twocoin;
    }   

    function ncAdd($value1,$value2,$digit=8){
        $value = bcadd(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
        //$value = display_format($value1 + $value2, $digit);
        return $value;
    }
    function ncSub($value1,$value2,$digit=8){
       $value = bcsub(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
        //$value = display_format($value1- $value2,$digit);
        return $value;
    }
    function ncMul($value1,$value2,$digit=8){
        $value = bcmul(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
        //$value = display_format($value1* $value2, $digit);
        return $value;
    }
    
    function ncDiv($value1,$value2,$digit=8){
        $value = bcdiv(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
         //$value = display_format($value1* $value2, $digit);
        return $value;
    }
    function imgvalidaion($img)
    {
        $myfile = fopen($img, "r") or die("Unable to open file!");
        $value = fread($myfile,filesize($img));
        if (strpos($value, "<?php") !== false) {
            $img = 0;
        } 
        elseif (strpos($value, "<?=") !== false){
            $img = 0;
        }
        elseif (strpos($value, "eval") !== false) {
            $img = 0;
        }
        elseif (strpos($value,"<script") !== false) {
            $img = 0;
        }else{
            $img=1;
        }
        fclose($myfile);
        return $img;
    }
    function TransactionString($length = 60) {
        $str = substr(hash('sha256', mt_rand() . microtime()), 0, $length);
        return $str;
    }
    function seoUrl($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
    
    function crul($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Accept: application/json, text/plain";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (curl_errno($ch)) {
            echo $result = 'Error:' . curl_error($ch);
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return $result;
    }
    function humanTiming ($time)
    {
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'min',
            1 => 'sec'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }
    function getCoinimg($coin){
        $image = \App\Models\Commission::where('source',$coin)->value('image');
        if(!$image){
            $image ="eth.svg";
        }
        return $image;
    }
    
?>