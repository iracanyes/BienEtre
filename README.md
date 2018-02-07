# BienEtre
Symfony3.3.9 application 
<div>
<h3>Tâches effectuées</h3>
    <ul>
        <li>
            Installation de symfony 3.3.9 via composer et symfony/skeleton
        </li>
        <li>
            Installation des dépendances
        </li>
        <li>
            Création des entités et relations 
        </li>
        <li>
            Création des fixtures DB
        </li>
        <li>
                    Intégration librairies nodejs : Webpack(gestionnaire de bundles JS)
            <ul>
                <li>
                    Optimisation Assets 
                </li>
                <li>
                    Importation des ressources images : logo, logo-white, favicon
                </li>
            </ul>
        </li>
        <li>
            Intégration du template
            <ul>
                <li>
                    Accueil
                </li>
                <li>
                    Prestataire 
                    <ul>
                        <li>
                            Accueil
                        </li>
                        <li>
                            Liste des prestataires
                        </li>
                        <li>
                            Recherche
                        </li>
                    </ul>
                </li>
                <li>
                    Service 
                    <ul>
                        <li>
                            Accueil
                        </li>
                        <li>
                            Liste des services
                        </li>
                        <li>
                            Recherche
                        </li>
                    </ul>
                </li>                                
            </ul>
        </li>
    </ul>
</div>
<div>
<h3>Tâches en cours</h3>
<ul>
    <li>
        Intégration du template
    </li>    
</ul>
<div>
    <h3>Tâches à effectuer</h3> 
    <ul>
        <li>
            Ajouter le module Gedmo\Timestampable pour gérer les datations des modifications de nos entités
        </li>
        <li>
            Entité Site-web : Définir les sliders de la page d'accueil
        </li>
        <li>
            Pagination : 
            <ul>
                <li>
                    Liste prestataire
                </li>
                <li>
                    Liste des services
                </li>
                <li>
                    Search Map
                </li>
            </ul>
        </li>
        <li>
            Template: provider-listing-detail.html.twig
            <ul>
                <li>
                    Controller: Provider => sur réception de vote (AJAX)
                    <ul>
                        <li>
                            Créer une méthode de calculer de la cotation des prestataires.
                            4 critères : Accueil , Equipe , Qualité service, Atmosphère
                        </li>
                        <li>
                            Créer une méthode d'affichage vote client dans les commentaires du prestataire.
                            + Ajoutez aux commentaires récents de la page d'accueil.
                        </li>
                    </ul>
                </li>
            </ul>        
        </li>
        <li>
            Pour les commentaires positifs/négatifs, il faudra contrôler en JS 
            qu'au moins un des 2 champs soit remplis 
        </li>
        <li>
            AJAX : Utilisation json_encode($response) et traitement en JS
            <ol>
                <li>
                    Recherche des prestataires : nom, localité|commune|code postal, ...
                </li>
                <li>
                    Template : index.html.twig
                </li>
                <li>
                    Template : provider-listing-detail.html.twig
                    <ul>
                        <li>
                            Mettre un provider en favori
                        </li>
                        <li>
                            Ajouter un vote à un provider
                        </li>
                    </ul>
                </li>
                <li>
                  Créer un formulaire pour ajouter le token reçu par e-mail avant de voir 
                      * le formulaire de confirmation
                </li>
                <li>
                  Vérification de l'existence d'un identifiant lors de l'inscription
                </li>
            </ol>
        </li>
    </ul>
</div>
<br>
<div>
    
</div>
<div style="background-color:blue">
    <h3>Remarques et notes </h3>
    <div class="alert">
        <p class="alert-info">
        Windows 10: Ne prend pas en charge "make" (commande GNU/Linux C++) <br>
        Il faut donc modifier le script de fichier de configuration <code>composer.json</code>
        <code>"php bin/console cache:warmup": "script",</code> <br>
         Linux : Prend en charge "make" <br>
          <code>"make cache-warmup": "script",</code>
        </p>
        <p class="alert-info">
        Windows 10 : Hautelook/Alice : catchPhrase() non-supporté remplacé par sentence(5)
        </p>            
    </div>
    <br>
    <div class="alert">
        <p class='alert-info'>
        Symfony 3.3+ : Activer, dans le fichier de configuration du framework , la prise en charge native des fichiers pour les sessions pour utiliser les fournisseurs d'utilisateurs en mode in_memory (utilisateurs contenus dans framework.yaml).
        </p>
        <ul>
            <li>
                Dé-commenter la section sur "sessions"
            </li>
        </ul>
    </div>
    <div>
       <p>
         À chaque nettoyage de la DB en développement "doctrine:database:drop --force", il ne faut pas oublier de créer la table qui contiendra les sessions authentifiés.
       </p>
       <ul>
         <li>
           Voir la documentation: <br>
           <a href="https://symfony.com/doc/current/doctrine/pdo_session_storage.html">PDO Session Storage</a>
         </li>
         <li>
            En utilisant la commande de migration de symfony (installer le bundle DoctrineMigrationsBundle) <br>
            Commande : <code>php bin/console doctrine:migrations:diff</code>      
         </li>
         <li>
              Ajouter au fichier de version de DB créé la ligne suivante                <pre>
$this->addSql('CREATE TABLE `sessions` (
       `sess_id` VARCHAR(128) NOT NULL PRIMARY KEY,
       `sess_data` BLOB NOT NULL,
       `sess_time` INTEGER UNSIGNED NOT NULL,
       `sess_lifetime` MEDIUMINT NOT NULL
   ) COLLATE utf8_bin, ENGINE = InnoDB
');
              </pre>
         </li>
         <li>
            Ensuite pour mettre à jour la base de donnée utiliser la commande: <br>
            <code> php bin/console doctrine:migrations:migrate</code>
         </li>                  
       </ul>
       <p class="alert-info">
         Attention, à chaque commande <code>doctrine:migrations:diff</code> pour calculer les différences entre les entités et la DB, la table session sera effacée car aucune entité ne la représente.
       </p>
       
       
       
       
    </div>
    <div>
      <h6>Remarque : Mise en production</h6>
      <p>
        Remettre toutes les contraintes d'unicités qui sont bloqués par les Fixtures dans les entités suivants:
        Ou Créer sa propre fonction de fixtures pour chaque contrainte d'unicités
      </p> 
      <ul>
        <li>
           
        </li>
      </ul>
    </div>
</div>
