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
       table-layout: fixed;
       overflow: hidden;
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


$sql = "SELECT NPPN,PODRAZDEL,NAMEWORK,RUKWORK,NARYADN,BEGWORK,ENDWORK,STATUSN FROM [DOPUSKTEST].[dbo].[TNaryad] WHERE STATUSN>0";
$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$result = sqlsrv_query( $conn, $sql , $params, $options );
$row_count = sqlsrv_num_rows( $result );

if ($row_count === false) { echo "Table is empty.<br>\n";}
 else { echo "Query complete.<br>\n"; }
echo $row_count;
$tmprow="";

?>



<table class="table">



    <?php
    $ikol=0;
    $iall=0;
    $koltab=10;
    $ruk='';
    $dolj='';
    $who='';
    $work='';
    $sstatus='';
    $status=0;
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) )
{
    $iall++;
    $ikol++;
    $newline='';
    If ($iall===1) {
        $newline="<tr>";
        echo $newline;
    }
    $status=$row["STATUSN"];
    If ($status ===1) {$sstatus='Статус:Не подготовлен';}
    If ($status ===2) {$sstatus='Статус:В работе';}
    If ($status ===3) {$sstatus='Статус:Прикрыт';}
    If ($status ===4) {$sstatus='Статус:Выдан';}
    If ($status ===5) {$sstatus='Статус:Не допускались';}

    $who=explode(",",$row["RUKWORK"]);
    $ruk=substr($who[0],0,35);
    $ruk=rtrim($ruk,"!,.-");
    $dolj=substr($who[1],0,35);
    $dolj=rtrim($dolj,"!,.-");
//    $work=mb_strimwidth(wordwrap($row["NAMEWORK"],20,"\n",true),1,160,"...");
//    $work=wordwrap($row["NAMEWORK"],20,"\n",true);
    $work = substr(str_pad($row["NAMEWORK"],170),0,170);
    $Work=rtrim($work,"!,.-");
    $tmprow='<b>'.$row["PODRAZDEL"].'<br>'.$sstatus.'</b><br>'.$work.'<br>'.'--------------------<br>'.$ruk.'<br>'.$dolj.'<br>'.'<b>№ '.$row["NPPN"].' ( '.$row["NARYADN"].')'.'<br>типовой</b>';
    $idn=$row["NPPN"];
    ?>

     <td id=$idn type="text" onClick="basicPopup('/naryad.php');return false" value=$idn width="150"> <div align="left"> <?php echo $tmprow;?>  </div> </td>

    <!--    <td  onClick="document.location='/naryad.php'" width="150"> <div align="left"> !!!<!!!?php echo $tmprow;?>  </div> </td> -->


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

<script>
    function basicPopup(url) {
        popupWindow = window.open(url,'popupWindow','height=300,width=700,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')
    }

</script>


</body>
</html>

