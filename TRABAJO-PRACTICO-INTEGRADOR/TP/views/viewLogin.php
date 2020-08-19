<div><label style="width:100%; padding: 20px; text-align:center; font-size: 25px; font-weight: bold; color: darkslateblue; box-sizing: border-box;" for="">GO TO EVENT</label></div>
    <form action="<?php echo FRONT_ROOT; ?>Login/Login" method="post">
    
        <table class="modifyList" style="margin: auto; width:20%">
            <tr>
                <th colspan="2">LOGIN</th>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" ></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" ></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="btnCargar" value="Ingresar"></td>
            </tr>
            <tr>
                <td colspan="2"><a href="<?php echo FRONT_ROOT; ?>Login/ShowAddUserView "> Registrarse</a></td>
            </tr>
            
        </table>
    </form>
    <br>
    <div class="container1" style="float:right; margin: auto">
        <div class="fb-login-button" data-width="12" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
        </div>

   

