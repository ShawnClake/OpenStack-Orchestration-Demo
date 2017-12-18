<?php


class Token {

  private $endPoint = 'https://172.25.181.200:13000/v3/auth/tokens?nocatalog';

  private $token = '';
  private $headers = [];

  function generate($username, $password, $project) {
    $curl = curl_init();
    $data_json = '{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "Default"},"name": "' . $username . '", "password": "' . $password . '"} } }, "scope": { "project": { "domain": { "name": "Default" }, "name":  "' . $project . '" } } }}';
    curl_setopt($curl, CURLOPT_URL, $this->endPoint);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_HEADER, 1);

    curl_setopt($curl, CURLOPT_HEADERFUNCTION,
      function($curls, $header) //use (&$this->headers)
      {
        $len = strlen($header);
        $header = explode(':', $header, 2);
        if (count($header) < 2) // ignore invalid headers
          return $len;

        $name = strtolower(trim($header[0]));
        if (!array_key_exists($name, $this->headers))
          $this->headers[$name] = [trim($header[1])];
        else
          $this->headers[$name][] = trim($header[1]);

        return $len;
      }
    );

    $response  = curl_exec($curl);

    curl_close($curl);

    $this->token =  $this->headers['x-subject-token'][0];
  }

  function get() {
    return $this->token;
  }

}

class Request {

  private $endPoint = '';
  private $response = '';
  private $headers = [];
  private $httpCode = '';

  function __construct($endpoint) {
    $this->endPoint = $endpoint;
  }

function post($token, $postData) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->endPoint);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Auth-Token:' . $token, 'Content-type: application/json', 'Accept: application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_HEADER, 1);

    curl_setopt($curl, CURLOPT_HEADERFUNCTION,
      function($curls, $header) //use (&$this->headers)
      {
        $len = strlen($header);
        $header = explode(':', $header, 2);
        if (count($header) < 2) // ignore invalid headers
          return $len;

        $name = strtolower(trim($header[0]));
        if (!array_key_exists($name, $this->headers))
          $this->headers[$name] = [trim($header[1])];
        else
          $this->headers[$name][] = trim($header[1]);

        return $len;
      }
    );

    $this->response  = curl_exec($curl);

    $this->httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
  }

  function getResponse() {
    return $this->response;
  }

  function getHeaders() {
    return $this->headers;
  }

  function getHttpCode() {
    return $this->httpCode;
  }

}



$type = $_GET['type'];


if(!isset($type))
{
header('Location: http://172.25.181.5/index.php?status=2');
die();
}


$token = new Token();
$token->generate('admin', 'NzcqybBgaDmDvuXpQXXF76CdF' ,'admin');


$stackName = "service" . $type . "-stack-" . uniqid();

$data = '';

if($type == "1")
  $data = json_encode(array("stack_name" => $stackName, "template_url" => 'http://172.25.181.5/templates/service1.yaml'));
else if($type == "2")
  $data = json_encode(array("stack_name" => $stackName, "template_url" => 'http://172.25.181.5/templates/service2.yaml'));
else if($type == "3")
  $data = json_encode(array("stack_name" => $stackName, "template_url" => 'http://172.25.181.5/templates/service3.yaml'));
else
{
  header('Location: http://172.25.181.5/index.php?status=3');
  die();
}



$request = new Request('https://172.25.181.200:13004/v1/e7fed25a470142688af92099aca81635/stacks');
$request->post($token->get(), $data);
echo $request->getHttpCode();
if($request->getHttpCode() != "201")
{
  header('Location: http://172.25.181.5/index.php?status=4');
  die();
}


header('Location: http://172.25.181.5/index.php?status=1&stack-name='.$stackName);

die();
