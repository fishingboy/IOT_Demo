#!/bin/bash

# 判斷 php 的路徑
[ -f "/opt/lampp/bin/php" ] && php="/opt/lampp/bin/php" || php="php"

# 壓縮 hash js file
gulp script 

# 取代 template .js => hash .js
rm -rf application/views_release
gulp rev 

# 清除過期的 hash .js file (保留最近兩筆)
gulp clean 

# 輸出訊息到 Slack
$php index.php tools/slack_sender gulpNotify
