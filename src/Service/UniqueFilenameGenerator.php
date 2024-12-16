<?php

namespace App\Service;

class UniqueFilenameGenerator
{

    public function generateUniqueFileName(string $imageOriginalName, string $imageExtension) {

        $currentTimestamp = time();
        $imageNewName = 'image' . '-' .  uniqid() . '-' . $imageOriginalName . '-' . $currentTimestamp . '.' . $imageExtension;

        return $imageNewName;
    }

}

// un test unitaire teste de manière automatique une fonctionnalité : une classe ou plusieurs classes travaillant ensemble (classes isolées de la BDD, du HTML etc)

// un test fonctionnel (e2e) teste aussi de manière automatique une fonctionnalité : mais en imitant le cheminement complet de l'utilisateur, donc charger une page, vérifier
// quand je clique sur le bouton de suppression que l'élément est bien supprimé en BDD etc