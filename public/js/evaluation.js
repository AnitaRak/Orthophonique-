/*Principe :
* Etape 1 : Récuperer les informations liées à l'évaluation : idPatient, idTest(épreuve).
* Etape 2 : Récuperer les informations sur les items contenu dans la vue run.html.twig.
* Etape 3 : Skipper les items qui on déjà une réponse dans la BDD. (reprendre l'épreuve la ou elle s'est arrêtée).
* Etape 4 : lorsque de nouvelle réponse on été entrées dans la vue, les envoyer au controller pour les enregistrer dans la BDD.
* Etape 5 : Gérer l'apparition des items. Une fois qu'on a répondu à un item passer au suivant.
* Etape 6 : Afficher la vue final quand tout les items ont été répondu. changer le statut de l'evaluation sur "Done".
*/
var idPatient;
var idTest;
var sequence;       //item courant dans la vue. Cette variable doit correspondre à l'item courant dans la vue pour que le programme fonctionne 
var lastItem;
$(document).ready(function () {

    //Etape 1 : Récuperer les informations liées à l'évaluation : idPatient, idTest(épreuve).
    idPatient = $("input[name='patient']").val();
    idTest = $("input[name='test']").val();

    //Etape 2 : on commence par le premier item.
    sequence = 0;
    lastItem = $("input[name='nbItem']").val();
    lastItem--;
    //Etape 3 : Skipper les items qui on déjà une réponse dans la BDD. (reprendre l'épreuve la ou elle s'est arrêtée)
    resume();
    $("." + sequence).css("display", "block");
    
});


//Etape 5 : Gérer l'apparition des items. Une fois qu'on a répondu à un item passer au suivant.
/*
*cette fonction permet de passer à la question suivante. Elle gère l'affichage des items dans la vue. 
*/
function questionS() {
    if (sequence < lastItem) {
        $("." + sequence).css("display", "none");
        sequence++;
        $("." + sequence).css("display", "block");
    } else {
        //Etape 6 : Afficher la vue final quand tout les items ont été répondu. changer le statut de l'evaluation sur "Done".
        $("." + sequence).css("display", "none");
        $(".end").css("display", "block");
        let end = true;
        $.ajax({
            type: "POST",
            url: '/evaluation/' + idTest + '/' + idPatient + '/run',
            data: { "end": end },
            success: function (response) {
                // Code à exécuter en cas de succès
                console.log("Requête réussie :", response);
            },
            error: function (xhr, status, error) {
                // Code à exécuter en cas d'erreur
                console.error("Erreur lors de la requête :", xhr, status, error);

                // Affichez la réponse du serveur si elle est disponible
                console.log("Réponse du serveur :", xhr.responseText || "Aucune réponse du serveur");
            }
        });
    }


}
/*
*cette fonction permet de revenir sur l'sequence précédent. Elle gère l'affichage des items dans la vue.
*/
function questionP() {
    if (sequence > 0) {
        $("." + sequence).css("display", "none");
        sequence--;
        $("#submit" + sequence).prop("disabled", false);
        $("." + sequence).css("display", "block");
    }

}
/*
*cette fonction permet de reprendre l'evaluation la ou elle s'est arrêtée.
*/ 
function resume() {
    skip = $("." + sequence + " input[name='skip']").val();
    while (skip) {
        sequence++;
        skip = $("." + sequence + " input[name='skip']").val();
        if (sequence >= lastItem){
            $(".end").css("display", "block");
        }
    }
    
    
}

//Etape 4 : lorsque de nouvelle réponse on été entrées dans la vue, les envoyer au controller pour les enregistrer dans la BDD.
/*
* envoie les réponses d'un sequence au controller 
*/
function AjaxReq() {
    $("#submit" + sequence).prop("disabled", true);
    /*
    *on intègre les données dans un FormData pour les envoyées vers le controller à l'aide d'un requête AJAX 
    */
    let formData = new FormData(document.getElementById('form' + sequence));
    let nbQuestion = $("input[name='nbQuestion']").val();
    let itemId = $("#submit" + sequence).data('item');
    for (let i = 0; i < nbQuestion; i++) {
        let question = $('#form' + sequence + " input[name='question" + i + "']").val();
        let point = $('input[name="choix' + question + '"]:checked').val();
        let tvalueData = $('input[name="choix' + question + '"]:checked').data('tvalue');
        formData.append('id' + i, question);
        formData.append('tval' + i, tvalueData);
        formData.append("point" + i, point);
    }
    formData.append('size', nbQuestion);
    formData.append('item', itemId);

    $.ajax({
        type: 'POST',
        url: '/evaluation/' + idTest + '/' + idPatient + '/run',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            // Faire quelque chose avec la réponse reçue du contrôleur
            setTimeout(function () {
                questionS();
            }, 500)

        },
        error: function (error) {
            console.error('Erreur:', error);
            $("#submit" + sequence).prop("disabled", false);
        }

    });
}


