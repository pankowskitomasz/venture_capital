<section class="user-s1 mdc-layout-grid mdc-layout-grid__inner bg-white p-0 minh-30vh">
    <div class="mdc-layout-grid__cell--span-12  mdc-layout-grid__cell--align-bottom text-center bg-white opacity-8 border-t border-gray">
        <div class="font-logo text-black p-1">
            <h4 class="font-bold m-0">Dashboard</h4>
        </div>
    </div>
</section>    
<section class="user-s2 mdc-layout-grid minh-70vh flex border-t">
    <div class="mdc-layout-grid__inner w-100">
        <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-2-tablet mdc-layout-grid__cell--span-3-desktop">
            <form action=""
                autocomplete="off"
                class="mdc-list bg-white border border-blue p-0"
                method="post">
                <div class="mdc-list-item p-0 border-b border-blue">
                    <span class="mdc-list-item__ripple"></span>
                    <input class="mdc-button w-100 text-gray"
                        name="dashboard"
                        type="submit"
                        value="Dashboard">  
                </div>
                <div class="mdc-list-item p-0 border-b border-blue">
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
        <div class="mdc-layout-grid__cell--span-12-phone mdc-layout-grid__cell--span-6-tablet mdc-layout-grid__cell--span-9-desktop minh-50vh">
            <div class="mdc-card w-100 h-100 border border-blue">
                <small class="text-gray p-2">Dashboard</small>
            </div>
        </div>
    </div>
</section>