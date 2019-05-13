console.log('JS chargé');

$('#likes button').on('click', function () {
    // Récuperation d'id
    const id = $('#likes button').first().data('likes');
    // Paramétres AJAX
    const params = {
        url: 'http://creation.sf/api/user/likes/' + id
    };
    // Lancement de l'appel AJAX
    $.ajax(params).done(displayNewLikes);
});

function displayNewLikes(json)
{
    $('#likes span').text(json.cpt);
    // affiche la nouvelle valeur du nombre de likes
    console.log('retour d\'appel AJAX');
}
