import {View} from 'zjs/base/View.js';
import {config} from 'setting/config/i18n.locale.local.js';
import {tpl} from 'zjs/tpl';

class LocaleSelect extends View {
    beforeRender() {
        this.options = config.enabled.map(key => config.available[key]);
        this.name = this.ctn.getAttribute('data-name');
        this.value = this.ctn.getAttribute('data-value') || config.default;
    }

    render() {
        this.ctn.innerHTML = tpl`
            <select name="${this.name}" class="gray ">
                ${this.options.map(option => tpl`
                    <option
                        ${(this.value == option.key) ? 'selected="selected"' : ''}
                        value="${option.key}">${option.title}</option>
                `)}
            </select>
        `;
    }

    startup() {
        this.select = this.ctn.elem('select');
    }

    setValue(val) {
        this.value = val;
        this.select.elem(`[value="${this.value}"]`).selected = true;
    }

    getValue() {
        return this.value;
    }
}

export {LocaleSelect};
