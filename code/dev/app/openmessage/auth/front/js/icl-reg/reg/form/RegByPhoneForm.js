import {View} from 'zjs/base/View.js';
import {request} from 'zjs/http/request';

class RegByPhoneForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
        <form method="post" action="${this.pageAttr('regByPhone')}">
            <input type="hidden" name="token" value="${this.pageAttr('token')}">
            <input type="hidden" name="type" value="">
            <div class="user-type flex-column-center">
                <a href="javascript:;" class="user-type-btn demander">${this.trans('I am demander')}</a>
                <a href="javascript:;" class="user-type-btn proofer">${this.trans('I am proofer')}</a>
            </div>
            <label>
                <div class="popup">
                    <ul class="popup-content right phone-popup">
                        <li>${this.trans('phonFormatError')}</li>
                    </ul>
                    <ul class="popup-content account-popup right">
                        <li>${this.trans('allreadyExisted')}</li>
                    </ul>
                </div>   
                <input type="number" name="phone" required="required" maxlength="13"
                       placeholder="${this.trans('phone')}" value="">
            </label>
            <label>
                <div class="popup">
                    <ul class="popup-content right password-tip">
                        <li>${this.trans('length')}</li>
                        <li>${this.trans('format')}</li>
                        <li>${this.trans('noSpace')}</li>
                    </ul>
                </div>
                <div class="popup">
                    <ul class="popup-content right password-popup">
                        <li>${this.trans('formatError')}</li>
                    </ul>
                </div>
                <input type="password" name="password" required="required"
                       placeholder="${this.trans('password')}" value="">
            </label>
            <div class="code-area">
                <div class="code">
                    <label>
                        <input type="number" name="code" required="required"
                               placeholder="${this.trans('phoneCode')}" value="">
                    </label>
                </div>
                <div class="popup">
                    <ul class="popup-content right code-popup">
                        <li>${this.trans('codeError')}</li>
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
            <button class="button expanded m-t-lg" type="submit">${this.trans('reg')}</button>
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
        this.phone = this.ctn.elem('[type=number]');
        this.code = this.ctn.elem('[name=code]');
        this.phonePattern = /^1(3|4|5|7|8)\d{9}$/;

        this.btnDemander.on('click', ()=> {
            this.type.value = 0;
            this.hideUserType();
        });

        this.btnProofer.on('click', ()=> {
            this.type.value = 1;
            this.hideUserType();
        });

        this.phone.on('blur', () => {
            let phonelVal = this.phone.value;

            if (phonelVal && this.phonePattern.test(phonelVal) == false ) {
                this.ctn.elem('.phone-popup').show();
                this.btn.setAttribute('disabled', 'true');
            } else {
                this.ctn.elem('.phone-popup').hide();
                this.btn.removeAttribute('disabled');
            }

            let postData = new FormData();
            postData.append('account', phonelVal);
            request.postJson(this.pageAttr('fetchUserByAccount'), postData)
                .then(data => {
                    if (data.existed) {
                        this.ctn.elem('.account-popup').show();
                    } else {
                        this.ctn.elem('.account-popup').hide();
                    }
                });
        });

        this.phone.on('keyup', () => {
            let phonelVal = this.phone.value;
            if (this.phonePattern.test(phonelVal) == true) {
                this.btn.removeAttribute('disabled');
            }

        });

        this.phone.on('focus', () => this.ctn.elem('.phone-popup').hide());

        this.password.on('blur', () => {
            let passwd = this.password.value,
                pattern = /^\S{6,14}$/;

            if (passwd && pattern.test(passwd) == false) {
                this.ctn.elem('.password-popup').show();
            } else {
                this.ctn.elem('.password-popup').hide();
            }
        });

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

        this.btn.on('click', (e) => {
            e.preventDefault();
            let phone = this.ctn.elem('[name=phone]').value;

            let postData = new FormData();
            postData.append('phone', phone);

            request.postJson(this.pageAttr('sendVerifyCodeByPhone'), postData)
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
                phone = this.phone.value;

            if (!code) {
                return false;
            }

            let postData = new FormData();
            postData.append('phone', phone);
            postData.append('code', code);

            request.postJson(this.pageAttr('checkVerifyCodeByPhone'), postData).then(data => {
                if (data.status == true) {
                    this.form.submit();
                } else {
                    this.ctn.elem('.code-popup').show();
                }
            });
        });

        this.code.on('focus', () => this.ctn.elem('.code-popup').hide() );
    }

    hideUserType() {
        this.ctn.elem('.user-type').style.display = 'none';
    }
}

export { RegByPhoneForm };

