<?php
   require 'includes/degiskenler.php';
   require_once 'vendor/autoload.php';
   $filter = new Twig_Filter('diziara', 'array_search');
   $loader = new Twig_Loader_Filesystem('templates');
   $twig = new Twig_Environment($loader, array('debug' => true));
   $twig->addFilter($filter);
   $twig->addExtension(new Twig_Extension_Debug());

   $template = $twig->load('stajformu/staj-formu.twig');
   echo $twig->render('stajformu/staj-formu.twig', array(
      'bolumprogram'    => $bolum_ve_programlar,
      'stajdonemtarih'  => $staj_donem_ve_tarih,
      'haftalikgun'     => $haftalik_gun,
      'ucret'           => $ucret)
   );
?>

