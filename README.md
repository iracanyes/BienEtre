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
            Entité Site-web : Définir les sliders de la page d'accueil
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
            </ol>
        </li>
    </ul>
</div>
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
    <p>
        
</div>
<div class="alert">
    
</div>
