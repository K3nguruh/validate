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

| **Methode**                                                  | **Beschreibung**                                                                                                                                                                                                                | **(Typ) Parameter**                                                                  | **Standardwert**     |
| ------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ | -------------------- |
| **`validateRequired($value)`**                               | Prüft ob ein Wert vorhanden und nicht leer ist. Bei null, leeren Strings, leeren Arrays und false wird false zurückgegeben. Ideal für Pflichtfelder in Formularen wie Name, E-Mail oder andere erforderliche Eingaben.          | `(mixed) $value`                                                                     | -                    |
| **`validateEqual($value, $compare)`**                        | Prüft ob zwei Werte inhaltlich übereinstimmen. Verwendet den nicht-strikten Vergleichsoperator (==), der Typkonvertierungen durchführt. Perfekt für Passwort-Bestätigungen, Token-Vergleiche oder andere Wertübereinstimmungen. | `(mixed) $value`<br>`(mixed) $compare`                                               | -                    |
| **`validateNotEqual($value, $compare)`**                     | Prüft ob zwei Werte inhaltlich nicht übereinstimmen. Verwendet den nicht-strikten Ungleichheitsoperator (!=), der Typkonvertierungen durchführt. Nützlich für Constraint-Validierungen oder Ausschlussvergleiche.               | `(mixed) $value`<br>`(mixed) $compare`                                               | -                    |
| **`validateMatch($value, $regex)`**                          | Prüft ob ein String einem regulären Ausdruck entspricht. Bei numerischen Werten erfolgt eine String-Konvertierung. Nützlich für Benutzernamen, Produktcodes oder andere formatierte Strings.                                    | `(string) $value`<br>`(string) $regex`                                               | -                    |
| **`validateText($value)`**                                   | Prüft ob ein Text keine HTML-Tags enthält. Bei HTML-Tags wird false zurückgegeben. Wichtig für reine Texteingaben wie Kommentare, Beschreibungen oder andere Textfelder.                                                        | `(string) $value`                                                                    | -                    |
| **`validateHtml($value, $allowedTags)`**                     | Prüft ob ein HTML-Text nur erlaubte Tags enthält. Bei nicht erlaubten Tags wird false zurückgegeben. Essentiell für WYSIWYG-Editoren, Blog-Beiträge oder andere HTML-Eingaben.                                                  | `(string) $value`<br>`(string) $allowedTags`                                         | `$allowedTags`: [1]  |
| **`validateEmail($value)`**                                  | Prüft ob eine E-Mail-Adresse gültig ist. Nutzt PHPs integrierte Validierung für Format und Syntax. Unerlässlich für Registrierungen, Kontaktformulare oder Newsletter-Anmeldungen.                                              | `(string) $value`                                                                    | -                    |
| **`validateUrl($value)`**                                    | Prüft ob eine URL gültig ist. Unterstützt HTTP(S), FTP und andere Protokolle. Wichtig für Weblinks, Profilangaben oder externe Referenzen.                                                                                      | `(string) $value`                                                                    | -                    |
| **`validateDate($value, $format)`**                          | Prüft ob ein Datum im angegebenen Format gültig ist. Erkennt ungültige Daten wie 31.02. Perfekt für Geburtstage, Termine oder andere Kalenderdaten.                                                                             | `(string) $value`<br>`(string) $format`                                              | `$format`: `"Y-m-d"` |
| **`validateMin($value, $minValue, $format)`**                | Prüft ob ein Wert größer/gleich dem Minimum ist (>=). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Ideal für Mindestalter, Mindestpreise oder zeitliche Untergrenzen.                              | `(mixed) $value`<br>`(mixed) $minValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateMax($value, $maxValue, $format)`**                | Prüft ob ein Wert kleiner/gleich dem Maximum ist (<=). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Optimal für Höchstalter, Preisobergrenzen oder zeitliche Deadlines.                            | `(mixed) $value`<br>`(mixed) $maxValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateMinMax($value, $minValue, $maxValue, $format)`**  | Prüft ob ein Wert zwischen Minimum und Maximum liegt [inklusiv]. Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Perfekt für Preisbereiche, Altersspannen oder Zeiträume.                             | `(mixed) $value`<br>`(mixed) $minValue`<br>`(mixed) $maxValue`<br>`(string) $format` | `$format`: `null`    |
| **`validateLess($value, $maxValue, $format)`**               | Prüft ob ein Wert strikt kleiner als das Maximum ist (<). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Ideal für strikte Obergrenzen bei Preisen, Mengen oder Zeitpunkten.                         | `(mixed) $value`<br>`(mixed) $maxValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateGreater($value, $minValue, $format)`**            | Prüft ob ein Wert strikt größer als das Minimum ist (>). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Optimal für strikte Untergrenzen bei Preisen, Mengen oder Zeitpunkten.                       | `(mixed) $value`<br>`(mixed) $minValue`<br>`(string) $format`                        | `$format`: `null`    |
| **`validateBetween($value, $minValue, $maxValue, $format)`** | Prüft ob ein Wert strikt zwischen Minimum und Maximum liegt (exklusiv). Bei Datumswerten wird der Format-Parameter für die Konvertierung genutzt. Perfekt für exklusive Bereiche bei Preisen, Altersgruppen oder Zeitspannen.   | `(mixed) $value`<br>`(mixed) $minValue`<br>`(mixed) $maxValue`<br>`(string) $format` | `$format`: `null`    |

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

