<?php
require_once __DIR__ . '/vendor/autoload.php';
require "staj.php";
require "takvim.php";


$form_verileri = unserialize($_POST["post"]);


array_walk($form_verileri, function(&$value, $key) {
   $deger = $value;
   if(!in_array($key, array('yapilacakstajlar','iseposta','hesaplanan_baslama_bitis'))) {
      $deger = mb_strtoupper(str_replace('i', 'İ', $value));
   }
   $value = $deger;
});

 /*$array_mapped = array_map(
   function ($array_item) {
      if(is_string($array_item)) {
         return mb_strtoupper(str_replace('i', 'İ', $array_item));
      }
      else {
         return $array_item;
      }
   }, $form_verileri);
*/
$yapilabilecek_stajlar = $form_verileri["hesaplanan_baslama_bitis"];
$stajlar_ve_tarihler = array_filter($yapilabilecek_stajlar);
$tum_veriler = array();

foreach($stajlar_ve_tarihler as $staj_kodu => $baslama_bitis ) {
   $staj_basi = $baslama_bitis["baslama"]->format('d-m-Y');
   $staj_sonu = $baslama_bitis["bitis"]->format('d-m-Y');

   $tum_veriler[] = array(

      'ogrenci_alanlari' => array(
         array( 
            "sol" => array("label" => "PROGRAMI", "value" => mb_strtoupper($form_verileri['program']), "class" =>"ogrsollabel"),

            "sag" => array("label" => "TOPLAM STAJ İŞ GÜNÜ", "value" => "20",  "class" =>"ogrsaglabel")
         ),
         array(
            "sol" => array("label" => "ADI SOYADI", "value" => $form_verileri['adsoyad'],  "class" =>"ogrsollabel"),
            "sag" => array("label" => "ÖĞRENCİNİN HAFTADA ÇALIŞACAĞI GÜN SAYISI", "value" => $form_verileri['haftagun'],  "class" =>"ogrsaglabel")
         ),
         array(
            "sol" => array("label" => "ÖĞRENCİ NUMARASI", "value" => $form_verileri['numara'],  "class" =>"ogrsollabel"),
            "sag" => array("label" => "YAPILACAK STAJ", "value" => $staj_kodu,  "class" =>"ogrsaglabel")
         ),
         array(
            "sol" => array("label" => "T.C. KİMLİK NO", "value" => "1234",  "class" =>"ogrsollabel"),
            "sag" => array("label" => "STAJ BAŞLANGIÇ TARİHİ", "value" => $staj_basi,  "class" =>"ogrsaglabel")
         ),
         array(
            "sol" => array("label" => "TELEFON NO", "value" => "1234",  "class" =>"ogrsollabel"),
            "sag" => array("label" => "STAJ BİTİŞ TARİHİ", "value" => $staj_sonu,  "class" =>"ogrsaglabel")
         )
      ),
      'isyeri_alanlari' => array(
         array(
            "sol" => array("label" => "İŞ YERİ MERSİS NO", "value" => "Elektronik", "class" => "mersis"),
            "sag" => array("label" => "İŞ YERİ VERGİ NO", "value" => "20", "class" => "vergi")
         ),
         array(
            "sol" => array("label" => "İŞ YERİNİN ADI / UNVANI", "value" => "Hasan ÖKTEN", "class" => "isyeriadi")
         ),
         array(
            "sol" => array("label" => "ADRESİ", "value" => "1234", "class" => "adres"),
         ),
         array(
            "sol" => array("label" => "FAALİYET ALANI", "value" => "Elektronik", "class" => "faaliyet"),
            "sag" => array("label" => "TELEFON NO", "value" => "20", "class" => "istelefon")
         ),
         array(
            "sol" => array("label" => "E-POSTA", "value" => "Elektronik", "class" => "iseposta"),
            "sag" => array("label" => "FAX NO", "value" => "20", "class" => "isfax")
         )
      )
   );
}



