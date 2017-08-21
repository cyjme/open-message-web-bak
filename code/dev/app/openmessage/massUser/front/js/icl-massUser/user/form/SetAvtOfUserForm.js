import { View } from 'zjs/base/View.js';
import { request } from 'zjs/http/request';

class SetAvtOfUserForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
            <form action="javascript:;" method="post">
                <div class="form-title">
                    <h3 class="title normal m-n">${this.trans('updateAvtImg')}</h3>
                </div>
                <div class="form-content font-gray">
                    <div class="upload-img update-avt-img"></div>
                </div>
                <div class="form-footer flex-end">
                    <button class="btn submit">${this.trans('submit')}</button>
                    <a class="btn cancel zon" href="javascript:;" zon-click="cancel">${this.trans('cancel')}</a>
                </div>
            </form>
        `;
    }

    startup() {
        this.form = this.ctn.elem('form');
        this.form.on('submit', () => {
            let postData = new FormData(this.form);
            let uploadView = this.view('.upload-img');
            postData.append('avt', JSON.stringify(uploadView.getKeys()));
            request.postJson(this.pageAttr('setAvtOfUser'), postData)
                .then(data => {
                    this.onSubmitted(data);
                });
        });
    }
}

export {SetAvtOfUserForm};
