<?php
date_default_timezone_set('Europe/London');

class StajHesapla {
  public $haftalik_staj_gunu;
  public $yapilacak_staj_sayisi;
  public $is_gunleri;
  public $staj_gunleri;
  public $baslama;
  public $baslama_tarihi;
  private $bitis;
  private $resmi_tatiller;




  public function __construct($staj_donemi, $basl_tarihi, $hsg, $ss) {
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
    $this->yapilacak_staj_sayisi=$ss;
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

    // Pazar gunleri ve 5 gun staj yapilacaksa Cumartesi gunleri tum gunlerden cikariliyor.
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
    $ilk_staj=array();
    for($i=0; $i<=19; $i++) {
      $ilk_staj[]=$this->is_gunleri[$i];
    }
    $this->staj_gunleri[]=$ilk_staj;


    if($this->yapilacak_staj_sayisi == 2 && count($this->is_gunleri)>=40) {
      echo "============================================";
      $ikinci_staj=array();
      for($i=0; $i<=19; $i++) {
        $ikinci_staj[]=$this->is_gunleri[$i+20];
      }
      $this->staj_gunleri[]=$ikinci_staj;
    }
    elseif($this->yapilacak_staj_sayisi == 2 && count($this->is_gunleri)<40) {
      $ikinci_staj=array();
      $this->staj_gunleri[]=$ikinci_staj;
    }
  }
}


$ystajsayisi=count($_POST["yapilacakstajlar"]);
$hstajgunu=intval($_POST["haftagun"]);
$baslama_donemi=explode("_",$_POST["stajbaslamatarihi"])[0];
$baslama_tarihi=explode("_",$_POST["stajbaslamatarihi"])[1];
$yeni1=new StajHesapla($baslama_donemi, $baslama_tarihi, $hstajgunu,$ystajsayisi);
$yeni1->iss_gunleri();
$yeni1->staj_gunleri_hesapla();

echo "<pre>";
print_r($yeni1->baslama);
echo "</pre>";




echo $ystajsayisi;
echo $hstajgunu;
echo "<pre>";
print_r($_POST); 
echo "</pre>";


/*
  public function tum_gunler() {
    $bsl=$this->baslama["guz"][2];
    $bts=$this->bitis["guz"];
    while($bsl<$bts) {
      $tmp_tarih=clone $bsl;
      $this->is_gunleri[]=$tmp_tarih;
      $bsl->modify('+1 day');
    }
  }

  public function resmi_tatil_haric_is_gunleri() {
    foreach($this->is_gunleri as $anahtar => $deger) {
      $guncel_gun=$deger->format('w');
      if($guncel_gun == 0) {
        unset($this->is_gunleri[$anahtar]);
      }
      elseif($guncel_gun == 6 && $this->haftalik_staj_gunu == 5) {
        unset($this->is_gunleri[$anahtar]);
      }
    }
  }

  public function kesin_is_gunleri() {
    foreach($this->is_gunleri as $anahtar => $deger) {
      if(in_array($deger, $this->resmi_tatiller)) {
        unset($this->is_gunleri[$anahtar]);
      }
    }
  }

  public function stajlara_gore_gunler() {
    $i=1;
    $ddizi=array_values($this->is_gunleri);
    $ede102=array();
    for($i=0; $i<=19; $i++) {
      $ede102[]=$ddizi[$i];
    }
    $this->staj_gunleri[]=$ede102;
  }
}

 */












/*
$haftalik_staj_gunu=5;
$staj_gunleri=[];
$resmi_tatiller=Array(new DateTime('2018-10-29'), new DateTime('2018-11-3'));
$staj_baslama_gunu = new DateTime('2018-10-04');
$gun_sayisi=0;
while($gun_sayisi<=20) {
  $staj_gunu=$staj_baslama_gunu->format('w');
  if($staj_gunu != 0) {
    if($staj_gunu == 6 && $haftalik_staj_gunu == 6) {
          echo $staj_baslama_gunu->format('d-m-Y') . "\n";
    $gun_sayisi++;
  }
  $staj_baslama_gunu->add(new DateInterval('P1D'));
}
}
$gunler=Array(new DateTime('2018-11-1'), new DateTime('2018-11-2'),new DateTime('2018-11-3'), new DateTime('2018-11-4'));
$tatiller=Array(new DateTime('2018-11-2'),new DateTime('2018-11-4'));

$sonn=array_filter($gunler, function($tarih) use($tatiller) {
  if(!in_array($tarih, $tatiller)) {
    return $tarih;
  }
});

print_r($sonn);

 */ 
?>
