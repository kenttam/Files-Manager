<html>
<head>
    <title>Facebook Sweetness</title>
</head>
<body>
    <h1>Not Logged in Login Fool</h1>

    <?php if (@$user_profile): ?>
        <pre>
            You don't have access to our test bank. Feel free to contact me for access.
            <!--?php echo print_r($user_profile, TRUE) ?-->
        </pre>
        <a href="#">Logout of this thing</a>
    <?php else: ?>
        <h2>Welcome to this facebook thing, please login below</h2>
        <a href="#">Login to this thing</a>
    <?php endif; ?>

</body>

</html> 