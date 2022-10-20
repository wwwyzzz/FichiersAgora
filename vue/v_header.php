﻿<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="sio">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>AgorA - Administration</title>

  <!-- Bootstrap core CSS -->
  <link href="web/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="web/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- <link href="web/lib/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" /> -->
  <!-- Custom styles for this template -->
  <link href="web/css/style.css" rel="stylesheet">
  <link href="web/css/style-responsive.css" rel="stylesheet">
  <link href="web/css/styleAgora.css" rel="stylesheet">

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="index.php" class="logo"><b>Ago<span>rA</span></b></a>
      <!--logo end-->
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
        <?php
// Si aucun utilisateur connecté, on affiche la demande de connexion
if (!isset($_SESSION['idUtilisateur'])){
   echo '<li><a class="logout" href="index.php?uc=connexion&action=demanderConnexion">Se connecter</a></li>';
} 
else { 
   echo '<a href="" class="userAgo">'.$_SESSION["prenomUtilisateur"].' '.$_SESSION["nomUtilisateur"].'</a>';
   echo '<li><a class="logout" href="index.php?uc=deconnexion&action=demanderDeconnexion">Se déconnecter</a></li>';
}
?>


        </ul>
      </div>
    </header>
    <!--header end-->
