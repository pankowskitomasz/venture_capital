<?php

DatabaseConnect();
$usr = new TUser($GLOBALS['connection']);

if(isset($_POST["deleteuser"])){
    $usr->deleteUser(htmlspecialchars($_POST["deleteuser"]));
}

//handle user list pagination
if(!isset($_SESSION["CurrentPage"])){
    $_SESSION["CurrentPage"]=1;
}
else{
    if(isset($_POST["prevpage"])
    && $_SESSION["CurrentPage"]>1){
        $_SESSION["CurrentPage"]--;
    }
    if(isset($_POST["nextpage"])
    && $_SESSION["CurrentPage"]<(ceil($usr->getListLength()/PAGE_SIZE))){
        $_SESSION["CurrentPage"]++;
    }
}

?>

<section class="user-s1 mdc-layout-grid mdc-layout-grid__inner bg-white p-0 minh-30vh">
    <div class="mdc-layout-grid__cell--span-12  mdc-layout-grid__cell--align-bottom text-center bg-white opacity-8 border-t border-gray">
        <div class="font-logo text-black p-1">
            <h4 class="font-bold m-0">Users list</h4>
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
                    <div class="w-100 mb-3">
                        <button class="mdc-button mdc-button--outlined text-gray float-left"
                            name="edituser"
                            type="submit">
                            New user
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
                                if(isset($_SESSION["CurrentPage"])){
                                    echo $_SESSION["CurrentPage"]." / ".ceil($usr->getListLength()/PAGE_SIZE);
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
                    <div class="w-100 mb-1 text-left d-inline-block p-1">
                        <small class="text-dark-gray">
                            *Administrator account cannot be changed
                        </small>
                    </div>                    
                    <div class="w-100 d-inline-block mb-3">
                        <table class="mdc-data-table__table w-100">
                            <thead>
                                <tr class="mdc-data-table__header-row border-b border-gray">
                                    <th class="mdc-data-table__header-cell text-gray">
                                        ID
                                    </th>
                                    <th class="mdc-data-table__header-cell text-gray"
                                        colspan="2">
                                        User name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $tab = $usr->getList();
                                    $pstart = ($_SESSION["CurrentPage"]-1)*PAGE_SIZE;
                                    $pend = $pstart+(PAGE_SIZE);
                                    for($i=$pstart;$i<count($tab) && $i<$pend;$i++){
                                        $tabrow = "<tr class=\"mdc-data-table__row\">";
                                        $tabrow .= "<td class=\"mdc-data-table__cell\">";
                                        $tabrow .= $tab[$i][0]."</td>";
                                        $tabrow .= "<td class=\"mdc-data-table__cell\">";
                                        $tabrow .= $tab[$i][1]."</td><td>";
                                        if($tab[$i][1]!=="administrator"){
                                            $tabrow .= "<button type='submit' name='edituser' class='mdc-button mdc-button--outlined text-gray border-blue text-blue float-right minw-30px' value='";
                                            $tabrow .= $tab[$i][0]."'>Edit</button>";
                                            $tabrow .= "<button type='submit' name='deleteuser' class='mdc-button mdc-button--outlined text-gray border-blue text-blue float-right minw-30px' value='";
                                            $tabrow .= $tab[$i][0]."'>&times;</button>";
                                        }
                                        $tabrow .= "</td></tr>";
                                        echo $tabrow;
                                    }
                                ?>    
                            </tbody>
                        </table>   
                    </div>  
                    <div class="w-100 mb-3">
                        <div class="float-right">
                            <button class="mdc-button text-gray btn-sm"
                                name="prevpage"
                                type="submit">
                                <span class="mdc-button__ripple"></span>
                                &lt;                                
                            </button>
                            <span class="text-gray">
                                <?php 
                                if(isset($_SESSION["CurrentPage"])){
                                    echo $_SESSION["CurrentPage"]." / ".ceil($usr->getListLength()/PAGE_SIZE);
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