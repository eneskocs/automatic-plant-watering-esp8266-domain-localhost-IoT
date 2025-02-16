#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecureBearSSL.h>
#include "DHT.h"
#define nem_sensor A0 //nem ölcer pini
#define su_pompasi D3  //su pompası pini
#define dhtPIN 14 // dht pini
#define dhtTYPE DHT11 
float anlik_nem_degeri;
float ortam_sicakligi;
float ortam_nemi;
int nem_kontrol_degeri;
int ortam_nem_kontrol_degeri;
int ortam_nem_kontrol_degeri_eski;
int su_pompasi_degeri;
int otomatik_sulama;
int ortam_nemi_sulama;
const char* ssid = "";
const char* password = "";
String serverName = "http://192.168.1.7/otomatik-sulama-sistemi/";
DHT dht(dhtPIN, dhtTYPE); 
unsigned long sonIslemZamani = 0;  // Son işlem zamanını saklamak için
const long zamanAraligi = 1200000;       // 20 dakika
HTTPClient http;
WiFiClient client;


// Post metodu ile anlik nem değerinin yollanıcağı sunucu adresi
void anlik_nem_gonder(){
  if(http.begin(client, serverName+"data/anlik-nem-kayit.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // Veritabanına göndermek istenilen veri belirtiliyor
    String postData = "anlik_nem=";
    postData+=String(anlik_nem_degeri);
    // HTTP POST isteği gönderme
    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
      if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
        String response = http.getString(); //Sunucudan yanıt alma
        Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
        Serial.println(response);         // sunucudan alınan cevabı yazdırma
      } else {
      Serial.printf("[HTTP] POST... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
      }        
    } else {
      Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  }
}


// Post metodu ile sicaklik ve nem değerinin yollanacağı sunucu adresi
void ortam_degerleri_gonder(){
  if(http.begin(client, serverName+"data/ortam-degerleri-kayit.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // Veritabanına göndermek istenilen veri belirtiliyor
    String postData = "ortam_sicakligi=" + String(ortam_sicakligi) + "&ortam_nemi=" + ortam_nemi;
    // HTTP POST isteği gönderme
    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
        if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String response = http.getString(); //Sunucudan yanıt alma
          Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
          Serial.println(response);         // sunucudan alınan cevabı yazdırma
        } else {
        Serial.printf("[HTTP] POST... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
        }        
      } else {
      Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
      }
      http.end();
    } else {
      Serial.printf("[HTTP} Bağlantı Koptu\n");
    }
}


// Get metodu ile nem kontrol değerinin alınacağı sunucu adresi
void nem_kontrol_degeri_al(){
  if(http.begin(client, serverName+"data/nem-kontrol.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
        String response = http.getString(); //Sunucudan yanıt alma
        Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
        Serial.println("Nem kontrol değeri: "+response);  // sunucudan alınan cevabı yazdırma
        nem_kontrol_degeri = response.toInt();       
      } else {
      Serial.printf("[HTTP] GET... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
      }        
    } else {
      Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  }
}



// Get metodu ile ortam nem kontrol değerinin alınacağı sunucu adresi
void ortam_nem_kontrol_degeri_al(){
  if(http.begin(client, serverName+"data/ortam-nem-kontrol.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
        String response = http.getString(); //Sunucudan yanıt alma
        Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
        Serial.println("Ortam Nem kontrol değeri: "+response);  // sunucudan alınan cevabı yazdırma
        ortam_nem_kontrol_degeri = response.toInt();       
      } else {
      Serial.printf("[HTTP] GET... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
      }        
    } else {
      Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  }
}


// Post metodu ile ortam bilgilerinin gönderileceği sunucu adresi
void ortam_kaydi_gonder(){
  if(http.begin(client, serverName+"data/ortam-kayitlar.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // Veritabanına göndermek istenilen veri belirtiliyor
    String postData = "ortam_nemi=" + String(ortam_nemi) + "&ortam_sicakligi=" + String(ortam_sicakligi) + "&toprak_nemi=" + String(anlik_nem_degeri);
    // HTTP POST isteği gönderme
    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
        if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String response = http.getString(); //Sunucudan yanıt alma
          Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
          Serial.println(response);  // sunucudan alınan cevabı yazdırma                 
        } else {
        Serial.printf("[HTTP] POST... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
        }        
    } else {
    Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  } 
}


// Get metodu ile su pompası değerinin alınacağı sunucu adresi
void su_pompasi_degeri_al(){
  if(http.begin(client, serverName+"data/su-pompasi.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
        String response = http.getString(); //Sunucudan yanıt alma
        Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
        Serial.println("Su pompası durumu: "+response);
        su_pompasi_degeri=response.toInt();  // sunucudan alınan cevabı yazdırma       
      } else {
      Serial.printf("[HTTP] GET... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
      }        
    } else {
      Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  }
}


// Post metodu ile sulama bilgilerinin gönderileceği sunucu adresi
void su_kaydi_gonder(String sulama_turu){
  if(http.begin(client, serverName+"data/sulama-kayitlari.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // Veritabanına göndermek istenilen veri belirtiliyor
    String postData = "anlik_nem_degeri=" + String(anlik_nem_degeri) + "&nem_kontrol_degeri=" + nem_kontrol_degeri + "&sulama_tipi=" + sulama_turu;
    // HTTP POST isteği gönderme
    int httpResponseCode = http.POST(postData);
    if (httpResponseCode > 0) {
        if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String response = http.getString(); //Sunucudan yanıt alma
          Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
          Serial.println(response);  // sunucudan alınan cevabı yazdırma                 
        } else {
        Serial.printf("[HTTP] POST... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
        }        
    } else {
    Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  }     
}


// Get metodu ile otomatik sulama değerinin alınacağı sunucu adresi
void otomatik_sulama_degeri_al(){
  if(http.begin(client, serverName+"data/otomatik-sulama.php")){  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
        String response = http.getString(); //Sunucudan yanıt alma
        Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
        Serial.println("Otomatik Sulama durumu: "+response);
        otomatik_sulama=response.toInt();  // sunucudan alınan cevabı yazdırma       
      } else {
      Serial.printf("[HTTP] GET... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
      }        
    } else {
      Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
    }
    http.end();
  } else {
    Serial.printf("[HTTP} Bağlantı Koptu\n");
  }
}


void setup() {
   
  Serial.begin(9600);
  Serial.println();
  Serial.println();
  Serial.println();

  for (uint8_t t = 4; t > 0; t--) {
    Serial.printf("[SETUP] WAIT %d...\n", t);
    Serial.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi ..");
  
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print('.');
    delay(1000);
  }
  pinMode(nem_sensor, INPUT);
  pinMode(su_pompasi, OUTPUT);
  digitalWrite(su_pompasi, HIGH);
  dht.begin(); // DHT nesnesini başlat
  ortam_nemi_sulama=1;
}

void loop() {
  if (digitalRead(su_pompasi) != LOW){
    delay(100);
    ortam_nemi  = dht.readHumidity();
    delay(100);
    ortam_sicakligi = dht.readTemperature();
    delay(100);
  }

   Serial.println("Ortam Nemi: "+String(ortam_nemi,1));
   Serial.println("Ortam Sıcaklığı: "+String(ortam_sicakligi,1));
   anlik_nem_degeri = analogRead(nem_sensor); 
   anlik_nem_degeri = map(anlik_nem_degeri,1023,0,0,100);
   Serial.println("Toprak Nemi: "+String(anlik_nem_degeri,1));

  if (WiFi.status() == WL_CONNECTED) {

    anlik_nem_gonder();
    ortam_degerleri_gonder();

    nem_kontrol_degeri_al();
    ortam_nem_kontrol_degeri_eski = ortam_nem_kontrol_degeri;
    ortam_nem_kontrol_degeri_al();
    

    unsigned long gecenSure = millis();

    if (gecenSure - sonIslemZamani >= zamanAraligi) {
      sonIslemZamani = gecenSure;
      // Burada zamanlanmış görevinizi yapın
      Serial.println("20 dakika geçti!");
      ortam_kaydi_gonder();
    }

    su_pompasi_degeri_al();

    if(su_pompasi_degeri == 1 && digitalRead(su_pompasi) != LOW){     
      Serial.println("Sulama Yapılıyor");
      su_kaydi_gonder("Manuel");     
      digitalWrite(su_pompasi, LOW);        
    }
    else if(su_pompasi_degeri == 0 && digitalRead(su_pompasi) != HIGH){
      digitalWrite(su_pompasi, HIGH);
    }

    otomatik_sulama_degeri_al();

    if((nem_kontrol_degeri > anlik_nem_degeri) && (otomatik_sulama == 1)){
      
      Serial.println("Sulama Yapılıyor");
      // Post metodu ile sulama bilgilerinin gönderileceği sunucu adresi
      if(http.begin(client, serverName+"data/sulama-kayitlari.php")){  
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        // Veritabanına göndermek istenilen veri belirtiliyor
        String postData = "anlik_nem_degeri=" + String(anlik_nem_degeri) + "&nem_kontrol_degeri=" + nem_kontrol_degeri + "&sulama_tipi=Otomatik";
        // HTTP POST isteği gönderme
        int httpResponseCode = http.POST(postData);
        if (httpResponseCode > 0) {
          if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
            String response = http.getString(); //Sunucudan yanıt alma
            Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
            Serial.println(response);  // sunucudan alınan cevabı yazdırma    
            int durum = digitalRead(su_pompasi);
            while ((nem_kontrol_degeri > anlik_nem_degeri) && (otomatik_sulama == 1)){
              if(durum == HIGH){
                digitalWrite(su_pompasi, LOW);
              }                    

              otomatik_sulama_degeri_al();
              nem_kontrol_degeri_al();
              anlik_nem_degeri = analogRead(nem_sensor); 
              anlik_nem_degeri = map(anlik_nem_degeri,1023,0,0,100); 
              anlik_nem_gonder();
            } 

            digitalWrite(su_pompasi, HIGH);                
          }else {
          Serial.printf("[HTTP] POST... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
          }        
        }else {
        Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
        }
        http.end();
      }else {
        Serial.printf("[HTTP} Bağlantı Koptu\n");
      }      
    }

    if((ortam_nem_kontrol_degeri < ortam_nemi) && (ortam_nemi_sulama == 0)){
      ortam_nemi_sulama = 1;
    }
    
    ortam_nem_kontrol_degeri_al();Serial.println("nem kontrol değerleri eski yeni");
    Serial.println(ortam_nem_kontrol_degeri_eski);
    Serial.println(ortam_nem_kontrol_degeri);
    if((ortam_nem_kontrol_degeri_eski != ortam_nem_kontrol_degeri) && (ortam_nemi_sulama == 0)){
      ortam_nemi_sulama = 1;
    }
    

     if((ortam_nem_kontrol_degeri > ortam_nemi) && (otomatik_sulama == 1) && (ortam_nemi_sulama == 1)){
      
      Serial.println("Sulama Yapılıyor");
      // Post metodu ile sulama bilgilerinin gönderileceği sunucu adresi
      if(http.begin(client, serverName+"data/sulama-kayitlari.php")){  
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        // Veritabanına göndermek istenilen veri belirtiliyor
        String postData = "anlik_nem_degeri=" + String(anlik_nem_degeri) + "&nem_kontrol_degeri=" + nem_kontrol_degeri + "&sulama_tipi=Otomatik";
        // HTTP POST isteği gönderme
        int httpResponseCode = http.POST(postData);
        if (httpResponseCode > 0) {
          if (httpResponseCode == HTTP_CODE_OK || httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY) {
            String response = http.getString(); //Sunucudan yanıt alma
            Serial.println(httpResponseCode); //sunucu yanıt kodunu yazdırma
            Serial.println(response);  // sunucudan alınan cevabı yazdırma    
            if((ortam_nem_kontrol_degeri > ortam_nemi) && (ortam_nemi_sulama == 1)){
              digitalWrite(su_pompasi, LOW);
              delay(3000);
              digitalWrite(su_pompasi, HIGH);
              ortam_nemi_sulama = 0;
            }
               
          }else {
          Serial.printf("[HTTP] POST... reddedildi, hata: %s\n", http.errorToString(httpResponseCode).c_str());
          }        
        }else {
        Serial.println("HTTP isteği hatası"); //sunucu hata kodunu yazdırma
        }
        http.end();
      }else {
        Serial.printf("[HTTP} Bağlantı Koptu\n");
      }      
    }
    


  }
  delay(2000);
}

