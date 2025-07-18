<?php
// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
  http_response_code(400);
  echo "Invalid input";
  exit;
}

// Clean data
$page = preg_replace('/[^a-zA-Z0-9\-]/', '', $data['page'] ?? 'unknown');
$hadError = $data['hadError'] ?? 'n/a';
$wasHelpful = $data['wasHelpful'] ?? 'n/a';
$improve = trim($data['improve'] ?? '');
$timestamp = date("Y-m-d H:i:s");

// Create a line of feedback
$entry = "[$timestamp] Page: $page | Had Error: $hadError | Was Helpful: $wasHelpful | Improve: $improve" . PHP_EOL;

// Append to file
$file = __DIR__ . "/feedback/feedback-$page.txt";
file_put_contents($file, $entry, FILE_APPEND);

echo "OK";
