import { s } from 'zjs/s';
import { zview } from 'zjs/zview';
import { zmask } from 'zjs/zmask';

import { SetNameOfUserForm } from 'openmessage-massUser/user/form/SetNameOfUserForm';
import { SetWeixinOfUserForm } from 'openmessage-massUser/user/form/SetWeixinOfUserForm';
import { SetPhoneOfUserForm } from 'openmessage-massUser/user/form/SetPhoneOfUserForm';
import { SetEmailOfUserForm } from 'openmessage-massUser/user/form/SetEmailOfUserForm';
import { SetAvtOfUserForm } from 'openmessage-massUser/user/form/SetAvtOfUserForm';
import { SetAddrOfUserForm } from 'openmessage-massUser/user/form/SetAddrOfUserForm';
import { AddAddrOfUserForm } from 'openmessage-massUser/user/form/AddAddrOfUserForm';

zview({
    '.set-name-of-user-form': SetNameOfUserForm,
    '.set-weixin-of-user-form': SetWeixinOfUserForm,
    '.set-phone-of-user-form': SetPhoneOfUserForm,
    '.set-email-of-user-form': SetEmailOfUserForm,
    '.set-avt-of-user-form': SetAvtOfUserForm,
    '.set-addr-of-user-form': SetAddrOfUserForm,
    '.add-addr-of-user-form': AddAddrOfUserForm,
});

const mask = zmask('.zmask');

const setNameBtn = s.elem('.set-name-btn');
const nameInfo = s.elem('.name-info');
const setNameOfUserForm = s.elem('.set-name-of-user-form');

const setWeixinBtn = s.elem('.set-weixin-btn');
const weixinInfo = s.elem('.weixin-info');
const setWeixinOfUserForm = s.elem('.set-weixin-of-user-form');

const setPhoneBtn = s.elem('.set-phone-btn');
const phoneInfo = s.elem('.phone-info');
const setPhoneOfUserForm = s.elem('.set-phone-of-user-form');

const setEmailBtn = s.elem('.set-email-btn');
const emailInfo = s.elem('.email-info');
const setEmailOfUserForm = s.elem('.set-email-of-user-form');

const setAvtBtn = s.elem('.set-avt-btn');
const setAvtOfUserForm = zview.view('.set-avt-of-user-form');

const setAddr = s('.addr-info');
const setAddrOfUserForm = zview.view('.set-addr-of-user-form');
let addrInfo;

const addAddrBtn = s.elem('.add-addr-btn');
const addAddrOfUserForm = zview.view('.add-addr-of-user-form');

setNameBtn.on('click', () => {
    setNameOfUserForm.removeClass('hide');
    nameInfo.addClass('hide');
});

setWeixinBtn.on('click', () => {
    setWeixinOfUserForm.removeClass('hide');
    weixinInfo.addClass('hide');
});

setPhoneBtn.on('click', () => {
    setPhoneOfUserForm.removeClass('hide');
    phoneInfo.addClass('hide');
});

setEmailBtn.on('click', () => {
    setEmailOfUserForm.removeClass('hide');
    emailInfo.addClass('hide');
});

setAvtBtn.on('click', () => {
    let uploadView = zview.view('.upload-img.update-avt-img');
    uploadView.clearImg();

    mask.pop('.set-avt-of-user-pop');

    setAvtOfUserForm.onSubmitted = (data) => {
        if (data) {
            window.location.reload(true);
        }
    };
});

setAvtOfUserForm.on('cancel', () => {
    mask.hide();
});

addAddrBtn.on('click', () => {
    mask.pop('.add-addr-of-user-pop');
});

addAddrOfUserForm
    .on('cancel', () => mask.hide())
    .onSubmitted = (data) => {
        if (data) {
            window.location.reload(true);
        }
    };

setAddr.forEach(elem => {
    elem.elem('.set-addr-btn').on('click', () => {
        let addrId = elem.elem('.set-addr-btn').getAttribute('data-addr-id');
        s.elem('.set-addr-of-user-form').setAttribute('data-addr-id', addrId);
        addrInfo = elem.elem('input');
        mask.pop('.set-addr-of-user-pop');
    });
});

setAddrOfUserForm
    .on('cancel', () => mask.hide())
    .onSubmitted = (data) => {
        if (data) {
            addrInfo.value = data.addr;
            mask.hide();
        }
    };
