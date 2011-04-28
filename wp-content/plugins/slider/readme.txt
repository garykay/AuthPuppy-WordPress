=== Authpuppy ===
Creator: Adcaelo
Donate link: http://adcaelo-online.com
Tags: encart, zone, personalisation, slide, slider
Requires at least: 2.8
Stable tag: 2.50
Zones pour Ile Sans Fil , Authpuppy

== Description ==
Rédiger des pages associé a un template spécifique (slide) et les afficher sous forme de slideshow.
Ne modifier qu'une seul fois une slide (page avec le template slide) pour que les modifications soient visible sur toutes les pages associées

== How ==
Ajouter a votre thème où a une template de page la ligne suivante :
<?php include (ABSPATH . "/wp-content/plugins/authpuppy/slider.php");
Ajouter a votre thème le template "slide.php" se trouvant dans le dossier slide du plugin


Pour créer une slide créer une page et associé lui le template "Slide" pour plus de clarté vous pouvez créer une page principale regroupant toutes les slides (Créer une page "Slide" avec le template Slide, puis lorsque vous créerais une slide associer la page parente et le template "Slide")

Pour afficher une ou plusieurs slide sur une page, ajouter des custom fields portant le nom 'slider' et ayant pour valeur le nom du slide de votre choix.

Ajouter a votre page / post autant de custom field ayant pour nom "slider" et pour valeur le nom de votre slide que vous souhaiter ajouter de slides.

Vous etes libre de personnaliser le plugin selon vos besoins!