<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  function generateReport($sql)
  {
      
      global $mainframe;
      
      ## Make DB connections
      $db    = JFactory::getDBO();
      
      // sql = 'Your Query Goes Here..';
      
      $db->setQuery($sql);
      $rows = $db->loadAssocList();
      
      ## If the query doesn't work ...
      if (!$db->query())
      {
         echo "<script>alert('Please report your problem.');
         window.history.go(-1);</script>\n";      
      }   
      
      ## Empty data vars
      $data = "" ;
      ## We need tabbed data
      $sep = "\t";
      
      $fields = (array_keys($rows[0]));
      
      ## Count all fields(will be the collumns
      $columns = count($fields);
      ## Put the name of all fields to $out. 
      for ($i = 0; $i < $columns; $i++) 
      {
        $data .= $fields[$i].$sep;
      }
      
      $data .= "\n";
      
      ## Counting rows and push them into a for loop
      for($k=0; $k < count( $rows ); $k++) 
      {
         $row = $rows[$k];
         $line = '';
         
         ## Now replace several things for MS Excel
         foreach ($row as $value) {
           $value = str_replace('"', '""', $value);
           $line .= '"' . $value . '"' . "\t";
         }
         $data .= trim($line)."\n";
      }
      
      $data = str_replace("\r","",$data);
      
      ## If count rows is nothing show o records.
      if (count( $rows ) == 0) 
      {
        $data .= "\n(0) Records Found!\n";
      }
      
      ## Push the report now!
      $this->name = 'export-invoices';
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=".$this->name.".xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      header("Lacation: excel.htm?id=yes");
      print $data ;
      die();   
   }

?>