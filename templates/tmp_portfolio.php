<?php

DatabaseConnect();
$messages = new TTextList($GLOBALS['connection']);

if(isset($_POST["msgdelete"])){
    $messages->delete(htmlspecialchars($_POST["msgdelete"]));
}

if(isset($_POST["msearch"])){
    $taggedRes = $messages->getByTag($_POST["msearch"]);
}


//handling messages list pagination
if(!isset($_SESSION["CurrentPage"])){
    $_SESSION["CurrentPage"]=1;
}
else{
    if(isset($_POST["prevpage"])
    && $_SESSION["CurrentPage"]>1){
        $_SESSION["CurrentPage"]--;
    }    
    if(isset($_POST["msearch"])){
        if(isset($_POST["nextpage"])
        && $_SESSION["CurrentPage"]<(ceil(count($taggedRes)/PAGE_SIZE))){
            $_SESSION["CurrentPage"]++;
        }
    }
    else{
        if(isset($_POST["nextpage"])
        && $_SESSION["CurrentPage"]<(ceil($messages->getListLength()/PAGE_SIZE))){
            $_SESSION["CurrentPage"]++;
        }
    }
}

?>

<section class="user-s1 mdc-layout-grid mdc-layout-grid__inner bg-white p-0 minh-30vh">
    <div class="mdc-layout-grid__cell--span-12  mdc-layout-grid__cell--align-bottom text-center bg-white opacity-8 border-t border-gray">
        <div class="font-logo text-black p-1">
            <h4 class="font-bold m-0">Portfolio list</h4>
        </div>
    </div>
