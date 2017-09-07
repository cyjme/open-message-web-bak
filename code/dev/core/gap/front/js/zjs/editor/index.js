import {View} from 'zjs/base/View.js';
import wangEditor from './wangEditor';

class Editor extends View {

    render() {
        this.editorId = this.ctn.getAttribute('id');
    }

    setValue(val) {
        this.ctn.elem('.content').innerHTML = this.tpl`
            ${val}
        `;
    }

    startup() {
        this.editor = new wangEditor(this.ctn);
        this.editor.customConfig.uploadImgServer = '/open/upload';
        this.editor.customConfig.uploadImgTimeout = '1000000';

        this.editor.create();
    }

    getHtml() {
        return this.editor.txt.html();
    }

    getText() {
        return this.editor.txt.text();
    }

}

export { Editor };
