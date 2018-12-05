<?php
ini_set('display_errors', 'on');

require_once __DIR__ . '/vendor/autoload.php';
require "staj.php";
require "takvim.php";

###################### Gcloud ###############

putenv('GOOGLE_APPLICATION_CREDENTIALS=google.json');
use Google\Cloud\Datastore\DatastoreClient;
use Carbon\Carbon;
$projectId = 'disco-history-206419';
$datastore = new DatastoreClient(['projectId' => $projectId, 'namespaceId' => 'vt']);
$kind = 'kayitlar';




$form_verileri = unserialize($_POST["post"]);



// Formdan gelen değerler büyük harfe çevriliyor.
// *********************************
array_walk($form_verileri, function(&$value, $key) {
   $deger = $value;
   if(!in_array($key, array('yapilacakstajlar','iseposta','hesaplanan_baslama_bitis'))) {
      $deger = mb_strtoupper(str_replace('i', 'İ', $value));
   }
   $value = $deger;
});



$yapilabilecek_stajlar = $form_verileri["hesaplanan_baslama_bitis"];
$stajlar_ve_tarihler = array_filter($yapilabilecek_stajlar);
$tum_veriler = array();

$queryede102 = $datastore->query()
->kind('kayitlar')
->filter('ogrencino', '=', intval($form_verileri['numara']))
->filter('stajkodu', '=', 'EDE102');

$queryede202 = $datastore->query()
->kind('kayitlar')
->filter('ogrencino', '=', $form_verileri['numara'])
->filter('stajkodu', '=', 'EDE202');



$resultede102 = $datastore->runQuery($queryede102);
$resultede202 = $datastore->runQuery($queryede202);


var_dump($resultede102->current());
var_dump($resultede202->current());





//$key1 = $datastore->key('kayitlar', $form_verileri['numara'].'_EDE102');
//$key2 = $datastore->key('kayitlar', $form_verileri['numara'].'_EDE202');
//$datastore->deleteBatch([$key1, $key2]);

