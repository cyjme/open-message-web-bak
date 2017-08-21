import { View } from 'zjs/base/View.js';
import { request } from 'zjs/http/request';

class SetWeixinOfUserForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form action="javascript:;" method="post" class="zon" zon-submit="submit">
            <div class="grid col4 space">
                <div class="cell2">
                    <div class="popup">
                        <span class="popup-content right weixin-popup">${this.trans('The weixin value is required')}</span>
                    </div>
                    <input type="text" name="weixin" placeholder="${this.trans('Weixin')}" value="" require>
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
        let weixinPupup = this.ctn.elem('.weixin-popup');

        this.ctn.elem('input[name="weixin"]').on('focus', () => {
            weixinPupup.hide();
        });

        this.form = this.ctn.elem('form');

        this.form.on('submit', () => {
            let userData = new FormData(this.form);
            let userWeixin = userData.get('weixin');

            if (!userWeixin) {
                weixinPupup.show();
                return;
            }

            let postData = new FormData();

            postData.append('userId', this.userId);
            postData.append('weixin', userWeixin);

            request.postJson(this.pageAttr('setWeixinOfUser'), postData)
                .then(data => {
                    this.onSubmitted(data);
                });
        });

        this.form.elem('.cancel').on('click', () => {
            this.changeState();
            weixinPupup.hide();
        });
    }

    onSubmitted(data) {
        if (!data) {
            throw 'not implemented';
        } else {
            this.changeState();
            this.ctn.previousElementSibling.elem('input').value = data.weixin;
        }
    }

    changeState() {
        this.ctn.addClass('hide');
        this.ctn.previousElementSibling.removeClass('hide');
    }

}

export { SetWeixinOfUserForm };
