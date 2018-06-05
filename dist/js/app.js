$(function () {
    // Global var's
    var messageBox = $('div#responseMessages');

    // load collections list
    function loadCollections() {
        $.ajax({
            url: '/main/getCollections',
            type: 'POST'
        }).done(function (response) {
            if(typeof response === 'object')
            {
                messageBox.html('');
                $('div#collections-box').html('');
                $.each(response, function (i,e) {
                    var card = '<div class="card">\n' +
                        '                            <div class="card-body">\n' +
                        '                                <h5 class="card-title">' + e.title + '</h5>\n' +
                        '                                <p class="card-text">' + e.description + '</p>\n' +
                        '                                <a href="#" role="button" class="btn btn-primary" id="collectionViewButton" collection-id="' + e.collection_id + '" collection-title="' + e.title + '">Переглянути колекцію</a>\n' +
                        '                            </div>\n' +
                        '                        </div>';
                    $('div#collections-box').append(card);
                });
            } else {
                messageBox.html('<div class="alert alert-danger" role="alert">loadCollections() > POST > /main/getCollections : ' + response + '</div>');
            }
        }).fail(function () {
            messageBox.html('<div class="alert alert-danger" role="alert">loadCollections() > POST > /main/getCollections : Request fail</div>');
            console.log("Request fail");
        });
    }

    // load products list
    function loadProducts() {
        $.ajax({
            url: '/main/getProducts',
            type: 'POST'
        }).done(function (response) {
            if(typeof response === 'object')
            {
                messageBox.html('');
                $('div#products-box').html('');
                $.each(response, function (i,e) {
                    var card = '<div class="card">\n' +
                        '<img class="card-img-top" src="' + e.image + '" alt="' + e.title + '">' +
                        '                            <div class="card-body">\n' +
                        '                                <h5 class="card-title">' + e.title + '</h5>\n' +
                        '                                <p class="card-text">Ціна: ' + e.price + '</p>' +
                        '                                <p class="card-text"><small class="text-muted">Виробник: ' + e.vendor + '</small></p>' +
                        '                                <p class="card-text">' + e.description + '</p>\n' +
                        '                            </div>\n' +
                        '                        </div>';
                    $('div#products-box').append(card);
                });
            } else {
                messageBox.html('<div class="alert alert-danger" role="alert">loadProducts() > POST > /main/getProducts : ' + response + '</div>');
            }
        }).fail(function () {
            messageBox.html('<div class="alert alert-danger" role="alert">loadProducts() > POST > /main/getProducts : Request fail</div>');
            console.log("Request fail");
        });
    }

    loadCollections();
    loadProducts();

    // Show all products
    $('a#displayAllProducts').on('click', function (e) {
        e.preventDefault();
        $('div#products-box').html('');
        loadProducts();
    });

    // Load products in collection
    $('div#collections-box').on('click', 'a#collectionViewButton', function (e) {
        e.preventDefault();
        var collectionId = $(this).attr('collection-id');
        $.ajax({
            url: '/main/getCollectionsProducts',
            type: 'POST',
            data: {
                collection : collectionId
            }
        }).done(function (response) {
            if(typeof response === 'object')
            {
                messageBox.html('');
                $('div#products-box').html('');
                $.each(response, function (i,e) {
                    var card = '<div class="card">\n' +
                        '<img class="card-img-top" src="' + e.image + '" alt="' + e.title + '">' +
                        '                            <div class="card-body">\n' +
                        '                                <h5 class="card-title">' + e.title + '</h5>\n' +
                        '                                <p class="card-text">Ціна: ' + e.price + '</p>' +
                        '                                <p class="card-text"><small class="text-muted">Виробник: ' + e.vendor + '</small></p>' +
                        '                                <p class="card-text">' + e.description + '</p>\n' +
                        '                            </div>\n' +
                        '                        </div>';
                    $('div#products-box').append(card);
                });
            } else {
                messageBox.html('<div class="alert alert-danger" role="alert">onClick a#collectionViewButton > POST > /main/getCollectionsProducts : ' + response + '</div>');
            }
        }).fail(function () {
            messageBox.html('<div class="alert alert-danger" role="alert">onClick a#collectionViewButton > POST > /main/getCollectionsProducts : Request fail</div>');
            console.log("Request fail");
        });
    });

    // Check for new data
    $('a#checkForNewData').on('click', function (e) {
        e.preventDefault();
        messageBox.html('<div class="alert alert-warning" role="alert">Оновлення списку ...</div>');
        $.ajax({
            url: '/main/synchronization',
            type: 'POST'
        }).done(function (response) {
            if(response === 200) {
                loadCollections();
                loadProducts();
            } else {
                messageBox.html('<div class="alert alert-danger" role="alert">onClick a#checkForNewData > POST > /main/synchronization : ' + response + '</div>');
            }
        }).fail(function () {
            messageBox.html('<div class="alert alert-danger" role="alert">onClick a#checkForNewData > POST > /main/synchronization : Request fail</div>');
            console.log("Request fail");
        });
    });
});