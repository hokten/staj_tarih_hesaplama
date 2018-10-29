<?php
   date_default_timezone_set('Europe/London');

   class StajHesapla {
      public $haftalik_staj_gunu;
      public $yapilacak_staj_sayisi;
      public $yapilacak_stajlar;
      public $is_gunleri;
      public $staj_gunleri;
      public $baslama;
      public $baslama_tarihi;
      private $bitis;
      public $resmi_tatiller;




      public function __construct($staj_donemi, $basl_tarihi, $hsg, $stajlar) {
         $this->is_gunleri=array();
         $this->staj_gunleri=array();
         $this->baslama=array(
            "guz"=>array(new DateTime('2018-10-15'), new DateTime('2018-11-05'), new DateTime('2018-11-19')),
            "bahar"=>array(new DateTime('2019-02-04'), new DateTime('2019-02-18'), new DateTime('2019-03-04')),
            "yaz"=>array(new DateTime('2019-06-24'), new DateTime('2019-07-22'), new DateTime('2019-07-29'))
         );

         $this->bitis=array(
            "guz"=>new DateTime('2019-01-4'),
            "bahar"=>new DateTime('2019-05-17'),
            "yaz"=>new DateTime('2019-08-29'));
            $this->resmi_tatiller=array(
               new DateTime('2018-10-28'),new DateTime('2018-10-29'),new DateTime('2019-1-1'),new DateTime('2019-4-23'),
               new DateTime('2019-5-1'),new DateTime('2019-5-19'),new DateTime('2019-6-4'),new DateTime('2019-6-5'),
               new DateTime('2019-6-6'),new DateTime('2019-6-7'),new DateTime('2019-8-10'),new DateTime('2019-8-11'),
               new DateTime('2019-8-12'),new DateTime('2019-8-13'),new DateTime('2019-8-14'),new DateTime('2019-8-30'),
               new DateTime('2019-10-28'),new DateTime('2019-10-29'));


               $this->haftalik_staj_gunu=$hsg;
               $this->yapilacak_stajlar=$stajlar;
               $this->yapilacak_staj_sayisi=count($this->yapilacak_stajlar);
               $this->baslama_tarihi=$this->baslama[$staj_donemi][$basl_tarihi];
               $this->bitis_tarihi=$this->bitis[$staj_donemi];

            }


            public function iss_gunleri() {

               // Verilen baslama tarihine uygun bitis tarihi seciliyor
               $bsl=clone $this->baslama_tarihi;
               $bts=clone $this->bitis_tarihi;

               // Baslama ve bitis arasindaki tum gunler bir diziye aktariliyor
               $tmp_is_gunleri=array();
               while($bsl<$bts) {
                  $tmp_tarih=clone $bsl;
                  $tmp_is_gunleri[]=$tmp_tarih;
                  $bsl->modify('+1 day');
               }

               // Pazar gunleri ve bes gun staj yapilacaksa Cumartesi gunleri tum gunlerden cikariliyor.
               $tmp_rth_is_gunleri=array();

               foreach($tmp_is_gunleri as $anahtar => $deger) {
                  $guncel_gun=$deger->format('w');
                  if($guncel_gun > 0 && $guncel_gun < 6) {
                     $tmp_rth_is_gunleri[]=$tmp_is_gunleri[$anahtar];
                  }
                  elseif($guncel_gun == 6 && $this->haftalik_staj_gunu == 6) {
                     $tmp_rth_is_gunleri[]=$tmp_is_gunleri[$anahtar];
                  }
               }

               // Resmi tatil gunleri son bulunan gun dizisinden cikariliyor
               $tmp_kes_is_gunleri=array();
               foreach($tmp_rth_is_gunleri as $anahtar => $deger) {
                  if(!in_array($deger, $this->resmi_tatiller)) {
                     $tmp_kes_is_gunleri[]=$deger;
                  }
               }

               $this->is_gunleri=$tmp_kes_is_gunleri;
            }

            public function staj_gunleri_hesapla() {
               $tmp_staj=array();
               for($i=0; $i<=19; $i++) {
                  $tmp_staj[]=clone $this->is_gunleri[$i];
               }
               $this->staj_gunleri[$this->yapilacak_stajlar[0]]=$tmp_staj;


               if($this->yapilacak_staj_sayisi == 2 && count($this->is_gunleri)>=40) {
                  $tmp_staj=array();
                  for($i=0; $i<=19; $i++) {
                     $tmp_staj[]=clone $this->is_gunleri[$i+20];
                  }
                  $this->staj_gunleri[$this->yapilacak_stajlar[1]]=$tmp_staj;
               }
               elseif($this->yapilacak_staj_sayisi == 2 && count($this->is_gunleri)<40) {
                  $tmp_staj=array();
                  $this->staj_gunleri[$this->yapilacak_stajlar[1]]=$tmp_staj;
               }
            }
         }

      ?>
