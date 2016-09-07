<?php

$lang['db_invalid_connection_str'] = 'Impossible de déterminer les paramètres de base de données sur la base de la chaîne de connexion que vous avez soumis.';
$lang['db_unable_to_connect'] = 'Impossible de se connecter à votre serveur de base de données en utilisant les paramètres fournis.';
$lang['db_unable_to_select'] = 'Impossible de sélectionner la base de données spécifiée:% s';
$lang['db_unable_to_create'] = 'Impossible de créer la base de données spécifiée:% s ';
$lang['db_invalid_query'] = 'La requête que vous avez soumis est pas valide. ';
$lang['db_must_set_table'] = 'Vous devez définir la table de base de données pour être utilisé avec votre requête.';
$lang['db_must_use_set'] = 'Vous devez utiliser la méthode "set" de mettre à jour une entrée.';
$lang['db_must_use_index'] = 'Vous devez spécifier un index pour correspondre sur les mises à jour batch ';
$lang['db_batch_missing_index'] = "Une ou plusieurs lignes soumises à la mise à jour de lot est absent de l'index spécifié.";
$lang['db_must_use_where'] = "Mises à jour ne sont pas autorisés à moins qu'ils ne contiennent une clause 'where'.";
$lang['db_del_must_use_where'] = 'Supprime ne sont pas autorisés à moins qu"ils contiennent un "où" ou "comme" clause.';
$lang['db_field_param_missing'] = 'Pour chercher les champs requiert le nom de la table en tant que paramètre.';
$lang['db_unsupported_function'] = 'Cette fonctionnalité ne sont pas disponibles pour la base de données que vous utilisez.';
$lang['db_transaction_failure'] = "l'échec de la transaction: Rollback effectué.";
$lang['db_unable_to_drop'] = "Impossible de supprimer la base de données spécifiée.";
$lang['db_unsuported_feature'] = 'Fonction non pris en charge de la plate-forme de base de données que vous utilisez.';
$lang['db_unsuported_compression'] = 'Le format de compression de fichier que vous avez choisi ne soit pas supporté par votre serveur.';
$lang['db_filepath_error'] = "Impossible d'écrire des données sur le chemin du fichier que vous avez soumis.";
$lang['db_invalid_cache_path'] = "Le chemin de cache que vous avez soumis est pas valide ou inscriptible.";
$lang['db_table_name_required'] = 'Un nom de table est nécessaire pour cette opération.';
$lang['db_column_name_required'] = 'Un nom de colonne est nécessaire pour cette opération.';
$lang['db_column_definition_required'] = "Une définition de colonne est nécessaire pour cette opération.";
$lang['db_unable_to_set_charset'] = 'Impossible de définir client jeu de caractères de connexion:% s';
$lang['db_error_heading'] = 'Une base de données erreur est survenue';

/* End of file db_lang.php */
/* Location: ./system/language/english/db_lang.php */