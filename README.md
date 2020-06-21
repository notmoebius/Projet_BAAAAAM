# Projet_BAAAAAM
Projet de conception et développement d'une application web pour la dématérialisation des arrêts de travail avec la CPAM de la Haute-Garonne.

Visible ici https://teambaaaaam.github.io/Projet_BAAAAAM/
<h3>Configuration minimale</h3>
<p>SGBD : MySQL (version 5.7.56 ou ultérieure)</p>
<p>Bootstrap 3 (version 3.4.1 ou ultérieure)</p>
<p>PHP (version 5.4 ou ultérieure)</p>

<h3>Installation</h3>
<ul><li>Clonage du répertoire en local</li>
<p>Dans un terminal, taper la commande suivante :
  git clone <a href="https://github.com/TeamBAAAAAM/Projet_BAAAAAM.git">https://github.com/TeamBAAAAAM/Projet_BAAAAAM.git</a> 
</p>
<p>Il est également possible d’utiliser le lien suivant https://github.com/TeamBAAAAAM/Projet_BAAAAAM.git pour cloner le dossier contenant les différentes pages à l’aide d’un IDE.</p>

<li>Création de la base de données</li>
<p> Script de création : <a href="bd_cpam/ScriptCreationBD.sql">ScriptCreationBD.sql</a></p>
<li>Accès à la base de données</li>
<p>Dans le fichier <a href="fonctions.php">fonctions.php</a>, vérifier les variables de connexion et les modifier si nécessaire</p>
<img src="README_img/var_connexion.png" width="350px">

# Projet_BAAAAAM
Projet de conception et développement d'une application web pour la dématérialisation des arrêts de travail avec la CPAM de la Haute-Garonne.

Visible ici https://teambaaaaam.github.io/Projet_BAAAAAM/
<h3>Configuration minimale</h3>
<p>SGBD : MySQL (version 5.7.56 ou ultérieure)</p>
<p>Bootstrap 3 (version 3.4.1 ou ultérieure)</p>
<p>PHP (version 5.4 ou ultérieure)</p>

<h3>Installation</h3>
<ul>
  <li>Clonage du répertoire en local</li>
<p>Dans un terminal, taper la commande suivante :
  git clone <a href="https://github.com/TeamBAAAAAM/Projet_BAAAAAM.git">https://github.com/TeamBAAAAAM/Projet_BAAAAAM.git</a> 
</p>
<p>Il est également possible d’utiliser le lien suivant https://github.com/TeamBAAAAAM/Projet_BAAAAAM.git pour cloner le dossier contenant les différentes pages à l’aide d’un IDE.</p>

<li>Création de la base de données</li>
<p> Script de création : <a href="bd_cpam/ScriptCreationBD.sql">ScriptCreationBD.sql</a></p>
<li>Accès à la base de données</li>
<p>Dans le fichier <a href="fonctions.php">fonctions.php</a>, vérifier les variables de connexion et les modifier si nécessaire</p>
<img src="README_img/var_connexion.png" width="350px">

<li>Gestion du fichier ENV</li>
<p>Créer un fichier appelé ".env" (sans caractères avec le '.').</p>
<p>Ce fichier contient les paramètres de connexions au différents serveurs. Ces paramètres correspondent à des variables d'environnement qui sont supprimés à la fin de l'exécution du script PHP.</p>

<p style="font-style:'italic';font-weight:'bold';">Important : Il est nécessaire d'ajouter le nom de ce fichier au ".gitignore" ! 
Il suffit de copier le nom du fichier ".env", et le disposer sur une seule ligne dans le fichier ".gitignore". 
Cette oprération est importante car sans cela, le fichier ".env" qui contient des données très sensibles sera récupérable à partir de la commande de clonnage de GIT. De plus, ce fichier est propre à une machine en particulier, c'est-à-dire que chaque paramètre du fichier ".env" ne fonctionnera pas forcément sur autre machine (cela peut être dû à des différences au niveau du système d'exploitation, des serveurs utilisés, etc.).</p>

<p>Pour le contenu de ce fichier, voici quelques règles à respecter :</p>
<ol>
  <li>Une clé "KEY" correspond au nom d'une variable à laquelle est affectée une valeur "VALUE".</li>
  <li>Une variable d'environnement est déclarée de cette façon : KEY=VALUE.</li>
  <li>Les commentaires sont indiqués par le caractère "#".</li>
  <li>Il est possible d'ajouter un commentaire après la déclaration d'une variable d'environnement.<br>
    Exemple :<br>KEY=VALUE   #Ceci est un commentaire</li>  
  <li>Les noms de variables doivent impérativement correspondre à ceux précisés dans l'exemple ci-dessous !</li>
</ol>
  
<h3>--- Exemple de fichier ".env" ---</h3>
<strong><em>NB : Les "_____" doivent être remplacées par les valeurs correspondantes !</em></strong>
<p>
# ------------------------------------------------------------------<br>
#  VARIABLES GLOBALES DE CONNEXION À LA BASE DE DONNÉES<br>
# ------------------------------------------------------------------<br>
MYSQL_HOST=_______________________________# Nom du host [MYSQL_HOST]<br>
MYSQL_USER=_______________________________# Nom d'utilisateur [MYSQL_USER]<br>
MYSQL_PWD=________________________________# Mot de passe [MYSQL_PWD]<br>
MYSQL_BD=_________________________________# Nom de la base de données [MYSQL_BD]<br>
MYSQL_PORT=_______________________________# Numéro du port de connexion [MYSQL_PORT]<br>
<br>
# ------------------------------------------------------------------<br>
# 	VARIABLES GLOBALES DE CONNEXION AU SERVEUR FTP<br>
# ------------------------------------------------------------------<br>
FTP_HOST=_________________________________# Nom du host [FTP_HOST]<br>
FTP_USER=_________________________________# Nom d'utilisateur [FTP_USER]<br>
FTP_PWD=__________________________________# Mot de passe [FTP_PWD]<br>
FTP_PORT=_________________________________# Numéro du port de connexion [FTP_PORT]<br>
<br>
# ------------------------------------------------------------------<br>
# 	VARIABLE GLOBALE DU CHEMIN VERS L'ESPACE DE STOCKAGE DES PIECES (sur le serveur FTP)<br>
# ------------------------------------------------------------------<br>
STORAGE_PATH=_____________________________# N.B. : À partir de la racine [STORAGE_PATH]<br>
<br>
# ------------------------------------------------------------------<br>
# 	VARIABLES GLOBALES POUR L'ENVOI DES MAILS<br>
# ------------------------------------------------------------------<br>
# Ces arguments sont insérer directement dans le fichier de configuration php.ini<br>
SMTP_HOST=________________________________# Nom du host [SMTP_HOST]<br>
SMTP_PORT=________________________________# Numéro du port [SMTP_PORT]<br>
SMTP_USER=________________________________# Nom d'utilisateur [SMTP_USER]<br>
SMTP_PwD=_________________________________# Mot de passe [SMTP_PWD]<br>
SENDMAIL_FROM=____________________________# Adresse mail de l'expéditeur [SENDMAIL_FROM]<br>
SENDMAIL_NAME=____________________________# Nom de l'expéditeur [SENDMAIL_NAME]<br>
</p>
<em> La variable globale 'STORAGE_PATH' correspond au chemin menant au dossier de destination des fichiers enregistrés. </em>
</ul>
