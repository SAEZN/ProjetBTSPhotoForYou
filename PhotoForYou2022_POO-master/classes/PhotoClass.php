<?php

class Photo
{
    private $id;
    private $title;
    private $description;
    private $price;
    private $filename;
    private $date;

    public function __construct($id, $title, $description, $price, $filename, $date, $file)
{
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
    $this->price = $price;
    $this->filename = $filename;
    $this->date = $date;
    $this->file = $file;
}

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function saveToDatabase(PDO $pdo)
{
    // Vérifiez si le fichier a été correctement téléchargé
    if ($this->file['error'] !== UPLOAD_ERR_OK) {
        // Gestion des erreurs
        // Vous pouvez afficher un message d'erreur ou effectuer d'autres actions ici
        return false;
    }

    // Lisez le contenu du fichier
    $fileData = file_get_contents($this->file['tmp_name']);

    // Préparation de la requête SQL
    $sql = "INSERT INTO photos (id, title, description, price, filename, date, file) VALUES (:id, :title, :description, :price, :filename, :date, :file)";
    $stmt = $pdo->prepare($sql);

    // Liaison des valeurs aux paramètres de la requête
    $stmt->bindValue(':id', $this->id);
    $stmt->bindValue(':title', $this->title);
    $stmt->bindValue(':description', $this->description);
    $stmt->bindValue(':price', $this->price);
    $stmt->bindValue(':filename', $this->filename);
    $stmt->bindValue(':date', $this->date);
    $stmt->bindValue(':file', $fileData, PDO::PARAM_LOB); // Utilisation de PDO::PARAM_LOB pour les données binaires

    // Exécution de la requête
    $stmt->execute();

    return true;
}
}