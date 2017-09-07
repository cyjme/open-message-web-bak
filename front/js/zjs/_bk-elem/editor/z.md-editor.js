import {Markdown} from './z.markdown.js';
import {Request} from './http/request.js';

class MdEditor {
    constructor (ctn, opts) {
        this.ctn = ctn;
        this.footer = this.ctn.elem('.footer');
        this.saveUrl = this.ctn.getAttribute('data-save');

        this.inputId = this.ctn.elem('input[name="commitId"]');
        //this.inputTitle = this.ctn.elem('input[name="title"]');
        //this.inputAbbr = this.ctn.elem('input[name="abbr"]');
        this.inputMarkdown = this.ctn.elem('input[name="markdown"]');
        this.inputHtml = this.ctn.elem('input[name="html"]');

        this.md = new Markdown(
            this.ctn.elem('.markdown'),
            opts.markdown
        );

        this.request = new Request();

        window.on('resize', () => this.resize());

        this.resize();
        this.initEvent();
    }

    resize () {
        this.md.setHeight(window.innerHeight - this.footer.offsetHeight);
    }

    initEvent () {
        document.on('keydown', (e) => {
            if(e.keyCode == 83 && (e.ctrlKey || e.metaKey)){
                //e.shiftKey ? showMenu() : saveAsMarkdown();
                //alert('ctrl + s');
                this.commit();
                e.preventDefault();
                return false;
            }
        });

        this.ctn.on('submit', (e) => {
            let val = this.md.getValue();
            if (!val) {
                alert('markdown cannot be empty');
                e.preventDefault();
                return false;
            }

            /*
            let min = 350;
            let max = 420;
            let re = /^#\s+(.*)$/im;
            let result = re.exec(val);
            let title = result ? result[1] : '';
            let text = require('remove-markdown')(val.replace(/^#\s+(.*)$/im, ''));
            let abbr = text.replace(/(\r\n|\n|\r)/gm,"").substr(0, max);
            let lastPos = min + abbr.substr(min).search(/[,|.|;|\s|'|"|，|。|；|“|‘]/);
            if (lastPos > min) {
                abbr = abbr.substr(0, lastPos) + ' ...';
            }
            */

            this.inputHtml.value = this.md.getHtml();
            this.inputMarkdown.value = this.md.getValue();

            //this.inputTitle.value = title;
            //this.inputAbbr.value = abbr;
        });
    }

    commit () {
        let markdown = this.md.getValue();
        if (!markdown) {
            return;
        }

        let fd = new FormData(this.ctn);
        fd.append('markdown', markdown);
        fd.append('html', this.md.getHtml());

        this.request.postJson(this.saveUrl, fd, (error, data) => {
            if (error) {
                return;
            }

            if (!data.commitId) {
                return;
            }

            if (!this.inputId.value) {
                this.inputId.value = data.commitId;

                window.history.pushState(
                    null,
                    markdown.substr(0, 21),
                    "?commitId=" + data.commitId
                );
            }
        });
    }

    render () {
    }
}

export {MdEditor};