$mpdf = new \Mpdf\Mpdf();

/*
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


$aylar=array(1 => "OCAK", 2 => "ŞUBAT", 3 => "MART", 4 => "NİSAN",
  5 => "MAYIS", 6 => "HAZİRAN", 7 => "TEMMUZ", 8 => "AĞUSTOS",
  9 => "EYLÜL", 10 => "EKİM", 11 => "KASIM", 12 => "ARALIK");

$yeni=new TakvimOlustur($tum_staj_baslama, $tum_staj_bitis);
*/
$ogrenci_alanlari=array(
   array(
      "sol" => array("label" => "PROGRAMI", "value" => $form_verileri['program'], "class" =>"ogrsollabel"),
      "sag" => array("label" => "TOPLAM STAJ İŞ GÜNÜ", "value" => "20",  "class" =>"ogrsaglabel")
   ),
   array(
      "sol" => array("label" => "ADI SOYADI", "value" => $form_verileri['adsoyad'],  "class" =>"ogrsollabel"),
      "sag" => array("label" => "ÖĞRENCİNİN HAFTADA ÇALIŞACAĞI GÜN SAYISI", "value" => $form_verileri['haftagun'],  "class" =>"ogrsaglabel")
   ),
   array(
      "sol" => array("label" => "ÖĞRENCİ NUMARASI", "value" => $form_verileri['numara'],  "class" =>"ogrsollabel"),
      "sag" => array("label" => "YAPILACAK STAJ", "value" => "EDE102",  "class" =>"ogrsaglabel")
   ),
   array(
      "sol" => array("label" => "T.C. KİMLİK NO", "value" => "1234",  "class" =>"ogrsollabel"),
      "sag" => array("label" => "STAJ BAŞLANGIÇ TARİHİ", "value" => "EDE102",  "class" =>"ogrsaglabel")
   ),
   array(
      "sol" => array("label" => "TELEFON NO", "value" => "1234",  "class" =>"ogrsollabel"),
      "sag" => array("label" => "STAJ BİTİŞ TARİHİ", "value" => "EDE102",  "class" =>"ogrsaglabel")
   )


);

$isyeri_alanlari=array(
   array(
      "sol" => array("label" => "İŞ YERİ MERSİS NO", "value" => "Elektronik", "class" => "mersis"),
      "sag" => array("label" => "İŞ YERİ VERGİ NO", "value" => "20", "class" => "vergi")
   ),
   array(
      "sol" => array("label" => "İŞ YERİNİN ADI / UNVANI", "value" => "Hasan ÖKTEN", "class" => "isyeriadi")
   ),
   array(
      "sol" => array("label" => "ADRESİ", "value" => "1234", "class" => "adres"),
   ),
   array(
      "sol" => array("label" => "FAALİYET ALANI", "value" => "Elektronik", "class" => "faaliyet"),
      "sag" => array("label" => "TELEFON NO", "value" => "20", "class" => "istelefon")
   ),
   array(
      "sol" => array("label" => "E-POSTA", "value" => "Elektronik", "class" => "iseposta"),
      "sag" => array("label" => "FAX NO", "value" => "20", "class" => "isfax")
   )
);

$staj_ve_balama_bitis=array();

//foreach($staj as $yapilabilecek_stajlar) {
//   if(!empty($staj)) {




$filter = new Twig_Filter('diziara', 'array_search');
$loader = new Twig_Loader_Filesystem('templates/pdfciktisi');
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addFilter($filter);
$template = $twig->load('main.twig');
$indenter = new \Gajus\Dindent\Indenter();
//$output=$indenter->indent(  $output=$twig->render('html.twig', array('ogrencialanlari' => $ogrenci_alanlari))  );
$output=$twig->render('main.twig', array('tum_veriler' => $tum_veriler));
//echo $output;
//var_dump($output);
//var_dump(array_filter($yapilabilecek_stajlar));
$mpdf->WriteHTML($output);
$mpdf->Output();


?>
