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
            $this->RegisterPropertyInteger("IntLiveCheck", 1440);
            $this->RegisterPropertyInteger("IntUpdateCheck", 1440);
            $this->RegisterPropertyInteger("LastUpdateDiff", 1380);
            $this->RegisterPropertyString("Supplement", "[]");

            // Zyklisches auslösen
            // Live Check Standard 1x am Tag
            $this->RegisterTimer("AliveCheck", 0, 'TLC_LiveCheck($_IPS[\'TARGET\']);');
            // Update Check Standard 1x am Tag
            $this->RegisterTimer("UpdateCheck", 0, 'TLC_LiveCheck($_IPS[\'TARGET\']);');


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
          $BetreffAlive = "ALIVE: " . $this->ReadPropertyString("License");

          SMTP_SendMail($this->ReadPropertyInteger("Alive"), $BetreffAlive, " ");

        }

        public function UpdateCheck() {
            $IDarray = json_decode($this->ReadPropertyString("Supplement"), true);

            foreach ($IDarray as $VarID) {
                $VarIDString = implode($VarID);
                $VarInfo = IPS_GetVariable($VarIDString);
                $TimeDiff = strtotime("now") - $VarInfo["VariableUpdated"];
                $DiffToLastUpdate = $this->ReadPropertyInteger("LastUpdateDiff")*60;


                if($TimeDiff > $DiffToLastUpdate)
                {
                  $BetreffALERT = "ALERT: " . $this->ReadPropertyString("License");
                  $ParentID = IPS_GetParent($VarIDString);
                  $ParentName = IPS_GetName($ParentID);
                  $VariableName = IPS_GetName($VarIDString);
                  $LastUpdate = date("d.m.y - H:i:s", $VarInfo["VariableUpdated"]);

                  SMTP_SendMail($this->ReadPropertyInteger("LastUpdate"), $BetreffALERT, "$ParentName: $VariableName, $VarIDString; Letzter Update: $LastUpdate");
                }

            }
        }

        public function ApplyChanges() {

            // Diese Zeile nicht löschen
            parent::ApplyChanges();

            // Intervall Alive
            $IntervallAlive = $this->ReadPropertyInteger("IntLiveCheck");
            $this->SetTimerInterval("AliveCheck", $IntervallAlive*60*1000);

            // Intervall Update
            $IntervallUpdate = $this->ReadPropertyInteger("IntUpdateCheck");
            $this->SetTimerInterval("UpdateCheck", $IntervallUpdate*60*1000);

          }


    }
?>
