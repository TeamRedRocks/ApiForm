<?php include '.config.php'; ?>
<html>
    <head>
        <?php echo $head; ?>
        <script>
            var baseUrl = '<?php echo $baseurl; ?>';
            function validateForm()
            {
                var form = document.forms["newMeal"];
                form.action = baseUrl + "/venues/" + form["venueid"].value + "/meals";
                return true;
            }
        </script>
    </head>
    <body>
        <div class='container'>
            <?php echo $navbar; ?>
            <h1>Create new meal</h1>
            <form name="newMeal" action="" method="POST" onsubmit="return validateForm()">
                <input type="text" name="venueid" placeholder="venue id" />
                <input type="text" name="name" placeholder="new meal name" />
                <input type="text" name="servingsizeoz" placeholder="serving size (oz)" /><br /><br />
                <textarea rows="8" cols="50" name="nutritionvaluesjson" placeholder="nutrition values json"></textarea><br /> <br />
                <input type="submit">
            </form>
            <?php echo $footer; ?>
        </div>
    </body>
</html>