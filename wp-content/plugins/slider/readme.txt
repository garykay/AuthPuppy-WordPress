=== Authpuppy ===
Creator: Adcaelo
Donate link: http://adcaelo-online.com
Tags: encart, zone, personalisation, slide, slider
Requires at least: 2.8
Stable tag: 2.50
Zones pour Ile Sans Fil , Authpuppy

== Description ==
R�diger des pages associ� a un template sp�cifique (slide) et les afficher sous forme de slideshow.
Ne modifier qu'une seul fois une slide (page avec le template slide) pour que les modifications soient visible sur toutes les pages associ�es

== How ==
Ajouter a votre th�me o� a une template de page la ligne suivante :
<?php include (ABSPATH . "/wp-content/plugins/authpuppy/slider.php");
Ajouter a votre th�me le template "slide.php" se trouvant dans le dossier slide du plugin


Pour cr�er une slide cr�er une page et associ� lui le template "Slide" pour plus de clart� vous pouvez cr�er une page principale regroupant toutes les slides (Cr�er une page "Slide" avec le template Slide, puis lorsque vous cr�erais une slide associer la page parente et le template "Slide")

Pour afficher une ou plusieurs slide sur une page, ajouter des custom fields portant le nom 'slider' et ayant pour valeur le nom du slide de votre choix.

Ajouter a votre page / post autant de custom field ayant pour nom "slider" et pour valeur le nom de votre slide que vous souhaiter ajouter de slides.

Vous etes libre de personnaliser le plugin selon vos besoins!