const int buttonPin = 2;  // Broche du bouton poussoir
const int pumpPin = 3;    // Broche du relais de la pompe
const int flowSensorPin = 4; // Broche du capteur de débit
const int humiditySensorPin = A0;

// Variables
bool pumpState = false;   // État initial de la pompe
int flowSensorValue = 0;  // Valeur du capteur de débit
int humiditySensorValue = 0; // Valeur du capteur d'humidité

void setup() {
  // Configuration des broches
 
  pinMode(buttonPin, INPUT_PULLUP);
  pinMode(pumpPin, OUTPUT);
  pinMode(flowSensorPin, INPUT_PULLUP);
  pinMode(humiditySensorPin, INPUT);
  
  // Initialisation du moniteur série
  Serial.begin(9600);

  // Désactivez la pompe au démarrage
  digitalWrite(pumpPin, HIGH);
}

void loop() {
  checkButton();
  checkHumiditySensor();
  checkFlowSensor();
  
  // Affichage de l'état de la pompe et de la valeur des capteurs
  Serial.print("État de la pompe : ");
  Serial.println(pumpState ? "Activée" : "Désactivée");
  Serial.print("Valeur du capteur de débit : ");
  Serial.println(flowSensorValue);
  Serial.print("Valeur du capteur d'humidité : ");
  Serial.println(humiditySensorValue);

  delay(1000);
}

void checkButton() {
  // Vérification de l'état du bouton poussoir
  if (digitalRead(buttonPin) == LOW) {
    // Le bouton est enfoncé, activez la pompe
    
    pumpState = true;
    digitalWrite(pumpPin, LOW);
    Serial.println("Pompe activée");
  } else {
    // Le bouton n'est pas enfoncé, désactivez la pompe
  
    pumpState = false;
    digitalWrite(pumpPin, HIGH);
    resetFlowSensor();
    Serial.println("Pompe désactivée");
  }
}

void checkHumiditySensor() {
  // Lecture de la valeur du capteur d'humidité
  humiditySensorValue = analogRead(humiditySensorPin);

  // Si l'humidité est supérieure à 1000, désactivez la pompe
  if (humiditySensorValue > 1200 && pumpState) {
    pumpState = false;
    digitalWrite(pumpPin, HIGH);
    resetFlowSensor();
    Serial.println("Humidité élevée, pompe désactivée");
  }
}

void checkFlowSensor() {
  // Lecture de la valeur du capteur de débit
  flowSensorValue = analogRead(flowSensorPin);
  flowSensorValue = map(flowSensorValue, 0, 1023, 0, 100);

  // Si le débit est inférieur ou égal à 20 et que la pompe est activée, désactivez la pompe
  if (flowSensorValue <= 20 && pumpState) {
    pumpState = false;
    digitalWrite(pumpPin, HIGH);
    resetFlowSensor();
    Serial.println("Débit faible, pompe désactivée");
  }
}

void resetFlowSensor() {
  // Réinitialiser la valeur du capteur de débit
  flowSensorValue = 0;
  Serial.println("Capteur de débit réinitialisé");
}