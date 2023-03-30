<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <?php echo link_tag("app.css") ?>
    <!-- Latest compiled and minified JavaScript -->

</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <br><br>
            </div>
            <div class="col-md-12" id="error_div" style="display:none">

                <div class="alert alert-danger">
                    
                    <h5><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Error!</h5>
                    <p id="error_msg"></p>
                </div>
            </div>

            <form id="login" method="post" name="login_form">
                <div class="row">
                    <input type="text" id="username" class="fadeIn second" name="username" placeholder="username" required>
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="password" required>
                </div>
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>
            <div class="col-md-12" id="success_div" style="display:none">

                <div class="alert alert-success">
                    
                    <h3><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Success!</h3>
                </div>
                    <br><br><br><br>
            </div>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="<?= base_url('/register') ?>">Register</a>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        const AES_ENCRYPTION_KEY = CryptoJS.enc.Base64.parse("<?= AES_ENCRYPTION_KEY ?>");
        const AES_IV = CryptoJS.enc.Base64.parse("<?= AES_IV ?>");
        const SALT = "<?= SALT ?>";
    </script>
    <?php echo script_tag("application.js"); ?>
</body>

</html>