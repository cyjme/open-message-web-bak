import {View} from './../base/View.js';
import {tpl} from './../tpl';
import {RequestQueue} from './../http/request-queue/RequestQueue.js';
import {fillObj as fill} from './../str/fill-obj.js';

class Zselect extends View {
    beforeRender() {
        if (!this.data) {
            this.data = this.buildDataFromAttr();
        }

        this.name = this.data.name;
        this.required = this.data.required;
        this.placeholder = this.data.placeholder;
        this.srcUrl = this.data.srcUrl;
        this.queryName = this.data.queryName;
        this.args = this.data.args;

        this.contentPattern = this.data.pattern.content;
        this.selectedPattern = this.data.pattern.selected || this.contentPattern;
        this.valuePattern = this.data.pattern.value;

        this.isMulti = this.data.isMulti;

        this.selectedItems = {};
        this.selectedNum = 0;

        this.ctn.addClass('zselect');

    }

    render() {
        this.ctn.innerHTML = tpl`
            <div class="selected-wrap">
                <input type="text"
                    ${this.required ? 'required="required"' : ''}
                    ${this.placeholder ? ('placeholder=' + this.placeholder) : ''}
                    class="zinput">
            </div>
            <div class="drop-wrap">
            </div>
        `;
    }

    startup() {
        this.selectedWrap = this.ctn.elem('.selected-wrap');
        this.dropWrap = this.ctn.elem('.drop-wrap');
        this.input = this.ctn.elem('.selected-wrap input');

        this.reg();
    }

    reg() {
        this.input.on('focus', () => this.focus());
        this.input.on('blur', (e) => this.blur(e));
        this.input.on('keyup', () => this.query());

        this.ctn.on('mousedown', (e) => {
            e.cancel();
            e.stop();
            this.input.focus();
            this.showDropWrap();
            return false;
        });

        this.selectedWrap.on('click', e => {
            let target = e.target;
            if (target.className == 'delete') {
                this.unSelect(target.parentNode);
            }
        });

        this.input.on('keydown', () => {
            if (this.selectedNum > 0) {
                this.input.style.width = (this.input.value.length + 1) * 8 + 24 + 'px';
            }
        });
    }

    setArg(key, val) {
        this.args[key] = val;
        this.clear();
        this.requestQueue = null;
    }


    load(data) {
        this.dropWrap.innerHTML = tpl`<ul></ul>`;
        let ul = this.dropWrap.elem('ul');

        data.map(obj => {
            if (!obj) {
                return;
            }

            let dropItem = this.createDropItem(obj);
            let li = document.createElement('li');
            ul.appendChild(li);
            li.appendChild(dropItem);
        });
    }

    createDropItem(obj) {
        let a = document.createElement('a');
        a.className = 'drop-item';
        a.href = 'javascript:;';
        a._obj = obj;
        a.innerHTML = fill(this.contentPattern, obj);
        a.on('click', () => this.select(a));
        return a;
    }

    createSelectedItem(obj) {
        let selectedItem = document.createElement('span');
        let value = fill(this.valuePattern, obj);
        let content = fill(this.selectedPattern, obj);
        selectedItem._obj = obj;

        if (!this.isMulti) {
            this.selectedItems = {};
            this.selectedNum = 0;
            this.selectedWrap.s('.selected-item').map(elem => elem.remove());
        }

        this.selectedItems[value] = 1;
        this.selectedNum++;

        selectedItem.className  = 'selected-item';
        selectedItem.innerHTML = tpl`
            <input type="hidden" name="${this.name}" value="${value}">
            ${content}
            <a class="delete" href="javascript:;">x</a>
        `;
        return selectedItem;
    }

    select(dropItem) {
        this.getRequestQueue().clear();
        this.input.value = '';
        this.hideDropWrap();

        let obj = dropItem._obj;
        let value = fill(this.valuePattern, obj);
        if (this.selectedItems[value]) {
            return;
        }

        this.insertSelectedItem(obj);
    }

    insertSelectedItem(obj) {
        let value = fill(this.valuePattern, obj);

        this.selectedWrap.insertBefore(this.createSelectedItem(obj), this.input);

        this.input.placeholder = '';
        this.input.style.width = '24px';
        this.input.required = '';
        this.event.trigger('select', value, obj);
    }

    unSelect(selectedItem) {
        this.getRequestQueue().clear();
        let value = selectedItem.elem('input').value;
        delete(this.selectedItems[value]);
        this.selectedNum--;
        selectedItem.remove();

        if (this.selectedNum == 0) {
            this.input.placeholder = this.placeholder || '';
            this.input.style.width = '100%';
            this.input.required = this.required;
        }
        this.event.trigger('unSelect', value, selectedItem._obj);
    }

    query() {
        this.getRequestQueue().queryPostJson(this.input.value.trim());
    }

    focus() {
        this.showDropWrap();
    }

    blur() {
        this.hideDropWrap();
        this.getRequestQueue().clear();
        this.input.value = '';
        return false;
    }

    showDropWrap() {
        this.query();
        this.dropWrap.style.display = 'block';
    }

    hideDropWrap() {
        this.dropWrap.style.display = 'none';
    }

    showErr(err) {
        this.dropWrap.innerHTML = err;
    }

    getRequestQueue() {
        if (this.requestQueue) {
            return this.requestQueue;
        }

        this.requestQueue = new RequestQueue({
            srcUrl: this.srcUrl,
            queryName: this.queryName,
            send: this.args,
        });

        this.requestQueue
            .onLoad(data => this.load(data))
            .onErr(err => this.showErr(err));

        return this.requestQueue;
    }

    setValue(val) {
        if (!val) {
            this.clear();
            return;
        }

        if (!(val instanceof Array)) {
            val = [val];
        }

        val.map(obj => this.insertSelectedItem(obj));
    }

    clear() {
        this.selectedItems = {};
        this.selectedWrap.s('.selected-item').forEach(elem => elem.remove());
    }

    buildDataFromAttr() {
        let data = {};
        data.name = this.ctn.getAttribute('data-name');
        data.required = this.ctn.getAttribute('data-required');
        data.placeholder = this.ctn.getAttribute('data-placeholder');
        data.srcUrl = this.ctn.getAttribute('data-src-url');
        data.queryName = this.ctn.getAttribute('data-query-name');
        data.args = this.extractArgs();

        data.pattern = {};
        data.pattern.content = this.ctn.getAttribute('data-item-content');
        data.pattern.selected = this.ctn.getAttribute('data-item-selected') || data.pattern.content;
        data.pattern.value = this.ctn.getAttribute('data-item-value');

        data.isMulti = this.ctn.getAttribute('data-multi') === 'multi' ? true : false;
        return data;
    }

    extractArgs() {
        let args = {};
        (this.ctn.getAttribute('data-args') || '').split(';')
            .forEach(item => {
                let arr = item.trim().split(':');
                if (arr[1]) {
                    args[arr[0]] = arr[1];
                }
            });

        return args;
    }
}

export {Zselect};
