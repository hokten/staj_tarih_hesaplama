<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$cikti=<<<CIKTI
<html>
<head>
<style>
@page {
	size: 8.5in 11in; /* <length>{1,2} | auto | portrait | landscape */
	      /* 'em' 'ex' and % are not allowed; length values are width height */
        margin-left:3%;
        margin-right:3%;
        margin-top:2%;
}
body {
  font-family:Arial;
}
div {
  padding-bottom:5px;
  border-bottom:1px dotted black;
}
td.header {
  font-weight:bold;
  text-align:center;
  vertical-align:middle;
  border:none;
}

td {
    border: 1px solid black;
}
.calisanlar td {
    border: 1px dotted black;

}
.aciklamalar td {
  border:none;
  vertical-align:top;
}

</style>
</head>
<body>
  <div style="width:90%; margin:auto">
    <table style="width:100%">
      <tr>
        <td style="width:20%; border:none"><img src="Amasya.gif" width="100" /></td>
         <td class="header">T.C.<br />
          AMASYA ÜNİVERSİTESİ<br />
          Amasya Teknik Bilimler Meslek Yüksekokulu Müdürlüğü<br />
        <br />
STAJ BAŞVURU FORMU
        </td>
        </tr>
    </table>
  </div>
  <!-- ================= 1. Bolum ==================== -->
  <div style="width:90%; margin:auto">
    <table style="width:100%">
      <tr>
        <td style="height:50px;">1.Bölüm</td>
        <td colspan="3">ENDÜSTRİYE DAYALI EĞİTİM YAPACAK ÖĞRENCİYE AİT BİLGİLER</td>
      </tr>
      <tr>
        <td colspan="4">Öğrenci Tarafından Doldurulacaktır.</td>
      </tr>
      <tr>
        <td style="font-size:0.7em;font-weight:bold;width:15%">Programı</td>
        <td style="font-size:0.7em;font-weight:bold;width:40%">P</td>
        <td style="font-size:0.7em;font-weight:bold;width:20%">Toplam Staj İş Günü</td>
        <td style="font-size:0.7em;font-weight:bold;width:25%"></td>
      </tr>
      <tr>
        <td style="font-size:0.7em;font-weight:bold;width:15%">Adı Soyadı</td>
        <td style="font-size:0.7em;font-weight:bold;width:40%">P</td>
        <td style="font-size:0.7em;font-weight:bold;width:20%">Öğrencinin Haftada Çalışacağı Gün Sayısı</td>
        <td style="font-size:0.7em;font-weight:bold;width:25%"></td>
      </tr>
      <tr>
        <td style="font-size:0.7em;font-weight:bold;width:15%">Öğrenci Numarasıı</td>
        <td style="font-size:0.7em;font-weight:bold;width:40%">P</td>
        <td style="font-size:0.7em;font-weight:bold;width:20%">Yapılacak Staj</td>
        <td style="font-size:0.7em;font-weight:bold;width:25%"></td>
      </tr>
      <tr>
        <td style="font-size:0.7em;font-weight:bold;width:15%">T.C. Kimlik No</td>
        <td style="font-size:0.7em;font-weight:bold;width:40%">P</td>
        <td style="font-size:0.7em;font-weight:bold;width:20%">Staj Başlangıç Tarihi</td>
        <td style="font-size:0.7em;font-weight:bold;width:25%"></td>
      </tr>
      <tr>
        <td style="font-size:0.7em;font-weight:bold;width:15%">Telefon No</td>
        <td style="font-size:0.7em;font-weight:bold;width:40%">P</td>
        <td style="font-size:0.7em;font-weight:bold;width:20%">Staj Bitiş Tarihi</td>
        <td style="font-size:0.7em;font-weight:bold;width:25%">&#9745;</td>
      </tr>
      <tr>
        <td colspan="4" style="font-size:0.7em; height:100px; vertical-align:top">
          Yukarıda belirtilen tarihler arasında  20 (Yirmi) iş günlük stajımı yapacağım. 
          Staj grubu değişikliği, iş yeri değişikliği, stajdan vazgeçmem halinde ve staj süresince 
          sağlık kurumlarından alacağım raporu en geç 3 (üç) iş günü içinde Yüksekokul Müdürlüğüne
          bildireceğimi beyan ve taahhüt ediyorum. Tarih :
                                                                                                                                                      Öğrencinin İmzası
        </td>
      </tr>



    </table>
  </div>



  <div style="width:90%; margin:auto">
    <table style="width:100%; font-size:0.7em; font-weight:bold">
      <tr>
        <td colspan="4">
           <table style="width:100%">
            <tr>
              <td style="border:none; width:10%">2. Bölüm</td>
              <td style="border:none; text-align:center; vertical-align:middle">ENDÜSTRİYE DAYALI EĞİTİM YAPILACAK YERE AİT BİLGİLER </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="font-size:0.8em; font-weight:normal; font-style:italic; text-align:center">Staj Yapılacak İş Yeri Tarafından Doldurulacaktır.</td>
      </tr>
      <tr>
        <td style="width:20%">İŞ YERİ MERSİS NO</td>
        <td></td>
        <td>İŞ YERİ VERGİ NO</td>
        <td></td>
      </tr>
      <tr>
        <td>İŞ YERİNİN ADI / UNVANI</td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td style="height:30px">ADRESİ</td>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td>FAALİYET ALANI</td>
        <td></td>
        <td style="width:15%">TELEFON NO</td>
        <td></td>
      </tr>

      <tr>
        <td>E-POSTA</td>
        <td></td>
        <td>FAX NO</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4">
          <table style="width:100%;">
            <tr class="calisanlar">
              <td>YÖNETİCİ</td>
              <td></td>
              <td>MÜHENDİS</td>
              <td></td>
              <td>TEKNİKER</td>
              <td></td>
              <td>TEKNİSYEN</td>
              <td></td>
              <td>İŞÇİ</td>
              <td></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="text-align:center; vertical-align:middle; height:25px">
          3308 Sayılı Mesleki Eğitim Kanunu Geçici 12. Maddesi Uyarınca Aşağıdaki Bilgilerin Doldurulması Gerekmektedir.
        </td>
      </tr>
      <tr>
        <td rowspan="2">İşyerinde Öğrenciye Ücret Ödemesi Yapılacak mı?(Mutlaka Belirtilmesi Gerekir)</td>
        <td rowspan="2"></td>
        <td colspan="2">Ücret Ödemesi Yapılacaksa Personel Sayısı Bildirilmesi Zorunludur.</td>
      </tr>
      <tr>
        <td>İşletmede Çalışan Personel Sayısı</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2" style="height:60px">
          Yukarıda bilgileri bulunan öğrencinin belirtilen tarihler
           arasında Kurumumuzda/İşletmemizde staj yapması uygundur.
        </td>
        <td colspan="2"></td>
      </tr>
    </table>
  </div>

