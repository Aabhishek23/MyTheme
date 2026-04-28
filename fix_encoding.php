<?php
$file = 'functions.php';
$lines = file($file);
$fixed_lines = [];

$replacements = [
    'ðŸ”‘' => '🔑',
    'ðŸ‘¤' => '👤',
    'ðŸ›’' => '🛒',
    'ðŸ“¦' => '📦',
    'ðŸšª' => '🚪',
    'ðŸ” ' => '🔑',
    'âœ¨' => '✨',
    'ðŸ“§' => '📧',
    'ðŸ”’' => '🔒',
    'ðŸ‘ ' => '👁️',
    'â†’' => '→',
    'ðŸŽ‰' => '🎉',
    'âœ…' => '✅',
    'â  ' => '❌',
    'ðŸ™ˆ' => '🙈',
    'â€”' => '—',
    'â€“' => '–',
    'Ã—' => '×',
    'â€¢' => '•',
    'Â†’' => '→',
];

foreach ($lines as $line) {
    // Fix Hindi lines by specific markers
    if (strpos($line, 'à¤¹à¤® à¤†à¤ªà¤¸à¥‡ à¤œà¤²à¥ à¤¦ à¤¹à¥€ à¤­à¥ à¤—à¤¤à¤¾à¤¨') !== false) {
        $line = str_replace('à¤¹à¤® à¤†à¤ªà¤¸à¥‡ à¤œà¤²à¥ à¤¦ à¤¹à¥€ à¤­à¥ à¤—à¤¤à¤¾à¤¨ à¤•à¥‡ à¤²à¤¿à¤  à¤¸à¤‚à¤ªà¤°à¥ à¤• à¤•à¤°à¥‡à¤‚à¤—à¥‡à¥¤', 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे।', $line);
    }
    if (strpos($line, 'à¤¶à¥‰à¤ªà¤¿à¤‚à¤— à¤•à¤°à¤¨à¥‡ à¤•à¥‡ à¤²à¤¿à¤  à¤§à¤¨à¥ à¤¯à¤µà¤¾à¤¦!') !== false) {
        $line = str_replace('à¤¶à¥‰à¤ªà¤¿à¤‚à¤— à¤•à¤°à¤¨à¥‡ à¤•à¥‡ à¤²à¤¿à¤  à¤§à¤¨à¥ à¤¯à¤µà¤¾à¤¦! à¤¹à¤® à¤†à¤ªà¤¸à¥‡ à¤œà¤²à¥ à¤¦ à¤¸à¥‡ à¤œà¤²à¥ à¤¦ à¤¸à¤‚à¤ªà¤°à¥ à¤• à¤•à¤°à¥‡à¤‚à¤—à¥‡à¥¤', 'शॉपिंग करने के लिए धन्यवाद! हम आपसे जल्द से जल्द संपर्क करेंगे।', $line);
    }
    
    // Fix separators
    if (strpos($line, '// â”€â”€') !== false) {
        $line = preg_replace('/\/\/ â”€â”€+/', '// ──', $line);
    }
    if (strpos($line, '// â•') !== false) {
        $line = preg_replace('/\/\/ â•+/', '// ══', $line);
    }

    // Apply general replacements
    foreach ($replacements as $search => $replace) {
        $line = str_replace($search, $replace, $line);
    }
    
    $fixed_lines[] = $line;
}

file_put_contents($file, implode('', $fixed_lines));
echo "Refixed functions.php\n";
?>
