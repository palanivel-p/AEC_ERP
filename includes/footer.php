
<?php Include("connection.php");?>

<div class="footer">
    <div class="copyright">
        <p>Copyright © Designed &amp; Developed by <a href="https://www.gbtechcorp.co.in/" target="_blank">GB TECH CORP</a> <?php echo date('Y')?></p>
    </div>
</div>
<script>
    setInterval(function(){
        var panel_api_key= getCookie('panel_api_key');

        if(panel_api_key==="")
        {
            window.location.href = '<?php echo $website; ?>/login?logout=1';
        }
    }, 1000);


    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
</script>