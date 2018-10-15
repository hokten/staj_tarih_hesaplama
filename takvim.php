<?php
class TakvimOlustur {
  public $takvim_ayi;
  public $takvim_yili;
  public $cikti_dizisi;

  public function __construct($baslangic_tarihi, $bitis_tarihi) {
    $begin = (clone $baslangic_tarihi)->modify('first day of');
    $end = (clone $bitis_tarihi)->modify('last day of');

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    $yil=$begin->format('Y');
    $ay=$begin->format('n');

    $i=0;
    $haftalar=array();


    foreach ($period as $dt) {
      $yil=$dt->format('Y');
      $ay=$dt->format('n');
      $hafta=$dt->format('W');
      $gun=($dt->format("w")+6)%7+1;
      //$haftalar[$yil][$ay][$hafta][$gun]= $dt->format("Y-m-d");
      $haftalar[$yil][$ay][$hafta][$gun]= clone $dt;


    }
    $this->cikti_dizisi=$haftalar;

  }
}

