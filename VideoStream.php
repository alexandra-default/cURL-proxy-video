<?php
/**
 * Created by Alexandra.Default.
 * Date: 09.06.2018
 * Time: 15:31
 */

class VideoStream
{
    private $login = 'login';
    private $pass = 'password';
    private $buffersize = 1024 * 1024;

    /**  Key function for streaming */
    public function getStream($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => 0,
                CURLOPT_USERPWD => "$this->login:$this->pass", //if your server requires authorisation
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_BUFFERSIZE => $this->buffersize
            )
        );
        header("Content-type: video/mp4"); //watched out for your video format!
        header("Transfer-encoding: chunked");
        header("Connection: keep-alive");
        header("Cache-Control: max-age=2592000, public");
        header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->url)) . ' GMT' );
        curl_exec($curl);
        curl_close($curl);
    }
}
