/*#######################################################################################
#### ARQUIVO:          Arduino_E-HORTA_ARDUINO.ino                                       
#### Processor:        Arduino UNO ou MEGA                                               
#### Author:           Marcelo Moraes                                                    
#### Date:             02/07/17                                                          
#### place:            Brazil, São Paulo                                                 
#######################################################################################*/
// Bibliotecas
#include "ThingSpeak.h"
#include <SPI.h>
#include <Ethernet.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>

// configuração enternet shield
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
EthernetClient client;

//Definição medição de voltagem
#define VOLTAGE_MAX 5.0
#define VOLTAGE_MAXCOUNTS 1023.0

//configuração ThingSpeak canal e api key
unsigned long myChannelNumber = 295698;
const char * myWriteAPIKey = "9LOKDR9QC87VR8CI";

//Configuração lcd serial
LiquidCrystal_I2C lcd(0x3f, 16, 2);
const char *lcdSerial[] =
{
  "E-HORTA",          //0
  "V.: 2.2.2",       //1
  " - ",              //2
  "Testando Conexão", //3
  "CONECTADO",        //4
  "MANUTENCAO",       //5
  "DESATIVADO",       //6
  "DESCONECTADO",     //7
  "Status",          //8
  ":",                //9
  " "                 //10
};


//Variaveis Globais
boolean Enviar = false;

void setup() {
  LcdSerial_Start();
  Conecta();
}

void loop() {
  Teste();
  lcd_Print();
  if(Enviar == true) {
    envia();
  }

  delay(15000); 
}

void Teste()  {
  int resposta = ThingSpeak.readFloatField(295257,1);
  if(resposta != 0) {
    Enviar = true;
  }else{
    Enviar = false;
    Conecta();
  }
}

void Conecta()  {
  Ethernet.begin(mac);
  ThingSpeak.begin(client);
}

void envia(){
  float pinVoltage = (random(500) / 5.00);
  ThingSpeak.setField(1,pinVoltage);
  lcd.setCursor(0,0);
  lcd.print(pinVoltage);
  lcd.setCursor(2,0);
  lcd.print(lcdSerial[10]);
  lcd.setCursor(3,0);
  lcd.print(lcdSerial[10]);
  delay(10);
  pinVoltage = (random(1000) / 20.00) - 10.00;
  ThingSpeak.setField(2,pinVoltage);
  lcd.setCursor(4,0);
  lcd.print(pinVoltage);
  lcd.setCursor(7,0);
  lcd.print(lcdSerial[10]);
  lcd.setCursor(8,0);
  lcd.print(lcdSerial[10]);
  delay(10);
  pinVoltage = (random(500) / 5.00);
  ThingSpeak.setField(3,pinVoltage);
  lcd.setCursor(8,0);
  lcd.print(pinVoltage);
  lcd.setCursor(10,0);
  lcd.print(lcdSerial[10]);
  lcd.setCursor(11,0);
  lcd.print(lcdSerial[10]);
  delay(10);
  pinVoltage = (map(random(1000),0,1000,0,1400) / 100.00);
  ThingSpeak.setField(4,pinVoltage);
  lcd.setCursor(12,0);
  lcd.print(pinVoltage);
  ThingSpeak.writeFields(myChannelNumber, myWriteAPIKey);   
}

void LcdSerial_Start() {
  lcd.init();
  lcd.backlight();
  lcd.setCursor(4,0);
  lcd.print(lcdSerial[0]);
  lcd.setCursor(3,1);
  lcd.print(lcdSerial[1]);
}

void lcd_Print()  {
  if(Enviar == true){
    lcd.clear();
    lcd.setCursor(4,0);
    lcd.print(lcdSerial[0]);
    lcd.setCursor(3,1);
    lcd.print(lcdSerial[4]);  
  }else{
    lcd.clear();
    lcd.setCursor(4,0);
    lcd.print(lcdSerial[0]);
    lcd.setCursor(2,1);
    lcd.print(lcdSerial[7]); 
  }
}


