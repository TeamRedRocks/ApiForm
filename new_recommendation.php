<?php include '.config.php'; ?>
<html>
    <head>
        <?php echo $head; ?>
    </head>
    <body>
        <div class='container'>
            <?php echo $navbar; ?>
            <h1>Create new recommendation</h1>
            <form action="<?php echo api('/recommendations'); ?>" method="POST">
                <input type="text" name="key" placeholder="recommendation key" />
                <input type="text" name="nutrient" placeholder="relevant nutrient" />
                <input type="text" name="recommendation" placeholder="recommendation message" />
                <input type="text" name="datasource" placeholder="data source" />
                <input type="submit">
            </form>
            <?php echo $footer; ?>
        </div>
    </body>
</html>