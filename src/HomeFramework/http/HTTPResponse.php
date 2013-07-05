<?php
namespace HomeFramework\http;

/**
 * Simple HTTP Response for straight HTML content
 * with status code 200.
 */
class HTTPResponse
{
    private static $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    /**
     * Response body
     * @var String
     */
    protected $body;

    /**
     * Status code
     * @var int
     */
    protected $statusCode;

    /**
     * Status text
     * @var string
     */
    protected $statusText;

    /**
     * Headers
     * @var array
     */
    protected $headers;

    /**
     * DataModifiedDate
     * @var string
     */
    protected $dataModifiedDate;

    /**
     * Constructor
     *
     * @param string $body       Body of the response
     * @param int    $statusCode Status code
     * @param array  $headers    Array of headers
     *
     * @return \HomeFramework\http\HTTPResponse
     */
    public function __construct($body = "", $statusCode = 200, array $headers = array())
    {
        $this->setBody($body);
        $this->setStatusCode($statusCode);
        $this->setHeaders($headers);
    }

    /**
     * Set body of the response
     *
     * @param string $body Body of the response
     * @return void
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get the body of the response
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the status code
     *
     * @param        $code
     * @param string $text HTTP Status text
     *
     * @throws \InvalidArgumentException
     * @internal param int $statusCode Status code
     * @return void
     */
    public function setStatusCode($code, $text = null)
    {
        $this->statusCode = (int) $code;
        if ($this->statusCode < 100 || $this->statusCode > 599) {
            throw new \InvalidArgumentException('The HTTP status code "%s" is not valid.', $code);
        }

        $this->statusText = $text ? $text : self::$statusTexts[$this->statusCode];
    }

    /**
     * Get the status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get the status text
     *
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * Set the response headers
     *
     * @param array $headers Array of headers
     * @return void
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * Get the response headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set a specific header
     *
     * @param string $key   Name of the header to set
     * @param string $value Header value
     * @return void
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Get a specific header
     *
     * @param string $key Name of the header to get
     * @return string
     */
    public function getHeader($key)
    {
        return isset($this->headers[$key]) ? $this->headers[$key] : null;
    }

    /**
     * Send the response on the standard output
     *
     * @return void
     */
    public function send()
    {
        if ( !$this->checkDataChanged() ) {
            header('HTTP/1.1 304 Not Modified');
            exit();
        }
        else {
            $this->sendHeader();
            $this->sendBody();
        }
    }

    /**
     * Send the response header
     *
     * @return void
     */
    public function sendHeader()
    {
        header('HTTP/1.1 ' . $this->statusCode . ' ' . $this->statusText . "\n");
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Send the response body
     *
     * @return void
     */
    public function sendBody()
    {
        echo $this->body;
    }

    /**
     * Setter for dataModifiedDate
     *
     * @param string $dataModifiedDate
     */
    public function setDataModifiedDate($dataModifiedDate)
    {
        $this->dataModifiedDate = $dataModifiedDate;
    }

    /**
     * Method used to check if the url content changed since it's last request.
     *
     * @return boolean
     */
    private function checkDataChanged()
    {
        if ( !empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && !empty($this->dataModifiedDate) ) {
            $lastFetchDate = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
            if ($lastFetchDate >= $this->dataModifiedDate) {
                return false;
            }
        }

        return true;
    }
}