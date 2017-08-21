import { View } from 'zjs/base/View.js';
import { request } from 'zjs/http/request';

class AddAddrOfUserForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form action="javascript:;" method="post" class="zon" zon-submit="submit">

            <div class="form-title">
                <h3 class="title normal m-n">${this.trans('addAddrOfUser')}</h3>
            </div>

            <div class="form-content">

                <label>
                    ${this.trans('nick')}
                    <input type="text" name="nick" value="" require>
                </label>
                <label>
                    ${this.trans('mobile')}
                    <input type="text" name="mobile" value="" require>
                </label>

                <label>
                    ${this.trans('addr')}
                    <input type="text" name="addr" value="" require>
                </label>
            </div>

            <div class="form-footer flex-end">
                <button class="btn submit">${this.trans('submit')}</button>
                <a href="javascript:;" class="zon btn cancel" zon-click="cancel">${this.trans('cancel')}</a>
            </div>
        </form>
        `;
    }

    startup() {
        this.userId = this.ctn.getAttribute('data-user-id');

        this.form = this.ctn.elem('form');

        this.form.on('submit', () => {
            
            let userData = new FormData(this.form);

            let postData = new FormData();

            postData.append('userId', this.userId);
            postData.append('addr', userData.get('addr') + '  ' + userData.get('nick') + '  ' + userData.get('mobile'));

            request.postJson(this.pageAttr('addAddrOfUser'), postData)
                .then(data => {
                    this.onSubmitted(data);
                });
        });
    }

    onSubmitted(data) {
        if (!data) {
            throw 'not implemented';
        }
    }

}

export { AddAddrOfUserForm };
