import {View} from './../base/View.js';
import {zdropdown} from './../zdropdown';

class MoreMenu extends View {

    startup() {
        if (this.ctn.elem('.more-wrap')) {
            zdropdown(
                this.ctn.elem('.more-btn'),
                this.ctn.elem('.more-wrap')
            );
        }
    }
}

export {MoreMenu};
