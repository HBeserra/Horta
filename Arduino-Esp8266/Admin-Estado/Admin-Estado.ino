#include "ThingSpeak.h"
#include <SPI.h>
#include <Ethernet.h>
#include <LiquidCrystal_I2C.h>

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
EthernetClient client;

unsigned long myChannelNumber = 295257;
const char * myWriteAPIKey = "21A0UDQIKM1YOW9X";

LiquidCrystal_I2C lcd(0x3f,16,2);

//#################### Estado E-Horta ##########################

// estado = 1;// DESATIVADO  //Horta não envia dados
// estado = 2;// TRANSMITINDO     //Horta envia dados
// estado = 3;// MANUTENÇAO //Horta em manutenção AVISA O USUSARIO NAO ENVIA DADOS

#define estado  2

//##############################################################

void setup() {
  lcd.init(); // inicia o lcd 
  lcd.backlight(); // liga o back light do lcd
  lcd.setCursor(4,0);  //escreve o nome e informa admin
  lcd.print("e-Horta");
  lcd.setCursor(5,1);
  lcd.print("ADMIN");
    
  Ethernet.begin(mac);
  ThingSpeak.begin(client);
}

void loop() {
  lcd.clear();
  lcd.setCursor(4,0);  //escreve o nome e informa admin
  lcd.print("e-Horta");
  lcd.setCursor(5,1);
  lcd.print("ADMIN");
  delay(10000);
  lcd.clear();
  lcd.setCursor(4,0);  //escreve o nome e informa admin
  lcd.print("e-Horta");
  switch (estado) {
    case 1:
      lcd.setCursor(3,1);
      lcd.print("DESATIVADO");
      break;
    case 2:
      lcd.setCursor(2,1);
      lcd.print("TRANSMITINDO");
      break;
    case 3:
      lcd.setCursor(2,1);
      lcd.print("MANUTENCAO");
      break;
    default: 
      lcd.setCursor(4,1);
      lcd.print("ERRO");
    break;
  }
  

  ThingSpeak.writeField(myChannelNumber, 1, estado, myWriteAPIKey);
  delay(5000); // ThingSpeak will only accept updates every 15 seconds.
}
