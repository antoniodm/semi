
#include "dht.h"
#include <SoftwareSerial.h>
    dht s1;
    dht s2;

#define DHT22_PIN 9
#define DHT22_PIN1 7
#define LEDV1 7
#define LEDV2 2
#define LEDR 3



void setup()
{
  

    Serial.begin(9600);
    pinMode(LEDR, OUTPUT);
    pinMode(LEDV1, OUTPUT);
    pinMode(LEDV2, OUTPUT);

    

}

void loop()
{
 // while (true){
 //     if (Serial.available()){
 //       char c = Serial.read();
 //       if (c=='C'){
 //         digitalWrite(LEDV1, HIGH);
 //         break;   
          //delay(500); 
          //digitalWrite(LEDV1, LOW);
 //       }
 //     }
 //   }
    // READ DATA
    int chk1 = s1.read22(DHT22_PIN);
    int chk2 = s2.read22(DHT22_PIN1);

    switch (chk1)
    {
        case DHTLIB_OK:
            digitalWrite(LEDR, HIGH);   
            delay(500);
            digitalWrite(LEDR, LOW); 
            break;
        case DHTLIB_ERROR_CHECKSUM: 
            delay(1000);
            break;
        case DHTLIB_ERROR_TIMEOUT: 
            delay(1000);
            break;
        default: 
            delay(1000);
            break;
    }
    switch (chk2)
    {
        case DHTLIB_OK: 
      digitalWrite(LEDV2, HIGH);   
      delay(500); 
      digitalWrite(LEDV2, LOW);           
            break;
        case DHTLIB_ERROR_CHECKSUM: 
            delay(1000);
            break;
        case DHTLIB_ERROR_TIMEOUT: 
            delay(1000);
            break;
        default: 
            delay(1000);
            break;
    }
    
    // DISPLAY DATA: ONE SENSOR PER LINE
    // line n:       S:#id_#humidity_#temperature #datetime
    // line 1:       1:52,3:23.8;2017-01-29 14:32:00;

    
    Serial.print("1:");
    Serial.print(s1.humidity, 1);
    Serial.print(":");
    Serial.print(s1.temperature, 1);
    Serial.print(";\n");
  


    Serial.print("2:");
    Serial.print(s2.humidity, 1);
    Serial.print(":");
    Serial.print(s2.temperature, 1);
    Serial.print(";\n");

    delay(6000);

}


