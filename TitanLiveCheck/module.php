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

            // Zyklisches auslösen
            $this->RegisterTimer("AliveCheck", 0, "TLC_LiveCheck($_IPS[\'TARGET\']);");
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

        }

        public function ApplyChanges() {

            // Diese Zeile nicht löschen
            parent::ApplyChanges();

            $Intervall = 2*1000;
            $this->SetTimerInterval("AliveCheck", $Intervall);

          }


    }
?>
