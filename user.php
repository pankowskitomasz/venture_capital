<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();   
}

include_once "php/comm.php";
include_once "php/db.php";
include_once "php/t_text_list.php";
include_once "php/t_user.php";

//to remove after pub
//include_once "php/support.php";
//createAdminAccount("password","admin@mussodent.com","9731");

if(isset($_POST["username"])
&& isset($_POST["userpass"])){
    DatabaseConnect();
    $usr = new TUser($GLOBALS['connection']);   
    $usr->getByName(htmlspecialchars($_POST["username"]));
    if($usr->getData("username")===htmlspecialchars($_POST['username'])
    && $usr->getData("password")===sha1(htmlspecialchars($_POST['userpass']))
    ){
        $_SESSION["UserLogged"] = $usr->getData("username");
    }
}

if(isset($_SESSION["UserLogged"])){
    //reading view config
    if(isset($_POST["login"])){
        $_SESSION["view"] = "dashboard";
    }
    if(isset($_POST["dashboard"])){
        $_SESSION["view"] = "dashboard";
    }
    if(isset($_POST["portfolio"])){
        $_SESSION["view"] = "portfolio";
    }
    if(isset($_POST["editportfolio"])){
        $_SESSION["view"] = "editportfolio";
    }
    if(isset($_POST["users"])){
        $_SESSION["view"] = "users";
    }
    if(isset($_POST["edituser"])){
        $_SESSION["view"] = "edituser";
    }
    if(isset($_POST["portfoliosearch"])){
        $_SESSION["view"] = "portfoliosearch";
    }
    if(isset($_POST["logout"])){
        $_SESSION["view"] = "logout";
    }
    
    //template selection and config
    if(isset($_SESSION["view"])){
        switch($_SESSION["view"]){
            case "portfolio":
                $_SESSION["viewTemplate"] = "templates/tmp_portfolio.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "users":
                $_SESSION["viewTemplate"] = "templates/tmp_users.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "dashboard":
                $_SESSION["viewTemplate"] = "templates/tmp_dashboard.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "editportfolio":
                $_SESSION["viewTemplate"] = "templates/tmp_editportfolio.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "portfoliosearch":
                $_SESSION["viewTemplate"] = "templates/tmp_portfolio.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "edituser":
                $_SESSION["viewTemplate"] = "templates/tmp_edituser.php";
                break;
            default: 
                $_SESSION["viewTemplate"] = "templates/tmp_login.php";     
                $_SESSION = array();
                session_destroy(); 
        }
    }
}
else{
    $_SESSION["viewTemplate"] = "templates/tmp_login.php";
}

?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
        <link rel="icon" href="img/favicon.png">
        <link rel="stylesheet" type="text/css" href="css/material-components-web.min.css">
        <link rel="stylesheet" type="text/css" href="css/styles.min.css">
        <title>e-Doctor | User</title>
    </head>
    <body">
        <header class="mdc-top-app-bar bg-transparent position-absolute">
            <div class="mdc-top-app-bar__row">
                <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                    <a href="index.html" class="font-logo">
                        <img class="navbar-logo float-left" src="img/navbar_logo.png" alt="logo">
                        <span class="font-bold text-dark text-shadow-light">
                            Venture
                        </span>
                    </a>
                </div>
                <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end d-block desktop-expand">
                    <button class="mdc-top-app-bar__action-item mdc-icon-button nav-menu-icon">
                        <div class="mdc-icon-button__ripple -mt-05"></div>
                        <span class="fa fa-bars text-gray"></span>                    
                    </button>
                    <div class="nav-menu text-right font-menu">
                        <a href="index.html" class="mdc-top-app-bar__action-item mdc-button nav-item">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label text-gray font-bold">Home</span>                    
                        </a>
                        <a href="services.html" class="mdc-top-app-bar__action-item mdc-button nav-item">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label text-gray font-bold">Services</span>                    
                        </a>
                        <a href="portfolio.html" class="mdc-top-app-bar__action-item mdc-button nav-item">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label text-gray font-bold">Portfolio</span>                    
                        </a>
                        <a href="contact.html" class="mdc-top-app-bar__action-item mdc-button nav-item">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label text-gray font-bold">Contact</span>                    
                        </a>
                        <a href="user.php" class="mdc-top-app-bar__action-item mdc-button nav-item">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label text-gray font-bold">Login</span>                    
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <main  class="minh-100vh">
            <?php
                if(isset($_SESSION["viewTemplate"])){
                    include $_SESSION["viewTemplate"]; 
                }
                else{
                    include "templates/tmp_login.php";                            
                }
            ?>
        </main>
        <footer class="mdc-layout-grid mdc-layout-grid__inner bg-black text-white border-t border-gray pb-0">
            <div class="mdc-layout-grid__cell--span-12 text-dark text-center">
                <img class="navbar-logo filter-invert" src="img/navbar_logo.png" alt="logo">
                <div class="font-bold text-white font-logo">
                    <small>Venture</small>
                </div>
            </div>
            <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-8-tablet mdc-layout-grid__cell--span-4-desktop text-white text-center border-t border-gray">
                <h3>
                    <small>Visit Us</small>
                </h3>
                <p class="text-white text-md">
                    <small>
                        266 Lake Blvd, Hayward<br/>
                        New York, NY 10010 
                    </small>    
                </p>
            </div>
            <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-8-tablet mdc-layout-grid__cell--span-4-desktop text-white text-center border-t border-gray">                
                <h3>
                    <small>Call Us</small>
                </h3>
                <p class="text-white text-md">
                    <small>
                        +1 181 264 4300<br/>
                        +1 181 264 3245
                    </small>
                </p>
            </div>
            <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-8-tablet mdc-layout-grid__cell--span-4-desktop text-white text-center border-t border-gray">
                <h3>
                    <small>Email Us</small>
                </h3>
                <p class="text-white text-md">
                    <small>
                        mail@venture.com<br/>
                        support@venture.com                  
                    </small>
                </p>
            </div>
            <div class="mdc-layout-grid__cell--span-12 text-center border-t border-gray">
                <small class="text-white">  
                    Copyright &copy; 2020-2021 Tomasz Pankowski. All rights reserved.
                    <a class="text-white link" href="privacy.html">Privacy policy</a>
                </small>
            </div>
        </footer>
    <script src="js/main.min.js"></script>
    <script src="js/material-components-web.min.js"></script>
    </body>
</html>