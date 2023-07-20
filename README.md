# garage-parrot
Site web d'un garage automobile fictif

# Documents
[Charte graphique](/charte_graphique.pdf)

[Documentation technique](/documentation_technique.pdf)


# Installation
Pour installer l'application en local, assurez-vous d'abord d'avoir installé [composer](https://getcomposer.org/download/) et [PHP](https://www.php.net/manual/en/install.php) sur votre machine.
Vous devez aussi avoir un serveur en local comme [XAMPP](https://www.apachefriends.org/download.html) ou [Wampserver](https://wampserver.aviatechno.net/), avec Apache et une base de données MySQL.

Voici les étapes à suivre : 

1. Cloner le dépot : `git clone https://github.com/AurinkGrellet/garage-parrot.git`
2. Rendez-vous dans le répertoire de l'application avec un interpréteur de commandes (cmd.exe ou autre)
3. Exécutez la commande `composer install`
4. Exécutez la commande `php bin/console doctrine:migrations:migrate`
5. Configurez le paramètre 'DATABASE_URL' du fichier .env avec les paramètres de connexion à votre base de donnée locale
6. Configurez le paramètre 'MAILER_DSN' du fichier .env avec les paramètres e-mail appropriés selon l'adresse que vous souhaitez utiliser (voir [Symfony Mailer](https://symfony.com/doc/current/mailer.html#using-built-in-transports).
   Pour une utilisation locale, vous pouvez tout aussi bien utliser une adresse e-mail de test avec [MailTrap](https://mailtrap.io/).

L'application est maintenant disponible en local avec toutes ses fonctions !

# Utilisation de l'application
2 utilisateurs sont créés par défaut : 
- Vincent Parrot, Administrateur

  E-mail : `vincent.parrot@gmail.com`
  
  Mot de passe : `CJ1mK8vOf27IzHew`
- Camille Dupont, Employée
  
  E-mail : `camille@gmail.com`
  
  Mot de passe : `15gSqsejtdIw`
