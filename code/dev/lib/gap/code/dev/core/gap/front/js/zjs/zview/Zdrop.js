import {View} from './../base/View.js';
import {zdropdown} from './../zdropdown';

class Zdrop extends View {
    startup() {
        zdropdown(
            this.ctn.elem('.zdrop-btn'),
            this.ctn.elem('.zdrop-wrap')
        );
    }
}

export {Zdrop};
