<?php

class UserRoles {
    const ADMIN = 'admin';
    const PHOTOGRAPHE = 'photographe';
    const CLIENT = 'client';
    const CLIENT = 'visiteur';

    // Méthode statique pour vérifier si un rôle est valide
    public static function isValidRole($role) {
        return in_array($role, [self::ADMIN, self::PHOTOGRAPHE, self::CLIENT, self::VISITEUR]);
    }
}

?>