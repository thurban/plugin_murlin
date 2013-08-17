<?php

/*
 +-------------------------------------------------------------------------+
 | Copyright (C) 2004-2009 The Cacti Group                                 |
 |                                                                         |
 | This program is free software; you can redistribute it and/or           |
 | modify it under the terms of the GNU General Public License             |
 | as published by the Free Software Foundation; either version 2          |
 | of the License, or (at your option) any later version.                  |
 |                                                                         |
 | This program is distributed in the hope that it will be useful,         |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
 | GNU General Public License for more details.                            |
 +-------------------------------------------------------------------------+
 | Cacti: The Complete RRDTool-based Graphing Solution                     |
 +-------------------------------------------------------------------------+
 | This code is designed, written, and maintained by the Cacti Group. See  |
 | about.php and/or the AUTHORS file for specific developer information.   |
 +-------------------------------------------------------------------------+
 | http://www.cacti.net/                                                   |
 +-------------------------------------------------------------------------+
*/
/*******************************************************************************

    Author ......... James Payne
    Contact ........ jamoflaw@gmail.com
    Home Site ...... http://withjames.co.uk
    Program ........ Cacti Availability Plugin
    Purpose ........ Creates Availability Statistics - Includes reporting structure
           
*******************************************************************************/

/* do NOT run this script through a web browser */
if (!isset($_SERVER["argv"][0]) || isset($_SERVER['REQUEST_METHOD'])  || isset($_SERVER['REMOTE_ADDR'])) {
   die("<br><strong>This script is only meant to run at the command line.</strong>");
}



# deactivate http headers
$no_http_headers = true;
# include some cacti files for ease of use
include_once(dirname(__FILE__) . "/../../../include/global.php");
include_once(dirname(__FILE__) . "/functions.php");

$hostname = $_SERVER["argv"][1];		# hostname/IP@
$cmd = $_SERVER["argv"][2];              	# one of: index/query/get


if (isset($_SERVER["argv"][3])) {$value = $_SERVER["argv"][3]; }
if (isset($_SERVER["argv"][4])){ $id = $_SERVER["argv"][4]; }

switch ($cmd)
{
    case "index":
        
        $indexes = reindex($hostname);
    
        if (is_array($indexes))
        {
            foreach($indexes as $i)
            {
                print $i . "\n";
            }
        }
        
        break;
        
    case "query":
        
        $indexes = array();
        
        if($value == "sites")
            $indexes = get_sites($hostname);
        
        if($value == "text")
            $indexes = get_text($hostname);
        
        if($value == "values")
            $indexes = get_values($hostname);
        
        if($value == "http_code")
            $indexes = get_http_codes($hostname);
            
        if (is_array($indexes))
        {
            foreach($indexes as $i)
            {
                print $i . "\n";
            }
        }
        
        break;
        
        case "get":
        
        $indexes = array();
        
        if($value == "values")
            $indexes = get_value($id);
        
        if($value == "http_code")
            $indexes = get_http_code($id);
        
        print $indexes;
               
        break;
    
    default:
        print "Invalid use of script query.\n\n";
        break;
        
}

?>