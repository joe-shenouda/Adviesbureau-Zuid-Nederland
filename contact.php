<?php
$ontvanger_email = "info@adviesbureau-zuid.nl";
$onderwerp_prefix = "[Website Contact] ";

// Controleer of het formulier is verstuurd
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Gegevens opschonen en ophalen (komt overeen met de 'name' velden in je HTML)
    $naam = strip_tags(trim($_POST["input_text"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $telefoon = strip_tags(trim($_POST["input_text_1"]));
    $bericht = trim($_POST["description"]);
    
    // Validatie
    if (empty($naam) || empty($bericht) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Foutmelding als gegevens niet kloppen
        header("Location: index.html?status=error");
        exit;
    }

    // E-mail inhoud opstellen
    $email_inhoud = "Er is een nieuw contactverzoek binnengekomen via de website:\n\n";
    $email_inhoud .= "Naam: $naam\n";
    $email_inhoud .= "Email: $email\n";
    $email_inhoud .= "Telefoon: $telefoon\n\n";
    $email_inhoud .= "Bericht:\n$bericht\n";

    // E-mail headers
    $headers = "From: Website Contact <noreply@adviesbureau-zuid.nl>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Verstuur de e-mail
    if (mail($ontvanger_email, $onderwerp_prefix . $naam, $email_inhoud, $headers)) {
        // Succes: Stuur gebruiker terug naar de site met succesmelding
        // Je kunt hier ook doorsturen naar een aparte 'bedankt.html' pagina
        echo "<script>alert('Bedankt! Uw bericht is succesvol verzonden.'); window.location.href='index.html';</script>";
    } else {
        // Fout bij verzenden
        echo "<script>alert('Er ging iets mis bij het verzenden. Probeer het later opnieuw of bel ons.'); window.location.href='index.html';</script>";
    }

} else {
    // Als iemand direct naar dit bestand surft zonder formulier
    header("Location: index.html");
}
?>
