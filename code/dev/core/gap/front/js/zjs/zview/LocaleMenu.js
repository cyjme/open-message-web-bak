import {View} from './../base/View.js';
import {tpl} from './../tpl';
import {trans} from './../trans';

class LocaleMenu extends View {

    render() {
        let selected = this.ctn.getAttribute('data-selected');

        let localeKeys = [];
        this.ctn.s('li').forEach(elem => {
            let localeKey = elem.getAttribute('data-localeKey');
            let isPrimary = elem.getAttribute('data-isPrimary');
            
            if (!selected && isPrimary == 1) {
                selected = localeKey;
            }

            localeKeys.push({
                localeKey: localeKey,
                isPrimary: isPrimary
            });
        });

        this.ctn.innerHTML = tpl`
            ${localeKeys.map(item => tpl`
                <li class="locale-item ${item.localeKey} ${item.localeKey == selected ? 'active' : ''}">
                    <a href="javascript:void(0);" class="locale-title zon" zon-click="switch"
                        data-localeKey="${item.localeKey}">
                        ${trans(tpl`${item.localeKey}`)}
                    </a>
                    <div class="zdrop">
                        <a href="javascript:void(0);" class="zdrop-btn">
                            <i class='icon icon-down'></i>
                        </a>
                        <ol class="zdrop-wrap">
                            <li>
                                <a href="javascript:void(0);" class="zon" zon-click="update"
                                    data-localeKey="${item.localeKey}">
                                    <i class="icon icon-update"></i>&nbsp;&nbsp;${trans('edit')}
                                </a>
                            </li>
                            <li class="${item.isPrimary == 1 ? 'hide' : ''} delete">
                                <a href="javascript:void(0);" class="zon" zon-click="delete"
                                    data-localeKey="${item.localeKey}">
                                    <i class="icon icon-delete"></i>&nbsp;&nbsp;${trans('delete')}
                                </a>
                            </li>
                            <li class="${item.isPrimary == 1 ? 'hide' : ''} set-as-primary">
                                <a href="javascript:void(0);" class="zon" zon-click="setAsPrimary"
                                    data-localeKey="${item.localeKey}">
                                    <i class="icon icon-stud"></i>&nbsp;&nbsp;${trans('setAsPrimary')}
                                </a>
                            </li>
                        </ol>
                    </div>
                </li>
            `)}
        `;

    }

    switch(localeKey) {
        let elem = this.ctn.elem('.'+ localeKey +'.locale-item');
        this.ctn.elem('.locale-item.active').removeClass('active');

        elem.removeClass('hide');
        elem.addClass('active');
    }

    setAsPrimary(localeKey) {
        this.ctn.elem('.set-as-primary.hide').removeClass('hide');
        this.ctn.elem('.delete.hide').removeClass('hide');

        this.ctn.elem('.' + localeKey + '.locale-item .set-as-primary').addClass('hide');
        this.ctn.elem('.' + localeKey + '.locale-item .delete').addClass('hide');
    }
}

export {LocaleMenu};
