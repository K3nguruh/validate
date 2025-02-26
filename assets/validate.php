<?php

/**
 * Klasse Validate
 *
 * Diese Klasse enthält eine Sammlung von Methoden zur Validierung von Eingabedaten.
 * Sie ermöglicht es, Werte auf Vorhandensein, Übereinstimmung mit bestimmten Mustern
 * (z. B. regulären Ausdrücken) sowie auf numerische und datumsbezogene Anforderungen zu prüfen.
 * Besonders nützlich ist sie für Webanwendungen, in denen Benutzereingaben überprüft werden müssen.
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
 * Version: 1.0.0
 * Datum:   2025-02-26 00:42
 * Lizenz:  MIT-Lizenz
 */

class Validate
{
  /**
   * Prüft, ob ein Wert vorhanden und nicht leer ist.
   *
   * Diese Methode überprüft, ob der übergebene Wert nicht leer ist. Dabei werden leere
   * Zeichenketten (auch solche, die nur aus Leerzeichen bestehen), null, false sowie
   * leere Arrays als leer gewertet.
   *
   * Beispiel:
   * validateRequired("Test");  // true
   * validateRequired("");      // false
   * validateRequired("   ");   // false
   * validateRequired(null);    // false
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @return bool Gibt true zurück, wenn der Wert nicht leer ist, andernfalls false.
   */
  public function validateRequired(mixed $value): bool
  {
    return !($value === "" || $value === null || $value === false || (is_string($value) && trim($value) === "") || (is_array($value) && empty($value)));
  }

  /**
   * Vergleicht zwei Werte auf exakte Gleichheit.
   *
   * Diese Methode überprüft, ob beide übergebenen Werte exakt übereinstimmen. Dabei
   * wird der strikte Vergleichsoperator (===) verwendet, der sowohl den Wert als auch
   * den Datentyp berücksichtigt.
   *
   * Beispiel:
   * validateEqual(5, 5);            // true
   * validateEqual("Test", "Test");  // true
   * validateEqual(5, "5");          // false
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $compare Der Wert, mit dem verglichen werden soll.
   * @return bool Gibt true zurück, wenn die Werte exakt übereinstimmen, andernfalls false.
   */
  public function validateEqual(mixed $value, mixed $compare): bool
  {
    return $value === $compare;
  }

  /**
   * Prüft, ob ein Wert einem regulären Ausdruck entspricht.
   *
   * Diese Methode vergleicht den gesamten übergebenen Wert mit dem angegebenen
   * regulären Ausdruck. Der Wert muss dabei vollständig dem Muster entsprechen.
   *
   * Beispiel:
   * validateMatch("abc123", "^[a-z0-9]+$");   // true
   * validateMatch("abc-123", "^[a-z0-9]+$");  // false
   *
   * @param string $value Der zu überprüfende Wert.
   * @param string $regex Der reguläre Ausdruck.
   * @return bool Gibt true zurück, wenn der Wert dem regulären Ausdruck entspricht, andernfalls false.
   */
  public function validateMatch(string $value, string $regex): bool
  {
    return preg_match("/{$regex}/", $value) === 1;
  }

  /**
   * Prüft, ob ein Text keine HTML-Tags enthält.
   *
   * Diese Methode entfernt alle HTML-Tags aus dem übergebenen Text und vergleicht
   * den bereinigten Text mit dem Original. Stimmen beide überein, so enthält der Text
   * keine HTML-Tags.
   *
   * Beispiel:
   * validateText("Hello World");         // true
   * validateText("<p>Hello World</p>");  // false
   *
   * @param string $value Der zu überprüfende Wert.
   * @return bool Gibt true zurück, wenn der Wert keine HTML-Tags enthält, andernfalls false.
   */
  public function validateText(string $value): bool
  {
    $cleanValue = strip_tags($value);
    return $cleanValue === $value;
  }

