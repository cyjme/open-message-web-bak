import {Zselect} from './Zselect.class.js';
function zselect(ctn) {
    let zs = new Zselect(ctn);
    //zs.render();
    return zs;
}

export {zselect};
