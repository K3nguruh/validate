<?php

/**
 * Klasse Validate
 *
 * Diese Klasse enthält eine Sammlung von Methoden zur Validierung von Eingabedaten.
 * Sie ermöglicht es, Werte auf Vorhandensein, Übereinstimmung mit bestimmten
 * Mustern (z. B. regulären Ausdrücken) sowie auf numerische und datumsbezogene
 * Anforderungen zu prüfen. Besonders nützlich ist sie für Webanwendungen, in denen
 * Benutzereingaben überprüft werden müssen.
 *
 *
 * Funktionalitäten
 * - Überprüfung auf Pflichtfelder und leere Werte
 * - Validierung von E-Mail-Adressen und URLs
 * - Text- und HTML-Validierung
 * - Numerische Vergleiche (min, max, zwischen)
 * - Datumsvalidierung mit flexiblem Format
 * - Mustervergleich mittels regulärer Ausdrücke
 *
 *
 * Autor:   K3nguruh <https://github.com/K3nguruh>
 * Version: 1.1.0
 * Datum:   2025-04-21 17:17
 * Lizenz:  MIT-Lizenz
 */

class Validate
{
  /**
   * Prüfung auf nicht-leeren Wert
   *
   * Diese Methode prüft, ob der übergebene Wert nicht leer ist. Dabei erkennt sie
   * leere Zeichenketten, Zeichenfolgen mit nur Leerzeichen, null, false und leere Arrays
   * als leere Werte.
   *
   * Beispiel:
   * validateRequired("Test");  // true
   * validateRequired("");      // false
   * validateRequired("   ");   // false
   * validateRequired(null);    // false
   *
   * @param mixed $value Der zu überprüfende Wert
   * @return bool True wenn der Wert nicht leer ist, ansonsten False
   */
  public function validateRequired(mixed $value): bool
  {
    return !($value === "" || $value === null || $value === false || (is_string($value) && trim($value) === "") || (is_array($value) && empty($value)));
  }

  /**
   * Prüfung auf inhaltliche Gleichheit
   *
   * Diese Methode prüft, ob zwei Werte inhaltlich übereinstimmen. Sie verwendet
   * den nicht-strikten Vergleichsoperator (==), der Typkonvertierungen durchführt und
   * nur den Inhalt, nicht aber den Datentyp berücksichtigt.
   *
   * Beispiel:
   * validateEqual(5, 5);    // true
   * validateEqual(5, "5");  // true
   * validateEqual(5, 6);    // false
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $compare Der Wert, mit dem verglichen werden soll
   * @return bool True wenn die Werte inhaltlich übereinstimmen, ansonsten False
   */
  public function validateEqual(mixed $value, mixed $compare): bool
  {
    return $value == $compare;
  }

  /**
   * Prüfung auf inhaltliche Ungleichheit
   *
   * Diese Methode prüft, ob zwei Werte inhaltlich nicht übereinstimmen. Sie verwendet
   * den nicht-strikten Ungleichheitsoperator (!=), der Typkonvertierungen durchführt und
   * nur den Inhalt, nicht aber den Datentyp berücksichtigt.
   *
   * Beispiel:
   * validateNotEqual(5, 6);    // true
   * validateNotEqual(5, "6");  // true
   * validateNotEqual(5, "5");  // false
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $compare Der Wert, mit dem verglichen werden soll
   * @return bool True wenn die Werte inhaltlich nicht übereinstimmen, ansonsten False
   */
  public function validateNotEqual(mixed $value, mixed $compare): bool
  {
    return $value != $compare;
  }

  /**
   * Prüfung auf Musterübereinstimmung
   *
   * Diese Methode prüft, ob ein Wert vollständig einem regulären Ausdruck entspricht.
   * Der übergebene Wert muss dabei komplett dem angegebenen Muster entsprechen, damit
   * die Validierung erfolgreich ist.
   *
   * Beispiel:
   * validateMatch("abc123", "^[a-z0-9]+$");   // true
   * validateMatch("abc-123", "^[a-z0-9]+$");  // false
   *
   * @param string $value Der zu überprüfende Wert
   * @param string $regex Der reguläre Ausdruck
   * @return bool True wenn der Wert dem regulären Ausdruck entspricht, ansonsten False
   */
  public function validateMatch(string $value, string $regex): bool
  {
    return preg_match("/{$regex}/", $value) === 1;
  }

