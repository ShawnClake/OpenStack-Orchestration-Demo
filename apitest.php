<?php


$type = $_GET['type'];

//echo "TYPE:".$type."<br>";


if(!isset($type))
{
header('Location: http://172.25.181.5/index.php?status=2');
die();
}



$headers = [];

function HandlerTokenHeader($curl, $header)
{
var_dump($header);
}


$curl = curl_init();

// Use this data for the shawn account
//$data_json = '{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "Default"},"name": "shawn", "password": "shawn123"} } }, "scope": { "project": { "domain": { "name": "Default" }, "name":  "shawn" } } }}';

// Use this data for the admin account
$data_json = '{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "Default"},"name": "admin", "password": "NzcqybBgaDmDvuXpQXXF76CdF"} } }, "scope": { "project": { "domain": { "name": "Default" }, "name":  "admin" } } }}';

curl_setopt($curl, CURLOPT_URL, "https://172.25.181.200:13000/v3/auth/tokens?nocatalog");

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_HEADER, 1);
//curl_setopt($curl, CURLOPT_HEADERFUNCTION, "HandleTokenHeader");

curl_setopt($curl, CURLOPT_HEADERFUNCTION,
  function($curls, $header) use (&$headers)
  {
    $len = strlen($header);
    $header = explode(':', $header, 2);
    if (count($header) < 2) // ignore invalid headers
      return $len;

    $name = strtolower(trim($header[0]));
    if (!array_key_exists($name, $headers))
      $headers[$name] = [trim($header[1])];
    else
      $headers[$name][] = trim($header[1]);

    return $len;
  }
);

$response  = curl_exec($curl);

curl_close($curl);

//echo "<br>BLURP 0<br>";

//var_dump($response);

//echo "<br>BLURP 1<br>";

//print_r($headers);

//echo "<br>BLURP 2<br>";

$tok =  $headers['x-subject-token'][0];


echo "Token: $tok <br><br>";


$curl2 = curl_init();

$uuid = uniqid();

//$data_json2 = json_encode(array("stack_name" => "testthisAPI-$uuid", "template_url" => 'https://raw.githubusercontent.com/ShawnClake/OpenStack-Heat-Templates/sasktel-sandbox/sasktel-sandbox/1i_api.yaml'));

$stackName = "service-stack-" . $uuid;


if($type == "1")
$data_json2 = json_encode(array("stack_name" => $stackName, "template_url" => 'http://172.25.181.5/templates/vnf.yaml'));
else if($type == "2")
$data_json2 = json_encode(array("stack_name" => $stackName, "template_url" => 'http://172.25.181.5/templates/.yaml'));
else if($type == "3")
$data_json2 = json_encode(array("stack_name" => $stackName, "template_url" => 'http://172.25.181.5/templates/.yaml'));
else
{
header('Location: http://172.25.181.5/index.php?status=3');
die();


}
//return;

//https://github.com/ShawnClake/OpenStack-Heat-Templates/blob/sasktel-sandbox/sasktel-sandbox/4i_2n_1v_api.yaml

//$data_json2 = '{"stack_name":"test this API","template_url":"https://raw.githubusercontent.com/ShawnClake/OpenStack-Heat-Templates/sasktel-sandbox/sasktel-sandbox/1i.yaml"}';


//$data_json2 = '{"stack_name":"test this API"}';


var_dump(json_decode($data_json2));
echo "<br>";

curl_setopt($curl2, CURLOPT_URL, "https://172.25.181.200:13004/v1/e7fed25a470142688af92099aca81635/stacks");


$authen = array('X-Auth-Token:' . $tok, 'Content-type: application/json', 'Accept: application/json');

var_dump($authen);

$headers = [];

curl_setopt($curl2, CURLOPT_POST, 1);
curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl2, CURLOPT_HTTPHEADER, $authen);
curl_setopt($curl2, CURLOPT_POSTFIELDS, $data_json2);
curl_setopt($curl2, CURLOPT_VERBOSE, 1);
curl_setopt($curl2, CURLOPT_HEADER, 1);
//curl_setopt($curl, CURLOPT_HEADERFUNCTION, "HandleTokenHeader");

curl_setopt($curl2, CURLOPT_HEADERFUNCTION,
  function($curls2, $header) use (&$headers)
  {
    $len = strlen($header);
    $header = explode(':', $header, 2);
    if (count($header) < 2) // ignore invalid headers
      return $len;

    $name = strtolower(trim($header[0]));
    if (!array_key_exists($name, $headers))
      $headers[$name] = [trim($header[1])];
    else
      $headers[$name][] = trim($header[1]);

    return $len;
  }
);


if(true)
{
$response2  = curl_exec($curl2);
$httpcode = curl_getinfo($curl2, CURLINFO_HTTP_CODE);
if($httpcode != "201")
{
header('Location: http://172.25.181.5/index.php?status=4');
die();

}

curl_close($curl2);

echo "<br>BLURP 0<br>";

var_dump($headers);

echo "<br>meh<br>";

var_dump($response2);

    $len = strlen($response2);
    $response2 = explode(':', $response2, 2);
    if (count($response2) < 2) // ignore invalid headers
      return $len;

    $name = strtolower(trim($response2[0]));
    if (!array_key_exists($name, $headers))
      $headers[$name] = [trim($reponse2[1])];
    else
      $headers[$name][] = trim($reponse2[1]);

echo "<br><br>";

echo json_encode($headers);






header('Location: http://172.25.181.5/index.php?status=1&stack-name='.$stackName);
die();


}

















//curl -v -s -X POST https://172.25.181.200:13000/v3/auth/tokens?nocatalog   -H "Content-Type: application/json"   -d '{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "'"Default"'"},"name": "'"shawn"'", "password": "'"shawn123"'"} } }, "scope": { "project": { "domain": { "name": "'"Default"'" }, "name":  "'"shawn"'" } } }}' \
//| python -m json.tool






//$data_json = '{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "Default"},"name": "shawn", "password": "shawn123"} } }, "scope": { "project": { "domain": { "name": "Default" }, "name":  "shawn" } } }}';

//var_dump(json_decode('{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "'"$OS_USER_DOMAIN_NAME"'"},"name": "'"$OS_USERNAME"'", "password": "'"$OS_PASSWORD"'"} } }, "scope": { "project": { "domain": { "name": "'"$OS_PROJECT_DOMAIN_NAME"'" }, "name":  "'"$OS_PROJECT_NAME"'" } } }}'));


//var_dump(json_decode('{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "Default"},"name": "shawn", "password": "shawn123"} } }, "scope": { "project": { "domain": { "name": "Default" }, "name":  "shawn" } } }}'));


//{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "Default"},"name": "shawn", "password": "shawn123"} } }, "scope": { "project": { "domain": { "name": "Default" }, "name":  "shawn" } } }}



//curl -v -s -X POST $OS_AUTH_URL/auth/tokens?nocatalog   -H "Content-Type: application/json"   -d '{ "auth": { "identity": { "methods": ["password"],"password": {"user": {"domain": {"name": "'"$OS_USER_DOMAIN_NAME"'"},"name": "'"$OS_USERNAME"'", "password": "'"$OS_PASSWORD"'"} } }, "scope": { "project": { "domain": { "name": "'"$OS_PROJECT_DOMAIN_NAME"'" }, "name":  "'"$OS_PROJECT_NAME"'" } } }}' \





