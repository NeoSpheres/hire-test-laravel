<?php

function generateMatricule() {
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';

    $matricule = substr(str_shuffle($letters), 0, 2); // Deux lettres majuscules aléatoires
    $matricule .= '-';
    $matricule .= substr(str_shuffle($numbers), 0, 3); // Trois chiffres aléatoires
    $matricule .= '-';
    $matricule .= substr(str_shuffle($letters), 0, 2); // Deux lettres majuscules aléatoires

    return $matricule;
}
