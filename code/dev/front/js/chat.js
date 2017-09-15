import ChatDom from './openmessage/chat/ChatDom';
import { Render } from './openmessage/chat/Render';
import Config from './openmessage/chat/Config';
import { request } from 'zjs/http/request';
import { pageAttr } from 'zjs/html/page-attr';
import { s } from 'zjs/s';
import { UploaderBuilder } from 'zjs/upload/qiniu4js.js';

let ws = new WebSocket("ws://" + Config.host + ":" + Config.port);
let fromAccToken = pageAttr('fromAccToken');
let toAccToken = pageAttr('toAccToken');
console.warn('fromAccToken', fromAccToken);
console.warn('toAccToken', toAccToken);
let currentChatAccToken = toAccToken;
let currentChatFirstMsgCreated = '2017-09-14 11:16:33';

function handleClickContactList(e) {
    let dom = e.target;
    let clickAccToken = '';
    while (true) {
        if (dom.getAttribute('acctoken') !== null) {
            clickAccToken = dom.getAttribute('acctoken');
            break;
        }
        dom = dom.parentElement;
    }

    changeContact(clickAccToken);
}

function changeContact(accToken) {
    currentChatAccToken = accToken;

    let chatItems = document.getElementsByClassName('chat-item');
    Array.from(chatItems).forEach(function (element) {
        element.setAttribute('style', 'display:none')
    });
    document.getElementById('chat-item-' + accToken).setAttribute('style', 'display:block');

    let contactItems = document.getElementsByClassName('contact-item');
    Array.from(contactItems).forEach(function (element) {
        element.classList.remove('active');
    });
    document.getElementById('contact-item-' + accToken).classList.add('active');
    document.getElementById('contact-item-' + accToken).classList.add('active');
    scrollBottom();
}

function scrollBottom() {
    let chatLists = document.getElementById('chat-lists');
    chatLists.scrollTop = chatLists.scrollHeight;
}

function sendMsg() {
    console.warn('send');
    let content = document.getElementById('chat-text').value;
    document.getElementById('chat-text').value = '';

    console.warn('token', currentChatAccToken);

    Render('myMsg', { 'toAccToken': currentChatAccToken, 'name': 'chang', 'time': '20:08', 'content': content, 'avatar': 'https://static.dingtalk.com/media/lADOpGV_jc0Bvc0Bvg_446_445.jpg_60x60q90.jpg' })
    scrollBottom();

    let msg = {
        type: 'im',
        content: content,
        fromAccToken: fromAccToken,
        toAccToken: currentChatAccToken
    }

    ws.send(JSON.stringify(msg));
}

function newMsg(msg) {
    Render('newMsg', { 'toAccToken': currentChatAccToken, 'name': 'chang', 'time': '20:08', 'contentType': msg.contentType, 'content': msg.content, 'avatar': 'https://static.dingtalk.com/media/lADOpGV_jc0Bvc0Bvg_446_445.jpg_60x60q90.jpg' })
    scrollBottom();
}

function reg() {
    //点击按钮
    document.getElementById('send-button').addEventListener("click", sendMsg);
    //联系人列表
    document.getElementById('contact-lists').addEventListener("click", handleClickContactList);
}

function startListen() {
    let $data = {
        "type": 'login',
        "token": fromAccToken
    };
    ws.onopen = function () {
        ws.send(JSON.stringify($data));
    };
    ws.onmessage = function (evt) {
        let msg = JSON.parse(evt.data);

        if (msg.type == 'imAction') {
            let msgItems = JSON.parse(msg.data);
            msgItems.map(item => {
                newMsg(item);
            })
            return;
        }
        newMsg(msg);
    };
    ws.onclose = function () {

    };
}

function landContactList() {
    request.postJson(Config.listContactListUrl, { 'accToken': fromAccToken })
        .then(data => {
            console.warn(data)
            if (data) {
                data.map(contact => {
                    console.warn('contact', contact);
                    Render('contact', {
                        'name': contact.name,
                        'time': '20:08',
                        'avatar': contact.avatar,
                        'accToken': contact.token
                    })
                    Render('chat', {
                        'accToken': contact.token
                    })
                })
                changeContact(currentChatAccToken);
            }
        })
        .catch(() => {
            alert('landContactList err')
        });
}

