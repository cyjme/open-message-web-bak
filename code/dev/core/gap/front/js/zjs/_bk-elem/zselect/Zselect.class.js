import {tpl} from './../../tpl';
import {addStyle} from './../../html/css';
import {RequestQueue} from './../../http/request-queue/RequestQueue.class.js';

import './../../prototype';

//require('./../prototype.js');

class Zselect {
    constructor(ctn) {
        this.ctn = ctn;

        this.name = ctn.getAttribute('data-name');
        this.value = ctn.getAttribute('data-value');
        this.required = ctn.getAttribute('data-required');
        this.placeholder = ctn.getAttribute('data-placeholder');

        this.selectedItems = {};
        this.selectedNum = 0;
        this.isMulti = ctn.getAttribute('data-multi') === 'multi' ? true : false;

        this.buildStyle();
        this.buildHtml();

        this.selectedWrap = this.ctn.elem('.selectedWrap');
        this.itemWrap = this.ctn.elem('.itemWrap');
        this.existedWrap = this.ctn.elem('.existedWrap');
        this.input = this.ctn.elem('.selectedWrap input');

        this.itemContentPattern = ctn.getAttribute('data-item-content');
        this.itemValuePattern = ctn.getAttribute('data-item-value');

        this.ctn.addClass('zselect');

        this.existedWrap.s('.zitem').forEach(elem => this.selectZitem(elem));

        this.buildEvent();
    }

    buildStyle() {
        addStyle(tpl`
            .zselect {
                position: relative;
                border: 1px solid #999;
            }
            .zselect .zinput {
                display: inline;
                width: inherit;
                background-color: inherit;
                border: 0;
                margin: 0;
            }
            .zselect .itemWrap {
                position: absolute;
                width: 100%;
                min-height: 100px;
                background: #ddd;
                border: 1px solid #ddd;
                display: none;
                z-index: 99;
            }
            .zselect .selectedWrap .zitem {
                padding-left: .5rem;
            }
        `);
    }

    buildHtml() {
        let existedHtml = this.ctn.innerHTML;
        this.ctn.innerHTML = tpl`
            <div class="selectedWrap">
                <input type="text"
                    ${this.required ? 'required="required"' : ''}
                    ${this.placeholder ? ('placeholder=' + this.placeholder) : ''}
                    class="zinput">
            </div>
            <div class="itemWrap">
            </div>
            <div class="existedWrap hide">
                ${existedHtml}
            </div>
        `;
    }

    buildEvent() {
        this.input.on('focus', () => this.focus());
        this.input.on('blur', (e) => this.blur(e));
        this.input.on('keyup', () => this.query());

        this.ctn.on('mousedown', (e) => {
            e.cancel();
            e.stop();
            this.input.focus();
            this.showItemWrap();
            return false;
        });

        this.selectedWrap.on('click', e => {
            let target = e.target;
            if (target.className == 'delete') {
                this.unSelectZitem(target.parentNode);
            }
        });
    }

    query() {
        this.getRequestQueue().queryPostJson(this.input.value.trim());
    }

    buildItemWrap(data) {
        this.itemWrap.innerHTML = tpl`
            <ul>
                ${data.map(item => this.createListItemHtml(item))}
            </ul>
        `;

        this.itemWrap.s('.zitem')
            .forEach(zitem => zitem.on('click', () => this.selectZitem(zitem)));
    }

    selectZitem(zitem) {
        this.input.value = '';
        this.hideItemWrap();

        let dataValue = zitem.getAttribute('data-value');

        if (this.selectedItems[dataValue]) {
            return;
        }

        if (!this.isMulti) {
            this.selectedItems = {};
            this.selectedNum = 0;

            this.selectedWrap.s('.zitem').forEach((elem) => elem.remove());
        }

        this.selectedItems[dataValue] = 1;
        this.selectedNum++;

        this.selectedWrap.insertBefore(this.createZitem(dataValue, zitem.innerHTML), this.input);

        this.input.placeholder = '';
        //this.input.style.width = '24px';
        this.input.required = '';
    }

    createZitem(val, content) {
        let zitem = document.createElement('span');
        zitem.className  = 'zitem selected';
        zitem.innerHTML = this.createZitemHtml(val, content);
        return zitem;
    }

    createZitemHtml(val, content) {
        return tpl`
            <input type="hidden" name="${this.name}" value="${val}">
            ${content}
            <a class="delete" href="javascript:;">x</a>
        `;
    }

    unSelectZitem(item) {
        delete(this.selectedItems[item.elem('input').value]);
        this.selectedNum--;
        item.remove();

        if (this.selectedNum == 0) {
            this.input.placeholder = this.placeholder;
            this.input.style.width = 'inherit';
            this.input.required = this.required;
        }
    }

    createListItemHtml(item) {
        function fill(pattern, item) {
            return pattern.replace(
                /\$\{([a-zA-Z][.a-zA-Z0-9]*)\}/g,
                (str, p1) => {
                    let re = item;
                    p1.split('.').map(sub => {
                        if (!re[sub]) {
                            return str;
                        }
                        re = re[sub];
                    });
                    return re;
                }
            );
        }

        let content = fill(this.itemContentPattern, item);
        let value = fill(this.itemValuePattern, item);

        return tpl`
            <li>
                <a class="zitem" data-value="${value}" href="javascript:;">${content}</a>
            </li>
        `;
    }

    focus() {
        this.showItemWrap();
    }

    blur() {
        this.hideItemWrap();
        return false;
/*
        console.log('blur');
        if (e.relatedTarget && this.ctn.contains(e.relatedTarget)) {
            e.cancel();
        } else {
            this.hideItemWrap();
        }
        */
    }

    showItemWrap() {
        this.query();
        this.itemWrap.style.display = 'block';
    }

    hideItemWrap() {
        this.itemWrap.style.display = 'none';
    }

    showErr(err) {
        this.itemWrap.innerHTML = err;
    }

    getRequestQueue() {
        if (this.requestQueue) {
            return this.requestQueue;
        }

        let send = {};

        this.ctn.getAttribute('data-args').split(';')
            .map((item) => {
                item = item.trim();
                let arr = item.split(':');
                if (arr[1]) {
                    send[arr[0]] = arr[1];
                }
            });

        this.requestQueue = new RequestQueue({
            srcUrl: this.ctn.getAttribute('data-src-url'),
            send: send,
            queryName: this.ctn.getAttribute('data-query-name')
        });

        this.requestQueue
            .onLoad(data => this.buildItemWrap(data))
            .onErr(err => this.showErr(err));

        return this.requestQueue;
    }

}

export {Zselect};
