<?php
   ini_set('memory_limit', '-1');
   require_once 'vendor/autoload.php';
   require "staj.php";
   require "takvim.php";

   $post = $_POST;

   $ystajlar=$_POST["yapilacakstajlar"];
   $hstajgunu=intval($_POST["haftagun"]);
   $baslama_donemi=explode("_",$_POST["stajbaslamatarihi"])[0];
   $baslama_tarihi=explode("_",$_POST["stajbaslamatarihi"])[1];

   $staj=new StajHesapla($baslama_donemi, $baslama_tarihi, $hstajgunu, $ystajlar);
   $staj->iss_gunleri();
   $staj->staj_gunleri_hesapla();

   $staj_tarihleri=array();
   foreach($staj->staj_gunleri as $staj_kodu => $staj_kodu_gunleri) {
      $staj_tarihleri[$staj_kodu]=array();
      if(!empty($staj_kodu_gunleri)) {
         $staj_tarihleri[$staj_kodu]["baslama"]=clone $staj_kodu_gunleri[0];
         $staj_tarihleri[$staj_kodu]["bitis"]=clone end($staj_kodu_gunleri);
      }
   }

   reset($staj_tarihleri);
   $tum_staj_baslama=current($staj_tarihleri)["baslama"];
   $tum_staj_bitis=current($staj_tarihleri)["bitis"];
   if(array_key_exists("bitis", end($staj_tarihleri))) $tum_staj_bitis=end($staj_tarihleri)["bitis"];

   $post['hesaplanan_baslama_bitis']=$staj_tarihleri;
   $post=serialize($post);
   

/*
   var_dump($staj_tarihleri);
   var_dump($tum_staj_baslama);
   var_dump($tum_staj_bitis);
   var_dump($staj->staj_gunleri);
*/



   $aylar=array(1 => "OCAK", 2 => "ŞUBAT", 3 => "MART", 4 => "NİSAN",
   5 => "MAYIS", 6 => "HAZİRAN", 7 => "TEMMUZ", 8 => "AĞUSTOS",
   9 => "EYLÜL", 10 => "EKİM", 11 => "KASIM", 12 => "ARALIK");

   $yeni=new TakvimOlustur($tum_staj_baslama, $tum_staj_bitis);

  //var_dump($yeni->cikti_dizisi);



   require_once 'vendor/autoload.php';
   $filter = new Twig_Filter('diziara', 'array_search');
   // $loader = new Twig_Loader_Filesystem('templates/stajtakvimi');
   $loader = new Twig_Loader_Filesystem('templates/stajtakvimi');

   $twig = new Twig_Environment($loader, array('debug' => true));
   $twig->addFilter($filter);
   $twig->addExtension(new Twig_Extension_Debug());

   // $template = $twig->load('body.table.days.satir.daybox.html.twig');
   $template = $twig->load('body/table/daystable/days/daybox/html.twig');

   echo $twig->render(
      'body/table/daystable/days/daybox/html.twig', 
      array(
         'stajgunleri' => $staj->staj_gunleri,
         'stajtarihleri' => $staj_tarihleri,
         'takvim' => $yeni->cikti_dizisi,
         'turkceay'=>$aylar,
         'post' => $post,
         'resmitatiller' => $staj->resmi_tatiller));
      ?>
