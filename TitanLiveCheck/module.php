<?
    // Klassendefinition
    class Alarmanlage extends IPSModule {

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

            // Ereignis für Auslösung
            $eid = IPS_CreateEvent(1);     //Zyklisches Ereignis
            IPS_SetEventCyclic($eid, 2, 1, 0, 0, 3, 6);

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
          $Project = GetValue($this->GetIDForIdent("License"))
          SMTP_SendMail($this->GetIDForIdent("Alive"), "ALIVE: " $Project, " ");

        }

        public function UpdateCheck() {

        }


    }
?>