  /**
   * Prüfung auf reinen Text ohne HTML
   *
   * Diese Methode prüft, ob ein Text keine HTML-Tags enthält. Sie entfernt alle
   * HTML-Tags aus dem Text und vergleicht dann das Ergebnis mit dem Original.
   * Stimmen beide überein, enthält der Text keine HTML-Tags.
   *
   * Beispiel:
   * validateText("Hello World");         // true
   * validateText("<p>Hello World</p>");  // false
   *
   * @param string $value Der zu überprüfende Wert
   * @return bool True wenn der Wert keine HTML-Tags enthält, ansonsten False
   */
  public function validateText(string $value): bool
  {
    $cleanValue = strip_tags($value);
    return $cleanValue === $value;
  }

  /**
   * Prüfung auf Text mit erlaubten HTML-Tags
   *
   * Diese Methode prüft, ob ein HTML-Text nur erlaubte Tags enthält. Sie entfernt
   * alle nicht erlaubten Tags und vergleicht das Ergebnis mit dem Original. Ohne
   * Angabe erlaubter Tags wird eine Standardliste gängiger Formatierungstags verwendet.
   *
   * Standard erlaubte Tags:
   * <a>, <b>, <blockquote>, <br>, <code>, <div>, <em>, <h1>-<h6>, <hr>, <i>,
   * <li>, <ol>, <p>, <s>, <span>, <strong>, <u>, <ul>
   *
   * Beispiele:
   * validateHtml("<p>Hello <b>World</b></p>");                   // true
   * validateHtml("<p>Hello <script>alert('XSS')</script></p>");  // false
   * validateHtml("<p>Test</p>", "<p>");                          // true
   * validateHtml("<p><b>Test</b></p>", "<p>");                   // false
   *
   * @param string $value Der zu überprüfende Wert
   * @param string|null $allowedTags Eine Zeichenfolge mit erlaubten HTML-Tags (optional)
   * @return bool True wenn der Wert nur erlaubte HTML-Tags enthält, ansonsten False
   */
  public function validateHtml(string $value, ?string $allowedTags = null): bool
  {
    $allowedTags = $allowedTags ?? "<a><b><blockquote><br><code><div><em><h1><h2><h3><h4><h5><h6><hr><i><li><ol><p><s><span><strong><u><ul>";
    $cleanValue = strip_tags($value, $allowedTags);
    return $cleanValue === $value;
  }

