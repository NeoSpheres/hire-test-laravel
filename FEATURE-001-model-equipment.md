# FEATURE-001 — Ajouter des équipements aux modèles de voiture

**Type :** Évolution fonctionnelle  
**Priorité :** Moyenne  
**Zone :** Gestion des modèles de voiture

## Contexte

L’application permet de gérer les marques, modèles, motorisations et voitures. Elle ne permet pas de décrire les équipements disponibles pour un modèle (climatisation, GPS, caméra de recul, etc.).

## Objectif

Ajouter un catalogue d’équipements et permettre d’associer plusieurs équipements à un modèle de voiture. Un même équipement doit pouvoir être associé à plusieurs modèles.

Cette évolution est un ajout : elle ne modifie ni les relations existantes ni les données actuelles.

## Règles métier

- Un équipement possède au minimum un nom et une description facultative.
- Un modèle peut avoir zéro, un ou plusieurs équipements.
- Un équipement peut être associé à zéro, un ou plusieurs modèles.
- Une même association modèle/équipement ne peut exister qu’une fois.

## Critères d’acceptation

- Un administrateur peut créer, modifier, lister et supprimer un équipement.
- Lors de la création ou modification d’un modèle, plusieurs équipements peuvent être sélectionnés.
- Les équipements associés sont affichés sur la page de détail du modèle.
- La suppression d’un modèle ou d’un équipement supprime uniquement ses liens.
- Une association dupliquée modèle/équipement est impossible.
- Des tests automatisés couvrent la création des associations, leur mise à jour et leur suppression.
