/**
 * Description: Ajout d'un widget collection
 */
let $ = require('jquery');


function addCollectionWidget(){

    // Action de création du prototype
    $(function () {

        $(".add-another-collection-widget").click(function (e) {
            // Empêcher l'ajout '#' dans les liens
            e.preventDefault();

            let list = $($(this).attr('data-list'));

            // Nombre élément dans liste
            let counter = list.data('widget-counter') | list.children().length;

            if(!counter){ counter = list.children().length }

            // template prototype
            let newWidget = list.attr('data-prototype');

            // Remplacer "__name__" par le counter dans les attributs 'id' et 'name'
            newWidget = newWidget.replace(/__name__/g, counter);

            counter++;

            // enregistrement du nombre d'élément de la collection
            list.data('widget-counter', counter);

            // Création d'un élément pour la collection
            var newElement = $(list.attr('data-widget-tags')).html(newWidget);

            // also add a remove button, just for this example
            $newElement.append('<a href="#" class="remove-tag btn-secondary">x</a>');

            newElement.appendTo(list);

            // handle the removal, just for this example
            $('.remove-tag').click(function(e) {
                e.preventDefault();

                $(this).parent().remove();

                return false;
            });
        });




    });
}

export default addCollectionWidget();