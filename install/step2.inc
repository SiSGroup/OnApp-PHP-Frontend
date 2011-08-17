<?php require_once 'header.inc';?>

<?php if ($result) { ?>
        <div align="center" class="table">
            Congratulation! Configurations have been saved. Installation proccess was finished successfully.<br />
            <p class="red">Delete or rename install/ directory and follow the link</p><br />
            <a href="<?php echo $base;?>">Login</a>
       </div>
<?php } else { ?>
    Config file isn't writable
<? } ?>
    
</body>
</html>