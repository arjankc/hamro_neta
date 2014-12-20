<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    |
    | Basset is built around collections. A collection contains assets for
    | your application. Collections can contain both stylesheets and
    | javascripts.
    |
    | A default "application" collection is ready for immediate use. It makes
    | a couple of assumptions about your directory structure.
    |
    | /public
    |    /assets
    |        /stylesheets
    |            /less
    |            /sass
    |        /javascripts
    |            /coffeescripts
    |
    | You can overwrite this collection or remove it by publishing the config.
    |
    */

    'collections' => array(

        'landing' => function($collection)
        {
            $collection->directory('assets/css', function($collection)
            {
                $collection->add('landing_page.css')->raw();
                $collection->add('jquery-ui-1.10.3.custom.css');
                $collection->add('jquery.jqplot.min.css');
            })->apply('UriRewriteFilter')->apply('CssMin');

            $collection->directory('assets/js', function($collection)
            {
                $collection->javascript('jquery-1.9.1.js');
                $collection->add('jquery-ui-1.10.3.custom.js');
                $collection->add('jquery.jqplot.js');
                $collection->add('plugins/jqplot.logAxisRenderer.min.js');
                $collection->add('plugins/jqplot.canvasTextRenderer.min.js');
                $collection->add('plugins/jqplot.canvasAxisLabelRenderer.min.js');
                $collection->add('plugins/jqplot.canvasAxisTickRenderer.min.js');
                $collection->add('plugins/jqplot.dateAxisRenderer.min.js');
                $collection->add('plugins/jqplot.categoryAxisRenderer.min.js');
                $collection->add('plugins/jqplot.barRenderer.min.js');
            })->apply('JsMin');
        },

        'public' => function($collection)
        {
            $collection->directory('assets/css', function($collection)
            {
                $collection->add('desktop_standard.css')->raw();
                $collection->add('jquery.pageslide.css');
                $collection->add('nprogress.css');
                // $collection->add('colorbox.css')->raw();
                $collection->add('chosen.min.css')->raw();
                $collection->add('jquery-ui-1.10.3.custom.css')->raw();
            })->apply('UriRewriteFilter')->apply('CssMin');

            $collection->directory('assets/js', function($collection)
            {
                $collection->javascript('lib/jquery-2.0.3.min.js');
                $collection->add('jquery.pageslide.js');
                $collection->add('jquery.livequery.js');
                $collection->add('nprogress.js');
                $collection->add('moment-with-langs.js');
                $collection->add('jquery.form.js');
                // $collection->add('jquery.colorbox.js');
                // $collection->add('globalize.min.js');
                // $collection->add('dx.chartjs.js');
                $collection->add('chosen.jquery.min.js');
                $collection->add('jquery-ui-1.10.3.custom.js');
                $collection->add('script.js');
            })->apply('JsMin');
        },

        'admin' => function($collection)
        {
            $collection->directory('assets/css', function($collection)
            {
                $collection->add('bootstrap.min.css');
                $collection->add('bootstrap-responsive.min.css');
                $collection->add('bootstrap-editable.css')->raw();
                $collection->add('main.css');
            })->apply('UriRewriteFilter')->apply('CssMin');

            $collection->directory('assets/js', function($collection)
            {
                $collection->javascript('lib/jquery-2.0.3.min.js');
                $collection->add('bootstrap.min.js');
                $collection->add('bootstrap-editable.min.js');
                $collection->add('admin-script.js');
            })->apply('JsMin');
        }

        // Basset default config
        // 'application' => function($collection)
        // {
        //     // Switch to the stylesheets directory and require the "less" and "sass" directories.
        //     // These directories both have a filter applied to them so that the built
        //     // collection will contain valid CSS.
        //     $directory = $collection->directory('assets/stylesheets', function($collection)
        //     {
        //         $collection->requireDirectory('less')->apply('Less');
        //         $collection->requireDirectory('sass')->apply('Sass');
        //         $collection->requireDirectory();
        //     });

        //     $directory->apply('CssMin');
        //     $directory->apply('UriRewriteFilter');

        //     // Switch to the javascripts directory and require the "coffeescript" directory. As
        //     // with the above directories we'll apply the CoffeeScript filter to the directory
        //     // so the built collection contains valid JS.
        //     $directory = $collection->directory('assets/javascripts', function($collection)
        //     {
        //         $collection->requireDirectory('coffeescripts')->apply('CoffeeScript');
        //         $collection->requireDirectory();
        //     });

        //     $directory->apply('JsMin');
        // }

    ),

    /*
    |--------------------------------------------------------------------------
    | Production Environment
    |--------------------------------------------------------------------------
    |
    | Basset needs to know what your production environment is so that it can
    | respond with the correct assets. When in production Basset will attempt
    | to return any built collections. If a collection has not been built
    | Basset will dynamically route to each asset in the collection and apply
    | the filters.
    |
    | The last method can be very taxing so it's highly recommended that
    | collections are built when deploying to a production environment.
    |
    | You can supply an array of production environment names if you need to.
    |
    */

    'production' => array('production', 'prod'),

    /*
    |--------------------------------------------------------------------------
    | Build Path
    |--------------------------------------------------------------------------
    |
    | When assets are built with Artisan they will be stored within a directory
    | relative to the public directory.
    |
    | If the directory does not exist Basset will attempt to create it.
    |
    */

    'build_path' => 'assets/compiled',

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Enable debugging to have potential errors or problems encountered
    | during operation logged to a rotating file setup.
    |
    */

    'debug' => false,

    /*
    |--------------------------------------------------------------------------
    | Node Paths
    |--------------------------------------------------------------------------
    |
    | Many filters use Node to build assets. We recommend you install your
    | Node modules locally at the root of your application, however you can
    | specify additional paths to your modules.
    |
    */

    'node_paths' => array(

        base_path().'/node_modules'

    ),

    /*
    |--------------------------------------------------------------------------
    | Gzip Built Collections
    |--------------------------------------------------------------------------
    |
    | To get the most speed and compression out of Basset you can enable Gzip
    | for every collection that is built via the command line. This is applied
    | to both collection builds and development builds.
    |
    | You can use the --gzip switch for on-the-fly Gzipping of collections.
    |
    */

    'gzip' => false,

    /*
    |--------------------------------------------------------------------------
    | Asset and Filter Aliases
    |--------------------------------------------------------------------------
    |
    | You can define aliases for commonly used assets or filters.
    | An example of an asset alias:
    |
    |   'layout' => 'stylesheets/layout/master.css'
    |
    | Filter aliases are slightly different. You can define a simple alias
    | similar to an asset alias.
    |
    |   'YuiCss' => 'Yui\CssCompressorFilter'
    |
    | However if you want to pass in options to an aliased filter then define
    | the alias as a nested array. The key should be the filter and the value
    | should be a callback closure where you can set parameters for a filters
    | constructor, etc.
    |
    |   'YuiCss' => array('Yui\CssCompressorFilter', function($filter)
    |   {
    |       $filter->setArguments('path/to/jar');
    |   })
    |
    |
    */

    'aliases' => array(

        'assets' => array(),

        'filters' => array(

            /*
            |--------------------------------------------------------------------------
            | Less Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when asset has a ".less" extension and it will
            | attempt to find missing constructor arguments.
            |
            */

            'Less' => array('LessphpFilter', function($filter)
            {
                $filter->whenAssetIs('.*\.less')->findMissingConstructorArgs();
            }),

            /*
            |--------------------------------------------------------------------------
            | Sass Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when asset has a ".sass" or ".scss" extension and
            | it will attempt to find missing constructor arguments.
            |
            */

            'Sass' => array('Sass\ScssFilter', function($filter)
            {
                $filter->whenAssetIs('.*\.(sass|scss)')->findMissingConstructorArgs();
            }),

            /*
            |--------------------------------------------------------------------------
            | CoffeeScript Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when asset has a ".coffee" extension and it will
            | attempt to find missing constructor arguments.
            |
            */

            'CoffeeScript' => array('CoffeeScriptFilter', function($filter)
            {
                $filter->whenAssetIs('.*\.coffee')->findMissingConstructorArgs();
            }),

            /*
            |--------------------------------------------------------------------------
            | CssMin Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when within the production environment and when
            | the "CssMin" class exists.
            |
            */

            'CssMin' => array('CssMinFilter', function($filter)
            {
                $filter->whenAssetIsStylesheet()->whenProductionBuild()->whenClassExists('CssMin');
            }),

            /*
            |--------------------------------------------------------------------------
            | JsMin Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter is applied only when within the production environment and when
            | the "JsMin" class exists.
            |
            */

            'JsMin' => array('JSMinFilter', function($filter)
            {
                $filter->whenAssetIsJavascript()->whenProductionBuild()->whenClassExists('JSMin');
            }),

            /*
            |--------------------------------------------------------------------------
            | UriRewrite Filter Alias
            |--------------------------------------------------------------------------
            |
            | Filter gets a default argument of the path to the public directory.
            |
            */

            'UriRewriteFilter' => array('UriRewriteFilter', function($filter)
            {
                $filter->setArguments(public_path())->whenAssetIsStylesheet();
            })

        )

    )

);
