<?php
/*
style.php
This is the landing page.

Created: 10/31/2018
Author: eCommerce
Original Source: https://www.w3schools.com/bootstrap/bootstrap_theme_company.asp
*/

header("Content-type: text/css");

$primary = "#99cc99";//#f4511e
$light = "#f6f6f6";//#f6f6f6

?>



  body {
      font: 400 15px Lato, sans-serif;
      line-height: 1.8;
      color: #818181;
  }
  h2 {
      font-size: 24px;
      text-transform: uppercase;
      color: #303030;
      font-weight: 600;
      margin-bottom: 30px;
  }
  h4 {
      font-size: 19px;
      line-height: 1.375em;
      color: #303030;
      font-weight: 400;
      margin-bottom: 30px;
  }  
  .jumbotron, footer {
      margin: auto;
      background-color: <?php echo $primary; ?>;
      color: #fff;
      padding: 100px 25px;
      font-family: Montserrat, sans-serif;
  }
  .container-fluid {
      padding: 20px 30px;
  }
  .bg-light {
      background-color: <?php echo $light; ?>;
  }
  .logo-small {
      color: <?php echo $primary; ?>;
      font-size: 50px;
  }
  .logo {
      color: <?php echo $primary; ?>;
      font-size: 200px;
  }
  .thumbnail {
      padding: 0 0 15px 0;
      border: none;
      border-radius: 0;
  }
  .thumbnail img {
      width: 100%;
      height: 100%;
      margin-bottom: 10px;
  }
  .carousel-control.right, .carousel-control.left {
      background-image: none;
      color: <?php echo $primary; ?>;
  }
  .carousel-indicators li {
      border-color: <?php echo $primary; ?>;
  }
  .carousel-indicators li.active {
      background-color: <?php echo $primary; ?>;
  }
  .item h4 {
      font-size: 19px;
      line-height: 1.375em;
      font-weight: 400;
      font-style: italic;
      margin: 70px 0;
  }
  .item span {
      font-style: normal;
  }
  .panel {
      border: 1px solid <?php echo $primary; ?>; 
      border-radius:0 !important;
      transition: box-shadow 0.5s;
  }
  .panel:hover {
      box-shadow: 5px 0px 40px rgba(0,0,0, .2);
  }
  .panel-footer .btn:hover {
      border: 1px solid <?php echo $primary; ?>;
      background-color: #fff !important;
      color: <?php echo $primary; ?>;
  }
  .panel-heading {
      color: #fff !important;
      background-color: <?php echo $primary; ?> !important;
      padding: 25px;
      border-bottom: 1px solid transparent;
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
      border-bottom-left-radius: 0px;
      border-bottom-right-radius: 0px;
  }
  .panel-footer {
      background-color: white !important;
  }
  .panel-footer h3 {
      font-size: 32px;
  }
  .panel-footer h4 {
      color: #aaa;
      font-size: 14px;
  }
  .panel-footer .btn {
      margin: 15px 0;
      background-color: <?php echo $primary; ?>;
      color: #fff;
  }
  .navbar {
      margin-bottom: 0;
      background-color: <?php echo $primary; ?>;
      z-index: 9999;
      border: 0;
      font-size: 12px !important;
      line-height: 1.42857143 !important;
      letter-spacing: 4px;
      border-radius: 0;
      font-family: Montserrat, sans-serif;
  }
  .navbar li a, .navbar .navbar-brand {
      color: #fff !important;
  }
  .navbar-nav li a:hover, .navbar-nav li.active a {
      color: <?php echo $primary; ?> !important;
      background-color: #fff !important;
  }
  .navbar-default .navbar-toggle {
      border-color: transparent;
      color: #fff !important;
  }
  footer .glyphicon {
      font-size: 20px;
      margin-bottom: 20px;
      color: <?php echo $light; ?>;
  }
  .slideanim {visibility:hidden;}
  .slide {
      animation-name: slide;
      -webkit-animation-name: slide;
      animation-duration: 1s;
      -webkit-animation-duration: 1s;
      visibility: visible;
  }
  @keyframes slide {
    0% {
      opacity: 0;
      transform: translateY(70%);
    } 
    100% {
      opacity: 1;
      transform: translateY(0%);
    }
  }
  @-webkit-keyframes slide {
    0% {
      opacity: 0;
      -webkit-transform: translateY(70%);
    } 
    100% {
      opacity: 1;
      -webkit-transform: translateY(0%);
    }
  }
  @media screen and (max-width: 768px) {
    .col-sm-4 {
      text-align: center;
      margin: 25px 0;
    }
    .btn-lg {
        width: 100%;
        margin-bottom: 35px;
    }
  }
  @media screen and (max-width: 480px) {
    .logo {
        font-size: 150px;
    }
  }
  

	
	
.card {
  background-color: rgba(255,255,255,0.8);
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  height: 600px;
  max-height: 600px;
  margin: 1rem;
  overflow-y: scroll;
  text-align: center;
  font-family: arial;
  padding: 0 !important;
  z-index: 2;
  color:black;
  transition: .3s all;
}

.card:hover{
  background-color: rgba(255,255,255,1);
  box-shadow: 0 6px 10px 0 rgba(0,0,0, 0.7);
  transition: .5s all;
}

.price {
  color: black;
  font-size: 22px;
  z-index: 3;
}

.card a.btn {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card a.btn:hover {
  opacity: 0.7;
}

.card img{
  max-height: 300px;
  height: 300px;
}

#cardbg{
  background-image: url("imgs/cardbg.jpg");
  background-size: cover;
  height: 100%;
  background-position: center;
  background-attachment: fixed;
  
}







