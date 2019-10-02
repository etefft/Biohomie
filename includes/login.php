<div id="login-form">
    
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
        <input type="email" name="email" id="" >
        Password
        <input type="password" name="password" id="" >
        <input type="hidden" name="login">
        <a href="">Forgot Password</a>
        <button type="submit" name="login-submit">Submit</button>
    </form>
    <a href="?input=signup"><button>Sign up</button></a>
</div>