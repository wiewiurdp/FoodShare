// soups.append();
// console.log(soups);

// var children = $('#foodbundle_post_category').children();
$(document).ready(function () {
    var soups = $('#foodbundle_post_subCategory').find('[data-soups]');
    var mains = $('#foodbundle_post_subCategory').find('[data-mains]');
    var desserts = $('#foodbundle_post_subCategory').find('[data-desserts]');
    var breakfasts = $('#foodbundle_post_subCategory').find('[data-breakfasts]');

    $('#foodbundle_post_category').on('change', function () {

        switch ($(this).val()) {
            case 'soup':
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
            case 'main':
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
            case 'dessert':
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
            case 'breakfast':
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

})


