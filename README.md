# PHP proxy livestream video via cURL
This little class will help you to proxy video live stream through your server.<br/>
You can do this in different ways, but I chose almighty cURL C:

**NOTE**

Watch-out for memory usage!<br/> After you started getStream() method it will work "forever" 
(well, untill source data ends, which is "never" aside from some kind of error appears or server's down), 
so you need to kill script, when client is no longer watching. <br/>
Same for php time-out limits.