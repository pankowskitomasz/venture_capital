<?php

//initial config
DatabaseConnect();
$prt = new TTextList($GLOBALS['connection']);
$pid="";
$ptitle = "";
$pcat = "";
$pdesc = "";

$catVal=array(
    "All"=>0,
    "Financial Planning"=>1,
    "Investments Management"=>2,
    "Tax Planning"=>3
);

//handle page related actions
if(isset($_POST["editportfolio"])){
    $prt->getById(htmlspecialchars($_POST["editportfolio"]));
    $pid = $prt->getData("id");
    $ptitle = $prt->getData("title");
    $pcat = $prt->getData("category");
    $pdesc = $prt->getData("description");
}
else if(isset($_POST["saveitem"])
&& isset($_POST["ptitle"])
&& isset($_POST["pcat"])
&& isset($_POST["pdesc"])
&& !empty($_POST["ptitle"])
&& !empty($_POST["pcat"])
&& !empty($_POST["pdesc"])){
    if(isset($_POST["pid"])){
        $prt->setData("id",htmlspecialchars($_POST["pid"]));
    }    
    $prt->setData("title",htmlspecialchars($_POST["ptitle"]));
    $prt->setData("category",array_flip($catVal)[htmlspecialchars($_POST["pcat"])]);        
    $prt->setData("description",htmlspecialchars($_POST["pdesc"]));    
    $prt->save();
}

?>
<section class="user-s1 mdc-layout-grid mdc-layout-grid__inner bg-white p-0 minh-30vh">
    <div class="mdc-layout-grid__cell--span-12  mdc-layout-grid__cell--align-bottom text-center bg-white opacity-8 border-t border-gray">
        <div class="font-logo text-black p-1">
            <h4 class="font-bold m-0">
                <?php
                if($pid!=""){
                    echo "Edit item";
                }
                else{
                    echo "New item";
                }
                ?>
            </h4>
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
                    <div class="mdc-layout-grid border-b border-gray">
                        <div class="mdc-layout-grid__inner">
                            <input type="hidden" 
                                name="pid" 
                                value="<?php echo $pid; ?>">
                            <div class="mdc-layout-grid__cell--span-4-phone mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-3-desktop">
                                <label class="text-gray w-100">Title:</label>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4-phone mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-9-desktop">
                                <input class="form-control text-center w-100"
                                    name="ptitle"
                                    type="text"
                                    tabindex="1"
                                    value="<?php echo $ptitle; ?>">
                            </div>
                            <div class="mdc-layout-grid__cell--span-4-phone mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-3-desktop">
                                <label class="text-gray w-100">Category:</label>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4-phone mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-9-desktop">                                                                
                                <select class="w-100 text-md outline-none"
                                    name="pcat"
                                    tabindex="2">
                                    <option value="0" <?php if(isset($catVal[$pcat]) && $catVal[$pcat]=="0")echo "selected"; ?>>
                                        All
                                    </option>
                                    <option value="1" <?php if(isset($catVal[$pcat]) && $catVal[$pcat]=="1")echo "selected"; ?>>
                                        Financial Planning
                                    </option>
                                    <option value="2" <?php if(isset($catVal[$pcat]) && $catVal[$pcat]=="2")echo "selected"; ?>>
                                        Investments Management
                                    </option>
                                    <option value="3" <?php if(isset($catVal[$pcat]) && $catVal[$pcat]=="3")echo "selected"; ?>>
                                        Tax Planning
                                    </option>
                                </select>
                            </div>   
                            <div class="mdc-layout-grid__cell--span-4-phone mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-3-desktop">
                                <label class="text-gray w-100">Description:</label>
                            </div>
                            <div class="mdc-layout-grid__cell--span-4-phone mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-9-desktop mb-3">
                                <textarea class="form-control text-center w-100 border-gray text-left"
                                    name="pdesc"
                                    tabindex="3"><?php echo $pdesc; ?></textarea>
                            </div>  
                            <div class="mdc-layout-grid__cell--span-12">
                                <div class="w-100 mb-2">
                                    <small class="text-center">
                                        *Fields cannot be empty, otherwise changes will not be saved
                                    </small>
                                </div>
                                <div class="w-100 p-1">
                                    <button class="mdc-button mdc-button--outlined text-gray float-left border-gray"
                                        name="portfolio"
                                        tabindex="7"
                                        type="submit">
                                        Back
                                    </button>
                                    <button class="mdc-button mdc-button--outlined text-gray float-right border-gray"
                                        name="saveitem"
                                        tabindex="5"
                                        type="submit">
                                        Save
                                    </button>
                                    <button class="mdc-button mdc-button--outlined text-gray float-right border-gray mr-1"
                                        name="clearform"
                                        tabindex="6"
                                        type="clear">
                                        Clear
                                    </button>
                                </div>
                            </div>            
                        </div>
                    </div>           
                </form>
            </div>
        </div>
    </div>
</section>