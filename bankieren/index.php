<?php
require_once 'vendor/autoload.php'; // Twig autoload

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('age', function ($birthdate) {
    $today = new \DateTime();
    $birthdate = new \DateTime($birthdate);
    $diff = $birthdate->diff($today);
    return $diff->format('%y');
}));

// Verbinding maken met de database en gegevens ophalen
$connection = new PDO('sqlite:' . __DIR__ . '/bankieren.db');
$statement = $connection->prepare('SELECT * FROM gebruikers');
$statement->execute();
$gebruikers = $statement->fetchAll(PDO::FETCH_ASSOC);

// Modify the data to include the current age
foreach ($gebruikers as &$gebruiker) {
    $gebruiker['leeftijd'] = $twig->getFilter('age')->getCallable()($gebruiker['geboortendatum']);
}

// Render het Twig-bestand met de gegevens
echo $twig->render('gebruikers.twig', ['gebruikers' => $gebruikers]);
?>
