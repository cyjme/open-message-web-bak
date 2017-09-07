import {View} from 'zjs/base/View.js';
import {tpl} from 'zjs/tpl';
import {trans} from 'zjs/trans';

class DeleteTransForm extends View {
    render() {
        this.ctn.innerHTML = tpl`
            <form class="callout small form zon" zon-submit="submit" action="javascript:;">
            <label>
                <span class="dto-localeKey"></span>
                :
                <span class="dto-value"></span>

                <input type="hidden" class="dto-localeKey" name="localeKey" value="">
                <input type="hidden" class="dto-key" name="key" value="">
            </label>
            <div class="text-right">
                <button class="btn submit">${trans('delete')}</button>
                <a class="btn cancel zon" zon-click="hide" href="javascript:;">${trans('cancel')}</a>
            </div>
            </form>
        `;
    }
}

export {DeleteTransForm};

