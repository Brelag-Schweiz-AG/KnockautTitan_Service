# KnockautTitan_Service

### Version
1.0

### Funktion
Modul zur überprüfung der Variablen aktuallisierung und für die Periodische meldung der Symbox.

### Konfigurationsformular
Einstellmöglichkeiten:
  - SMTP Instanz für den Alive Check
  - SMTP Instanz für den Aktuallisierungs Check
  - Eingabe der Lizenz
  - Liste mit der zu Prüfende Variablen
  - Intervall Zeit in Minuten für den Alive Check
  - Intervall Zeit in Minuten für den Aktuallisierungs Check
  - Notwendige Differenzzeit (letzte Aktuallisierung bis jetzt) für senden einer E-Mail

### Funktionen
  - KTS_LiveCheck: Periodisches versenden einer Mail als Lebenszeichen.
  - KTS_UpdateCheck: Periodisches überprüfen von ausgewählten Variablen.