</section>  
<section class="user-s2 mdc-layout-grid minh-70vh flex border-t">
    <div class="mdc-layout-grid__inner w-100">
        <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-2-tablet mdc-layout-grid__cell--span-3-desktop">
            <form action=""
                autocomplete="off"
                class="mdc-list bg-white border border-gray p-0"
                method="post">
                <div class="mdc-list-item p-0 border-b border-gray">
                    <span class="mdc-list-item__ripple"></span>
                    <input class="mdc-button w-100 text-gray"
                        name="dashboard"
                        type="submit"
                        value="Dashboard">  
                </div>
                <div class="mdc-list-item p-0 border-b border-gray">
                    <span class="mdc-list-item__ripple"></span> 
                    <input class="mdc-button w-100 text-gray"
                        name="portfolio"
                        type="submit"
                        value="Portfolio">
                </div>
                <?php 
                    if(isset($_SESSION["UserLogged"])
                    && $_SESSION["UserLogged"]==="administrator"){
                ?>  
                <div class="mdc-list-item p-0 border-b border-gray">
                    <span class="mdc-list-item__ripple"></span> 
                    <input class="mdc-button w-100 text-gray"
                        name="users"
                        type="submit"
                        value="Users">
                </div>
                <?php } ?> 
                <div class="mdc-list-item p-0">
                    <span class="mdc-list-item__ripple"></span> 
                    <input class="mdc-button w-100 text-gray"
                        name="logout"
                        type="submit"                                
                        value="Logout">       
                </div>
            </form>
        </div>
        <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-6-tablet mdc-layout-grid__cell--span-9-desktop">
            <div class="mdc-card w-100 h-100 border border-gray p-2">
                <form action=""
                    autocomplete="off"
                    class="w-100 h-100"
                    method="post">
                    <div class="w-100 p-2 mdc-card--outlined mb-2">
                        <label class="text-gray pb-2">Find</label>
                        <div class="text-center">
                            <input class="form-control text-center w-80"
                                name="msearch"
                                tabindex="1"
                                type="text">
                            <button class="mdc-button text-gray"
                                name="msgsearch"
                                tabindex="2"
                                type="submit">
                                <span class="mdc-button__ripple"></span>
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="w-100 mb-3">
                        <button class="mdc-button mdc-button--outlined text-gray float-left mr-2"
                            name="editportfolio"
                            type="submit">
                            New
                        </button>
                        <button class="mdc-button mdc-button--outlined text-gray float-left"
                            name="messages"
                            type="submit">
                            <span class="mdc-button__ripple"></span>
                            Show All
                        </button>
                        <div class="float-right">
                            <button class="mdc-button text-gray btn-sm"
                                name="prevpage"
                                type="submit">
                                <span class="mdc-button__ripple"></span>
                                &lt;                                
                            </button>
                            <span class="text-gray">
                                <?php     
                                    if(isset($_POST["msearch"])){
                                        if(isset($_SESSION["CurrentPage"])){
                                            echo $_SESSION["CurrentPage"]." / ".(ceil(count($taggedRes)/PAGE_SIZE)==0)?"1":ceil(count($taggedRes)/PAGE_SIZE);
                                        } 
                                    }
                                    else{
                                        if(isset($_SESSION["CurrentPage"])){
                                            echo $_SESSION["CurrentPage"]." / ".(ceil($messages->getListLength()/PAGE_SIZE)==0)?"1":ceil(count($taggedRes)/PAGE_SIZE);
                                        }     
                                    }                            
                                ?>
                            </span>
                            <button class="mdc-button text-gray btn-sm"
                                name="nextpage"
                                type="submit">
                                <span class="mdc-button__ripple"></span>
                                &gt;
                            </button>
                        </div>
                    </div>  
                    <div class="w-100 d-inline-block mb-3">
                        <table class="mdc-data-table__table w-100">
                            <thead>
                                <tr class="mdc-data-table__header-row border-b border-gray">
                                    <th class="mdc-data-table__header-cell text-gray w-40px p-1">ID</th>
                                    <th class="mdc-data-table__header-cell text-gray">title</th>
                                    <th class="mdc-data-table__header-cell text-gray" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(isset($_POST["msearch"])){
                                        $tab = $taggedRes;
                                    }
                                    else{    
                                        $tab = $messages->getList();
                                    }
                                    $pstart = ($_SESSION["CurrentPage"]-1)*PAGE_SIZE;
                                    $pend = $pstart+(PAGE_SIZE);
                                    for($i=$pstart;$i<count($tab) && $i<$pend;$i++){
                                        echo "<tr  class=\"mdc-data-table__row\">".
                                            "<td class=\"mdc-data-table__cell p-1\">".
                                            $tab[$i]["id"]."</td>".
                                            "<td class=\"mdc-data-table__cell\">".
                                            ucwords($tab[$i]["title"])." ".
                                            "</td>".
                                            "<td class=\"mdc-data-table__cell p-0\">".
                                            "<button type='submit' name='msgdelete' class='mdc-button mdc-button--outlined text-gray float-right minw-30px' value='".$tab[$i][0]."'>X</button>".
                                            "<button type='submit' name='editportfolio' class='mdc-button mdc-button--outlined text-gray float-right minw-30px' value='".$tab[$i][0]."'>Edit</button>".                                            
                                            "</td></tr>";
                                    }
                                ?>    
                            </tbody>
                        </table>   
                    </div>  
                    <div class="w-100 mb-3">
                        <button class="mdc-button mdc-button--outlined text-gray float-left"
                            name="messages"
                            type="submit">
                            <span class="mdc-button__ripple"></span>
                            Show All
                        </button>
                        <div class="float-right">
                            <button class="mdc-button text-gray btn-sm"
                                name="prevpage"
                                type="submit">
                                <span class="mdc-button__ripple"></span>
                                &lt;                                
                            </button>
                            <span class="text-gray">
                                <?php     
                                    if(isset($_POST["msearch"])){
                                        if(isset($_SESSION["CurrentPage"])){
                                            echo $_SESSION["CurrentPage"]." / ".(ceil(count($taggedRes)/PAGE_SIZE)==0)?"1":ceil(count($taggedRes)/PAGE_SIZE);
                                        } 
                                    }
                                    else{
                                        if(isset($_SESSION["CurrentPage"])){
                                            echo $_SESSION["CurrentPage"]." / ".(ceil($messages->getListLength()/PAGE_SIZE)==0)?"1":ceil(count($taggedRes)/PAGE_SIZE);
                                        }     
                                    }                            
                                ?>
                            </span>
                            <button class="mdc-button text-gray btn-sm"
                                name="nextpage"
                                type="submit">
                                <span class="mdc-button__ripple"></span>
                                &gt;
                            </button>
                        </div>
                    </div>           
                </form>
            </div>
        </div>
    </div>
</section>