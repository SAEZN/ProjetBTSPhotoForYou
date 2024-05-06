<?php
class UserManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDB($db);
    }

    public function add(User $user)
    {
        $q = $this->_db->prepare('INSERT INTO utilisateurs(nom_utilisateur, adresse_email, mot_de_passe, role) VALUES(:nom, :mail, :mdp, :role)');
        $q->bindValue(':nom', $user->getNom());
        $q->bindValue(':mail', $user->getMail());
        $q->bindValue(':mdp', $user->getMdp());
        $q->bindValue(':role', $user->getRole());

        $q->execute();

        $user->hydrate([
            'id' => $this->_db->lastInsertId(),
            'credits' => 0
        ]);
    }

    public function getUser($sonMail)
    {
        $q= $this->_db->prepare('SELECT id, nom_utilisateur as nom, adresse_email as mail, mot_de_passe as mdp, role FROM utilisateurs WHERE adresse_email = :mail');
        $q->execute(array(':mail' => $sonMail));
        $userInfo = $q->fetch(PDO::FETCH_ASSOC);
        if ($userInfo) {
            return new User($userInfo);
        } else {
            return $userInfo;
        }
    }

    public function updateRole($userId, $newRole)
    {
        $allowedRoles = ['admin', 'photographe', 'invite'];
        if (!in_array($newRole, $allowedRoles)) {
            throw new Exception("Rôle invalide");
        }

        $q = $this->_db->prepare('UPDATE utilisateurs SET role = :role WHERE id = :id');
        $q->execute(array(':role' => $newRole, ':id' => $userId));

        if ($q->rowCount() === 0) {
            throw new Exception("Échec de la mise à jour du rôle de l'utilisateur");
        }
    }

    public function count()
    {
        return $this->_db->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();
    }

    public function exists($mailUser, $mdpUser)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE adresse_email = :mail AND mot_de_passe = :mdp');
        $q->execute([':mail' => $mailUser, ':mdp' => $mdpUser]);
        return (bool) $q->fetchColumn();
    }

    public function setDB(PDO $db)
    {
        $this->_db = $db;
    }
}
?>