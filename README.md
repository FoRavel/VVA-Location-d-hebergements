# VVA---R-servation-d-h-bergements
Location d'hébergements

VVA = Village Vacances Alpes. Ce projet a servi de support à l'épreuve E4 du BTS.

Ce site Web permet de réserver pour une période définie, un hébergement parmis ceux proposés par le site.

Spécificités techniques principales:
- Afficher la liste des hébergements avec leurs caractéristiques (libellé, surface habitable, prix de location, wi-fi...)
- Ajouter-supprimer-modifier des hébergements
- Réserver un hébergment pour une période définie
- Se connecter avec un login et mot de passe

Technologie employées:
- PHP procédural
- JQuery/Ajax
- HTML5
- Bootstrap
- SQL 
- PhpMyAdmin

CONFIGURATION BASE DE DONNEES: 
$bdd = new PDO("mysql:host=localhost;dbname=vva;charset=utf8", "root", "");

Le fichier .sql de la base de données est présent dans le git et s'appelle vva.sql

Identifiants de test:
identifiant:admin
mdp:123abc
