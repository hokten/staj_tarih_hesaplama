<?php xdebug_enable(); ?>
<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Hammersmith+One" rel="stylesheet">
<style>
ul {list-style-type: none;}
body {font-family: Verdana, sans-serif;}

.numberCircle {
font-family: 'Hammersmith One', sans-serif;


font-size: 33px;
    color: #607B7D;
}
.calendar {
  width:65%;
  margin:auto
}
.day_box {
  position:relative;
  width:100%;
  height:45px;
}
.day_number {
  position:absolute;
  top:2px;
  left:2px;
}
.days.empty {
  background-color:#D3FFDD
}
.staj_number_bir {
  position:absolute;
  bottom:2px;
  right:2px;
  background-color:#FFE066;
  border:1px solid #50514F;
  font-size:12px;
  color:#F25F5C;
}
.staj_number_iki {
  position:absolute;
  bottom:2px;
  right:2px;
  background-color:#ED6A5A;
  border:1px solid #7C0B2B;
  font-size:12px;
  color:#F4FFDD;
}

.month_table {
  display: table;
  width:100%;
  height:90px;
  border-collapse: separate;
  border-spacing: 5px;
  background-color: #E9C46A
}
.month {
  display:table-cell;
  background-color: #F4A261;
  border:1px solid #E76F51;
  color:#EF2D56;
  font-size:17px;
  font-weight:bold;
  text-align:center;
  vertical-align:middle
}

.weekdays_table {
  display: table;
  width:100%;
  border-collapse: separate;
  border-spacing: 5px;
  background-color: #D3DDAC

}

.weekdays_row { 
  display:table-row;
  height:30px;
 }

.weekdays {
  display:table-cell;
  width:13%;
  background-color: #2E5266;
  border:1px solid #247BA0;
  color:#F0B67F;
  font-weight:bold;
  font-size:13px;
  text-align:center;
  vertical-align:middle
}


.days_table {
  display: table;
  width:100%;
  border-collapse: separate;
  border-spacing: 5px;
  background-color: #D3FFDD;
  margin-bottom:20px;
}

.days_row { 
  display:table-row;
  height:50px;
 }

.days {
  display:table-cell;
  width:13%;
  background-color: #B2DBBF;
  border:1px solid #247BA0;
}

/* Add media queries for smaller screens */
@media screen and (max-width:720px) {
    .weekdays li, .days li {width: 13.1%;}
}

@media screen and (max-width: 420px) {
    .weekdays li, .days li {width: 12.5%;}
    .days li .active {padding: 2px;}
}

@media screen and (max-width: 290px) {
    .weekdays li, .days li {width: 12.2%;}
}
</style>
</head>
<body>

<?php
require "staj.php";
require "takvim.php";

$ystajsayisi=count($_POST["yapilacakstajlar"]);
$hstajgunu=intval($_POST["haftagun"]);
$baslama_donemi=explode("_",$_POST["stajbaslamatarihi"])[0];
$baslama_tarihi=explode("_",$_POST["stajbaslamatarihi"])[1];

$staj=new StajHesapla($baslama_donemi, $baslama_tarihi, $hstajgunu,$ystajsayisi);
$staj->iss_gunleri();
$staj->staj_gunleri_hesapla();


$staj_tarihleri["birinci"]=array("baslama"=>$staj->staj_gunleri[0][0], "bitis"=>end($staj->staj_gunleri[0]));


if(array_key_exists(1,$staj->staj_gunleri)) {
  $staj_tarihleri["ikinci"]=array();
  if(count($staj->staj_gunleri[1])>0) {
    $staj_tarihleri["ikinci"]["baslama"]=$staj->staj_gunleri[1][0];
    $staj_tarihleri["ikinci"]["bitis"]=end($staj->staj_gunleri[1]);
  }
}

$tum_staj_baslama=$staj_tarihleri["birinci"]["baslama"];
$tum_staj_bitis=$staj_tarihleri["birinci"]["bitis"];
if(array_key_exists("ikinci", $staj_tarihleri)) {
  if(count($staj_tarihleri["ikinci"])) {
    $tum_staj_bitis=$staj_tarihleri["ikinci"]["bitis"];
  }
}

$ddd=$staj->staj_gunleri;
var_dump($ddd);
var_dump($tum_staj_baslama);
var_dump($tum_staj_bitis);;





