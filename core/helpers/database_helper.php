<?php

/*
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */


function importMySQLdb($con, $filePath, $gzip=false){
    
    $templine = ''; $lines = array();
    
    if($gzip){
        $dbData = gzdecode(file_get_contents($filePath));
        $lines = explode("\n", $dbData);
    }else{
        $lines = file($filePath);
    }
    
    foreach ($lines as $line){
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;
            
        $templine .= $line;
        
        if (substr(trim($line), -1, 1) == ';'){
            mysqli_query($con, $templine) or print('Error performing query' . mysqli_error($con) . '<br />');
            $templine = '';
        }
    
    }
}

function installMySQLdb($con, $filePath, $gzip=false){
    
    $templine = ''; $lines = array();
    $completed = true;
    if($gzip){
        $dbData = gzdecode(file_get_contents($filePath));
        $lines = explode("\n", $dbData);
    }else{
        $lines = file($filePath);
    }
    
    foreach ($lines as $line){
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;
            
        $templine .= $line;
        
        if (substr(trim($line), -1, 1) == ';'){
            mysqli_query($con, $templine);
            if (mysqli_errno($con)){
                echo 'Error performing query' . mysqli_error($con) . '<br />';
                $completed = false;
            }else{
                if(strtolower(substr(trim($templine),0,6)) == 'create'){
                   $d = explode('`',trim($templine));
                   echo '"'.$d[1].'" table created successfully <br>'; 
                }
            }
            $templine = '';
        }
    
    }
    return $completed;
}

function writeBackupFile($fp, $content, $backupFileName){
    if (fwrite($fp, $content) === FALSE) {
        echo "Cannot write to file ($backupFileName)";
        die();
    }
}

function gzCompressFile($source, $level = 9){ 
    $dest = $source . '.gz'; 
    $mode = 'wb' . $level; 
    $error = false; 
    if ($fp_out = gzopen($dest, $mode)) { 
        if ($fp_in = fopen($source,'rb')) { 
            while (!feof($fp_in)) 
                gzwrite($fp_out, fread($fp_in, 1024 * 512)); 
            fclose($fp_in); 
        } else {
            $error = true; 
        }
        gzclose($fp_out); 
    } else {
        $error = true; 
    }
    if ($error)
        return false; 
    else
        return true; 
} 

