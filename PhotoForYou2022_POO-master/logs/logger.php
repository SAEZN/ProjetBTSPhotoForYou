<?php
// Chemin vers le fichier journal
$logFile = 'logs/app.log';

// Fonction pour enregistrer un message dans le journal avec le nom de la page
function logMessage($message, $pageName, $level = 'info') {
    global $logFile;
    $logEntry = date('[Y-m-d H:i:s]') . " [$level] Page $pageName : $message" . PHP_EOL;
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

// Fonction pour enregistrer une erreur dans le journal
function logError($message) {
    logMessage($message, 'error');
}

// Fonction pour enregistrer un avertissement dans le journal
function logWarning($message) {
    logMessage($message, 'warning');
}

/* Exemple d'utilisation :
logMessage('Erreur de connexion à la base de données', 'Accueil', 'error');
logError('Erreur de base de données : Impossible de se connecter');
logWarning('Attention : La configuration est obsolète');
*/

?>