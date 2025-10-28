<?php
// When the form is submitted, handle the input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your OpenAI API Key
    $apiKey = "YOUR_OPENAI_API_KEY"; // Replace this with your real key
    //Go to https://platform.openai.com/account/api-keys

    // User's message from the HTML form
    $userMessage = trim($_POST["message"]);

    // OpenAI Chat API endpoint
    $url = "https://api.openai.com/v1/chat/completions";

    // Prepare data for the request
    $data = [
        "model" => "gpt-4o-mini",
        "messages" => [
            ["role" => "system", "content" => "You are a helpful assistant."],
            ["role" => "user", "content" => $userMessage]
        ],
        "temperature" => 0.7
    ];

    // Set request headers
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ];

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute request
    $response = curl_exec($ch);

    // Handle errors
    if (curl_errno($ch)) {
        $error = 'Error: ' . curl_error($ch);
    } else {
        $decoded = json_decode($response, true);
        $reply = $decoded['choices'][0]['message']['content'] ?? "No response";
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ChatGPT PHP Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background: #f6f8fa;
        }
        form {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .response {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h2>💬 Chat with Me!</h2>

<form method="POST">
    <textarea name="message" placeholder="Type your question here..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea><br>
    <button type="submit">Ask Me!</button>
</form>

<?php if (!empty($reply)): ?>
    <div class="response">
        <h3>🤖 ChatGPT says:</h3>
        <p><?= nl2br(htmlspecialchars($reply)) ?></p>
    </div>
<?php elseif (!empty($error)): ?>
    <div class="response" style="color:red;">
        <strong><?= htmlspecialchars($error) ?></strong>
    </div>
<?php endif; ?>

</body>
</html>
