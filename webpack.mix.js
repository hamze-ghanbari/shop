let mix = require('laravel-mix');


/* Allow multiple Laravel Mix applications*/
require('laravel-mix-merge-manifest');
mix.mergeManifest();
/*----------------------------------------*/

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/public.js', 'public/js')
    // .js('resources/js/helpers/Validation.js', 'public/js/validation')
    .js('Modules/Auth/Resources/assets/js/app.js', 'public/modules/auth/js')
    .js('Modules/User/Resources/assets/js/app.js', 'public/modules/user/js')
    .js('Modules/User/Resources/assets/js/user.js', 'public/modules/user/js')
    .js('Modules/User/Resources/assets/js/role.js', 'public/modules/user/js')
    .js('Modules/Product/Resources/assets/js/app.js', 'public/modules/Product/js')
    .js('Modules/Product/Resources/assets/js/category.js', 'public/modules/Product/js')
    // public style
    .sass('resources/sass/app.scss', 'public/styles/css')
    .sass('resources/sass/styles/style.scss', 'public/styles/css')
    .sass('resources/sass/classes/_color_classes.scss', 'public/styles/css/classes')
    .sass('resources/sass/classes/_button_classes.scss', 'public/styles/css/classes')
    .sass('resources/sass/classes/_typography_classes.scss', 'public/styles/css/classes')
    // module style
    .sass('Modules/Auth/Resources/assets/sass/app.scss', 'public/modules/auth/css')
    .sass('Modules/User/Resources/assets/sass/app.scss', 'public/modules/User/css')
    .sass('Modules/User/Resources/assets/sass/user.scss', 'public/modules/User/css')
    .sass('Modules/Product/Resources/assets/sass/app.scss', 'public/modules/Product/css')
    .sass('Modules/Product/Resources/assets/sass/category.scss', 'public/modules/Product/css')