$aylar=array(1 => "OCAK", 2 => "ŞUBAT", 3 => "MART", 4 => "NİSAN",
  5 => "MAYIS", 6 => "HAZİRAN", 7 => "TEMMUZ", 8 => "AĞUSTOS",
  9 => "EYLÜL", 10 => "EKİM", 11 => "KASIM", 12 => "ARALIK");

$yeni=new TakvimOlustur($tum_staj_baslama, $tum_staj_bitis);


$staj_ozet_devami="";
if(array_key_exists("ikinci", $staj_tarihleri)) {
  $staj_ozet_devami .= "<tr><td colspan='4'>İkinci Staj</td></tr>\n";
  $staj_ozet_devami .= "\t\t<tr>\n";
  if(count($staj_tarihleri["ikinci"])>0) {
    $staj_ozet_devami .= "<td>Başlama</td>\n";
    $staj_ozet_devami .= "<td>{$staj_tarihleri["ikinci"]["baslama"]->format('d-m-Y')}</td>\n";
    $staj_ozet_devami .= "<td>Bitiş</td>\n";
    $staj_ozet_devami .= "<td>{$staj_tarihleri["ikinci"]["bitis"]->format('d-m-Y')}</td>\n";
  }
  else {
    $staj_ozet_devami .= "<td colspan='4'>İkinci stajı yapabilmek için yeterli gün yok</td>\n";
  }
  $staj_ozet_devami .= "</tr>";
}



echo '<div class="calendar">';
$staj_ozet=<<<STAJOZET
  <div class="staj_baslama_bitis_ozet">
    <table>
      <tr><td colspan="4">Birinci Staj</td></tr>
      <tr>
        <td>Başlama Tarihi</td>
        <td>{$staj_tarihleri["birinci"]["baslama"]->format('d-m-Y')}</td>
        <td>Bitiş Tarihi</td>
        <td>{$staj_tarihleri["birinci"]["bitis"]->format('d-m-Y')}</td>
      </tr>
      $staj_ozet_devami
    </table>
  </div>
STAJOZET;

echo $staj_ozet;
      




foreach($yeni->cikti_dizisi as $yil => $ay) {
  foreach($ay as $ay_numarasi => $haftalar) {
    echo "<div class='month_container'>";
    $ay_header=<<<AYHEADER
      <div class="month_table">
        <div class="month">$aylar[$ay_numarasi]<br><span style="font-size:18px;color:#D62839">$yil</span></div>
      </div>
AYHEADER;
    echo $ay_header;
    $gun_header=<<<GUNHEADER
      <div class='weekdays_table'>
        <div class='weekdays_row'>
          <div class='weekdays'>PAZARTESİ</div>
          <div class='weekdays'>SALI</div>
          <div class='weekdays'>ÇARŞAMBA</div>
          <div class='weekdays'>PERŞEMBE</div>
          <div class='weekdays'>CUMA</div>
          <div class='weekdays'>CUMARTESİ</div>
          <div class='weekdays'>PAZAR</div>
        </div>
      </div>

GUNHEADER;
    echo $gun_header;
    echo '<div class="days_table">';
    foreach($haftalar as $haftanin_gunleri) {
      echo '<div class="days_row">';
      for($i=1; $i<=7; $i++) {
        if (!array_key_exists($i, $haftanin_gunleri)) {
          echo '<div class="days empty"></div>';
        }
        else {
          echo '<div class="days">';
          echo '<div class="day_box">';
          echo '<div class="day_number"><div class="numberCircle">'.$haftanin_gunleri[$i]->format('j')."</div></div>";

          // TODO burası for dongusu ile kisalabilir
          if(array_key_exists(0,$staj->staj_gunleri)) {
             $staj_bir_cakisma=array_search($haftanin_gunleri[$i], $staj->staj_gunleri[0]);
            $staj_bir_content=$staj_bir_cakisma===false ? "" : "<div class='staj_number_bir'>".($staj_bir_cakisma+1).". Gün</div>";
            echo $staj_bir_content;
          }
          if(array_key_exists(1,$staj->staj_gunleri)) {
             $staj_iki_cakisma=array_search($haftanin_gunleri[$i], $staj->staj_gunleri[1]);
            $staj_iki_content=$staj_iki_cakisma===false ? "" : "<div class='staj_number_iki'>".($staj_iki_cakisma+1).". Gün</div>";
            echo $staj_iki_content;
          }



          echo '</div>';
          echo '</div>';

        }
        echo "\n\r";
      }
      echo "</div>";
    }
    echo "</div>";
    echo "</div>";
  }
}
?>
</div>
</body>
</html>

