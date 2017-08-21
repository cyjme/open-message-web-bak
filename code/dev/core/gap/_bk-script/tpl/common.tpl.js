module.exports = function(commonName, commonDir, bootJses) {
    return `
/*
  * generate by script/build-js.js
  * author by zjh
*/

import {zon} from 'zjs/event/zon.js';
import 'zjs/prototype.js';

${bootJses.map(jsFile => `import '${jsFile.replace(commonDir, '.')}';`).join('\n')}

let ${commonName} = {};

zon.on('require', elem => {
    if (${commonName}.requirePage) {
        ${commonName}.requirePage(elem.getAttribute('data-page'));
    }
});

zon.reg();

document.ready(() => {
    if (zon.hasEvent('load')) {
        zon.trigger('load');
    }
});

export {${commonName}};
`.trim();

};
