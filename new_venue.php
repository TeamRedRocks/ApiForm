<?php include '.config.php'; ?>
<html>
    <head>
        <?php echo $head; ?>
    </head>
    <body>
        <div class='container'>
            <?php echo $navbar; ?>
            <h1>Create new venue</h1>
            <form action="<?php echo api('/venues'); ?>" method="POST">
                <input type="text" name="name" placeholder="new venue name" />
                <input type="submit">
            </form>
            <?php echo $footer; ?>
        </div>
    </body>
</html>