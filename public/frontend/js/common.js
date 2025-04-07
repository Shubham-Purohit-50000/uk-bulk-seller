$('#productSearchInput').on('keyup', function () {
    let query = $(this).val().trim();
    let $results = $('#productSearchResults');

    if (query.length < 2) {
        $results.html('');
        return;
    }

    $.ajax({
        url: '/search-products',
        type: 'GET',
        data: { q: query },
        success: function (response) {
            $results.html(response.html || '<p>No products found.</p>');
        }
    });
});

var remove_preloader = function () {
    if ($("body").hasClass("preload-wrapper")) {
      setTimeout(function () {
        $(".custom-preload").fadeOut("slow");
      }, 100);
    }
};

var bring_preloader = function () {
    if ($("body").hasClass("preload-wrapper")) {
      setTimeout(function () {
        $(".custom-preload").css('display','block').fadeIn("slow");
      }, 100);
    }
};