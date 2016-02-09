<!--/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */-->

 <div class="login_header">
    <h1>Login</h1>
</div>
<div class="login_text">
    <span><b>Please sign in to use the administrative section.</b></span>
</div>
<div class="login_form">
    <div class="login_form__explanation">
        <h1>How to Login</h1>
        <h3>Type in your Username and Password and press Login.</h3>
    </div>
    <div class="login_form__login">
        <form method="post" action="index.php?m=home">
            <div class="login_form_input">
                <span class="login_form_text">Username</span>
                <input class="login_input" name="Username_Post" />
            </div>
            <div class="login_form_input">
                <span class="login_form_text">Password</span>
                <input class="login_input" type="password" name="Password_Post" />
            </div>
            <div class="login_form_submit">
                <button class="submit_button">Login</button>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
</div>