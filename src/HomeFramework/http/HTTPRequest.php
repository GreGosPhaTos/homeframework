<?php
namespace HomeFramework\http;

use HomeFramework\http;

class HTTPRequest
{

    /**
     * Get the request data
     *
     * @param string $method HTTPMethod
     * @param $key
     * @return string|null
     */
    public function getData($method = "GET", $key)
	{
	    switch($method) {
            case 'POST' :
            case 'PUT' :
                $postData = $this->getContent();
                return $postData[$key];
            case 'GET' :
                $getData = $this->getGetData();
                return $getData[$key];
            default :
                return null;
        }
	}

    /**
     * @return mixed
     */
    public function getRequestURI() {
		return $_SERVER['REQUEST_URI'];
	}

    /**
     * @return array|void
     */
    public function getContent() {
        if (strlen($httpStream = file_get_contents('php://input'))>0){
            $dataSerializer = new DataSerializer();
            return $dataSerializer->unserialize($httpStream);
        }
        return $_POST;
    }

    /**
     * @return array|void
     */
    public function getGetData() {
        if (!empty($_GET)) {
            return $_GET;
        }

        $dataSerializer = new DataSerializer();
        return $dataSerializer->unserialize($_SERVER['QUERY_STRING']);
    }

    /**
     * @return mixed
     */
    public function getFileName() {
        return $_FILES['name'];
    }

    /**
     * @return mixed
     */
    public function getFileContentType() {
        return $_FILES['type'];
    }

    /**
     * @return mixed
     */
    public function getFileTmpPath() {
        return $_FILES['tmp_name'];
    }

    public function getFileError() {
        return $_FILES['error'];
    }

    public function getFileSize() {
        return $_FILES['size'];
    }

	public function getUserAgent() {
	    return $_SERVER['HTTP_USER_AGENT'];
	}

    public function getHost() {
        return $_SERVER['HTTP_HOST'];
    }

    public function getCookies() {
        return $_COOKIE;
    }

    public function getMethod() {
        $_SERVER['REQUEST_METHOD'];
    }
}
