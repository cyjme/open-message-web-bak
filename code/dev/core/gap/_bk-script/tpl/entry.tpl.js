module.exports = function(common, entry, appDir, bootJses, bootEntryJses, pageLength) {

    function tplRequirePage() {
        if (pageLength > 0) {
            return `
import {${common}} from '${common}';

${common}.requirePage = (page) => {
    import('./page/' + page + '.js');
};
`.trim();
        }

        return '';
    }

    return `
/*
  * generate by script/build-js.js
  * author by zjh
*/

${bootJses.map(jsFile => `import '${jsFile.replace(appDir, '.')}';`).join('\n')}
${bootEntryJses.map(jsFile => `import '${jsFile.replace(appDir, '.')}';`).join('\n')}

${tplRequirePage()}

`.trim();

};

