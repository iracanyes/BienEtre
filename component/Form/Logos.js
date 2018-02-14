"use strict";
// Utilisation normale de JQuery
const $ = require("jquery");

// Mise à disposition JQuery as $
global.$ = global.JQuery = $;

var containerCollection;

// Ajout du bouton "ajout de logo"
var addLogoButton = $("<a href='#' class='add_tag_link'>Ajouter une image</a>");

var newDivLogo = $("<div class='logo'></div>").append(addLogoButton);

function addLogoForm(containerCollection, newDivLogo)
{
    // data-prototype
    let prototype = containerCollection.data("data-prototype");

    let index = containerCollection.data("index");

    let newForm = prototype;

    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // Incrémenter l'index avec une nouvelle item
    containerCollection.data("index", index++);

    // Affichage du formulaire dans la page
    let newFormDiv = $("<div class='logo'></div>").append(newForm);

    newDivLogo.before(newFormDiv);


}

$(function () {
    // div contenant les logos
    containerCollection = $("div.logos");

    // ajout du bouton 'add' et div dans le div.logos
    containerCollection.append(newDivLogo);

    // Nombre d'inputs pour l'utiliser comme index d'ajout
    containerCollection.data(
        "index",
        containerCollection.find(":input").length
    );

    addLogoButton.on("click", function(e) {
        // empêcher le lien de créer un url "#"
        e.preventDefault();

        //Ajout d'un nouveau logo
        addLogoForm(containerCollection, newDivLogo);
    });


});

