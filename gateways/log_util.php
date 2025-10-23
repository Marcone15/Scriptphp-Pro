<?php
function logMessage($message, $logFile = 'default.log') {
    $logDir = __DIR__ . '/../logs';
    
    $currentDate = date('Y-m-d');
    $logFile = $currentDate . '.log';
    $logFilePath = $logDir . '/' . $logFile;

    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $maxLines = 10;

    $timestamp = date('Y-m-d H:i:s');
    $logEntry = $timestamp . " - " . $message . PHP_EOL;

    $logContents = file_exists($logFilePath) ? file($logFilePath, FILE_IGNORE_NEW_LINES) : [];

    if (count($logContents) >= $maxLines) {
        array_shift($logContents);
    }

    $logContents[] = $logEntry;

    file_put_contents($logFilePath, implode(PHP_EOL, $logContents) . PHP_EOL);
}
?>
