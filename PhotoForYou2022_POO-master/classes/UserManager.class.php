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
		$q = $this->_db->prepare('INSERT INTO users(nom,prenom,type,mail,mdp) VALUES(:nom, :prenom, :type, :mail, :mdp)');
		$q->bindValue(':nom', $user->getNom());
		$q->bindValue(':prenom', $user->getPrenom());
		$q->bindValue(':type', $user->getType());
		$q->bindValue(':mail', $user->getMail());
		$q->bindValue(':mdp', $user->getMdp());

		$q->execute();

		$user->hydrate([
			'Id' => $this->_db->lastInsertId(),
			'Credit' => 0]);
	}

	public function getUser($sonMail)
	{
		$q= $this->_db->query('SELECT Nom, Prenom, Mail, Mdp, Type FROM users WHERE Mail = "'. $sonMail .'"');
		$userInfo = $q->fetch(PDO::FETCH_ASSOC);
		if ($userInfo)
		{
			return new User($userInfo);
		}	
		else
		{
			return $userInfo;
		}
	}

	public function count()
	{
		return $this->_db->query("SELECT COUNT(*) FROM users")->fetchColumn();
	}

	public function exists($mailUser, $mdpUser)
	{
		$q= $this->_db->prepare('SELECT COUNT(*) FROM users WHERE mail = :mail AND mdp = :mdp');
		$q->execute([':mail'=> $mailUser, ':mdp'=> $mdpUser]);
		return (bool) $q->fetchColumn();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}
?>