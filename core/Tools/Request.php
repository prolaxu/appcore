<?php
//HTTP Request
namespace core\Tools;

class Request
{
    public $url;
    public $root;
    public $paths = [];
    function __construct()
    {
        $this->url = $this->getUrl()->url;
        $this->root = $this->getUrl()->root;
    }
    // Ridirect method
    public function redirect($url, $arr = [])
    {
        header("Location:" . routePath($url));
    }
    //retuen rootPath 

    public function getUrl()
    {
        $path = explode('/', $_SERVER['REQUEST_URI'], 3);
        return (object)[
            "root" => "/" . $path[1],
            "url" => "/" . $path[2],
        ];
    }
    public function httpPost($url, $data = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function redirect_post($url, array $data = [], array $headers = null)
    {
        $params = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        if (!is_null($headers)) {
            $params['http']['header'] = '';
            foreach ($headers as $k => $v) {
                $params['http']['header'] .= "$k: $v\n";
            }
        }

        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);

        if ($fp) {
            echo @stream_get_contents($fp);
            die();
        } else {
            // Error
            throw new \Exception("Error loading '$url', $php_errormsg");
        }
    }
}