function backupMySQLdb($con, $dbName, $backupPath, $gzip=false){

    $date = date( "d-m-Y-h-i-s");
    $dbTables = array();
    $defaultRowLimit = 100;
    $defaultRowSizeLimit = 9999;
    $backupOkay = false;

    if (!is_dir($backupPath))
        mkdir($backupPath, 0777, true);

    $backupFileName = $backupPath.$dbName.'-'.$date.'.sql';
    
    $fp = fopen($backupFileName ,'w+');
        
$contents = 
"-- ---------------------------------------------------------
--
-- Rainbow PHP Framework - Database Backup Tool
-- 
--
-- Host Connection Info: ".mysqli_get_host_info($con)."
-- Generation Time: ".date('F d, Y \a\t H:i A')."
-- Server version: ".mysqli_get_server_info($con)."
-- PHP Version: ".PHP_VERSION."
--
-- ---------------------------------------------------------\n

SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";

--
-- Database: `".$dbName."` --
--
\n";
    writeBackupFile($fp, $contents, $backupFileName);
   
    $results = mysqli_query($con, 'SHOW TABLES');
   
    while($row = mysqli_fetch_array($results)) {
        $dbTables[] = $row[0];
    }

    foreach($dbTables as $table){
        $contents = "-- Table `".$table."` --\n";
        writeBackupFile($fp, $contents, $backupFileName);
        
        $results = mysqli_query($con, 'SHOW CREATE TABLE '.$table);
        while($row = mysqli_fetch_array($results)) {
            $contents = $row[1].";\n\n";
            writeBackupFile($fp, $contents, $backupFileName);
        }
        
        $results = mysqli_query($con, 'SELECT * FROM '.$table. ' LIMIT 1');
        $fields =  mysqli_fetch_fields($results);
        $fields_count = count($fields);
        
        $handleRow = 0;
        
        do {    
            $results = mysqli_query($con, 'SELECT * FROM '.$table.' LIMIT '.$handleRow.', '.$defaultRowLimit);
            $handleRow += $defaultRowLimit;
            $row_count = mysqli_num_rows($results);
                           
            $insert_head = "INSERT INTO `".$table."` (";
            for($i=0; $i < $fields_count; $i++){
                $insert_head  .= "`".$fields[$i]->name."`";
                    if($i < $fields_count-1){
                            $insert_head  .= ', ';
                        }
            }
            $insert_head .=  ")";
            $insert_head .= " VALUES\n";       
                   
            if($row_count>0){
                $r = $limit = $rowSize = $divisionAsif = 0;
                while($row = mysqli_fetch_array($results)){
                    if($rowSize > $defaultRowSizeLimit){
                        $limit = 0;
                        $divisionAsif = 0;
                    }else{
                        $limit = $defaultRowLimit;
                        $divisionAsif = $r % $limit;
                    }
                    $rowSize = 0;
                    if($divisionAsif == 0){
                        $contents = $insert_head;
                        writeBackupFile($fp, $contents, $backupFileName);
                    }
                    $contents = "(";
                    writeBackupFile($fp, $contents, $backupFileName);
                    
                    for($i=0; $i < $fields_count; $i++){
                        $row_content =  str_replace("\n","\\n",mysqli_real_escape_string($con,$row[$i])); 
                        $rowSize = $rowSize + strlen($row_content);
                        switch($fields[$i]->type){
                            case 8: case 3:
                                writeBackupFile($fp, $row_content, $backupFileName);
                                break;
                            default:
                                writeBackupFile($fp, "'". $row_content ."'", $backupFileName);
                        }
                        if($i < $fields_count-1){
                                $contents  = ', ';
                                writeBackupFile($fp, $contents, $backupFileName);
                            }
                    }
                    if($rowSize > $defaultRowSizeLimit){
                        $contents = ");\n\n";
                        writeBackupFile($fp, $contents, $backupFileName);
                    }else{
                        if(($r+1) == $row_count || ($divisionAsif) == $limit-1){
                            $contents = ");\n\n";
                            writeBackupFile($fp, $contents, $backupFileName);
                        }else{
                            $contents = "),\n";
                            writeBackupFile($fp, $contents, $backupFileName);
                        }
                    }
                    $r++;
                }
            }
        
        } while($row_count !== 0);
    }
    fclose($fp);
    $backupOkay = true;
    
    if($gzip){
        ini_set('zlib.output_compression','Off');
        $backupOkay = gzCompressFile($backupFileName, 9);
        delFile($backupFileName);
        $backupFileName = $backupPath.$dbName.'-'.date( "d-m-Y-h-i-s").'.sql.gz';
    }
    
    if($backupOkay)
        return $backupFileName;
    else
        return '';
}

