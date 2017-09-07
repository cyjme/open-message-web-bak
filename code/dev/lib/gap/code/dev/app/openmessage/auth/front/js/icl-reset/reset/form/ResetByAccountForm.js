import {View} from 'zjs/base/View.js';
import {pageAttr} from 'zjs/html/page-attr';
import {request} from 'zjs/http/request';

class ResetByAccountForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
            <div class="card">
                <div class="logo">
                    <a href=""><i class="icon icon-logo"></i></a>
                </div>
                <form method="post" action="${pageAttr('resetByAccount')}">
                <input type="hidden" name="token" value="${this.pageAttr('token')}">
                <label>
                    <div class="popup">
                        <ul class="popup-content account-popup">
                            <li>${this.trans('notRegistered')}</li>
                        </ul>
                        <ul class="popup-content account-format-popup">
                            <li>${this.trans('formatError')}</li>
                        </ul>
                    </div>
                    <input type="text" name="account" required="required"
                           placeholder="${this.trans('account')}" value="">
                </label> 
                <div class="flex-between">
                    <div>
                         <div class="popup">
                            <ul class="popup-content code-popup">
                                <li>${this.trans('codeError')}</li>
                            </ul>
                        </div>
                        <label>
                            <input type="number" name="code" required="required"
                                   placeholder="${this.trans('code')}" value="">
                        </label>
                    </div>
                    <div>
                        <button class="button send-code expanded">${this.trans('sendCode')}</button>
                    </div>
                </div>
                <label>
                    <div class="popup">
                        <ul class="popup-content password-tip">
                            <li>${this.trans('length')}</li>
                            <li>${this.trans('format')}</li>
                            <li>${this.trans('noSpace')}</li>
                        </ul>
                    </div>
                    <div class="popup">
                        <ul class="popup-content password-popup">
                            <li>${this.trans('formateError')}</li>
                        </ul>
                    </div>
                    <input type="password" name="password" required="required"
                           placeholder="${this.trans('password')}" value="">
                </label> 
                <label>
                    <div class="popup">
                        <ul class="popup-content password-confirm-tip">
                            <li>${this.trans('notSame')}</li>
                        </ul>
                    </div>
                    <input type="password" name="password_confirm" required="required"
                           placeholder="${this.trans('passwordConfirm')}" value="">
                </label>
                <button class="button expanded m-t-lg" type="submit">${this.trans('reset')}</button> 
                </form>
            </div>
        `;
    }

    startup() {
        this.btn = this.ctn.elem('.send-code');
        this.acct = this.ctn.elem('[name=account]');
        this.password = this.ctn.elem('[type=password]');
        this.password_confirm = this.ctn.elem('[name=password_confirm]');
        this.code = this.ctn.elem('[name=code]');
        this.phonePattern =  /^1[34578]\d{9}$/;
        this.emailPattern = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

        this.btn.on('click', (e) => {
            e.preventDefault();
            let account = this.ctn.elem('[name=account]').value.trim();

            if (!account || (this.phonePattern.test(account) == false && this.emailPattern.test(account) == false)) {
                //todo
                alert('account illegal');
                return false;
            }

            let postData = new FormData();

            if (this.phonePattern.test(account)) {
                postData.append('phone', account);
                request.postJson(pageAttr('sendVerifyCodeByPhone'), postData)
                    .then(data => {
                        if (data.status == 'ok') {
                            this.countdown();
                        } else {
                            //todo
                            alert('验证码发送失败');
                        }
                    });
            } else if (this.emailPattern.test(account)) {
                postData.append('email', account);
                request.postJson(pageAttr('sendVerifyCodeByEmail'), postData)
                    .then(data => {
                        if (data.status == 'ok') {
                            this.countdown();
                        } else {
                            //todo
                            alert('验证码发送失败');
                        }
                    });
            }
        });

        this.acct.on('blur', () => {
            let postData = new FormData(),
                account = this.ctn.elem('[name=account]').value.trim();
            if (!this.formatCorrect(account)) {
                this.ctn.elem('.account-format-popup').show();
            }
            postData.append('account', account);
            request.postJson(pageAttr('fetchUserByAccount'), postData)
                .then(data => {
                    if (!data.existed) {
                        this.ctn.elem('.account-popup').show();
                    }
                });
        });

        this.acct.on('focus', () => {
            this.ctn.elem('.account-popup').hide();
            this.ctn.elem('.account-format-popup').hide();
        });

        this.password_confirm.on('blur', () => {
            let passwd = this.password.value.trim(),
                passwd_confirm = this.password_confirm.value.trim();

            if (passwd != passwd_confirm) {
                this.ctn.elem('.password-confirm-tip').show();
            }
        });

        this.password_confirm.on('focus', () => {
            this.ctn.elem('.password-confirm-tip').hide();
        });

        this.password.on('focus', () => {
            this.ctn.elem('.password-confirm-tip').hide();
        });

        this.password.on('blur', () => {
            let passwd = this.password.value,
                pattern = /^\S{6,14}$/;

            if (!passwd || pattern.test(passwd) == false) {
                this.ctn.elem('.password-popup').show();
            } else {
                this.ctn.elem('.password-popup').hide();
            }
        });

        this.password.on('focus', () => this.ctn.elem('.password-popup').hide());

        this.ctn.elem('form').on('submit', (e) => {
            e.preventDefault();
            let code = this.code.value,
                account = this.acct.value;

            if (!code) {
                return false;
            }

            let postData = new FormData();
            postData.append('code', code);

            if (this.phonePattern.test(account)) {
                postData.append('phone', account);
                request.postJson(pageAttr('checkVerifyCodeByPhone'), postData).then(data => {
                    if (data.status == true) {
                        this.ctn.elem('form').submit();
                    } else {
                        this.ctn.elem('.code-popup').show();
                    }
                });
            } else if (this.emailPattern.test(account)) {
                postData.append('email', account);
                request.postJson(pageAttr('checkVerifyCodeByEmail'), postData).then(data => {
                    if (data.status == true) {
                        this.ctn.elem('form').submit();
                    } else {
                        this.ctn.elem('.code-popup').show();
                    }
                });
            }


        });
        this.code.on('focus', () => this.ctn.elem('.code-popup').hide() );
    }

    countdown () {
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
    }

    formatCorrect(account) {
        let phonePattern =  /^1[34578]\d{9}$/,
            emailPattern = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

        if (!account || (phonePattern.test(account) == false && emailPattern.test(account) == false)) {
            return false;
        }

        return true;
    }
}

export { ResetByAccountForm };
