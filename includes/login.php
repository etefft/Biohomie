   <!-- PAGE INFO -->

    <!-- This page has code that will be used for any type of login -->


<div id="login-form">
    <?php
        var_dump($_SESSION);
    ?>
    <form action="<?php echo htmlspecialchars("src/verify.php");?>" method="post">
    <?php
        if (!empty($formErr)) {
            ?>
            <div class="alert alert-danger" role="alert">
    <p id="login-error" class=""><?php echo $formErr; ?></p>
    </div>
    <?php
        }
    ?>
    
       
        Email
        <input type="email" name="email" id="" required>
        Password
        <input type="password" name="password" id="" required>
        <input type="hidden" name="login">
        <a href="">Forgot Password</a>
        <button type="submit" name="login-submit">Submit</button>
    </form>
    <a href="?input=signup"><button>Sign up</button></a>
</div>