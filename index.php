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
                   width: 100%; border-collapse: collapse; border-spacing: 0px;    /* Убираем двойные линии между ячейками */
}
   TH, TD {
    border: 1px solid black; /* Параметры рамки */
    text-align: center; /* Выравнивание по центру */
    padding: 4px; /* Поля вокруг текста */
   }
   TH {
    background: #fc0; /* Цвет фона ячейки */
    height: 40px; /* Высота ячеек */
    vertical-align: bottom; /* Выравнивание по нижнему краю */
    padding: 0; /* Убираем поля вокруг текста */
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
}else{
      echo "Connection unstable.<br />";
      die( print_r( sqlsrv_errors(), true));
}


$sql = "SELECT iTes,sTes FROM [DOPUSKTEST].[dbo].[ttes]";
$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$result = sqlsrv_query( $conn, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $result );

if ($row_count === false) { echo "Table is empty.<br>\n";}
else { echo "Query complete.<br>\n"; }
echo $row_count;
$tmprow='';
$iall=0;
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) 
{
$iall++;
$tmprow=$iall.' '.$row["iTes"].' '.$row["sTes"].'<br>------------------'.'Ivanov I.I.<br>'.'Dolgnosty glavnogo injenera<br>'.'nomer naryada XXXYYYZZZ<br>'.'KTC2'.'Kotelnoe otdelenie<br>'.'Date 2019-07-02';      
?>
<table width="150" border="1" cellpadding="4" cellspacing="1"> 
<tr> 
<td width="150"> <div align="leftcenter"> <?php echo $tmprow;?>  </div> </td>
</tr></table>
<?php
}
sqlsrv_free_stmt($result);
sqlsrv_close($conn);

?>

</body>
</html>
