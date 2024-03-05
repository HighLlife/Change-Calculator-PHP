<?php

// Functie om de input te verifieren
function validateInput($input) 
{
    if (!isset($input)) {
        throw new Exception("Geen bedrag meegegeven.");
    }

    if (!is_numeric($input)) {
        throw new Exception("Geen wisselgeld.");
    }

    return true;
}

// Functie om de input naar een getal te parse
function parseInput($input) 
{
    return floatval($input);
}

// Functie om de wisselgeld in munten te berekenen
function calculateChange($cents) 
{
    define('MONEY_UNITS', [
        5000 => "50 euro",
        2000 => "20 euro",
        1000 => "10 euro",
        500 => "5 euro",
        200 => "2 euro",
        100 => "1 euro",
        50 => "50 cent",
        20 => "20 cent",
        10 => "10 cent",
        5 => "5 cent"
    ]);

    $remainingCents = $cents;

    foreach (MONEY_UNITS as $cent => $description) {
        if ($remainingCents >= $cent) {
            $numberOfTimes = floor($remainingCents / $cent);
            $remainingCents -= $numberOfTimes * $cent;
            
            echo "$numberOfTimes x $description, ";
        }
    }
}

// Functie om het bedrag naar de dichtstbijzijnde 5 cent te afronden
function roundToNearestFiveCents($amount) 
{
    return round($amount * 100 / 5, 0, PHP_ROUND_HALF_UP) * 5 / 100;
}

// Functie om negatief wisselgeld te berekenen
function calculateNegativeChange() 
{
    echo "Er is geen wisselgeld terug te geven voor een negatief bedrag." . PHP_EOL;
}

try {
    // Main code
    $input = $argv[1];

    validateInput($input);

    $amount = parseInput($input);

    if ($amount == 0) {
        echo "Geen wisselgeld." . PHP_EOL;
        exit(0);
    }

    if ($amount < 0) {
        calculateNegativeChange();
        exit(0);
    }

    $roundedAmount = roundToNearestFiveCents($amount);
    $amountInCents = round($roundedAmount * 100);

    calculateChange($amountInCents);

    echo "Voor bedrag €$roundedAmount." . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
?>
