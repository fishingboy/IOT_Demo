#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <dht11.h>

void setup() {

  Serial.begin(115200);                 //Serial connection
  WiFi.begin("yourSSID", "yourPASS");   //WiFi connection

  while (WiFi.status() != WL_CONNECTED) {  //Wait for the WiFI connection completion
     delay(500);
     Serial.println("Waiting for connection");
  }
  Serial.println("WIFI 連線成功！");

  if (WiFi.status() == WL_CONNECTED) {
    // 宣告
    HTTPClient http;
    char apiUrl[255];

    // 組 api 網址
    sprintf(apiUrl, "http://iot.leo-kuo.com/api/log/write?celsius=%f&humidity=%f", 233.0, 333.0);

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
    Serial.println("不做事，僅測試!!");
    delay(2000);
}