function dbCountRows($con, $tableName){
    $result = mysqli_query($con, 'SELECT COUNT(*) FROM '.$tableName);
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function insertToDb($con,$tableName,$arr){
    $part1 = $part2 = '';
    $part1 .= 'INSERT INTO '.$tableName.' (';
    $part2 .= ' VALUES (';
    $queryCount = count($arr); $i = 0;
    foreach($arr as $key=>$val){
        if(++$i === $queryCount) {
            $part1 .= $key.')';
            $part2 .= "'".$val."')";
        }else{
            $part1 .= $key.',';
            $part2 .= "'".$val."',";
        }
    }
    $buildQuery = $part1.$part2;
    mysqli_query($con,$buildQuery); 
        
    return mysqli_error($con);
}

function insertToDbPrepared($con,$tableName,$arr){
    $params = array();
    $error = $typeDef = $part1 = $part2 = '';
    $part1 .= 'INSERT INTO '.$tableName.' (';
    $part2 .= ' VALUES (';
    $queryCount = count($arr); $i = 0;
    foreach($arr as $key=>$val){
        $params[$i] = &$arr[$key];
        $typeDef .= 's';
        if(++$i === $queryCount) {
            $part1 .= $key.')';
            $part2 .= "?)";
        }else{
            $part1 .= $key.',';
            $part2 .= "?,";
        }
    }
    $buildQuery = $part1.$part2;

    $stmt = mysqli_prepare($con,$buildQuery);
    
    if (false===$stmt)
        return mysqli_error($con);
        
    call_user_func_array("mysqli_stmt_bind_param",array_merge(array(&$stmt, &$typeDef), $params));
    mysqli_stmt_execute($stmt);
    $error = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    
    return $error;
}

function updateToDb($con,$tableName,$arr,$where){
    $part1 = $part2 = '';
    $part1 .= 'UPDATE '.$tableName.' SET ';
    $part2 .= ' WHERE ';
    $queryCount = count($arr); $i = 0;
    foreach($arr as $key=>$val){
        if(++$i === $queryCount) {
            $part1 .= $key."='".$val."' ";
        }else{
            $part1 .= $key."='".$val."', ";
        }
    }
    $i = 0;
    foreach($where as $key=>$val){
        if($i == 1) {
            $part2 .= ' AND '.$key."='".$val."'";
            break;
        }else{
            $part2 .= $key."='".$val."'";
        }
        $i++;
    }
    $buildQuery = $part1.$part2;
    mysqli_query($con,$buildQuery); 
        
    return mysqli_error($con);
}

function updateToDbPrepared($con,$tableName,$arr,$where,$customTypeDef=false,$typeDefStr=''){
    $params = array();
    $error = $typeDef = $part1 = $part2 = '';
    $i = $j = 0;
    $part1 .= 'UPDATE '.$tableName.' SET ';
    $part2 .= ' WHERE ';
    $queryCount = count($arr);
    foreach($arr as $key=>$val){
        $params[$i] = &$arr[$key];
        $typeDef .= 's';
        if(++$i === $queryCount) {
            $part1 .= $key."= ? ";
        }else{
            $part1 .= $key."= ?,";
        }
    }
    foreach($where as $key=>$val){
        $params[$i] = &$where[$key];
        $typeDef .= 's';
        if($j == 1) {
            $part2 .= ' AND '.$key."=?";
            break;
        }else{
            $part2 .= $key."=?";
        }
        $i++; $j++;
    }
    $buildQuery = $part1.$part2;
    $stmt = mysqli_prepare($con,$buildQuery);
    
    if (false===$stmt)
        return mysqli_error($con);
        
    if($customTypeDef)
        $typeDef = $typeDefStr; 

    call_user_func_array("mysqli_stmt_bind_param",array_merge(array(&$stmt, &$typeDef), $params));
    mysqli_stmt_execute($stmt);
    $error = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    
    return $error;
}

function mysqliPreparedQuery($con,$query,$typeDef = false,$params = false, $noSingle = true){
  $result = $bindParams = array();
  $countRes = 0;$multiQuery = false;
  if($stmt = mysqli_prepare($con,$query)){
    if(count($params) == count($params,1)){
      $params = array($params);
      $multiQuery = false;
    } else {
      $multiQuery = true;
    } 

    if($typeDef){   
      $bindParamsReferences = array();
      $bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");        
      foreach($bindParams as $key => $value){
        $bindParamsReferences[$key] = &$bindParams[$key]; 
      }
      array_unshift($bindParamsReferences,$typeDef);
      $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
      $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences);
    }

    foreach($params as $queryKey => $query){
      foreach($bindParams as $paramKey => $value){
        $bindParams[$paramKey] = $query[$paramKey];
      }
      $queryResult = array();
      if(mysqli_stmt_execute($stmt)){
        $resultMetaData = mysqli_stmt_result_metadata($stmt);
        if($resultMetaData){                                                                              
          $stmtRow = array();  
          $rowReferences = array();
          while ($field = mysqli_fetch_field($resultMetaData)) {
            $rowReferences[] = &$stmtRow[$field->name];
          }                               
          mysqli_free_result($resultMetaData);
          $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result');
          $bindResultMethod->invokeArgs($stmt, $rowReferences);
          while(mysqli_stmt_fetch($stmt)){
            $countRes++;
            $row = array();
            foreach($stmtRow as $key => $value){
              $row[$key] = $value;          
            }
            $queryResult[] = $row;
          }
          mysqli_stmt_free_result($stmt);
        } else {
          $queryResult[] = mysqli_stmt_affected_rows($stmt);
        }
      } else {
        $queryResult[] = false;
      }
      $result[$queryKey] = $queryResult;
    }
    mysqli_stmt_close($stmt);  
  } else {
    $result = false;
  }

  if($multiQuery){
    return $result;
  } else {
    if($noSingle){
        if($countRes == 0)
            return false;
        elseif($countRes == 1)
            return $result[0][0];
        else
            return $result[0];
    }else{
        if($countRes == 0)
            return array();
        else
            return $result[0];
    }
  }
}