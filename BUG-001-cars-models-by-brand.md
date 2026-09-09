# BUG-001 — Les modèles ne se chargent pas pour la marque sélectionnée

**Type :** Bug backend / API  
**Priorité :** Moyenne  
**Zone :** Cars datatable -> création d'une voiture

## Contexte

Le formulaire de création de voiture charge les modèles disponibles après la sélection d'une marque.

## Préconditions

- Au moins une marque existe.
- Cette marque possède au moins un modèle associé.

## Étapes de reproduction

1. Ouvrir `/datatable-cars`.
2. Cliquer sur **Create Car**.
3. Sélectionner une marque qui possède des modèles.
4. Observer la liste **Model**.

## Résultat observé

La requête répond avec un statut HTTP `200`, mais la liste de modèles est vide ou contient des modèles ne correspondant pas à la marque sélectionnée.

## Résultat attendu

L'API doit renvoyer uniquement les modèles associés à la marque dont l'identifiant est fourni dans l'URL. La liste **Model** doit ensuite afficher ces modèles.

## Critères d’acceptation

- Pour une marque possédant des modèles, l'api les retourne.
- Aucun modèle associé à une autre marque n’est retourné.
- Pour une marque sans modèle, l’API retourne une liste vide avec le statut `200`.
- Un test automatisé couvre le filtrage par marque.
