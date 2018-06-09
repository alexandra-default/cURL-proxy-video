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

    /**  This method is called whenever a new chunk of data arrived from cURL.  */
    public function callback($curl, $data)
    {
        ob_get_clean();
        if (($data === false) || ($data == null))
        {
            throw new \Exception (curl_error($curl) . " " . curl_errno($curl));
        }
        $length = strlen($data);
        header("Content-type: video/mp4"); //watched out for your video format!
        header("Transfer-encoding: chunked");
        header("Connection: keep-alive");
        header("Cache-Control: max-age=2592000, public");
        header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->url)) . ' GMT' );
        echo $data;
        ob_flush();
        flush();
        return $length;
    }

    /**  Key function for streaming */
    public function getStream($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => 0,
                CURLOPT_USERPWD => "$this->login:$this->pass", //if your server requires authorisation
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_BUFFERSIZE => $this->buffersize,
                CURLOPT_WRITEFUNCTION => array($this, "callback")
            )
        );
        curl_exec($curl);
        curl_close($curl);
    }
}