<?php
session_start();
include "components/connect.php";
include "vendor/autoload.php";

if(!isset($_SESSION["msg"])){
    $sql = $conn->prepare("SELECT name FROM products;");
    $sql->execute();

    $products = " ";
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $name = $row["name"];
        $products .= "$name, ";
    }
    $_SESSION["msg"] = array(
        array(
            'role' => 'system',
            'content' => "Your are AI ChatBot, an AI assistance of HungerHub Kitchen to help user decide what to eat. You will suggest food to student by asking their mood and taste. You strictly only can follow the product name to suggest. The product include $products. You do not simply add description yourself, just tell the product name! If user asked for food not in the product list, reject them and suggest our own product. Once the student decided what to eat, tell them to go menu page and search for the product."
        )
    );
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $yourApiKey = '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';
    $client = OpenAI::client($yourApiKey);
    $prompt = $_POST["prompt"];
    $message = $_SESSION["msg"];

    $new_message = array(
        'role' => 'user',
        'content' => $prompt
    );
    $message[] = $new_message;
    $_SESSION["msg"] = $message;

    $response = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => $message
    ]);

    foreach($response->choices as $result){
        $text = $result->message->content;
    }

    $message = $_SESSION["msg"];

    $new_message = array(
        'role' => 'assistant',
        'content' => $text
    );
    $message[] = $new_message;
    $_SESSION["msg"] = $message;

    echo $text;
}
?>