function listChatHistory() {
    let accToken = pageAttr('fromAccToken');
    let withAccToken = currentChatAccToken;

    let msg = {
        'type': 'imAction',
        'actionType': 'listHistory',
        'accToken': accToken,
        'withAccToken': withAccToken,
        'sinceCreated': currentChatFirstMsgCreated
    }

    setTimeout(function () {
        ws.send(JSON.stringify(msg));
    }, 3000);
}


landContactList();
reg();
startListen();
// Render('newMsg', { 'name': 'chang', 'time': '20:08', 'content': '我是一条新消息', 'avatar': 'https://static.dingtalk.com/media/lADOpGV_jc0Bvc0Bvg_446_445.jpg_60x60q90.jpg' });
// Render('myMsg', { 'name': 'chang', 'time': '20:08', 'content': '我是一条新消息', 'avatar': 'https://static.dingtalk.com/media/lADOpGV_jc0Bvc0Bvg_446_445.jpg_60x60q90.jpg' });
listChatHistory();
document.getElementById('chat-text').addEventListener('keydown', function (e) {
    if (e.keyCode === 13) {
        if (e.ctrlKey) {
            sendMsg();
        }
    }
})

// 更多配置，参考https://github.com/lsxiao/qiniu4js
let uploader = new UploaderBuilder()
    .debug(false)//开启debug，默认false
    // .button('uploadButton')//指定上传按钮
    .retry(0)//设置重传次数，默认0，不重传
    .auto(true)//选中文件后立即上传，默认true
    .multiple(true)//是否支持多文件选中，默认true
    .accept(['image/*'])//过滤文件，默认无，详细配置见http://www.w3schools.com/tags/att_input_accept.asp
    .tokenShare(true)
    // 设置token获取URL：客户端向该地址发送HTTP GET请求, 若成功，服务器端返回{"uptoken": 'i-am-token'}。
    .tokenUrl(pageAttr('fetchUpToken'))
    .listener({
        onReady() {
            //该回调函数在图片处理前执行,也就是说task.file中的图片都是没有处理过的
            //选择上传文件确定后,该生命周期函数会被回调。
        },
        onStart() {
            //所有内部图片任务处理后执行
            //开始上传
        },
        onTaskGetKey() {
            //为每一个上传的文件指定key,如果不指定则由七牛服务器自行处理
            return Date.now() + '-' + Math.floor(Math.random() * 10000 + 1);
        },
        onTaskProgress: function () {
            //每一个任务的上传进度,通过`task.progress`获取
        },
        onTaskSuccess(task) {
            //一个任务上传成功后回调
            console.warn(task.key);
            console.warn('up success');
            let content = Config.qiniuDomain + task.key;
            let msg = {
                type: 'im',
                content: content,
                contentType: 'img',
                fromAccToken: fromAccToken,
                toAccToken: currentChatAccToken
            }

            Render('myMsg', { 'toAccToken': currentChatAccToken, 'name': 'chang', 'time': '20:08', 'content': content, 'contentType': 'img', 'avatar': 'https://static.dingtalk.com/media/lADOpGV_jc0Bvc0Bvg_446_445.jpg_60x60q90.jpg' })
            ws.send(JSON.stringify(msg));
        },
        onTaskFail() {
            //一个任务在经历重传后依然失败后回调此函数
        },
        onTaskRetry() {
            //开始重传
        },
        onFinish() {
            //所有任务结束后回调，注意，结束不等于都成功，该函数会在所有HTTP上传请求响应后回调(包括重传请求)。
        }
    })
    .build();

//你可以自行监听HTML元素的click事件，在回调函数内部打开文件选择窗口
document.getElementById('btn-upload').addEventListener("click", function () {
    uploader.chooseFile();
});