foreach($stajlar_ve_tarihler as $staj_kodu => $baslama_bitis ) {
   $staj_basi = $baslama_bitis["baslama"]->format('d-m-Y');
   $staj_sonu = $baslama_bitis["bitis"]->format('d-m-Y');

   ######## Gcloud ##############
   $kayit_id = $datastore->key('stajlar', $form_verileri['numara'].'_'.$staj_kodu);
   $kayit = $datastore->entity($kayit_id,  [
     'Adı Soyadı' => $form_verileri["adsoyad"],
     'Haftalık İş Günü' => intval($form_verileri['haftagun']),
     'İşçi' => intval($form_verileri['isci']),
     'İşyeri Adı' => $form_verileri['isyeriadi'],
     'İşyeri Adresi' => $form_verileri['isyeriadresi'],
     'İşyeri Eposta' => $form_verileri['iseposta'],
     'İşyeri Faaliyet Alanı' => $form_verileri['faaliyetalani'],
     'İşyeri Fax No' => $form_verileri['isfaxno'],
     'İşyeri Mersis No' => $form_verileri['mersisno'],
     'İşyeri Telefon No' => $form_verileri['istelefonu'],
     'İşyeri Vergi No' => $form_verileri['vergino'],
     'Mühendis' => intval($form_verileri['muhendis']),
     'Öğrenci No' => intval($form_verileri['numara']),
     'Öğrenci Telefon Numarası' => $form_verileri['telefonno'],
     'Personel Sayısı' => intval($form_verileri['calisansayisi']),
     'Staj Başlangıç Tarihi' => Carbon::createFromFormat('d-m-Y H:i:s', "$staj_basi 00:00:00", 'Europe/Istanbul'),
     'Staj Bitiş Tarihi' =>  Carbon::createFromFormat('d-m-Y H:i:s', "$staj_sonu 00:00:00", 'Europe/Istanbul'),
     'TC Kimlik No' => $form_verileri['tckimlikno'],
     'Tekniker' => intval($form_verileri['tekniker']),
     'Teknisyen' => intval($form_verileri['teknisyen']),
     'Toplam Staj İş Günü' => 20,
     'Ücret Ödemesi' => $form_verileri['ucret'],
     'Yapılacak Staj' => $staj_kodu,
     'Yönetici' => intval($form_verileri['yonetici'])
   ]);

   # Saves the entity
   $datastore->upsert($kayit);



   $tum_veriler[] = array(

      'ogrenci_alanlari' => array(
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
            "sag" => array("label" => "YAPILACAK STAJ", "value" => $staj_kodu,  "class" =>"ogrsaglabel")
         ),
         array(
            "sol" => array("label" => "T.C. KİMLİK NO", "value" => $form_verileri['tckimlikno'],  "class" =>"ogrsollabel"),
            "sag" => array("label" => "STAJ BAŞLANGIÇ TARİHİ", "value" => $staj_basi,  "class" =>"ogrsaglabel")
         ),
         array(
            "sol" => array("label" => "TELEFON NO", "value" => "1234",  "class" =>"ogrsollabel"),
            "sag" => array("label" => "STAJ BİTİŞ TARİHİ", "value" => $staj_sonu,  "class" =>"ogrsaglabel")
         )
      ),
      'isyeri_alanlari' => array(
         array(
            "sol" => array("label" => "İŞ YERİ MERSİS NO", "value" => $form_verileri["mersisno"], "class" => "mersis"),
            "sag" => array("label" => "İŞ YERİ VERGİ NO", "value" => $form_verileri["vergino"], "class" => "vergi")
         ),
         array(
            "sol" => array("label" => "İŞ YERİNİN ADI / UNVANI", "value" => $form_verileri["isyeriadi"], "class" => "isyeriadi")
         ),
         array(
            "sol" => array("label" => "ADRESİ", "value" => $form_verileri["isyeriadresi"], "class" => "adres"),
         ),
         array(
            "sol" => array("label" => "FAALİYET ALANI", "value" => $form_verileri["faaliyetalani"], "class" => "faaliyet"),
            "sag" => array("label" => "TELEFON NO", "value" => $form_verileri["istelefonu"], "class" => "istelefon")
         ),
         array(
            "sol" => array("label" => "E-POSTA", "value" => $form_verileri["iseposta"], "class" => "iseposta"),
            "sag" => array("label" => "FAX NO", "value" => $form_verileri["isfaxno"], "class" => "isfax")
         )
       ),
       'isyeri_ekstra' => array(
         'yonetici' => $form_verileri['yonetici'],
         'muhendis' => $form_verileri['muhendis'],
         'teknisyen' => $form_verileri['teknisyen'],
         'tekniker' => $form_verileri['tekniker'],
         'isci' => $form_verileri['isci'],
         'ucret' => $form_verileri['ucret'],
         'calisansayisi' => $form_verileri['calisansayisi']
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
$twig->addExtension(new Twig_Extension_Debug());

$twig->addFilter($filter);
$template = $twig->load('main.twig');
$indenter = new \Gajus\Dindent\Indenter();
//$output=$indenter->indent(  $output=$twig->render('html.twig', array('ogrencialanlari' => $ogrenci_alanlari))  );
$output=$twig->render('main.twig', array('tum_veriler' => $tum_veriler));
echo $output;
//var_dump($output);
//var_dump(array_filter($yapilabilecek_stajlar));
//$mpdf->WriteHTML($output);
//$mpdf->Output();

$query = $datastore->query()
->kind('kayitlar');
//->filter('ogrencino', '=', 1236)
//->limit(1);

$result = $datastore->runQuery($query);
foreach ($result as $task) {
   $date=$task['baslamatarihi'];
   var_dump($date);
   $date1=$task['bitistarihi'];
   var_dump($date1);
}

$query = $datastore->query()
->kind('kayitlar');
//->filter('ogrencino', '=', 1236)
//->limit(1);

$result = $datastore->runQuery($query);
foreach ($result as $task) {
   $date=$task['baslamatarihi'];
   var_dump($date);
   $date1=$task['bitistarihi'];
   var_dump($date1);
}


?>
