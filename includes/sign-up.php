<form action="<?php echo htmlspecialchars("src/verify.php");?>" method="post">
    <?php
        if (!empty($formErr)) {
            ?>
            <div class="alert alert-danger" role="alert">
    <p id="sign-up-error" class=""><?php echo $formErr; ?></p>
    </div>
    <?php
        }
    ?>
    First Name
    <input type="text" name="firstname" id="firstname">
    Last Name
    <input type="text" name="lastname" id="lastname">
    Email
    <input type="email" name="email" id="">
    Password
    <input type="password" name="password" id="sign-up-password">
    Confirm Password
    <input type="password" name="password-verify" id="sign-up-password-check">
    <input type="hidden" name="sign-up">
    <p id="pass-match"></p>
    <button id="sign-up-submit" type="submit" name="sign-up-submit">Submit</button>
</form>
<a href="?input=login"><button>Login</button></a>
<script src="js/passcheck.js"></script>
