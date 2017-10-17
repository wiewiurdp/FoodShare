// soups.append();
// console.log(soups);

$(document).ready(function () {
    var soups = $('#foodbundle_post_subCategory').find('[data-soups]');
    var mains = $('#foodbundle_post_subCategory').find('[data-mains]');
    var desserts = $('#foodbundle_post_subCategory').find('[data-desserts]');
    var breakfasts = $('#foodbundle_post_subCategory').find('[data-breakfasts]');

    $('#foodbundle_post_category').on('change', function () {

        switch ($(this).val()) {
            case 'Zupa':
                if (soups.hasClass("hidden")) {
                    soups.toggleClass('hidden');
                }
                if (!mains.hasClass("hidden")) {
                    mains.toggleClass("hidden");
                }
                if (!desserts.hasClass("hidden")) {
                    desserts.toggleClass("hidden");
                }
                if (!breakfasts.hasClass("hidden")) {
                    breakfasts.toggleClass("hidden");
                }
                break;
            case 'Danie Główne':
                if (!soups.hasClass("hidden")) {
                    soups.toggleClass('hidden');
                }
                if (mains.hasClass("hidden")) {
                    mains.toggleClass("hidden");
                }
                if (!desserts.hasClass("hidden")) {
                    desserts.toggleClass("hidden");
                }
                if (!breakfasts.hasClass("hidden")) {
                    breakfasts.toggleClass("hidden");
                }
                break;
            case 'Deser':
                if (!soups.hasClass("hidden")) {
                    soups.toggleClass('hidden');
                }
                if (!mains.hasClass("hidden")) {
                    mains.toggleClass("hidden");
                }
                if (desserts.hasClass("hidden")) {
                    desserts.toggleClass("hidden");
                }
                if (!breakfasts.hasClass("hidden")) {
                    breakfasts.toggleClass("hidden");
                }
                break;
            case 'Śniadanie/kolacja':
                if (!soups.hasClass("hidden")) {
                    soups.toggleClass('hidden');
                }
                if (!mains.hasClass("hidden")) {
                    mains.toggleClass("hidden");
                }
                if (!desserts.hasClass("hidden")) {
                    desserts.toggleClass("hidden");
                }
                if (breakfasts.hasClass("hidden")) {
                    breakfasts.toggleClass("hidden");
                }
                break;

        }
    })

});