  /**
   * Prüft, ob ein HTML-Text nur erlaubte Tags enthält.
   *
   * Diese Methode entfernt alle HTML-Tags, die nicht in der Liste der erlaubten Tags enthalten
   * sind, und vergleicht den bereinigten Text mit dem Original. Wird kein Wert für $allowedTags
   * übergeben, kommt eine Standardliste gängiger Formatierungstags zum Einsatz.
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
   * @param string $value Der zu überprüfende Wert.
   * @param string|null $allowedTags (Optional) Eine Zeichenfolge, die die erlaubten HTML-Tags enthält.
   * @return bool Gibt true zurück, wenn der Wert nur erlaubte HTML-Tags enthält, andernfalls false.
   */
  public function validateHtml(string $value, ?string $allowedTags = null): bool
  {
    $allowedTags = $allowedTags ?? "<a><b><blockquote><br><code><div><em><h1><h2><h3><h4><h5><h6><hr><i><li><ol><p><s><span><strong><u><ul>";
    $cleanValue = strip_tags($value, $allowedTags);
    return $cleanValue === $value;
  }

  /**
   * Prüft, ob ein Wert eine gültige E-Mail-Adresse ist.
   *
   * Diese Methode verwendet PHPs integrierten E-Mail-Filter, um zu überprüfen, ob der
   * übergebene Wert das Format einer gültigen E-Mail-Adresse besitzt.
   *
   * Beispiel:
   * validateEmail("test@example.com");  // true
   * validateEmail("invalid-email");     // false
   *
   * @param string $value Der zu überprüfende Wert.
   * @return bool Gibt true zurück, wenn der Wert eine gültige E-Mail-Adresse ist, andernfalls false.
   */
  public function validateEmail(string $value): bool
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
  }

  /**
   * Prüft, ob ein Wert eine gültige URL ist.
   *
   * Diese Methode verwendet PHPs integrierten URL-Filter, um zu überprüfen, ob der
   * übergebene Wert das Format einer gültigen URL besitzt.
   *
   * Beispiel:
   * validateUrl("https://www.example.com");  // true
   * validateUrl("invalid-url");              // false
   *
   * @param string $value Der zu überprüfende Wert.
   * @return bool Gibt true zurück, wenn der Wert eine gültige URL ist, andernfalls false.
   */
  public function validateUrl(string $value): bool
  {
    return filter_var($value, FILTER_VALIDATE_URL) !== false;
  }

  /**
   * Prüft, ob ein Wert ein gültiges Datum im angegebenen Format ist.
   *
   * Diese Methode erstellt ein Datum anhand des übergebenen Formats und vergleicht, ob
   * der formatierte Wert exakt dem ursprünglichen Wert entspricht. So wird sichergestellt,
   * dass sowohl das Format als auch das Datum selbst gültig sind.
   *
   * Beispiel:
   * validateDate("2025-01-17", "Y-m-d");  // true
   * validateDate("17-01-2025", "Y-m-d");  // false
   *
   * @param string $value Der zu überprüfende Wert.
   * @param string $format Das Datumsformat.
   * @return bool Gibt true zurück, wenn der Wert ein gültiges Datum ist, andernfalls false.
   */
  public function validateDate(string $value, string $format = "Y-m-d"): bool
  {
    $date = DateTime::createFromFormat($format, $value);
    return $date && $date->format($format) === $value;
  }

  /**
   * Prüft, ob ein Wert mindestens einen bestimmten Grenzwert erreicht.
   *
   * Diese Methode vergleicht den übergebenen Wert mit einem Mindestwert. Bei Zahlen wird der
   * numerische Vergleich durchgeführt, bei Strings wird die Länge des Textes und bei Datumswerten
   * der Zeitpunkt verglichen. Optional kann ein Datumsformat angegeben werden.
   *
   * Beispiel:
   * validateMin(10, 5);                                // true
   * validateMin(5, 10);                                // false
   * validateMin("2025-01-17", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $minValue Der minimale Wert.
   * @param string|null $format Das Datumsformat, falls der Wert ein Datum ist (Standard: null).
   * @return bool Gibt true zurück, wenn der Wert größer oder gleich dem minimalen Wert ist, andernfalls false.
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
   * Prüft, ob ein Wert höchstens einen bestimmten Grenzwert erreicht.
   *
   * Diese Methode vergleicht den übergebenen Wert mit einem Maximalwert. Bei Zahlen wird der
   * numerische Vergleich durchgeführt, bei Strings wird die Länge des Textes und bei Datumswerten
   * der Zeitpunkt verglichen. Optional kann ein Datumsformat angegeben werden.
   *
   * Beispiel:
   * validateMax(5, 10);                                // true
   * validateMax(15, 10);                               // false
   * validateMax("2024-12-31", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $maxValue Der maximale Wert.
   * @param string|null $format Das Datumsformat, falls der Wert ein Datum ist (Standard: null).
   * @return bool Gibt true zurück, wenn der Wert kleiner oder gleich dem maximalen Wert ist, andernfalls false.
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
   * Prüft, ob ein Wert zwischen zwei Grenzwerten liegt (inklusive der Grenzen).
   *
   * Diese Methode kombiniert die Überprüfungen auf Mindest- und Maximalwert, um zu prüfen, ob
   * der übergebene Wert zwischen zwei Grenzwerten liegt. Es werden numerische Vergleiche,
   * Vergleiche der Zeichenlänge bei Strings sowie Zeitvergleiche bei Datumswerten (optional
   * mit Format) durchgeführt.
   *
   * Beispiel:
   * validateMinMax(7, 5, 10);                                           // true
   * validateMinMax(4, 5, 10);                                           // false
   * validateMinMax("2025-01-02", "2025-01-01", "2025-01-03", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $minValue Der minimale Wert.
   * @param mixed $maxValue Der maximale Wert.
   * @param string|null $format Das Datumsformat, falls der Wert ein Datum ist (Standard: null).
   * @return bool Gibt true zurück, wenn der Wert zwischen dem minimalen und maximalen Wert liegt, andernfalls false.
   */
  public function validateMinMax(mixed $value, mixed $minValue, mixed $maxValue, ?string $format = null): bool
  {
    return $this->validateMin($value, $minValue, $format) && $this->validateMax($value, $maxValue, $format);
  }

  /**
   * Prüft, ob ein Wert kleiner als ein bestimmter Grenzwert ist.
   *
   * Diese Methode vergleicht den übergebenen Wert mit einem Maximalwert. Dabei wird bei
   * Zahlen der numerische Wert, bei Strings die Zeichenlänge und bei Datumswerten der
   * Zeitpunkt (optional mit Format) verglichen.
   *
   * Beispiel:
   * validateLess(5, 10);                                // true
   * validateLess(15, 10);                               // false
   * validateLess("2024-12-31", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $maxValue Der maximale Wert.
   * @param string|null $format Das Datumsformat, falls der Wert ein Datum ist (Standard: null).
   * @return bool Gibt true zurück, wenn der Wert kleiner als der maximale Wert ist, andernfalls false.
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
   * Prüft, ob ein Wert größer als ein bestimmter Grenzwert ist.
   *
   * Diese Methode vergleicht den übergebenen Wert mit einem Mindestwert. Bei Zahlen wird
   * der numerische Vergleich durchgeführt, bei Strings wird die Länge des Textes und bei
   * Datumswerten der Zeitpunkt (optional mit Format) verglichen.
   *
   * Beispiel:
   * validateGreater(10, 5);                                // true
   * validateGreater(5, 10);                                // false
   * validateGreater("2025-01-02", "2025-01-01", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $minValue Der minimale Wert.
   * @param string|null $format Das Datumsformat, falls der Wert ein Datum ist (Standard: null).
   * @return bool Gibt true zurück, wenn der Wert größer als der minimale Wert ist, andernfalls false.
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
   * Prüft, ob ein Wert zwischen zwei Grenzwerten liegt (exklusive der Grenzen).
   *
   * Diese Methode überprüft, ob der übergebene Wert größer als der Mindestwert und
   * gleichzeitig kleiner als der Maximalwert ist. Bei Zahlen wird der numerische Vergleich,
   * bei Strings die Zeichenlänge und bei Datumswerten (optional mit Format) der Zeitpunkt
   * verglichen.
   *
   * Beispiel:
   * validateBetween(7, 5, 10);                                           // true
   * validateBetween(5, 5, 10);                                           // false
   * validateBetween(10, 5, 10);                                          // false
   * validateBetween("2025-01-02", "2025-01-01", "2025-01-03", "Y-m-d");  // true
   *
   * @param mixed $value Der zu überprüfende Wert.
   * @param mixed $minValue Der minimale Wert.
   * @param mixed $maxValue Der maximale Wert.
   * @param string|null $format Das Datumsformat, falls der Wert ein Datum ist (Standard: null).
   * @return bool Gibt true zurück, wenn der Wert zwischen dem minimalen und maximalen Wert liegt, andernfalls false.
   */
  public function validateBetween(mixed $value, mixed $minValue, mixed $maxValue, ?string $format = null): bool
  {
    return $this->validateGreater($value, $minValue, $format) && $this->validateLess($value, $maxValue, $format);
  }
}
