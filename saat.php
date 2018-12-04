<?php
   date_default_timezone_set("Europe/Istanbul");
   echo "*** Testing date_format() : basic functionality - formatting coinstants ***\n";
   var_dump(date(DATE_RFC3339));
$date = new DateTime("2005-07-14 22:30:41");
var_dump( $date->format( DateTime::ATOM) ) ;
var_dump( $date->format( DateTime::COOKIE) ) ;
var_dump( $date->format( DateTime::ISO8601) ) ;
var_dump( $date->format( DateTime::RFC822) ) ;
var_dump( $date->format( DateTime::RFC850) ) ;
var_dump( $date->format( DateTime::RFC1036) ) ;
var_dump( $date->format( DateTime::RFC1123) ) ;
var_dump( $date->format( DateTime:: RFC2822) ) ;
var_dump( $date->format( DateTime::RFC3339) ) ;
var_dump( $date->format( DateTime::RSS) ) ;
var_dump( $date->format( DateTime::W3C) ) ;
?>
