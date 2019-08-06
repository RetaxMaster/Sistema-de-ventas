/* const path = require("path");

module.exports = {
    entry: {
        home : "./input/scripts/latest-videos.js"
    },
    output: {
        path: path.join(__dirname, "output"),
        filename: "latest-videos.bundle.js"
    },
    module: {
        rules: [{
            test: /\.js$/,
            exclude: /node_modules/,
            loader: "babel-loader",
            query: {
                presets: ["@babel/preset-env", "@babel/polyfill"]
            }
        }]
    },
    mode: "development"
}; */

const path = require('path');

module.exports = {
    entry: './input/scripts/sales.js',
    output: {
        filename: 'sales.bundle.js',
        path: path.join(__dirname, 'output')
    },
    module: {
        rules: [{
            test: /\.js$/,
            exclude: /node_modules/,
            loader: "babel-loader"
        }]
    },
    mode: "development"
};