<?PHP  header("Content-Type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>


<body onload=" loadjavascript()" onresize="onwindowresize()" onkeydown="keydown(event)">



<meta http-equiv='X-UA-Compatible' content='IE=Edge'/>
<meta http-equiv='content-type' content='text/html' />
<meta charset="UTF-8"/>

<meta http-equiv='PRAGMA' CONTENT='NO-CACHE'/>

<meta name='viewport' content='width=device-width,height=device-height,user-scalable=yes'/>

<title>Нарядно допускная система PHP & SQL Server (sqlsrv)</title>
 
<style type="text/css">
   TABLE {
       width: 100%;
       /*       border-collapse: collapse;*/
       border-spacing: 4px; /* Убираем двойные линии между ячейками */
       font-size: 12px; /* размер шрифта*/
       font-family: "Segoe-normal", Arial, Helvetica, sans-serif;
       /*       table-layout: fixed;*/
          }
    TD {
    background: #f5f5f5; /* Цвет фона ячейки */
    border: 1px solid black; /* Параметры рамки */
    padding: 1px; /* Поля вокруг текста */
    vertical-align: top;
   }
  </style>

<input id='language' type='hidden' value='ru'>
<input id='shownotification' type='hidden' value='no'>


<?php

$serverName = "c-dc1-sql03v8, 8433";
$connectionInfo = array("DATABASE"=>"DOPUSKTEST","CharacterSet" => "UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);


if( $conn ) {
      echo "Connection complete.<br />";
}
else
{
      echo "Connection unstable.<br />";
      die( print_r( sqlsrv_errors(), true));
}


$sql = "SELECT NPPN,PODRAZDEL,NAMEWORK,RUKWORK,NARYADN,BEGWORK,ENDWORK FROM [DOPUSKTEST].[dbo].[TNaryad] WHERE STATUSN>0";
$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$result = sqlsrv_query( $conn, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $result );

if ($row_count === false) { echo "Table is empty.<br>\n";}
 else { echo "Query complete.<br>\n"; }
echo $row_count;
$tmprow="";

?>

<table>



    <?php
    $ikol=0;
    $iall=0;
    $koltab=10;
    $ruk='';
    $dolj='';
    $who='';
    $work='';
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) )
{
    $iall++;
    $ikol++;
    $newline='';
    If ($iall===1) {
        $newline='<tr>';
        echo $newline;
    }
    $who=explode(",",$row["RUKWORK"]);
    $ruk=substr($who[0],0,30);
    $dolj=substr($who[1],0,30);
//    $work=mb_strimwidth(wordwrap($row["NAMEWORK"],20,"\n",true),1,160,"...");
//    $work=wordwrap($row["NAMEWORK"],20,"\n",true);
    $work = substr(str_pad($row["NAMEWORK"],160),0,160);
    $tmprow='<b>'.$row["PODRAZDEL"].'</b>'.'<br><br>'.$work.'<br>'.'--------------------<br>'.$ruk.'<br>'.$dolj.'<br>'.'<b>№ '.$row["NPPN"].' ( '.$row["NARYADN"].')'.'<br>типовой</b>';
    ?>

    <td width="158"> <div align="left"> <?php echo $tmprow;?>  </div> </td>

    <?php
        $newline='';
    If ($iall % $koltab===0) {
            $iall=0;
            $newline='</tr>';
     }
    If ($ikol === $row_count) {
            $newline='</tr>';
    }
    echo $newline;

}
?>
 </table>

<?php
sqlsrv_free_stmt($result);
sqlsrv_close($conn);

?>

</body>
</html>
