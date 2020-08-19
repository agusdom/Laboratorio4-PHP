
<div><label style="width:100%; padding: 20px; text-align:center; font-size: 25px; font-weight: bold; color: darkslateblue; box-sizing: border-box;" for="">REGISTRARSE</label></div>

<form action="<?php echo FRONT_ROOT; ?>Login/Add" method="post">
    <table class="modifyList" style="margin:  auto; width:35%">
        <tr>
            <th colspan="2">SIGN UP</th>
        </tr>
        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" required></td>
        </tr>
        <tr>
            <td>LastName:</td>
            <td><input type="lastname" name="lastname" required></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password" required></td>
        </tr>
        <tr>
        <td>Confirm Password:</td>
            <td><input type="password" name="password_confirm" required="required"  id="password_confirm" oninput="check(this)" /></td>
        
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="btnCargar" value="Ingresar"></td>
        </tr>
        <tr> <td colspan="2"><a href="<?php echo FRONT_ROOT; ?>Login/Index">Volver al Login</a></td> </tr>
    </table>
</form>

<script language='javascript' type='text/javascript'>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
</script>