<!-- =========================== 3. Bolum ====================== -->
  <div style="width:90%; margin:auto">
    <table style="width:100%; font-size:0.7em; font-weight:bold">
      <tr>
        <td>  
          <table style="width:100%">
            <tr>
              <td style="border:none; width:10%">3. Bölüm</td>
              <td style="border:none; text-align:center; vertical-align:middle">BÖLÜM STAJ ONAYI</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>Öğrencinin Danışmanı veya Bölüm Başkanı tarafından onaylanacaktır.</td>
      </tr>
      <tr>
        <td style="height:50px">Öğrencinin, yukarıda bilgileri yer alan kurumda/işletmede staj yapması uygundur.</td>
      </tr>
    </table>
  </div>
  <div style="width:90%; margin:auto">
    <table class="aciklamalar" style="width:100%; font-size:0.7em;">
      <tr>
        <td>1)</td>
        <td>Öğrencimizin iş yerinizde staj yapmasının uygun görülmesi durumunda, bu formun tarafınızca onaylanması gerekmektedir.</td>
      </tr>
      <tr>
        <td>2)</td>
        <td>Silinti, kazıntı, tahribat veya tahrifat yapılmış belgeler işleme alınmayacaktır. Lütfen belge üstünde tahribat veya tahrifat yapmayınız.    Eğer bu form öğrenci tarafından tahrip veya tahrif edilmiş şekilde iş yerinize ulaştırılmışsa lütfen onaylamayarak formun yenilenmesini sağlayınız.</td>
      </tr>
      <tr>
        <td>3)</td> 
        <td>5510 sayılı Sosyal Sigortalar ve Genel Sağlık Sigortası Kanunu’nun 5. maddesinin (b) bendi gereğince öğrencimizin zorunlu iş kazası ve meslek hastalığı sigorta primleri kurumumuzca ödenecektir.</td>
      </tr>
      <tr>
        <td>4)</td>
        <td>Zorunlu İş Yeri Kaza ve Meslek Hastalığı Sigortası Müdürlüğümüze bildirilen tarihlere göre yapıldığından mazeretsiz olarak devam edilmeyen günler için öğrenci ve iş yerleri sorumlu olacaktır. Staj sonuna eklenmeyecektir. Müdürlüğümüzün bilgisi dışında yapılan stajlar esnasında gerçekleşebilecek iş kazalarında sorumluluk öğrenciler ve iş yerlerine aittir.</td>
      </tr>
      <tr>
        <td>5)</td>
        <td>Öğrencilerimiz, toplam staj süresinin %10’undan fazla devamsızlık yapması halinde BAŞARISIZ sayılacaktır.</td>
      </tr>
      <tr>
        <td>6)</td>
        <td>Öğrencinin staja devamını takip ederek devam-devamsızlık durumunu staj sonunda Staj Sicil ve Değerlendirme Formu’na işleyiniz.</td>
      </tr>
      <tr>
        <td>7)</td>
        <td>Staj işlemleri hakkında detaylı bilgi için lütfen tbmyo.amasya.edu.tr adresini ziyaret ediniz.</td>
      </tr>









    </table>
  </div>

 
 
</body>
</html>
CIKTI;
$mpdf->WriteHTML($cikti);
//$mpdf->WriteHTML('<table style="border:2px double black"><tr><td>Hello woşşıığd!</td></tr></table>');
$mpdf->Output();
?>
