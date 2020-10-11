<?php

class DateHelper extends Helper {

    function _getDiff($from = array() , $to = array() ) {
        $dateDiff =     mktime( $to['hour']    , $to['minutes']   , $to['seconds'] ,
                        $to['month']   , $to['day']       , $to['year'] )
                        -
                        mktime( $from['hour']  , $from['minutes'] , $from['seconds'] ,
                        $from['month'] , $from['day']     , $from['year'] );
        return abs($dateDiff);
    }
    
    function _isValidDate( $sDate = "01/01/1980 00:00:00" ) {
        $dateString = split( " "    , $sDate      );
        $dateParts  = split( "[/-]" , $dateString[0] );
        $dateParts2 = isset($dateString[1]) ? split( "[:]"  , $dateString[1] ) : array('00','00','00');
        if( !checkdate($dateParts[1], $dateParts[2], $dateParts[0]) )
        {  return false; }
        return array
               (
                 'month'   => $dateParts[1] ,
                 'day'     => $dateParts[2] ,
                 'year'    => $dateParts[0] ,
                 'hour'    => $dateParts2[0] ,
                 'minutes' => $dateParts2[1] ,
                 'seconds' => $dateParts2[2]
               );
    }
    
    function getDiff($dateFrom, $dateTo) {
        $from   = $this->_isValidDate($dateFrom);
        $to     = $this->_isValidDate($dateTo);
        $yearinseconds  = (60*60*24*365.242199);
        $monthinseconds = (60*60*24*30.4);
        $dayinseconds   = (60*60*24);
        $hourinseconds  = (60*60);
        $minuteinseconds = 60;
        if($from && $to) {
            $dateDiff = $this->_getDiff($from, $to);
            $r = $dateDiff;
            $dd['years'] =     floor ( $dateDiff / $yearinseconds );
            $r -= $dd['years']*$yearinseconds;
            $remainder['years'] = $r/$yearinseconds;
            $dd['months'] =    floor ($r / $monthinseconds);
            $r -= $dd['months']*$monthinseconds;
            $remainder['months'] = $r/$monthinseconds;
            $dd['days']  =     floor ($r / $dayinseconds );
            $r -= $dd['days']*$dayinseconds;
            $remainder['days'] = $r/$dayinseconds;
            $dd['hours'] =     floor ($r  / $hourinseconds);
            $r -= $dd['hours']*$hourinseconds;
            $remainder['hours'] = $r/$hourinseconds;
            $dd['minutes'] =   floor ($r / $minuteinseconds);
            $r -= $dd['minutes']*$minuteinseconds;
            $remainder['minutes'] = $r/$minuteinseconds;
            $dd['seconds'] =   $r; // $dateDiff;
            $remainder['seconds'] = 0;
            
            foreach ($dd as $period => $amt) {
                if ($remainder[$period] >= .94) {
                    return  (__('almost',true)." ".($amt+1). " ".__n(rtrim($period,"s" ), $period, $amt+1, true));
                }
                else if($dd[$period] > 0 && $remainder[$period] > 0 && $remainder[$period]  <= .3) {
                    return (__('over',true)." ".($amt). " ".__n(rtrim($period, "s"), $period, $amt, true));   
                } else {
                    // continue;
                }
            }
            return $return;
        }
        return false;
    }
    
    function myTime($start_time, $end_time)
    {
        list($hours, $minutes,$seconds) = split(':', $start_time);
    $startTimestamp = mktime($hours, $minutes,$seconds);
    
    list($hours, $minutes,$seconds) = split(':', $end_time);
    $endTimestamp = mktime($hours, $minutes,$seconds);
    
    $seconds = $endTimestamp - $startTimestamp;
    
    $minutes = ($seconds / 60) % 60;
    $hours = round($seconds / (60 * 60));
    
    return  $hours.':'.$minutes.':'.date("s",$seconds); 
        
    }
}
?>