<?php include '.config.php'; ?>

<html>
    <head>
        <?php echo $head; ?>
    </head>
    <body>
        <div class='container'>
            <?php echo $navbar; ?>
            <h1>Venue listing</h1>
            <?php
                $json = file_get_contents(api('/venues'));
                $decode = json_decode($json, true);
                
                echo "Found " . $decode["count"] . " venues";
                
                echo "<table align='center' style='border:2px solid #B88;padding:8px;margin-top:8px;margin-bottom:8px;margin-left:auto;margin-right:auto;'>";
                echo "<tr><th>id</th><th>name</th></tr>";
                foreach($decode["venues"] as $venue)
                {
                    echo "<tr><td>" . $venue["id"] . "</td><td>" . $venue["name"] . "</td></tr>";
                }
                echo "</table>";
            ?>
            <?php echo $footer; ?>
        </div>
    </body>
</html>