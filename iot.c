#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <dht11.h>

#include "SSD1306.h" // alias for `#include "SSD1306Wire.h"
SSD1306  display(0x3c, D3, D5); // 0.96 OLed IIC2

#define DHT11PIN 5  // DHT11輸出接第5腳 (D1)

ESP8266WebServer server(80); // HTTP伺服器物件
dht11 DHT11;                 // DHT11感測器物件

IPAddress apIP(192, 168, 4, 3);    // 設定AP模式的IP位址；預設是192.168.4.1。
const char *ssid =  "ESP8266";     // AP模式的Wi-Fi熱點名稱 (***Not "DLink-HomeWiFi 2";)
const char *password = "12345678"; // Wi-Fi密碼 (***Not "my password";)
float humid = 0;  // 濕度整數 ; //***int humid = 0;
float temp = 0;   // 溫度整數 ; //***int temp = 0;

void rootRouter() {
  server.send(200, "text/html", "<p>Hello from <b>ESP8266</b>!</p>");
}

void setup() {
  WiFi.mode(WIFI_AP);   // 啟用AP模式
  WiFi.softAPConfig(apIP, apIP, IPAddress(255, 255, 255, 0));  // 設定微控器的IP位址
  WiFi.softAP(ssid, password);  // 設定Wi-Fi的識別名稱和密碼

  Serial.begin(9600);
  Serial.println();

  // 等待 wifi 連線
  int wifi_retry = 0;
  while (WiFi.status() != WL_CONNECTED) {  //Wait for the WiFI connection completion
    delay(500);
    Serial.println("還沒連上 wifi, 再等一下...");
    if (wifi_retry++ > 100) {
      Serial.println("等太久了，連線失敗！");
      break;
    }
  }

  pinMode(DHT11PIN, INPUT);

  display.init();
  display.flipScreenVertically();
  display.setFont(ArialMT_Plain_16);
  display.setTextAlignment(TEXT_ALIGN_LEFT);
  //??dht.begin(); // initialize dht

  // HTTP begin
  // HTTPClient http;
  // http.begin("http://iot.leo-kuo.com/api/log/write?celsius=100&humidity=200");
  // int httpCode = http.GET();
  // String payload = http.getString();
  // http.end();
  // HTTP end

   server.on("/temp", []() {   // 設定 '/temp' 路徑的路由
   float chk = DHT11.read(DHT11PIN);  // *** int chk = DHT11.read(DHT11PIN);

   if (chk == 0) {
     char htmlStr[700];
     humid = DHT11.humidity;
     temp = DHT11.temperature;

     snprintf ( htmlStr, 700,
      "<html>\
       <head>\
         <meta charset='utf-8'/>\
         <meta http-equiv='refresh' content='5'/>\
         <meta name='viewport' content='width=device-width;\
             initial-scale=1.0;\
             maximum-scale=1.0;\
             user-scalable=0;'/>\
         <title>溫溼度感測器</title>\
         <style>\
                    body { font-family: '微軟正黑體', '黑體-繁', Sans-Serif;}\
         </style>\
         </head>\
         <body>\
          <h1>遠端溫溼度監控系統</h1>\
          <p>溫度：%.2f </p>\
          <p>濕度：%.2f </p>\
        </body>\
        </html>",
          temp, humid
        );

      server.send(200, "text/html", htmlStr);
     } else {
      server.send(200, "text/html", "Sensor Error");
     }
  });

  server.on("/index.html", rootRouter);
  server.on("/", rootRouter);
  server.onNotFound ( []() {
    server.send ( 404, "text/plain", "File Not Found" );
  } );

  server.begin();
  Serial.println("HTTP server started");
}

void displayTempHumid(){
  // Reading temperature or humidity takes about 250 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)

//  float h = dht.readHumidity();
//  float t = dht.readTemperature();  // Read temperature as Celsius
//  float f = dht.readTemperature(true);  // Read temperature as Fahrenheit

  // Check if any reads failed and exit early (to try again).
  if (isnan(humid) || isnan(temp)){     // || isnan(f)
    display.clear(); // clearing the display
    display.drawString(5,0, "Failed DHT");
    return;
  }
  display.clear();
  display.drawString(0, 0, "Humidity: " + String(humid) + "%\t");
  display.drawString(0, 16, "Temp: " + String(temp) + "C");
  //display.drawString(0, 32, "Temp: " + String(f) + "F");

  Serial.print("Humidity: " + String(humid) + "%\t");
  Serial.println("Temp: " + String(temp) + "C\t");
  //Serial.println("Temp: " + String(f) + "F");

  if (WiFi.status() == WL_CONNECTED) {
    // 宣告
    HTTPClient http;
    char apiUrl[255];

    // 組 api 網址
    sprintf(apiUrl, "http://iot.leo-kuo.com/api/log/write?celsius=%f&humidity=%f", temp, humid);

    // 呼叫 api
    http.begin(apiUrl);
    int httpCode = http.GET();

    // 取得 api 回應
    String api_response = http.getString();
    Serial.println("API Response:");
    Serial.println(api_response);

    // 結束 http 連線
    http.end();
  } else {
    Serial.println("Wifi 未連線，無法呼叫 api !");
  }
}

void loop() {
    server.handleClient();

    displayTempHumid();
    display.display();
    delay(2000);
}