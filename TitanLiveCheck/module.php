<?
    // Klassendefinition
    class TitanLiveCheck extends IPSModule {

        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);

            // Selbsterstellter Code
        }

        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

            // Eigenschaften für Einstellungen
            $this->RegisterPropertyInteger("Alive", 0);               // Eigenschat um SMTP Instanz (Live Check) auszuwählen
            $this->RegisterPropertyInteger("LastUpdate", 0);          // Eigenschat um SMTP Instanz (Aktuallisierungs Check) auszuwählen
            $this->RegisterPropertyString("License", "");             // String eingage für die jeweilige Lizenz
            $this->RegisterPropertyInteger("IntLiveCheck", 1440);     // Eigenschaft für Eingabe der Intervallzeit für den Live Check (Standard 24h)
            $this->RegisterPropertyInteger("IntUpdateCheck", 1440);   // Eigenschaft für Eingabe der Intervallzeit für den Aktuallisierungs Check (Standard 24h)
            $this->RegisterPropertyInteger("LastUpdateDiff", 1380);   // Eigenschaft für Eingabe der der Differenz seit der letzten Aktuallisierung (Standard 23h)
            $this->RegisterPropertyString("Supplement", "[]");        // Liste zum Einfügen der zu überprüfenden Variablen

            // Zyklisches auslösen
            // Live Check Standard 1x am Tag
            $this->RegisterTimer("AliveCheck", 0, 'TLC_LiveCheck($_IPS[\'TARGET\']);');     // Timer in Millisekunden für den Live Check, hier 0 ms wird in "ApplyChanges" eingestellt
            // Update Check Standard 1x am Tag
            $this->RegisterTimer("UpdateCheck", 0, 'TLC_UpdateCheck($_IPS[\'TARGET\']);');  // Timer in Millisekunden für den Aktuallisierungs Check, hier 0 ms wird in "ApplyChanges" eingestellt


        }


        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        // Wird nicht benötigt, keine Bedienung durch WebFront
        public function RequestAction($Ident, $Value) {

              switch($Ident) {
                    case "":

                    break;
                    case "":

                    break;
                    case "":

                    break;
                    case "":

                    break;
                    case "":

                    break;
                    }

      }

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */

        // Funktion für Live Check, kann auch über Ereignisse oder Skripts aufgerufen werden
        public function LiveCheck() {


          // Sendet alle 24h einen E-Mail
          $BetreffAlive = "ALIVE: " . $this->ReadPropertyString("License");         // Betreff erstellen für Live Check Mail

          SMTP_SendMail($this->ReadPropertyInteger("Alive"), $BetreffAlive, " ");   // Senden der Live Check Mail

        }

        // Funktion für Aktuallisierungs Check, kann auch über Ereignisse oder Skripts aufgerufen werden
        public function UpdateCheck() {
            $IDarray = json_decode($this->ReadPropertyString("Supplement"), true);    // Auslesen der Liste mit den zu überprüfende Variablen, alle Variablen werden in ein Array eingefügt

            // Jeden eintrag vom Array mit den zu überprüfende Variablen einzeln prüfen
            foreach ($IDarray as $VarID) {
                $VarIDString = implode($VarID);                                       // aus dem array Eintrag ein String machen
                $VarInfo = IPS_GetVariable($VarIDString);                             // Mit der ID die oben als string gespeichert wird sämtliche Variablen information in ein Array speichern.
                $TimeDiff = strtotime("now") - $VarInfo["VariableUpdated"];           // Zeit Differenz von Jetzt zum letzten Update der Variable ausrechnen wird als Unix Timestamp ausgegeben.
                $DiffToLastUpdate = $this->ReadPropertyInteger("LastUpdateDiff")*60;  // Angabe der Differenz

                // Überprüfen ob die Differenz zu gross ist.
                if($TimeDiff > $DiffToLastUpdate)
                {
                  $BetreffALERT = "ALERT: " . $this->ReadPropertyString("License");   // Betreff für Aktuallisierungs Check Mail erstellen
                  $ParentID = IPS_GetParent($VarIDString);                            // ID der übergeordente Variable ermitteln für Mail Inhalt
                  $ParentName = IPS_GetName($ParentID);                               // Name der übergeordente Variable ermitteln für Mail Inhalt
                  $VariableName = IPS_GetName($VarIDString);                          // Variable Name ermitteln für Mail Inhalt
                  $LastUpdate = date("d.m.y - H:i:s", $VarInfo["VariableUpdated"]);   // Unix Timestamp in leserliche Datumsangabe umwandeln, für Mail Inhalt.

                  SMTP_SendMail($this->ReadPropertyInteger("LastUpdate"), $BetreffALERT, "INSTANZ: $ParentName / VARIABLE: $VariableName / VARIABLEN ID: $VarIDString / LETZTES UPDATE: $LastUpdate");      // Mail fals Zeitdifferenz zu gross ist.
                }

            }
        }

        public function ApplyChanges() {

            // Diese Zeile nicht löschen
            parent::ApplyChanges();

            // Intervall Alive
            $IntervallAlive = $this->ReadPropertyInteger("IntLiveCheck");       // Zahl aus Konfigurationsformular Auslesen
            $this->SetTimerInterval("AliveCheck", $IntervallAlive*60*1000);     // Zahl aus Konfigurationsformular in Millisekunden umrechnen und in Live Chek Timer einfügen

            // Intervall Update
            $IntervallUpdate = $this->ReadPropertyInteger("IntUpdateCheck");    // Zahl aus Konfigurationsformular Auslesen
            $this->SetTimerInterval("UpdateCheck", $IntervallUpdate*60*1000);   // Zahl aus Konfigurationsformular in Millisekunden umrechnen und in Aktuallisierungs Chek Timer einfügen

          }


    }
?>
