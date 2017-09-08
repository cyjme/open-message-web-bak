var __dirname = __dirname || '';
const path = require('path');
const webpack = require('webpack');
const baseDir = path.resolve(__dirname);

let siteConfig = require(path.join(baseDir, './code/dev/front/setting/config/site.local.js'));

//console.log(env);

module.exports = (env) => {
    let options = {
        output: {
            filename: '[name].js',
            chunkFilename: '[hash].js',
            path: path.join(baseDir, './code/site/static/js'),
            publicPath: '//' + siteConfig.static.host + '/js/'
        },
        entry: {
            "fill-company-cntr": './code/dev/front/react/fillCompanyCntr.js'
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: [{
                        loader: 'babel-loader',
                        options: {
                            presets: ['react', 'es2015'],
                        }
                    }]
                    //loader: 'babel-loader?-babelrc,+cacheDirectory,presets[]=es2015,presets[]=stage-0,presets[]=react',
                    /*
                    loader: 'babel-loader',
                    options: {
                        babelrc: false,
                        presets: ['react', 'es2015'],
                        cacheDirectory: true
                    },
                    */
                }
            ]
        }
    };

    if (env == 'dev') {
        options.devtool = 'source-map';
    } else if (env == 'prod') {
        options.plugins = [
            new webpack.DefinePlugin({
                'process.env': {
                    'NODE_ENV': JSON.stringify('production')
                }
            }),
            new webpack.LoaderOptionsPlugin({
                minimize: true,
                debug: false
            }),
            new webpack.optimize.UglifyJsPlugin({
                compress: {
                    warnings: false,
                    //screw_ie8: true,
                    //conditionals: true,
                    //unused: true,
                    //comparisons: true,
                    //sequences: true,
                    //dead_code: true,
                    //evaluate: true,
                    //if_return: true,
                    //join_vars: true,
                },
                output: {
                    comments: false,
                },
            }),
            new webpack.optimize.AggressiveMergingPlugin()
        ];
    }

    return options;
};
