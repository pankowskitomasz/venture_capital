<section class="user-s1 mdc-layout-grid mdc-layout-grid__inner bg-white p-0 minh-50vh">
    <div class="mdc-layout-grid__cell--span-12  mdc-layout-grid__cell--align-bottom text-center bg-white opacity-8 border-t border-gray">
        <div class="font-logo text-black p-1">
            <h2 class="font-bold m-0">Sign in</h2>
        </div>
    </div>
</section>        
<section class="user-s2 mdc-layout-grid minh-50vh bg-light-gray border-t border-gray">            
    <div class="mdc-layout-grid__inner minh-50vh">
        <div class="mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--align-middle">
            <form class="text-md border border-gray p-2 mx-auto phone-w-75 tablet-w-50 desktop-w-35 bg-white"
                action=""
                autocomplete="off"
                method="POST">
                <label class="text-gray mb-1 d-block font-bold">Login</label>
                <input type="text" 
                    class="form-control w-100 text-md mb-2"
                    maxlength="80"
                    name="username"
                    placeholder="Login...">
                <label class="text-gray mb-1 d-block font-bold">Password</label>
                <input type="password" 
                    class="form-control w-100 text-md mb-2"
                    maxlength="80"
                    name="userpass"
                    placeholder="Password...">
                <div class="text-center">
                    <input type="reset"
                        class="mdc-button bg-dark text-white"
                        value="Clear">
                    <input type="submit"
                        class="mdc-button bg-dark text-white"
                        name="login"
                        value="Accept">
                </div>
            </form>
        </div>
    </div>
</section>