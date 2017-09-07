module.exports = {
    "env": {
        "browser": true,
        "commonjs": true,
        "es6": true,
        "jest": true
    },
    "extends": ["eslint:recommended"],
    "parser": "babel-eslint",
    "parserOptions": {
        "sourceType": "module",
        "allowImportExportEverywhere": true
    },
    "rules": {
        "indent": ["error", 4],
        "linebreak-style": ["error", "unix"],
        //"quotes": ["error", "double"],
        "semi": ["error", "always"],
        "no-else-return": "error"
    }
};
