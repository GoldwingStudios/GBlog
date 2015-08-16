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
    <span><b>Bitte melden Sie sich an, um den Administrationsbereich zu benutzen.</b></span>
</div>
<div class="login_form">
    <div class="login_form__login">
        <form method="post" action="index.php?m=home">
            <div class="login_form_input_usr">
                <span class="login_form_text">Benutzername:</span><br/>
                <?php
                if (USER_LOGIN_ERROR) {
                    ?>
                    <input class="login_input_red" name="Username_Post" />
                    <?php
                } else {
                    ?>
                    <input class="login_input" name="Username_Post" />
                    <?php
                }
                ?>
            </div>
            <div class="login_form_input_psw">
                <span class="login_form_text">Passwort:</span><br/>
                <?php
                if (USER_LOGIN_ERROR) {
                    ?>
                    <input class="login_input_red" type="password" name="Password_Post" />
                    <?php
                } else {
                    ?>
                    <input class="login_input" type="password" name="Password_Post" />
                    <?php
                }
                ?>
            </div>
            <div class="login_form_submit">
                <input type="image" src="./assets/images/login/login_submit.png" />
            </div>
        </form>
    </div>
    <div class="login_form__explanation">
        <h1>How to Login</h1>
        <h3>Type in your Username / Password and press Login.</h3>
    </div>
</div>