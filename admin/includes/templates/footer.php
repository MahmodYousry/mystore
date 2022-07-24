        
        <div class="footer">

        </div>
        <script src="<?php echo $js; ?>jquery-ui.min.js"></script>
        <script src="<?php echo $js; ?>bootstrap.min.js"></script>
        <script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>
        <script src="<?php echo $js; ?>ajaxFunctions.js"></script>
        <script src="<?php echo $js; ?>backend.js"></script>
        <?php 
            header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        ?>
        
    </body>

</html>