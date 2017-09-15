function create(type, params) {
    let dom = '';
    let content = '';
    switch (type) {
        case 'newMsg':
            switch(params.contentType){
                case 'img':
                    content = `<img src="`+params.content+`?imageView2/2/w/300" />`
                    break;
                case 'file':
                    content = `this is file`
                    break;
                default:
                    content = `<pre class="text">`+ params.content + `</pre>`
                    break;
            }
            dom = `<div class="msg-box">
                            <div class="msg-item not-me">
                                <div class="msg-status"></div>
                                <div class="msg-profile-info clearfix">   
                                    <span class="profile-wrp">
                                        <span class="">   
                                            <span class="name-text">`+ params.name + `</span>
                                        </span>
                                    </span>
                                    <span class="msg-time">`+ params.time + `</span>
                                </div>
                                <div class="clearfix">   
                                    <div class="avatar" style="background-image: url(`+ params.avatar + `)"></div>
                                    <div class="msg-bubble-box">
                                        <div class="msg-bubble-area">
                                            <div class="msg-bubble">
                                                `+content+`
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>`
            break;
        case 'myMsg':
            switch(params.contentType){
                case 'img':
                    content = `<img src="`+params.content+`?imageView2/2/w/300" />`
                    break;
                case 'file':
                    content = `this is file`
                    break;
                default:
                    content = `<pre class="text">`+ params.content + `</pre>`
                    break;
            }
            dom = `<div class="msg-box">
                            <div class="msg-item me">
                                <div class="msg-status"></div>
                                <div class="msg-profile-info clearfix">   
                                    <span class="profile-wrp">
                                        <span class="">   
                                            <span class="name-text">`+ params.name + `</span>
                                        </span>
                                    </span>
                                    <span class="msg-time">`+ params.time + `</span>
                                </div>
                                <div class="clearfix">   
                                    <div class="avatar" style="background-image: url(`+ params.avatar + `)"></div>
                                    <div class="msg-bubble-box">
                                        <div class="msg-bubble-area">
                                            <div class="msg-bubble">
                                                `+content+`
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>`
            break;
        case 'contact':
            dom = `
                    <div class="list-item contact-item context-menu contact-item-company" acctoken="`+ params.accToken + `" id="contact-item-` + params.accToken + `">
                        <i class="iconfont icon-delete-contact tipper-attached"></i>
                        <div class="avatar-wrap">
                            <div class="user-avatar normal" style="background-image: url(`+ params.avatar + `);"></div>
                        </div>
                        <div class="contact-item-content">
                            <div class="title-wrap">
                                <div class="name-wrap">
                                    <span>`+ params.name + `</span>
                                </div>
                                <span class="time">`+ params.time + `</span>
                            </div>
                        </div>
                    </div>
                `
            break;
        case 'chat':
            dom = `
                    <div class="msg-items chat-item" id="chat-item-`+ params.accToken + `"></div>
                `
            break;
        default:
            break;
    }

    return dom;
}

let ChatDom = {
    'create': create
};

export default ChatDom;
