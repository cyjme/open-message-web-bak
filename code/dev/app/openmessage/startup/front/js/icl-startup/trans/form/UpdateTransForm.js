import {View} from 'zjs/base/View.js';
import {tpl} from 'zjs/tpl';
import {trans} from 'zjs/trans';

class UpdateTransForm extends View {
    render() {
        this.ctn.innerHTML = tpl`
            <form class="callout small form zon" zon-submit="submit" action="javascript:;">
            <label>
                <span class="dto-localeKey"></span>

                <input type="hidden" name="localeKey" class="dto-localeKey" value="">
                <input type="hidden" name="key" class="dto-key" value="">
                <input type="text" name="value" class="dto-value" value="">
            </label>
            <div class="text-right">
                <button class="btn submit">${trans('update')}</button>
                <a class="btn cancel zon" zon-click="hide" href="javascript:;">${trans('cancel')}</a>
            </div>
            </form>
        `;
    }
}

export {UpdateTransForm};
