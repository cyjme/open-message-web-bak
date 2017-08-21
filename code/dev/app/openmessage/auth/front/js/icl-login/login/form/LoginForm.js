import {View} from 'zjs/base/View.js';
import {pageAttr} from 'zjs/html/page-attr';
import {request} from 'zjs/http/request';

class LoginForm extends View {
    render() {
        this.ctn.innerHTML = this.tpl`
            <form method="post" action="${pageAttr('loginByEmail')}">
            <input type="hidden" name="token" value="${this.pageAttr('token')}">
            <label>
                <div class="popup">
                    <ul class="popup-content account-popup right">
                        <li>${this.trans('notRegistered')}</li>
                    </ul>
                    <ul class="popup-content account-format-popup">
                        <li>${this.trans('formatError')}</li>
                    </ul>
                </div>
                <input type="text" name="account" required="required" maxlength="50"
                       placeholder="${this.trans('email/phone')}" value="">
            </label>
            <label>
                <div class="popup">
                    <ul class="popup-content account-password-popup right">
                        <li>${this.trans('acctOrPasswdUnvalid')}</li>
                    </ul>
                </div>
                <input type="password" name="password" required="required"
                       placeholder="${this.trans('password')}" value="">
            </label>
            <div class="login-tip">
                <label>
                    <input type="checkbox" name="auto" checked="checked" value="true">${this.trans('auto-login-next-time')}
                </label>
                
                <a href="${pageAttr('resetByAccount')}">
                     ${this.trans('forgetPassword?')}
                </a>
            </div>
            <button class="button expanded m-t-lg" type="submit">${this.trans('login')}</button>
            <div>
                ${this.trans('No account?')}
                <a href="${pageAttr('regByEmail')}">
                    ${this.trans('register')}
                </a>
            </div> 
        </form>
        `;
    }

    startup () {
        this.phonePattern =  /^1[34578]\d{9}$/;
        this.acct = this.ctn.elem('[name=account]');
        this.passwd = this.ctn.elem('[name=password]');
        this.emailPattern = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

        this.acct.on('blur' ,() => {
            let account = this.acct.value.trim();
            let form = this.ctn.elem('form');

            if (this.phonePattern.test(account)) {
                form.setAttribute('action', pageAttr('loginByPhone'));
            } else {
                form.setAttribute('action', pageAttr('loginByEmail'));
            }
        });

        this.acct.on('blur', () => {
            let postData = new FormData(),
                account = this.ctn.elem('[name=account]').value.trim();
            if (!this.formatCorrect(account)) {
                this.ctn.elem('.account-format-popup').show();
                return false;
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
            this.ctn.elem('.account-password-popup').hide();
        });

        this.passwd.on('focus', () => {
            this.ctn.elem('.account-password-popup').hide();
        });

        this.ctn.elem('form').on('submit', (e) => {
            e.preventDefault();
            let account = this.acct.value.trim(),
                password = this.passwd.value.trim(),
                postData = new FormData();
            postData.append('password', password);
            if (this.phonePattern.test(account) == true) {
                postData.append('phone', account);
                request.postJson(pageAttr('verifyPasswordByPhone'), postData)
                    .then(data => {
                        if (data.status == true) {
                            this.ctn.elem('form').submit();
                        } else {
                            this.ctn.elem('.account-password-popup').show();
                        }
                    });
            } else {
                postData.append('email', account);
                request.postJson(pageAttr('verifyPasswordByEmail'), postData)
                    .then(data => {
                        if (data.status == true) {
                            this.ctn.elem('form').submit();
                        } else {
                            this.ctn.elem('.account-password-popup').show();
                        }
                    });
            }
        });
    }

    formatCorrect(account) {
        if (!account || (this.phonePattern.test(account) == false && this.emailPattern.test(account) == false)) {
            return false;
        }

        return true;
    }
}

export {LoginForm};

