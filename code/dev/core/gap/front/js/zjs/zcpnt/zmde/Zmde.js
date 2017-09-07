import {View} from './../../base/View.js';
import {loadJs, loadCss} from './../../html/load';

// https://stackoverflow.com/questions/18614169/set-value-for-ace-editor-without-selecting-the-whole-editor

class Zmde extends View {
    render() {
        this.ctn.addClass('zmde');
        this.ctn.style.height = '100%';

        this.ctn.innerHTML = this.tpl`
            <div class="grid col2">
                <div class="cell coder-wrap">
                    <div class="coder"></div>
                </div>
                <div class="cell preview-wrap">
                    <div class="preview"></div>
                </div>
            </div>
        `;
    }

    startup() {
        this.previewElem = this.ctn.elem('.preview');
        this.coderElem = this.ctn.elem('.coder');

        this.coderWrap = this.ctn.elem('.coder-wrap');
        this.previewWrap = this.ctn.elem('.preview-wrap');

        this.loadMarkdown();
        this.loadCoder();

        this.coderWrap.on('scroll', () => {
            this.previewWrap.scrollTop =
                (this.previewWrap.scrollHeight - this.previewWrap.offsetHeight)
                * this.coderWrap.scrollTop
                / (this.coderWrap.scrollHeight - this.coderWrap.offsetHeight);
        });
    }

    preview() {
        if (this.markdown && this.coder) {
            this.previewElem.innerHTML = this.getHtml();
        }
    }

    getText() {
        if (this.markdown && this.coder) {
            return this.previewElem.innerText;
        }

        return '';
    }

    getHtml() {
        return this.markdown.render(this.coder.getValue());
    }

    getCode() {
        return this.coder.getValue();
    }

    setCode(code, flag = null) {
        if (this.coder) {
            this.coder.setValue(code, flag);
        }
    }

    loadMarkdown() {
        let langOverrides = {
            js: 'javascript',
            html: 'xml'
        };

        loadCss(this.data.highlight.css);
        loadJs(this.data.highlight.js, () => {
            loadJs(this.data.markdownit.js, () => {
                this.markdown = window.markdownit({
                    html: true,
                    linkify: true,
                    highlight: function(code, lang) {
                        lang = langOverrides[lang] || lang;
                        if (lang && window.hljs.getLanguage(lang)) {
                            return window.hljs.highlight(lang, code).value;
                        }
                        return '';
                    }
                });

                this.preview();
                this.trigger('load');
            });
        });
    }

    loadCoder() {
        if (this.data.coder.type == 'ace') {
            this.loadAce();
        }
    }

    loadAce() {
        loadJs(this.data.coder.js, () => {
            this.coder = window.ace.edit(this.coderElem);
            this.coder.$blockScrolling = Infinity;

            this.coder.setTheme("ace/theme/chrome");
            this.coder.setOptions({
                maxLines: Infinity,
                minLines: 21
            });
            this.coder.resize();

            const session = this.coder.getSession();
            session.setMode("ace/mode/markdown");
            session.setUseWrapMode(true);
            session.setWrapLimitRange(80, 80);

            this.coder.on('change', () => {
                this.preview();
                this.trigger('change');
            });
            this.preview();
        });
    }
}

export {Zmde};

