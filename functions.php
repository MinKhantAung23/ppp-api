<?php

require_once "./global.php";

function dd($data,$showType = false): void{
    // die and dump
    echo "<pre>";
    if ($showType) {
        var_dump($data);
    }else {
        print_r($data);
    }
    echo "</pre>";
    die();
};

function url(string $path):string 
{
    $url = isset($_SERVER["HTTPS"]) ? "https" : "http";
    $url .= "://";
    $url .= $_SERVER["HTTP_HOST"];
    if (isset($path)) {
        $url .= "/";
        $url .= $path;
    }
    return $url;
};

function response(mixed $data, int $status = 200): string
{
    header("Content-type: Application/json");
    http_response_code($status);
    if(is_array($data)){
        return json_encode($data);
    };
    return json_encode(["message" => $data]);
};

function area(float $width,float $breadth): float
{
    return $width * $breadth;
};

function logger(string $message): void
{
    echo "\e[39m[LOG]". "\e[32m". $message. "\n";
};

// file upload 

function extension($fileName):string
{
    return pathinfo($fileName)["extension"];
}

function randomFileName($ext): string 
{
    return md5(uniqid()).".". $ext;
};

function upload(string $key, string $dir):string
{
    $ext = extension($_FILES[$key]["name"]);
    $newFileName = $dir."/". randomFileName($ext);
    move_uploaded_file($_FILES[$key]["tmp_name"],$newFileName);
    return $newFileName;
};

function saveJsonFile(string $text): void
{
    $newFileName = RECORD_DIR. "/". randomFileName("json");
    $file = fopen($newFileName, "w");
    fwrite($file, $text);
    fclose($file);
};

function scanFile($dir): array
{
    $files = scandir($dir);
    $result = [];
    foreach($files as $file){
        if ($file != "." && $file != "..") {
            // $data = json_encode(file_get_contents($dir."/".$file). true);
            // $data["file"] = $file;
            $result[] = $file;
        }
    }
    return $result;
};

function responseNoContent():void
{
    http_response_code(204);
}

