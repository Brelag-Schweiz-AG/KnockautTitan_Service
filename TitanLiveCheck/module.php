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
            $this->RegisterPropertyInteger("Alive", 0);
            $this->RegisterPropertyInteger("LastUpdate", 0);
            $this->RegisterPropertyString("License", "");
            $this->RegisterPropertyInteger("IntLiveCheck", 12);
            $this->RegisterPropertyInteger("IntUpdateCheck", 12);
            $this->RegisterPropertyString("Supplement", "[]");

            // Zyklisches auslösen
            // Live Check Standard 1x am Tag
            $this->RegisterTimer("AliveCheck", 0, 'TLC_LiveCheck($_IPS[\'TARGET\']);');
            // Update Check Standard 1x am Tag
            $this->RegisterTimer("UpdateCheck", 0, 'TLC_LiveCheck($_IPS[\'TARGET\']);');

            // Test Variablen
            $this->RegisterVariableString("TESTString", "Test String", "", 0);
        }


        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function RequestAction($Ident, $Value) {

              switch($Ident) {
                    case "Password":

                    break;
                    case "Mode":

                    break;
                    case "Quittierung":

                    break;
                    case "OldPassword":

                    break;
                    case "NewPassword":

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
        public function LiveCheck() {


          // Sendet alle 24h einen E-Mail
          $Betreff = "ALIVE: " . $this->ReadPropertyString("License");

          SMTP_SendMail($this->ReadPropertyInteger("Alive"), $Betreff, " ");

        }

        public function UpdateCheck() {
            $IDarray = json_decode($this->ReadPropertyString("Supplement"), true);

            foreach ($IDarray as $VarID) {
                $VarIDString = implode($VarID);
                $VarInfo = IPS_GetVariable($VarIDString);

                SetValue($this->GetIDForIdent("TESTString"), $VarInfo);
            }
        }

        public function ApplyChanges() {

            // Diese Zeile nicht löschen
            parent::ApplyChanges();

            $Intervall = $this->ReadPropertyInteger("IntLiveCheck");
            $this->SetTimerInterval("AliveCheck", $Intervall*60*1000);

          }


    }
?>
