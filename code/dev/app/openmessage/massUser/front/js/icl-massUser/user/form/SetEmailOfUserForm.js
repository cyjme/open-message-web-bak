import { View } from 'zjs/base/View.js';
import { request } from 'zjs/http/request';

class SetEmailOfUserForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form action="javascript:;" method="post" class="zon" zon-submit="submit">
            <div class="grid col4 space">
                <div class="cell2">
                    <div class="popup">
                        <span class="popup-content right email-popup">${this.trans('email value error')}</span>
                    </div>
                    <input type="email" placeholder="${this.trans('Email')}" name="email" value="" require>
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
                    <input type="text" placeholder="${this.trans('verifyCode')}" name="verifyCode" value="" require>
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
        let emailPupup = this.ctn.elem('.email-popup');
        let codePupup = this.ctn.elem('.code-popup');

        this.ctn.elem('input[name="email"]').on('focus', () => {
            emailPupup.hide();
        });

        this.ctn.elem('input[name="verifyCode"]').on('focus', () => {
            codePupup.hide();
        });

        this.form = this.ctn.elem('form');

        this.form.on('submit', () => {
            let userData = new FormData(this.form);
            let userEmail = userData.get('email');
            let userVerify = userData.get('verifyCode');

            if (this.testEmail(userEmail)) {
                emailPupup.show();
                codePupup.hide();
                return;
            } else if (!userVerify) {
                emailPupup.hide();
                codePupup.show();
                return;
            }

            let postCodeData = new FormData();
            
            postCodeData.append('email', userEmail);
            postCodeData.append('code', userVerify);

            let postUserData = new FormData();

            postUserData.append('userId', this.userId);
            postUserData.append('email', userEmail);
            postUserData.append('verifyCode', userVerify);

            request.postJson(this.pageAttr('checkVerifyCodeByEmail'), postCodeData).then(data => {
                if (data.status == true) {
                    request.postJson(this.pageAttr('setEmailOfUser'), postUserData)
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
            let userEmail = userData.get('email');

            if (this.testEmail(userEmail)) {
                emailPupup.show();
                return;
            }

            let postData = new FormData();

            postData.append('email', userEmail);

            request.postJson(this.pageAttr('sendVerifyCodeByEmail'), postData)
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
            emailPupup.hide();
            codePupup.hide();
        });
    }

    onSubmitted(data) {
        if (!data) {
            throw 'not implemented';
        } else {
            this.changeState();
            this.ctn.previousElementSibling.elem('input').value = data.email;
        }
    }

    testEmail(email) {
        let emailReg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
        if (!email || emailReg.test(email) == false) {
            return true;
        }
    }

    changeState() {
        this.ctn.addClass('hide');
        this.ctn.previousElementSibling.removeClass('hide');
    }

}

export { SetEmailOfUserForm };
