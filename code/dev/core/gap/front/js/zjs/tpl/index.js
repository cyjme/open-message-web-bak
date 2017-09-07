import {escapeHtml} from './escape/escapeHtml.js';

// http://2ality.com/2015/01/template-strings-html.html
// https://muffinresearch.co.uk/removing-leading-whitespace-in-es6-template-strings/

function tpl(literalSections, ...substs) {
    // Use raw literal sections: we don’t want
    // backslashes (\n etc.) to be interpreted
    let raw = literalSections.raw;

    let result = '';

    substs.forEach((subst, i) => {
        // Retrieve the literal section preceding
        // the current substitution
        let lit = raw[i];

        // In the example, map() returns an array:
        // If substitution is an array (and not a string),
        // we turn it into a string
        if (Array.isArray(subst)) {
            subst = subst.join('');
        }

        // If the substitution is preceded by a dollar sign,
        // we escape special characters in it
        if (lit.endsWith('$')) {
            subst = escapeHtml(subst);
            lit = lit.slice(0, -1);
        }
        result += lit;
        result += subst;
    });
    // Take care of last literal section
    // (Never fails, because an empty template string
    // produces one literal section, an empty string)
    result += raw[raw.length-1]; // (A)

    return result.replace(/\s+/g, ' ');
    /*
    // Split on newlines.
    let lines = result.split(/(?:\r\n|\n|\r)/);


    return lines.map((line) => {
        return line.replace(/^\s+/gm, '');
    }).join(' ').trim();
    */
}

export {tpl};
