<!-- For statcounter -->
{if $STATCOUNTER_STATUS=='yes'}
    <script type="text/javascript">
        //<![CDATA[
        var sc_project = 9749224;
        var sc_invisible = 1;
        var sc_security = "beb94475";
        var scJsHost = (("https:" == document.location.protocol) ? "https://secure." : "https://www.");
        document.write("<sc" + "ript type='text/javascript' src='" + scJsHost + "statcounter.com/counter/counter_xhtml.js'></" + "script>");
        //]]>
    </script>
{/if}
<!-- For statcounter -->

{if $LIVECHAT_STATUS == 'yes'}
    {$CHAT_CODE}
{/if}