const path = require('path');

const ExtractTextPlugin = require("extract-text-webpack-plugin");

const extractSass = new ExtractTextPlugin('style.css');

module.exports = {
	entry: path.join(__dirname, './css/main.scss'),
	output: {
		path: path.join(__dirname, './css'),
		filename: 'bundle.js'
	},
    module: {
        rules: [{
            test: /\.scss$/,
            loader: extractSass.extract(['css-loader', 'sass-loader'])
        }]
    },
	plugins: [
		extractSass
	]
};