### Einbindung

```php
require_once "path/to/validate.php";
```

### Initialisierung

```php
$validate = new Validate();
```

## Beispiele

```php
// =============== ALLGEMEINE VALIDIERUNGEN ===============

// Prüfung auf Pflichtfeld
if (!$validate->validateRequired($_POST["username"])) {
  $errors[] = "Benutzername ist ein Pflichtfeld";
}

// Prüfung auf Gleichheit
if (!$validate->validateEqual($_POST["password"], $_POST["password_confirm"])) {
  $errors[] = "Die Passwörter stimmen nicht überein";
}

// Prüfung auf Ungleichheit
if (!$validate->validateNotEqual($_POST["username"], $_POST["password"])) {
  $errors[] = "Benutzername und Passwort dürfen nicht identisch sein";
}

// ================== TEXT-VALIDIERUNGEN ==================

// Prüfung auf Musterübereinstimmung
if (!$validate->validateMatch($_POST["username"], "^[a-zA-Z0-9]{3,20}$")) {
  $errors[] = "Benutzername darf nur aus 3-20 alphanumerischen Zeichen bestehen";
}

// Prüfung auf reinen Text
if (!$validate->validateText($_POST["comment"])) {
  $errors[] = "Der Kommentar darf keine HTML-Tags enthalten";
}

// ================== HTML-VALIDIERUNGEN ==================

// Prüfung auf erlaubte HTML-Tags
if (!$validate->validateHtml($_POST["content"])) {
  $errors[] = "Der HTML-Inhalt enthält nicht erlaubte Tags";
}

// Prüfung auf eingeschränkte HTML-Tags
if (!$validate->validateHtml($_POST["content"], "<p><a>")) {
  $errors[] = "Der HTML-Inhalt darf nur <p> und <a> Tags enthalten";
}

// ================= FORMAT-VALIDIERUNGEN =================

// Prüfung auf gültige E-Mail
if (!$validate->validateEmail($_POST["email"])) {
  $errors[] = "Die E-Mail-Adresse ist ungültig";
}

// Prüfung auf gültige URL
if (!$validate->validateUrl($_POST["website"])) {
  $errors[] = "Die Website-URL ist ungültig";
}

// ============== DATUMS-FORMAT-VALIDIERUNGEN =============

// Prüfung auf gültiges Datum (Standard-Format)
if (!$validate->validateDate($_POST["birthdate"])) {
  $errors[] = "Das Geburtsdatum muss im Format JJJJ-MM-TT angegeben werden";
}

// Prüfung auf gültiges Datum (Benutzerdefiniertes Format)
if (!$validate->validateDate($_POST["customDate"], "d.m.Y")) {
  $errors[] = "Das Datum muss im Format TT.MM.JJJJ angegeben werden";
}

// =============== NUMERISCHE VALIDIERUNGEN ===============

// Prüfung auf Mindestwert (inklusiv)
if (!$validate->validateMin($_POST["age"], 18)) {
  $errors[] = "Sie müssen mindestens 18 Jahre alt sein";
}

// Prüfung auf Maximalwert (inklusiv)
if (!$validate->validateMax($_POST["age"], 99)) {
  $errors[] = "Das Alter darf maximal 99 Jahre betragen";
}

// Prüfung auf Wertebereich (inklusiv)
if (!$validate->validateMinMax($_POST["age"], 18, 99)) {
  $errors[] = "Das Alter muss zwischen 18 und 99 Jahren liegen";
}

// Prüfung auf kleineren Wert (exklusiv)
if (!$validate->validateLess($_POST["price"], 1000)) {
  $errors[] = "Der Preis darf nicht 1000€ oder mehr betragen";
}

// Prüfung auf größeren Wert (exklusiv)
if (!$validate->validateGreater($_POST["price"], 0)) {
  $errors[] = "Der Preis muss größer als 0€ sein";
}

// Prüfung auf Wertebereich (exklusiv)
if (!$validate->validateBetween($_POST["price"], 0, 1000)) {
  $errors[] = "Der Preis muss zwischen 0€ und 1000€ liegen";
}

// ============== TEXT-LÄNGEN-VALIDIERUNGEN ===============

// Prüfung auf Mindestlänge (inklusiv)
if (!$validate->validateMin($_POST["password"], 8)) {
  $errors[] = "Das Passwort muss mindestens 8 Zeichen lang sein";
}

// Prüfung auf Maximallänge (inklusiv)
if (!$validate->validateMax($_POST["summary"], 200)) {
  $errors[] = "Die Zusammenfassung darf maximal 200 Zeichen lang sein";
}

// Prüfung auf Längenbereich (inklusiv)
if (!$validate->validateMinMax($_POST["description"], 50, 1000)) {
  $errors[] = "Die Beschreibung muss zwischen 50 und 1000 Zeichen lang sein";
}

// ============== DATUMS-WERT-VALIDIERUNGEN ===============

// Prüfung auf Mindestdatum (inklusiv)
if (!$validate->validateMin($_POST["event_date"], "2025-01-01", "Y-m-d")) {
  $errors[] = "Das Veranstaltungsdatum muss nach oder gleich dem 01.01.2025 sein";
}

// Prüfung auf Maximaldatum (inklusiv)
if (!$validate->validateMax($_POST["event_date"], "2025-12-31", "Y-m-d")) {
  $errors[] = "Das Veranstaltungsdatum darf nicht nach dem 31.12.2025 liegen";
}

// Prüfung auf Datumsbereich (inklusiv)
if (!$validate->validateMinMax($_POST["event_date"], "2025-01-01", "2025-12-31", "Y-m-d")) {
  $errors[] = "Das Veranstaltungsdatum muss zwischen 01.01.2025 und 31.12.2025 liegen";
}

// Prüfung auf früheres Datum (exklusiv)
if (!$validate->validateLess($_POST["event_date"], "2026-01-01", "Y-m-d")) {
  $errors[] = "Das Veranstaltungsdatum muss vor dem 01.01.2026 liegen";
}

// Prüfung auf späteres Datum (exklusiv)
if (!$validate->validateGreater($_POST["event_date"], "2024-12-31", "Y-m-d")) {
  $errors[] = "Das Veranstaltungsdatum muss nach dem 31.12.2024 liegen";
}

// Prüfung auf Datumsbereich (exklusiv)
if (!$validate->validateBetween($_POST["event_date"], "2024-12-31", "2026-01-01", "Y-m-d")) {
  $errors[] = "Das Veranstaltungsdatum muss zwischen 31.12.2024 und 01.01.2026 liegen";
}

// Fehler anzeigen (falls vorhanden)
if (!empty($errors)) {
  foreach ($errors as $error) {
    echo "<div class='error'>$error</div>";
  }
}
```

## Support

Bei Fragen oder Problemen:

- Erstelle ein [GitHub Issue](https://github.com/K3nguruh/validate/issues)
- Kontaktiere den Maintainer

## Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert. Siehe [LICENSE](LICENSE.md) für Details.
