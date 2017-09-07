class Markdown {
    constructor (ctn, opts) {
        this.ctn = ctn;
        this.in = this.ctn.elem('.in');
        this.out = this.ctn.elem('.out');
        this.loadJs = require('load-script');
        this.loadCss = require('load-css-file');

        this.init();

        this.loadMarkdownit(opts.markdownit, opts.highlight);
        this.loadAce(opts.ace);
    }

    init () {
        let self = this;
        //this.ctn.style.height = window.innerHeight + 'px';
        this.in.on('scroll', () => {
            self.out.scrollTop = (self.out.scrollHeight - self.out.offsetHeight)
                * self.in.scrollTop
                / (self.in.scrollHeight - self.in.offsetHeight);
        });
    }

    setHeight (height) {
        this.ctn.style.height = height + 'px';
    }

    loadMarkdownit (markdownit, highlight) {
        let languageOverrides = {
            js: 'javascript',
            html: 'xml'
        };

        this.loadCss(highlight.css);
        this.loadJs(highlight.js, () => {
            this.loadJs(markdownit.js, () => {
                this.md = window.markdownit({
                    html: true,
                    linkify: true,
                    highlight: function(code, lang){
                        if(languageOverrides[lang]) lang = languageOverrides[lang];
                        if(lang && window.hljs.getLanguage(lang)){
                            return window.hljs.highlight(lang, code).value;
                        }
                        return '';
                    }
                });
                this.render();
            });
        });

    }

    loadAce (ace) {
        this.loadJs(ace.js, () => {
            this.coder = window.ace.edit(this.in.elem('.coder'));
            this.coder.setTheme("ace/theme/chrome");
            this.coder.setOptions({
                maxLines: Infinity,
                minLines: 21
            });
            this.coder.resize();

            this.coderSession = this.coder.getSession();
            this.coderSession.setMode("ace/mode/markdown");
            this.coderSession.setUseWrapMode(true);
            this.coderSession.setWrapLimitRange(80, 80);

            this.coder.on('change', () => this.render());
            this.render();
        });
    }

    render () {
        if (this.md && this.coder) {
            //this.out.innerHTML = this.md.render(this.coder.getValue());
            this.out.innerHTML = this.getHtml();
        }
    }

    getValue () {
        return this.coder.getValue();
    }

    getHtml () {
        return this.md.render(this.coder.getValue());
    }
}

export {Markdown};
