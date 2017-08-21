import { View } from 'zjs/base/View.js';
import { request } from 'zjs/http/request';

class SetPhoneOfUserForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form action="javascript:;" method="post" class="zon" zon-submit="submit">
            <div class="grid col4 space">
                <div class="cell2">
                    <div class="popup">
                        <span class="popup-content right phone-popup">${this.trans('phone value error')}</span>
                    </div>
                    <input type="text" placeholder="${this.trans('Phone')}" name="phone" value="" require>
                </div>
                <div class="cell2">
                    <button class="btn hollow primary get-verify-code">${this.trans('getVerifyCode')}</button>
                </div>
            </div>
            <div class="grid col4 space">
                <div class="cell2">
                    <div class="popup">
                        <span class="popup-content right code-popup">${this.trans('codeError')}</span>
                    </div>
                    <input type="text" placeholder="${this.trans('VerifyCode')}" name="verifyCode" value="" require>
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
        let phonePupup = this.ctn.elem('.phone-popup');
        let codePupup = this.ctn.elem('.code-popup');

        this.ctn.elem('input[name="phone"]').on('focus', () => {
            phonePupup.hide();
        });

        this.ctn.elem('input[name="verifyCode"]').on('focus', () => {
            codePupup.hide();
        });

        this.form = this.ctn.elem('form');

        this.form.on('submit', () => {
            let userData = new FormData(this.form);
            let userPhone = userData.get('phone');
            let userVerify = userData.get('verifyCode');

            if (this.testPhone(userPhone)) {
                phonePupup.show();
                codePupup.hide();
                return;
            } else if (!userVerify) {
                phonePupup.hide();
                codePupup.show();
                return;
            }

            let postCodeData = new FormData();
            
            postCodeData.append('phone', userPhone);
            postCodeData.append('code', userVerify);

            let postUserData = new FormData();

            postUserData.append('userId', this.userId);
            postUserData.append('phone', userPhone);
            postUserData.append('verifyCode', userVerify);

            request.postJson(this.pageAttr('checkVerifyCodeByPhone'), postCodeData).then(data => {
                if (data.status == true) {
                    request.postJson(this.pageAttr('setPhoneOfUser'), postUserData)
                        .then(data => {
                            this.onSubmitted(data);
                        });
                } else {
                    codePupup.show();
                }
            });
        });

        this.form.elem('.get-verify-code').on('click', (e) => {
            e.preventDefault();
            let userData = new FormData(this.form);
            let userPhone = userData.get('phone');

            if (this.testPhone(userPhone)) {
                phonePupup.show();
                return;
            }

            let postData = new FormData();

            postData.append('phone', userPhone);

            request.postJson(this.pageAttr('sendVerifyCodeByPhone'), postData)
                .then(data => {
                    if (data.status == 'ok') {
                        let flag = 60;
                        let codeBtn = this.ctn.elem('.get-verify-code');

                        codeBtn.disabled = true;

                        let timer = setInterval(()=> {
                            --flag;
                            codeBtn.innerHTML = this.trans('Get After %d-seconds').replace('%d', flag);

                            if (flag === 0) {
                                clearInterval(timer);
                                codeBtn.innerHTML = this.trans('getVerifyCode');
                                codeBtn.disabled = false;
                            }
                        }, 1000);
                    }
                });
        });

        this.form.elem('.cancel').on('click', () => {
            this.changeState();
            phonePupup.hide();
            codePupup.hide();
        });
    }

    onSubmitted(data) {
        if (!data) {
            throw 'not implemented';
        } else {
            this.changeState();
            this.ctn.previousElementSibling.elem('input').value = data.phone;
        }
    }

    testPhone(phone) {
        let phoneReg = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
        if (!phone || phoneReg.test(phone) == false) {
            return true;
        }
    }

    changeState() {
        this.ctn.addClass('hide');
        this.ctn.previousElementSibling.removeClass('hide');
    }

}

export { SetPhoneOfUserForm };
