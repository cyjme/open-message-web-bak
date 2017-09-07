import './boot/action/actionAsm.js';

import {LocaleMenu} from 'zjs/zview/LocaleMenu.js';
import {MoreMenu} from 'zjs/zview/MoreMenu.js';
import {Zdrop} from 'zjs/zview/Zdrop.js';
import {Zselect} from 'zjs/zview/Zselect.js';
import {zview} from 'zjs/zview';
import {Upload} from 'zjs/zview/Upload.js';

zview({
    '.zselect': Zselect,
    '.locale-menu': LocaleMenu,
    '.more-menu': MoreMenu,
    '.zdrop': Zdrop,
    '.upload-img': Upload,
});
