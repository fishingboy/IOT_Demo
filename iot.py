import requests
 
def iot_log(celsius, humidity):
    payload = {'celsius':celsius,'humidity':humidity}
    response = requests.get("http://iot.leo-kuo.com/api/log/write", params=payload)
    print(response.text)

iot_log(3,2)
