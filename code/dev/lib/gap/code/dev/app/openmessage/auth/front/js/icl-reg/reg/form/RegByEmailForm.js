import {View} from 'zjs/base/View.js';
import {request} from 'zjs/http/request';

class RegByEmailForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form method="post" action="${this.pageAttr('regByEmail')}">
            <input type="hidden" name="token" value="${this.pageAttr('token')}">
            <input type="hidden" name="type" value="">
            <div class="user-type flex-column-center">
                <a href="javascript:;" class="user-type-btn demander">${this.trans('I am demander')}</a>
                <a href="javascript:;" class="user-type-btn proofer">${this.trans('I am proofer')}</a>
            </div>
            <label>
                <div class="popup">
                    <ul class="popup-content right email-popup">
                        <li>${this.trans('emailFormatError')}</li>
                    </ul>
                    <ul class="popup-content account-popup right">
                        <li>${this.trans('allreadyExisted')}</li>
                    </ul>
                </div>
                <input type="email" name="email" required="required" maxlength="50"
                       placeholder="${this.trans('email')}" value="">
            </label>
            <label>
                <div class="popup">
                    <ul class="popup-content right password-tip">
                        <li>· ${this.trans('length')}</li>
                        <li>· ${this.trans('format')}</li>
                        <li>· ${this.trans('noSpace')}</li>
                    </ul>
                </div>
                <div class="popup">
                    <ul class="popup-content right password-popup">
                        <li>${this.trans('passwordFormatError')}</li>
                    </ul>
                </div>
                <input type="password" name="password" required="required"
                       placeholder="${this.trans('password')}" value="">
            </label>
            <div class="code-area">
                <div class="code">
                    <label>
                        <input type="number" name="code" required="required"
                               placeholder="${this.trans('emailCode')}" value="">
                    </label>
                </div>
                <div class="popup">
                    <ul class="popup-content right code-popup">
                        <li>${this.trans('codError')}</li>
                    </ul>
                </div>
                <div class="code-btn-ctn">
                    <button class="button send-code expanded" disabled>${this.trans('sendCode')}</button>
                </div>
            </div>
            <label class="text-left">
                <input type="checkbox" name="agree" checked="checked" value="true">${this.trans('readAgree')}
                <a href="${this.pageAttr('reg-agreement')}">${this.trans('agreement')}</a>
            </label>
            <button class="button expanded" type="submit">${this.trans('reg')}</button>
        </form>
        `;
    }

    startup() {
        this.form = this.ctn.elem('form');
        this.btn = this.ctn.elem('.send-code');
        this.type = this.ctn.elem('[name=type]');
        this.btnDemander = this.ctn.elem('.demander');
        this.btnProofer = this.ctn.elem('.proofer');
        this.password = this.ctn.elem('[type=password]');
        this.email = this.ctn.elem('[type=email]');
        this.code = this.ctn.elem('[name=code]');
        this.emailPattern =  /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

        this.btnDemander.on('click', ()=> {
            this.type.value = 0;
            this.hideUserType();
        });

        this.btnProofer.on('click', ()=> {
            this.type.value = 1;
            this.hideUserType();
        });

        this.email.on('blur', () => {
            let emailVal = this.email.value;

            if (emailVal && this.emailPattern.test(emailVal) == false) {
                this.ctn.elem('.email-popup').show();
                this.btn.setAttribute('disabled', 'true');
            } else {
                this.ctn.elem('.email-popup').hide();
                this.btn.removeAttribute('disabled');
            }

            let postData = new FormData();
            postData.append('account', emailVal);
            request.postJson(this.pageAttr('fetchUserByAccount'), postData)
                .then(data => {
                    if (data.existed) {
                        this.ctn.elem('.account-popup').show();
                    } else {
                        this.ctn.elem('.account-popup').hide();
                    }
                });
        });

        this.email.on('keyup', () => {
            let emaillVal = this.email.value;
            if (this.emailPattern.test(emaillVal) == true) {
                this.btn.removeAttribute('disabled');
            }
        });

        this.email.on('focus', () => this.ctn.elem('.email-popup').hide());

        this.password.on('focus', () => {
            this.ctn.elem('.password-popup').hide();
            if (this.password.value.trim() == '') {
                this.ctn.elem('.password-tip').show();
                let timer = setTimeout(() => {
                    this.ctn.elem('.password-tip').hide();
                    clearTimeout(timer);
                }, 3000);
            }
        });

        this.password.on('blur', () => {
            let passwd = this.password.value,
                pattern = /^\S{6,14}$/;

            if (passwd && pattern.test(passwd) == false) {
                this.ctn.elem('.password-popup').show();
            } else {
                this.ctn.elem('.password-popup').hide();
            }
        });

        this.password.on('focus', () => this.ctn.elem('.password-popup').hide());

        this.btn.on('click', (e) => {

            let emailVal = this.email.value;
            e.preventDefault();
            let postData = new FormData();
            postData.append('email', emailVal);

            request.postJson(this.pageAttr('sendVerifyCodeByEmail'), postData)
                .then(data => {
                    if (data.status == 'ok') {
                        let time = 60;
                        this.btn.disabled = true;
                        let timer = setInterval(()=> {
                            this.btn.innerHTML = this.trans('sent(%d-seconds)').replace('%d', time);
                            this.btn.addClass('code-sent');
                            time--;

                            if (time == 0) {
                                clearInterval(timer);
                                this.btn.innerHTML = this.trans('sendCode');
                                this.btn.disabled = false;
                                this.btn.removeClass('code-sent');
                            }
                        }, 1000);
                    } else {
                        //todo
                        alert('验证码发送失败');
                    }
                });
        });

        this.form.on('submit', (e) => {
            e.preventDefault();
            let code = this.code.value,
                emailVal = this.email.value;

            if (!code) {
                return false;
            }

            let postData = new FormData();
            postData.append('email', emailVal);
            postData.append('code', code);

            request.postJson(this.pageAttr('checkVerifyCodeByEmail'), postData).then(data => {
                if (data.status == true) {
                    this.form.submit();
                } else {
                    this.ctn.elem('.code-popup').show();
                }
            });
        });

        this.code.on('focus', () => this.ctn.elem('.code-popup').hide());
    }

    hideUserType() {
        this.ctn.elem('.user-type').style.display = 'none';
    }
}
export { RegByEmailForm };
