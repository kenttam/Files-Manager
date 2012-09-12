<?php

  $text = pdf2string("files/Electrical Engineering/ee 2/hw1.pdf");
  echo $text;

  function pdf2string($sourcefile){
    $fp = fopen($sourcefile, 'rb');
    $content = fread($fp, filesize($sourcefile));
    fclose($fp);

    $searchstart = 'stream';
    $searchend = 'endstream';
    $pdfdocument = '';
    $pos = 0;
    $pos2 = 0;
    $startpos = 0;
   
    while( $pos !== false && $pos2 !== false ){
      $pos = strpos($content, $searchstart, $startpos);
      $pos2 = strpos($content, $searchend, $startpos + 1);
     
      if ($pos !== false && $pos2 !== false){
        if ($content[$pos]==0x0d && $content[$pos+1]==0x0a) $pos+=2;
        else if ($content[$pos]==0x0a) $pos++;

        if ($content[$pos2-2]==0x0d && $content[$pos2-1]==0x0a) $pos2-=2;
        else if ($content[$pos2-1]==0x0a) $pos2--;

        $textsection = substr($content, $pos + strlen($searchstart) + 2, $pos2 - $pos - strlen($searchstart) - 1);
        $data = @gzuncompress($textsection);
        $data = ExtractText2($data);
        $startpos = $pos2 + strlen($searchend) - 1;
        
        if ($data === false){ 
          return -1;}
          
        $pdfdocument .= $data;}}
   return $pdfdocument;}

function ExtractText2($postScriptData){
  $sw = true;
  $textStart = 0;
  $len = strlen($postScriptData);

  while ($sw){
    $ini = strpos($postScriptData, '(', $textStart);
    $end = strpos($postScriptData, ')', $textStart+1);
    if (($ini>0) && ($end>$ini)){
      $valtext = strpos($postScriptData,'Tj',$end+1);
      if ($valtext == $end + 2)
        $text .= substr($postScriptData,$ini+1,$end - $ini - 1);}
      
    $textStart = $end + 1;
    if ($len<=$textStart) $sw=false;
    
    if (($ini == 0) && ($end == 0)) $sw=false;}
  
  $trans = array("\\341" => "a","\\351" => "e","\\355" => "i","\\363" => "o","\\223" => "","\\224" => "");
  $text  = strtr($text, $trans);
  return $text;
} 
?>