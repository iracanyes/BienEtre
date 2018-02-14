/**
 * Description: Ajout d'un widget collection
 */
let $ = require('jquery');

$(function () {
    $(".add-another-collection-widget").click(function () {
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
        let newElement = $(list.attr('data-widget-tags')).html(newWidget);

        newElement.appendTo(list);

    });
});