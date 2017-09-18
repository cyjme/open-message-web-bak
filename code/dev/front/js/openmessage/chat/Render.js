import ChatDom from './ChatDom';

export function Render(type, params) {
    let toAccToken = params.toAccToken;
    let chatItem = document.getElementById('chat-item-' + toAccToken);
    let contactLists = document.getElementById('contact-lists');
    let chatLists = document.getElementById('chat-lists');
    let dom = '';
    switch (type) {
        case 'newMsg':
            dom = ChatDom.create(type, params);
            chatItem.innerHTML += dom;
            break;
        case 'history':
            dom = ChatDom.create('newMsg', params);
            chatItem.innerHTML = dom + chatItem.innerHTML;
            break;
        case 'history-my':
            dom = ChatDom.create('myMsg', params);
            // chatItem.innerHTML += dom;
            chatItem.innerHTML = dom + chatItem.innerHTML;
            break;
        case 'myMsg':
            dom = ChatDom.create(type, params);
            chatItem.innerHTML += dom;
            break;
        case 'contact':
            dom = ChatDom.create(type, params);
            contactLists.innerHTML += dom;
            break;
        case 'chat':
            dom = ChatDom.create(type, params);
            chatLists.innerHTML += dom;
            break;
        default:
            break;
    }

    return dom;
}
