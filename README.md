# `validate.php`

![GitHub repo size](https://img.shields.io/github/repo-size/K3nguruh/validate)
![GitHub issues](https://img.shields.io/github/issues/K3nguruh/validate)
![GitHub license](https://img.shields.io/github/license/K3nguruh/validate)
![GitHub stars](https://img.shields.io/github/stars/K3nguruh/validate)
![GitHub forks](https://img.shields.io/github/forks/K3nguruh/validate)

Diese Klasse enthält eine Sammlung von Methoden zur Validierung von Eingabedaten. Sie ermöglicht es, Werte auf Vorhandensein, Übereinstimmung mit bestimmten Mustern (z. B. regulären Ausdrücken) sowie auf numerische und datumsbezogene Anforderungen zu prüfen. Besonders nützlich ist sie für Webanwendungen, in denen Benutzereingaben überprüft werden müssen.

## Funktionalitäten

- Überprüfung auf Pflichtfelder und leere Werte
- Validierung von E-Mail-Adressen und URLs
- Text- und HTML-Validierung
- Numerische Vergleiche (min, max, zwischen)
- Datumsvalidierung mit flexiblem Format
- Mustervergleich mittels regulärer Ausdrücke

## Voraussetzungen

- PHP `8.0` oder höher
- PHP mit aktivierter Filter-Extension für E-Mail und URL-Validierung
- PHP mit aktivierter DateTime-Extension für Datumsvalidierung

## Methoden

| **Methode**                                                  | **Beschreibung**                                                                                                                                                                                                              | **(Typ) Parameter**                                                                  | **Standardwert**     |
| ------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ | -------------------- |
| **`validateRequired($value)`**                               | Prüft ob ein Wert vorhanden und nicht leer ist. Bei null, leeren Strings, leeren Arrays und false wird false zurückgegeben. Ideal für Pflichtfelder in Formularen wie Name, E-Mail oder andere erforderliche Eingaben.        | `(mixed) $value`                                                                     | -                    |
| **`validateEqual($value, $compare)`**                        | Prüft ob zwei Werte strikt gleich sind (===). Bei numerischen Werten und Strings wird Wert und Typ verglichen. Perfekt für Passwort-Bestätigungen, Token-Vergleiche oder andere exakte Übereinstimmungen.                     | `(mixed) $value`<br>`(mixed) $compare`                                               | -                    |
| **`validateMatch($value, $regex)`**                          | Prüft ob ein String einem regulären Ausdruck entspricht. Bei numerischen Werten erfolgt eine String-Konvertierung. Nützlich für Benutzernamen, Produktcodes oder andere formatierte Strings.                                  | `(string) $value`<br>`(string) $regex`                                               | -                    |
| **`validateText($value)`**                                   | Prüft ob ein Text keine HTML-Tags enthält. Bei HTML-Tags wird false zurückgegeben. Wichtig für reine Texteingaben wie Kommentare, Beschreibungen oder andere Textfelder.                                                      | `(string) $value`                                                                    | -                    |
| **`validateHtml($value, $allowedTags)`**                     | Prüft ob ein HTML-Text nur erlaubte Tags enthält. Bei nicht erlaubten Tags wird false zurückgegeben. Essentiell für WYSIWYG-Editoren, Blog-Beiträge oder andere HTML-Eingaben.                                                | `(string) $value`<br>`(string) $allowedTags`                                         | `$allowedTags`: [1]  |
| **`validateEmail($value)`**                                  | Prüft ob eine E-Mail-Adresse gültig ist. Nutzt PHPs integrierte Validierung für Format und Syntax. Unerlässlich für Registrierungen, Kontaktformulare oder Newsletter-Anmeldungen.                                            | `(string) $value`                                                                    | -                    |
| **`validateUrl($value)`**                                    | Prüft ob eine URL gültig ist. Unterstützt HTTP(S), FTP und andere Protokolle. Wichtig für Weblinks, Profilangaben oder externe Referenzen.                                                                                    | `(string) $value`                                                                    | -                    |
| **`validateDate($value, $format)`**                          | Prüft ob ein Datum im angegebenen Format gültig ist. Erkennt ungültige Daten wie 31.02. Perfekt für Geburtstage, Termine oder andere Kalenderdaten.                                                                           | `(string) $value`<br>`(string) $format`                                              | `$format`: `"Y-m-d"` |
| **`validateMin($value, $minValue, $format)`**                | Prüft ob ein Wert größer/gleich dem Minimum ist (>=). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Ideal für Mindestalter, Mindestpreise oder zeitliche Untergrenzen.                            | `(mixed) $value`<br>`(mixed) $minValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateMax($value, $maxValue, $format)`**                | Prüft ob ein Wert kleiner/gleich dem Maximum ist (<=). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Optimal für Höchstalter, Preisobergrenzen oder zeitliche Deadlines.                          | `(mixed) $value`<br>`(mixed) $maxValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateMinMax($value, $minValue, $maxValue, $format)`**  | Prüft ob ein Wert zwischen Minimum und Maximum liegt [inklusiv]. Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Perfekt für Preisbereiche, Altersspannen oder Zeiträume.                           | `(mixed) $value`<br>`(mixed) $minValue`<br>`(mixed) $maxValue`<br>`(string) $format` | `$format`: `null`    |
| **`validateLess($value, $maxValue, $format)`**               | Prüft ob ein Wert strikt kleiner als das Maximum ist (<). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Ideal für strikte Obergrenzen bei Preisen, Mengen oder Zeitpunkten.                       | `(mixed) $value`<br>`(mixed) $maxValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateGreater($value, $minValue, $format)`**            | Prüft ob ein Wert strikt größer als das Minimum ist (>). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Optimal für strikte Untergrenzen bei Preisen, Mengen oder Zeitpunkten.                     | `(mixed) $value`<br>`(mixed) $minValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateBetween($value, $minValue, $maxValue, $format)`** | Prüft ob ein Wert strikt zwischen Minimum und Maximum liegt (exklusiv). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Perfekt für exklusive Bereiche bei Preisen, Altersgruppen oder Zeitspannen. | `(mixed) $value`<br>`(mixed) $minValue`<br>`(mixed) $maxValue`<br>`(string) $format` | `$format`: `null`    |

> _[1]: `"<a><b><blockquote><br><code><div><em><h1><h2><h3><h4><h5><h6><hr><i><li><ol><p><s><span><strong><u><ul>"`_

## Rückgabewerte

Alle Validierungsmethoden geben einen boolean-Wert zurück:

- `true`: Validierung erfolgreich
- `false`: Validierung fehlgeschlagen

## Fehlerbehandlung

Die Klasse wirft keine Exceptions und führt eine stille Fehlerbehandlung durch. Bei ungültigen Eingaben wird `false` zurückgegeben.

## Installation

```sh
git clone https://github.com/K3nguruh/validate.git
```

## Anwendung

### Beispielcode

```php
<?php

// Validierungsklasse einbinden
require_once "path/to/validate.php";

// Validate-Instanz erstellen
$validate = new Validate();

// ========== ALLGEMEINE VALIDIERUNGEN ==========

// Pflichtfeld prüfen (prüft leere Werte, null, false, leere Arrays)
if ($validate->validateRequired($_POST["username"])) {
  echo "Benutzername ist vorhanden\n";
}

// Gleichheit prüfen (prüft strikte Gleichheit ===)
if ($validate->validateEqual($_POST["password"], $_POST["password_confirm"])) {
  echo "Passwörter stimmen überein\n";
}

// ========== TEXT-VALIDIERUNGEN ==========

// Musterprüfung (prüft alphanumerische Zeichen, 3-20 Zeichen)
if ($validate->validateMatch($_POST["username"], "^[a-zA-Z0-9]{3,20}$")) {
  echo "Benutzername enthält nur erlaubte Zeichen\n";
}

// HTML-Prüfung (prüft auf HTML-Tags und gibt false zurück wenn gefunden)
if ($validate->validateText($_POST["comment"])) {
  echo "Kommentar enthält keine HTML-Tags\n";
}

// ========== HTML-VALIDIERUNGEN ==========

// HTML-Standard (prüft auf vordefinierte sichere Tags)
if ($validate->validateHtml($_POST["content"])) {
  echo "HTML enthält nur Standardtags\n";
}

// HTML-Eingeschränkt (prüft auf <p> und <a> Tags)
if ($validate->validateHtml($_POST["content"], "<p><a>")) {
  echo "HTML enthält nur <p> und <a> Tags\n";
}

// ========== FORMAT-VALIDIERUNGEN ==========

// E-Mail-Validierung (prüft Format und Syntax)
if ($validate->validateEmail($_POST["email"])) {
  echo "E-Mail-Adresse ist gültig\n";
}

// URL-Validierung (prüft Schema, Host und Syntax)
if ($validate->validateUrl($_POST["website"])) {
  echo "Website-URL ist gültig\n";
}

// ========== DATUMS-VALIDIERUNGEN ==========

// Standardformat (Y-m-d)
if ($validate->validateDate($_POST["birthdate"])) {
  echo "Datum ist im Format Y-m-d\n";
}

// Benutzerdefiniertes Format (d.m.Y)
if ($validate->validateDate($_POST["customDate"], "d.m.Y")) {
  echo "Datum ist im Format d.m.Y\n";
}

// ========== NUMERISCHE VALIDIERUNGEN ==========

// Mindestwert (>=, größer oder gleich)
if ($validate->validateMin($_POST["age"], 18)) {
  echo "Alter ist größer oder gleich 18\n";
}

// Maximalwert (<=, kleiner oder gleich)
if ($validate->validateMax($_POST["age"], 99)) {
  echo "Alter ist kleiner oder gleich 99\n";
}

// Bereichsprüfung (>=, <=, inklusiv)
if ($validate->validateMinMax($_POST["age"], 18, 99)) {
  echo "Alter liegt zwischen 18 und 99 (18 <= Alter <= 99)\n";
}

// Kleiner als (<, exklusiv)
if ($validate->validateLess($_POST["price"], 1000)) {
  echo "Preis ist kleiner als 1000 (Preis < 1000)\n";
}

// Größer als (>, exklusiv)
if ($validate->validateGreater($_POST["price"], 0)) {
  echo "Preis ist größer als 0 (Preis > 0)\n";
}

// Bereichsprüfung (>, <, exklusiv)
if ($validate->validateBetween($_POST["price"], 0, 1000)) {
  echo "Preis liegt zwischen 0 und 1000 (0 < Preis < 1000)\n";
}

// ========== DATUMS-VERGLEICHE ==========

// Mindestdatum (>=, nach oder gleich)
if ($validate->validateMin("2025-01-01", "2024-01-01", "Y-m-d")) {
  echo "Datum ist nach oder gleich dem 01.01.2024\n";
}

// Maximaldatum (<=, vor oder gleich)
if ($validate->validateMax("2025-01-01", "2026-01-01", "Y-m-d")) {
  echo "Datum ist vor oder gleich dem 01.01.2026\n";
}

// Datumsbereich (>=, <=, inklusiv)
if ($validate->validateMinMax("2025-01-01", "2024-01-01", "2026-01-01", "Y-m-d")) {
  echo "Datum liegt zwischen 01.01.2024 und 01.01.2026 (inklusive)\n";
}
```

## Support

Bei Fragen oder Problemen:

- Erstelle ein [GitHub Issue](https://github.com/K3nguruh/validate/issues)
- Kontaktiere den Maintainer

## Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert. Siehe [LICENSE](LICENSE.md) für Details.