  /**
   * Prüfung auf gültige E-Mail-Adresse
   *
   * Diese Methode prüft, ob ein Wert das Format einer gültigen E-Mail-Adresse aufweist.
   * Dabei wird PHPs integrierter E-Mail-Filter verwendet, der verschiedene Aspekte
   * wie Domainstruktur und Syntaxregeln überprüft.
   *
   * Beispiel:
   * validateEmail("test@example.com");  // true
   * validateEmail("invalid-email");     // false
   *
   * @param string $value Der zu überprüfende Wert
   * @return bool True wenn der Wert eine gültige E-Mail-Adresse ist, ansonsten False
   */
  public function validateEmail(string $value): bool
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
  }

  /**
   * Prüfung auf gültige URL
   *
   * Diese Methode prüft, ob ein Wert das Format einer gültigen URL aufweist.
   * Sie nutzt PHPs integrierten URL-Filter, der Schema, Domain und allgemeine
   * Syntax einer URL überprüft.
   *
   * Beispiel:
   * validateUrl("https://www.example.com");  // true
   * validateUrl("invalid-url");              // false
   *
   * @param string $value Der zu überprüfende Wert
   * @return bool True wenn der Wert eine gültige URL ist, ansonsten False
   */
  public function validateUrl(string $value): bool
  {
    return filter_var($value, FILTER_VALIDATE_URL) !== false;
  }

  /**
   * Prüfung auf gültiges Datum
   *
   * Diese Methode prüft, ob ein Wert ein gültiges Datum im angegebenen Format darstellt.
   * Sie erstellt ein DateTime-Objekt aus dem Wert und vergleicht dessen formatierte
   * Darstellung mit dem Original, um sicherzustellen, dass sowohl Format als auch
   * das Datum selbst gültig sind.
   *
   * Beispiel:
   * validateDate("2025-01-17", "Y-m-d");  // true
   * validateDate("17-01-2025", "Y-m-d");  // false
   *
   * @param string $value Der zu überprüfende Wert
   * @param string $format Das Datumsformat
   * @return bool True wenn der Wert ein gültiges Datum im angegebenen Format ist, ansonsten False
   */
  public function validateDate(string $value, string $format = "Y-m-d"): bool
  {
    $date = DateTime::createFromFormat($format, $value);
    return $date && $date->format($format) === $value;
  }

  /**
   * Prüfung auf Mindestwert (inklusiv)
   *
   * Diese Methode prüft, ob ein Wert einen festgelegten Mindestwert erreicht oder überschreitet.
   * Je nach Datentyp werden unterschiedliche Vergleiche durchgeführt:
   * - Bei numerischen Werten: direkter Zahlenvergleich
   * - Bei Strings: Vergleich der Zeichenkettenlänge
   * - Bei Datumswerten: chronologischer Vergleich (mit optionalem Formatparameter)
   *
   * Beispiel:
   * validateMin(10, 5);                                // true
   * validateMin(5, 10);                                // false
   * validateMin("2025-01-17", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $minValue Der minimale Wert
   * @param string|null $format Das Datumsformat, falls nötig (Standard: null)
   * @return bool True wenn der Wert >= dem Minimum ist, ansonsten False
   */
  public function validateMin(mixed $value, mixed $minValue, ?string $format = null): bool
  {
    if ($format !== null) {
      $thisValue = DateTime::createFromFormat($format, $value);
      $minValue = DateTime::createFromFormat($format, $minValue);

      if (!$thisValue || !$minValue) {
        return false;
      }
    } else {
      $thisValue = is_numeric($value) ? $value : strlen($value);
    }

    return $thisValue >= $minValue;
  }

  /**
   * Prüfung auf Maximalwert (inklusiv)
   *
   * Diese Methode prüft, ob ein Wert einen festgelegten Maximalwert nicht überschreitet.
   * Je nach Datentyp werden unterschiedliche Vergleiche durchgeführt:
   * - Bei numerischen Werten: direkter Zahlenvergleich
   * - Bei Strings: Vergleich der Zeichenkettenlänge
   * - Bei Datumswerten: chronologischer Vergleich (mit optionalem Formatparameter)
   *
   * Beispiel:
   * validateMax(5, 10);                                // true
   * validateMax(15, 10);                               // false
   * validateMax("2024-12-31", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $maxValue Der maximale Wert
   * @param string|null $format Das Datumsformat, falls nötig (Standard: null)
   * @return bool True wenn der Wert <= dem Maximum ist, ansonsten False
   */
  public function validateMax(mixed $value, mixed $maxValue, ?string $format = null): bool
  {
    if ($format !== null) {
      $thisValue = DateTime::createFromFormat($format, $value);
      $maxValue = DateTime::createFromFormat($format, $maxValue);

      if (!$thisValue || !$maxValue) {
        return false;
      }
    } else {
      $thisValue = is_numeric($value) ? $value : strlen($value);
    }

    return $thisValue <= $maxValue;
  }

  /**
   * Prüfung auf Wert im Bereich (inklusiv)
   *
   * Diese Methode prüft, ob ein Wert zwischen zwei Grenzwerten liegt, wobei die
   * Grenzen eingeschlossen sind. Je nach Datentyp werden numerische Vergleiche,
   * Textlängenvergleiche oder Datumsvergleiche durchgeführt.
   *
   * Beispiel:
   * validateMinMax(7, 5, 10);                                    // true
   * validateMinMax(4, 5, 10);                                    // false
   * validateMinMax("2025-01-02", "2025-01-01", "2025-01-03", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $minValue Der minimale Wert
   * @param mixed $maxValue Der maximale Wert
   * @param string|null $format Das Datumsformat, falls nötig (Standard: null)
   * @return bool True wenn der Wert zwischen Min und Max liegt (inklusiv), ansonsten False
   */
  public function validateMinMax(mixed $value, mixed $minValue, mixed $maxValue, ?string $format = null): bool
  {
    return $this->validateMin($value, $minValue, $format) && $this->validateMax($value, $maxValue, $format);
  }

  /**
   * Prüfung auf kleineren Wert (exklusiv)
   *
   * Diese Methode prüft, ob ein Wert strikt kleiner als ein festgelegter Grenzwert ist.
   * Je nach Datentyp werden numerische Vergleiche, Textlängenvergleiche oder
   * Datumsvergleiche durchgeführt.
   *
   * Beispiel:
   * validateLess(5, 10);                                // true
   * validateLess(15, 10);                               // false
   * validateLess("2024-12-31", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $maxValue Der maximale Wert
   * @param string|null $format Das Datumsformat, falls nötig (Standard: null)
   * @return bool True wenn der Wert < dem Maximum ist, ansonsten False
   */
  public function validateLess(mixed $value, mixed $maxValue, ?string $format = null): bool
  {
    if ($format !== null) {
      $thisValue = DateTime::createFromFormat($format, $value);
      $maxValue = DateTime::createFromFormat($format, $maxValue);

      if (!$thisValue || !$maxValue) {
        return false;
      }
    } else {
      $thisValue = is_numeric($value) ? $value : strlen($value);
    }

    return $thisValue < $maxValue;
  }

  /**
   * Prüfung auf größeren Wert (exklusiv)
   *
   * Diese Methode prüft, ob ein Wert strikt größer als ein festgelegter Grenzwert ist.
   * Je nach Datentyp werden numerische Vergleiche, Textlängenvergleiche oder
   * Datumsvergleiche durchgeführt.
   *
   * Beispiel:
   * validateGreater(10, 5);                                // true
   * validateGreater(5, 10);                                // false
   * validateGreater("2025-01-02", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $minValue Der minimale Wert
   * @param string|null $format Das Datumsformat, falls nötig (Standard: null)
   * @return bool True wenn der Wert > dem Minimum ist, ansonsten False
   */
  public function validateGreater(mixed $value, mixed $minValue, ?string $format = null): bool
  {
    if ($format !== null) {
      $thisValue = DateTime::createFromFormat($format, $value);
      $minValue = DateTime::createFromFormat($format, $minValue);

      if (!$thisValue || !$minValue) {
        return false;
      }
    } else {
      $thisValue = is_numeric($value) ? $value : strlen($value);
    }

    return $thisValue > $minValue;
  }

  /**
   * Prüfung auf Wert im Bereich (exklusiv)
   *
   * Diese Methode prüft, ob ein Wert zwischen zwei Grenzwerten liegt, wobei die
   * Grenzen ausgeschlossen sind. Der Wert muss strikt größer als der Mindestwert und
   * strikt kleiner als der Maximalwert sein. Je nach Datentyp werden unterschiedliche
   * Vergleiche durchgeführt.
   *
   * Beispiel:
   * validateBetween(7, 5, 10);                                           // true
   * validateBetween(5, 5, 10);                                           // false
   * validateBetween(10, 5, 10);                                          // false
   * validateBetween("2025-01-02", "2025-01-01", "2025-01-03", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert
   * @param mixed $minValue Der minimale Wert
   * @param mixed $maxValue Der maximale Wert
   * @param string|null $format Das Datumsformat, falls nötig (Standard: null)
   * @return bool True wenn der Wert zwischen Min und Max liegt (exklusiv), ansonsten False
   */
  public function validateBetween(mixed $value, mixed $minValue, mixed $maxValue, ?string $format = null): bool
  {
    return $this->validateGreater($value, $minValue, $format) && $this->validateLess($value, $maxValue, $format);
  }
}
