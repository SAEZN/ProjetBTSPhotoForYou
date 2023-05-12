<?php

class Photo
{
    private $id;
    private $title;
    private $description;
    private $filename;
    private $date;

    public function __construct($id, $title, $description, $filename, $date, $file)
{
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
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
    // Chemin du dossier "uploads"
    $uploadDirectory = 'uploads/';

    // Génération d'un nom de fichier unique
    $filename = uniqid() . '_' . $this->filename;

    // Déplacement du fichier téléchargé vers le dossier "uploads"
    move_uploaded_file($this->file['tmp_name'], $uploadDirectory . $filename);

    // Préparation de la requête SQL
    $sql = "INSERT INTO photos (id, title, description, filename, date, file) VALUES (:id, :title, :description, :filename, :date, :file)";
    $stmt = $pdo->prepare($sql);

    // Liaison des valeurs aux paramètres de la requête
    $stmt->bindValue(':id', $this->id);
    $stmt->bindValue(':title', $this->title);
    $stmt->bindValue(':description', $this->description);
    $stmt->bindValue(':filename', $filename);
    $stmt->bindValue(':date', $this->date);
    $stmt->bindValue(':file', $this->file);

    // Exécution de la requête
    $stmt->execute();
   }
}