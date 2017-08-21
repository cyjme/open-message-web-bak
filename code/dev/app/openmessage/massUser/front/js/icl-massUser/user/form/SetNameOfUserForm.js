import { View } from 'zjs/base/View.js';
import { request } from 'zjs/http/request';

class SetNameOfUserForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form action="javascript:;" method="post" class="zon" zon-submit="submit">
            <div class="grid col4 space">
                <div class="cell2">
                    <div class="popup">
                        <span class="popup-content right name-popup">${this.trans('The name value is required')}</span>
                    </div>
                    <input type="text" name="nick" placeholder="${this.trans('Name')}" value="" require>
                </div>
                <div class="cell2">
                    <button class="btn submit">${this.trans('submit')}</button>
                    <a href="javascript:;" class="zon btn cancel">${this.trans('cancel')}</a>
                </div>
            </div>
        </form>
        `;
    }

    startup() {
        this.userId = this.ctn.getAttribute('data-user-id');
        let namePupup = this.ctn.elem('.name-popup');

        this.ctn.elem('input[name="nick"]').on('focus', () => {
            namePupup.hide();
        });

        this.form = this.ctn.elem('form');

        this.form.on('submit', () => {
            let userData = new FormData(this.form);
            let userNick = userData.get('nick');

            if (!userNick) {
                namePupup.show();
                return;
            }

            let postData = new FormData();

            postData.append('userId', this.userId);
            postData.append('nick', userNick);

            request.postJson(this.pageAttr('setNameOfUser'), postData)
                .then(data => {
                    this.onSubmitted(data);
                });
        });

        this.form.elem('.cancel').on('click', () => {
            this.changeState();
            namePupup.hide();
        });
    }

    onSubmitted(data) {
        if (!data) {
            throw 'not implemented';
        } else {
            this.changeState();
            this.ctn.previousElementSibling.elem('input').value = data.nick;
        }
    }

    changeState() {
        this.ctn.addClass('hide');
        this.ctn.previousElementSibling.removeClass('hide');
    }

}

export { SetNameOfUserForm };
